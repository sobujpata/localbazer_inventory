<?php

use App\Http\Controllers\BankLoanController;
use App\Http\Controllers\InvoiceProductController;
use App\Http\Controllers\miscellaneousController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\buyProductController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CustomerContactController;
use App\Http\Controllers\PartnerController;
use App\Http\Middleware\TokenVerificationMiddleware;


// Web API Routes
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/verify-otp',[UserController::class,'VerifyOTP'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/reset-password',[UserController::class,'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user-profile',[UserController::class,'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update',[UserController::class,'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);

//customer contact us api
Route::post('/customer-message',[CustomerContactController::class,'CustomerContactUs']);

// User Logout
Route::get('/logout',[UserController::class,'UserLogout']);

// Page Routes
Route::get('/about',[HomeController::class,'HomePage']);
Route::get('/testmonials',[HomeController::class,'Testmonial']);
Route::get('/contact',[HomeController::class,'Contact']);
Route::get('/',[HomeController::class,'HomeProduct'])->name('product.list');

Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/sendOtp',[UserController::class,'SendOtpPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);




Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);

Route::get('/productPage',[ProductController::class,'ProductPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/invoicePage',[InvoiceController::class,'InvoicePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/salePage',[InvoiceController::class,'SalePage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/reportPage',[ReportController::class,'ReportPage'])->middleware([TokenVerificationMiddleware::class]);






// Category API
Route::post("/create-category",[CategoryController::class,'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-category",[CategoryController::class,'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-category",[CategoryController::class,'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-category",[CategoryController::class,'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/category-by-id",[CategoryController::class,'CategoryByID'])->middleware([TokenVerificationMiddleware::class]);


// Customer API
Route::post("/create-customer",[CustomerController::class,'CustomerCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-customer",[CustomerController::class,'CustomerList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-customer",[CustomerController::class,'CustomerDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/update-customer",[CustomerController::class,'CustomerUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/customer-by-id",[CustomerController::class,'CustomerByID'])->middleware([TokenVerificationMiddleware::class]);


// Product API
Route::post("/create-product",[ProductController::class,'CreateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/delete-product",[ProductController::class,'DeleteProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post( '/update-product', [ProductController::class, 'UpdateProduct'])->name('update-product')->middleware([TokenVerificationMiddleware::class]);
Route::get("/list-product",[ProductController::class,'ProductList'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/product-by-id",[ProductController::class,'ProductByID'])->middleware([TokenVerificationMiddleware::class]);



// Invoice
Route::post("/invoice-create",[InvoiceController::class,'invoiceCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/invoice-select",[InvoiceController::class,'invoiceSelect'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-details",[InvoiceController::class,'InvoiceDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-delete",[InvoiceController::class,'invoiceDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-complete",[InvoiceController::class,'invoiceComplete'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/invoice-printed",[InvoiceController::class,'invoicePrinted'])->middleware([TokenVerificationMiddleware::class]);

//Due amount show previous day
Route::get("/due-amount/{customer_id}", [InvoiceController::class, 'DueAmounts']);

//Invoice details edit Route
Route::get("/invoice-edit-page/{id}",[InvoiceController::class,'invoiceEditPage'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-delete-product",[InvoiceController::class,'invoiceDeleteProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-update-product",[InvoiceController::class,'invoiceUpdateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::post("/invoice-create-product",[InvoiceController::class,'invoiceCreateProduct'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/invoice-page-after-print",[InvoiceController::class,'invoicePageAfterPrint'])->middleware([TokenVerificationMiddleware::class]);


// SUMMARY & Report
Route::get("/summary",[DashboardController::class,'Summary'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/sales-report/{FormDate}/{ToDate}",[ReportController::class,'SalesReport'])->middleware([TokenVerificationMiddleware::class]);
Route::get("/category-product/{categoryId}",[ReportController::class,'CategoryWiseProduct'])->middleware([TokenVerificationMiddleware::class]);

//buy product Route
Route::get('/buy-product', [buyProductController::class, 'index'])->middleware([TokenVerificationMiddleware::class]);

//buy product API
Route::get('/buying-details', [buyProductController::class, 'buyingDetails'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/buying-details-store', [buyProductController::class, 'store'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/buying-details-by-id', [buyProductController::class, 'show'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/buying-details-update/{id}', [buyProductController::class, 'update'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/buying-details-delete', [buyProductController::class, 'destroy'])->middleware([TokenVerificationMiddleware::class]);


//Collection Route
Route::get('/collection-list', [CollectionController::class, 'index'])->name('collection.index')->middleware([TokenVerificationMiddleware::class]);
Route::put('/collection-update', [CollectionController::class, 'update'])->name('update.collection')->middleware([TokenVerificationMiddleware::class]);
Route::get('/collections', [CollectionController::class, 'CollectionList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/invoice-create-amount', [CollectionController::class, 'CollectionCreate'])->middleware([TokenVerificationMiddleware::class]);

//Due Amount API
Route::get('/due-amount', [CollectionController::class, 'DueList'])->name('due.index')->middleware([TokenVerificationMiddleware::class]);
Route::put('/due-amount-update', [CollectionController::class, 'DueUpdate'])->name('update.due')->middleware([TokenVerificationMiddleware::class]);

//invoice product Route
Route::get('/search-invoice', [InvoiceProductController::class, 'index'])->name('invoice.product.search')->middleware([TokenVerificationMiddleware::class]);


//partners api
Route::post('/partner-deposit', [PartnerController::class, "DepositAmount"])->middleware([TokenVerificationMiddleware::class]);
Route::post('/partner-withdraw', [PartnerController::class, "WithdrawAmount"])->middleware([TokenVerificationMiddleware::class]);

//partners Route
Route::get('/partner-list', [PartnerController::class, 'index'])->middleware([TokenVerificationMiddleware::class]);

//Other costing Route
Route::get('/other-cost', [miscellaneousController::class, 'OtherCost'])->middleware([TokenVerificationMiddleware::class]);
//Other Costing API
Route::get('/list-costing', [miscellaneousController::class, 'CostingList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/create-costing', [miscellaneousController::class, 'CostingCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/costing-by-id', [miscellaneousController::class, 'CostingById'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-costing', [miscellaneousController::class, 'CostingUpdate'])->middleware([TokenVerificationMiddleware::class]);

//bank Route
Route::get('/bank-list', [BankLoanController::class, 'Banks'])->middleware([TokenVerificationMiddleware::class]);
//bank API
Route::get('/list-bank', [BankLoanController::class, 'BankList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/create-bank', [BankLoanController::class, 'BankCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/bank-by-id', [BankLoanController::class, 'BankById'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/get-bank-loan-by-id/{id}', [BankLoanController::class, 'BankLoanById'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-bank', [BankLoanController::class, 'BankUpdate'])->middleware([TokenVerificationMiddleware::class]);

//loan repay balance Route
Route::get('/loan-repay-balance-list', [BankLoanController::class, 'LoanRepayPage'])->middleware([TokenVerificationMiddleware::class]);
//loan-repay-balance API
Route::get('/list-loan-repay-balance', [BankLoanController::class, 'LoanRepayList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/create-loan-repay-balance', [BankLoanController::class, 'LoanRepayCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/loan-repay-balance-by-id', [BankLoanController::class, 'LoanRepayById'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-loan-repay-balance', [BankLoanController::class, 'LoanRepayUpdate'])->middleware([TokenVerificationMiddleware::class]);
