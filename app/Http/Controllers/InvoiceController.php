<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\View\View;


class InvoiceController extends Controller
{

    function InvoicePage():View{
        return view('pages.dashboard.invoice-page');
    }

    function SalePage():View{
        return view('pages.dashboard.sale-page');
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


       $invoiceID=$invoice->id;

       $products= $request->input('products');

       foreach ($products as $EachProduct) {
            InvoiceProduct::create([
                'invoice_id' => $invoiceID,
                'user_id'=>$user_id,
                'product_id' => $EachProduct['product_id'],
                'qty' =>  $EachProduct['qty'],
                'sale_price'=>  $EachProduct['sale_price'],
            ]);
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
        $invoice = Invoice::with('customer')->get();

        return response()->json([
            'data' => $invoice,
            'role' => $user_role
        ]);
    }

    function InvoiceDetails(Request $request){
        $customerDetails=Customer::where('id',$request->input('cus_id'))->first();
        $invoiceTotal=Invoice::where('id',$request->input('inv_id'))->first();
        $invoiceProduct=InvoiceProduct::where('invoice_id',$request->input('inv_id'))->with('product')
            ->get();
        return array(
            'customer'=>$customerDetails,
            'invoice'=>$invoiceTotal,
            'product'=>$invoiceProduct,
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
        // dd($invoiceProduct);
        return view('pages.dashboard.edit-page',  compact('invoiceTotal','customerDetails', 'invoiceProduct'));
    }
    function invoiceDeleteProduct(Request $request)
    {
        $product_id = $request->input('productID');
        $invoice_product = InvoiceProduct::where('id', $product_id)->first();
        $sale_price = $invoice_product->sale_price;

        $invoice_id = $request->input('invoiceID');
        $invoice = Invoice::where('id', $invoice_id)->first();
        $total_price = $invoice->total;
        $payable_price = $invoice->payable;

        $total_price_after = $total_price - $sale_price;
        $payable_price_after = $payable_price - $sale_price;
        //update two table
        Invoice::where('id', $invoice_id)->update([
            'total' => $total_price_after,
            'payable' => $payable_price_after,
            ]);
        // dd($payable_price_after);
        // Perform the deletion logic
    InvoiceProduct::where('id', $product_id)->where('invoice_id', $invoice_id)->delete();

    // Redirect back to the previous page
    return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    function invoiceUpdateProduct(Request $request)
    {
        DB::beginTransaction();
        try {
        $invoice_id = $request->input('invoiceID');
        $product_id = $request->input('productID');
        
        $quantity = $request->input('qty');
        $product_rate = $request->input('productRate');

        $new_sale_price = $quantity * $product_rate; //update to invoice product

        $old_sale_price = $request->input('salePrice');

        $invoice = Invoice::where('id', $invoice_id)->first();
        $total_price = $invoice->total;
        $payable_price = $invoice->payable;

        $total_price_after = $total_price - $old_sale_price + $new_sale_price; //update to invoice

        // dd($total_price_after);

        $payable_price_after = $payable_price - $old_sale_price + $new_sale_price;
        //update two table
        Invoice::where('id', $invoice_id)->update([
            'total' => $total_price_after,
            'payable' => $payable_price_after,
            ]);
        //update invoice product
        InvoiceProduct::where('id', $product_id)->where('invoice_id', $invoice_id)->update([
            'qty' =>$quantity,
            'rate' =>$product_rate,
            'sale_price' =>$new_sale_price,
        ]);
        
        DB::commit();

        return redirect()->back()->with('success', 'Invoice updated successfully.');

        }
        catch (Exception $e) {
            DB::rollBack();
            return 0;
        }

    }
}
