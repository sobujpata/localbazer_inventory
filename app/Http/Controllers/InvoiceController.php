<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\View\View;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class InvoiceController extends Controller
{

    function InvoicePage():View{
        return view('pages.dashboard.invoice-page');
    }

    function SalePage():View{
        return view('pages.dashboard.sale-page');
    }
    function invoicePageAfterPrint():View{
        return view('pages.dashboard.invoice-page-after-print');
    }

    function invoiceCreate(Request $request){

        DB::beginTransaction();

        try {

        $user_id=$request->header('id');
        $total=$request->input('total');
        $discount=$request->input('discount');
        $vat=$request->input('vat');
        $payable=$request->input('payable');

        $customer_id=$request->input('customer_id');

        $invoice= Invoice::create([
            'total'=>$total,
            'discount'=>$discount,
            'vat'=>$vat,
            'payable'=>$payable,
            'user_id'=>$user_id,
            'customer_id'=>$customer_id,
        ]);


        $invoiceID = $invoice->id; // Invoice ID
        $products = $request->input('products'); // Retrieve products from request
        
        foreach ($products as $EachProduct) {
            $product_id = $EachProduct['product_id'];
            $qty = $EachProduct['qty'];
            $sale_price = $EachProduct['sale_price'];
        
           
        
            // Ensure valid values for calculations
            $qty = is_numeric($qty) ? $qty : 0;
            $sale_price = is_numeric($sale_price) ? $sale_price : 0;
        
            // Calculate total buy price
            $total_buy_price = $qty * $EachProduct['total_buy_price'];
        
            // Create InvoiceProduct record
            InvoiceProduct::create([
                'invoice_id' => $invoiceID,
                'user_id' => $user_id,
                'product_id' => $product_id,
                'qty' => $qty,
                'sale_price' => $sale_price,
                'rate' => $qty > 0 ? $sale_price / $qty : 0, // Avoid division by zero
                'total_buy_price' => $total_buy_price,
            ]);
        
            // Update the product quantity in the Product table
            $product = Product::find($EachProduct['product_id']); // Find the product by its ID
            if ($product) {
                $product->buy_qty -= $EachProduct['qty']; // Decrease the quantity
                $product->save(); // Save the changes
            }
        }

       DB::commit();

       return 1;

        }
        catch (Exception $e) {
            DB::rollBack();
            return 0;
        }

    }

    function invoiceSelect(Request $request){
        $user_role=$request->header('role');
        $invoices = Invoice::where('complete', '0')->with('customer')->get();
        // Prepare a response structure
        $responseData = $invoices->map(function ($invoice) {
            $invoice_id = $invoice->id;

            // Fetch invoice products for the current invoice
            $invoiceProducts = InvoiceProduct::where('invoice_id', $invoice_id)
                ->with('product')
                ->get();

            // Calculate total buy price for this invoice
            $totalBuyPrice = InvoiceProduct::where('invoice_id', $invoice_id)
                ->join('products', 'invoice_products.product_id', '=', 'products.id')
                ->select(DB::raw('SUM(products.buy_price * invoice_products.qty) as total_buy_price'))
                ->value('total_buy_price');

            return [
                'invoice' => $invoice,
                'invoiceProducts' => $invoiceProducts,
                'totalBuyPrice' => $totalBuyPrice,
            ];
        });
        return response()->json([
            'data' => $responseData,
            'role' => $user_role,
        ]);
    }
    function invoicePrinted(Request $request)
    {
        $user_role = $request->header('role');

        // Fetch all completed invoices with customers
        $invoices = Invoice::where('complete', '1')
            ->with('customer')
            ->get();

        // Prepare a response structure
        $responseData = $invoices->map(function ($invoice) {
            $invoice_id = $invoice->id;

            // Fetch invoice products for the current invoice
            $invoiceProducts = InvoiceProduct::where('invoice_id', $invoice_id)
                ->with('product')
                ->get();

            // Calculate total buy price for this invoice
            $totalBuyPrice = InvoiceProduct::where('invoice_id', $invoice_id)
                ->join('products', 'invoice_products.product_id', '=', 'products.id')
                ->select(DB::raw('SUM(products.buy_price * invoice_products.qty) as total_buy_price'))
                ->value('total_buy_price');

            return [
                'invoice' => $invoice,
                'invoiceProducts' => $invoiceProducts,
                'totalBuyPrice' => $totalBuyPrice,
            ];
        });

        return response()->json([
            'data' => $responseData,
            'role' => $user_role,
        ]);
    }

    function InvoiceDetails(Request $request){
        
        $customerDetails=Customer::where('id',$request->input('cus_id'))->first();
        $invoiceTotal=Invoice::where('id',$request->input('inv_id'))->first();
        // Fetch detailed invoice products with related products
        $invoiceProducts = InvoiceProduct::where('invoice_id', $request->input('inv_id'))
        ->with('product')
        ->get();

        // Calculate total buy price using database query
        $totalBuyPrice = InvoiceProduct::where('invoice_products.invoice_id', $request->input('inv_id'))
        ->join('products', 'invoice_products.product_id', '=', 'products.id') // Adjust table/column names
        ->select(DB::raw('SUM(products.buy_price * invoice_products.qty) as total_buy_price'))
        ->value('total_buy_price');

        $alltotalBuyPrice = InvoiceProduct::join('products', 'invoice_products.product_id', '=', 'products.id') // Join the product table
            ->select(DB::raw('SUM(products.buy_price * invoice_products.qty) as total_buy_price')) // Calculate the sum
            ->value('total_buy_price'); // Retrieve the aggregated value

            // Get the start and end dates for last month
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Calculate the total for last month
        $totalBuyPriceLastMonth = InvoiceProduct::whereBetween('invoice_products.created_at', [$startOfLastMonth, $endOfLastMonth])
            ->join('products', 'invoice_products.product_id', '=', 'products.id')
            ->select(DB::raw('SUM(products.buy_price * invoice_products.qty) as total_buy_price'))
            ->value('total_buy_price');

        $due_amount = Collection::where('customer_id', $request->input('cus_id'))->sum('due');
// Initialize $due_invoice as an empty collection
$due_invoice = collect(); 

// Retrieve invoices only if the due amount is greater than 0
if ($due_amount > 0) {
    $due_invoice = Collection::where('customer_id', $request->input('cus_id'))
        ->where('due', '>', 0) // Exclude invoices where due is 0
        ->get();
}
        return array(
            'customer'=>$customerDetails,
            'invoice'=>$invoiceTotal,
            'product'=>$invoiceProducts,
            'buyingPrice'=>$totalBuyPrice,
            'allbuyingPrice'=>$alltotalBuyPrice,
            'totalBuyPriceLastMonth'=>$totalBuyPriceLastMonth,
            'due_amount'=>$due_amount,
            'due_invoice'=>$due_invoice
        );
    }

    function invoiceDelete(Request $request){
        DB::beginTransaction();
        try {
            $user_id=$request->header('id');
            InvoiceProduct::where('invoice_id',$request->input('inv_id'))->delete();
            Invoice::where('id',$request->input('inv_id'))->delete();
            DB::commit();
            return 1;
        }
        catch (Exception $e){
            DB::rollBack();
            return 0;
        }
    }
    function invoiceComplete(Request $request){

            $user_id=$request->header('id');
            Invoice::where('id',$request->input('inv_id'))->update([
                'complete' => 1
            ]);
            return 1;

    }

    function invoiceEditPage(Request $request)
    {
        // dd("salim");
        $invoice_id = $request->id;
        // $invoice = Invoice::find($invoice_id);
        $invoiceTotal=Invoice::where('id', $invoice_id)->first();
        $customerDetails=Customer::where('id',$invoiceTotal->customer_id)->first();
        $invoiceProduct=InvoiceProduct::where('invoice_id',$invoice_id)
        ->with('product')
        ->get();
        // $buy_price = $invoiceProduct->total_buy_price/$invoiceProduct->qty;
        // dd($invoiceProduct);
        return view('pages.dashboard.edit-page',  compact('invoiceTotal','customerDetails', 'invoiceProduct'));
    }
    public function invoiceDeleteProduct(Request $request)
    {
        $invoice_product_id = $request->input('productID');
        $product_id = $request->input('product_id');
        $ProductQtyDelete = $request->input('ProductQtyDelete');
        $invoice_id = $request->input('invoiceID');

        try {
            // Fetch product and update quantity
            $product = Product::find($product_id);

            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            $product->buy_qty += $ProductQtyDelete; // Update the product quantity
            $product->save();

            // Fetch invoice product and adjust prices
            $invoice_product = InvoiceProduct::where('id', $invoice_product_id)->where('invoice_id', $invoice_id)->first();

            if (!$invoice_product) {
                return redirect()->back()->with('error', 'Invoice product not found.');
            }

            $sale_price = $invoice_product->sale_price;

            // Fetch invoice and update totals
            $invoice = Invoice::find($invoice_id);

            if (!$invoice) {
                return redirect()->back()->with('error', 'Invoice not found.');
            }

            $invoice->total -= $sale_price;
            $invoice->payable -= $sale_price;
            $invoice->save();

            // Delete the product from the invoice
            $invoice_product->delete();

            return redirect()->back()->with('success', 'Product deleted successfully.');

        } catch (\Exception $e) {
            // Handle unexpected errors
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public function invoiceUpdateProduct(Request $request)
    {
        DB::beginTransaction(); // Start a transaction

        try {
            // Extract request data
            $invoice_id = $request->input('invoiceID');
            $product_id = $request->input('productID');
            $main_product_id = $request->input('product_id');
            $quantity = $request->input('qty');
            $oldQty = $request->input('invoiceOldQty');
            if($quantity==$oldQty){
                return redirect()->back()->with('error', 'Quantity No change.');
            }
            $newQty = $quantity - $oldQty;
            $product_rate = $request->input('productRate');
            $buy_price = $request->input('buy_price');
            $old_sale_price = $request->input('salePrice');

            // Calculate new values
            $new_sale_price = $quantity * $product_rate; // New sale price for the invoice product
            $total_buy_price = $buy_price * $quantity;   // New total buy price

            // Fetch and validate the invoice
            $invoice = Invoice::find($invoice_id);
            if (!$invoice) {
                return redirect()->back()->with('error', 'Invoice not found.');
            }

            // Update invoice totals
            $invoice->total = $invoice->total - $old_sale_price + $new_sale_price;
            $invoice->payable = $invoice->payable - $old_sale_price + $new_sale_price;
            $invoice->save();

            // Fetch and validate the invoice product
            $invoiceProduct = InvoiceProduct::where('id', $product_id)
                ->where('invoice_id', $invoice_id)
                ->first();

            if (!$invoiceProduct) {
                return redirect()->back()->with('error', 'Invoice product not found.');
            }

            // Update the invoice product
            $invoiceProduct->update([
                'qty' => $quantity,
                'rate' => $product_rate,
                'sale_price' => $new_sale_price,
                'total_buy_price' => $total_buy_price,
            ]);

            // Fetch and validate the product in inventory
            $product = Product::find($main_product_id);
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            // Update the product's buy quantity in inventory
            $product->buy_qty -= $newQty;
            $product->save();

            DB::commit(); // Commit transaction

            return redirect()->back()->with('success', 'Invoice updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction in case of an error

            // Log the error for debugging purposes
            Log::error('Error updating invoice: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating the invoice: ' . $e->getMessage());
        }
    }


    //edit create product
    public function invoiceCreateProduct(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            $invoice_id = $request->input('invoiceID');
            $product_id = $request->input('productName');
            $product_qty = $request->input('qty');
            $product_rate = $request->input('productRate');
            $total_buy_price = $request->input('total_buy_price');

            $total_sale_price = $product_qty * $product_rate;

            $invoice = Invoice::where('id', $invoice_id)->first();
            $total_price = $invoice->total;
            $payable_price = $invoice->payable;
            $new_total_price = $total_price + $total_sale_price;
            $new_payable_price = $payable_price + $total_sale_price;


            //update two table
            $invoice = Invoice::where('id', $invoice_id)->update([
                'total' => $new_total_price,
                'payable' => $new_payable_price,
                ]);


            //invoiceProduct table update
            $invoice_products = InvoiceProduct::create([
                'user_id' =>$user_id,
                'invoice_id' => $invoice_id,
                'product_id' => $product_id,
                'qty' => $product_qty,
                'rate' => $product_rate,
                'sale_price' => $total_sale_price,
                'total_buy_price' => $total_buy_price,
                ]);

            // Fetch product and update quantity
            $product = Product::find($product_id);

            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            $product->buy_qty -= $product_qty; // Update the product quantity
            $product->save();

            // dd($invoice_products);
            DB::commit();
            return redirect()->back()->with('success', 'Product added successfully.');
        }
        catch (Exception $e) {
            DB::rollBack();
            return 0;

        }
    }


    public function DueAmounts($customer_id){
        $due_amount = Collection::where('customer_id', $customer_id)->sum('due');


    }
}
