<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');

});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// }); 
Route::middleware('auth:api')->group(function () {
   //---------------------------------- REFERENCES -----------------------------------------------
   //DASHBOARD
   Route::get('dashboard/index/{payment_type}', 'References\DashboardController@index');
   Route::get('dashboard/payment/{payment_type}/{is_string}', 'References\DashboardController@getPaymentLine');
   //END DASHBOARD
   // List of Charges

   //List departments
   Route::get('departments', 'References\DepartmentsController@index');
   //List single departments
   Route::get('department/{id}', 'References\DepartmentsController@show');
   //Create new departments
   Route::post('department', 'References\DepartmentsController@create');
   //Update departments
   Route::put('department/{id}', 'References\DepartmentsController@update');
   //Delete departments
   Route::put('department/delete/{id}', 'References\DepartmentsController@delete');
   //Check if department was used
   Route::get('departmentcheck/{id}', 'References\DepartmentsController@checkIfUsed');
   // END departments

   //List categories
   Route::get('categories', 'References\CategoriesController@index');
   //List single category
   Route::get('category/{id}', 'References\CategoriesController@show');
   //Create new category
   Route::post('category', 'References\CategoriesController@create');
   //Update category
   Route::put('category/{id}', 'References\CategoriesController@update');
   //Delete category
   Route::put('category/delete/{id}', 'References\CategoriesController@delete');
   //Check if category was used
   Route::get('categorycheck/{id}', 'References\CategoriesController@checkIfUsed');
   // END categories

   //List units
   Route::get('units', 'References\UnitsController@index');
   //List single unit
   Route::get('unit/{id}', 'References\UnitsController@show');
   //Create new unit
   Route::post('unit', 'References\UnitsController@create');
   //Update unit
   Route::put('unit/{id}', 'References\UnitsController@update');
   //Delete unit
   Route::put('unit/delete/{id}', 'References\UnitsController@delete');
   //Check if unit was used
   Route::get('unitcheck/{id}', 'References\UnitsController@checkIfUsed');
   // END units

   //List cardtypes
   Route::get('cardtypes', 'References\CardtypeController@index');
   //List single cardtype
   Route::get('cardtype/{id}', 'References\CardtypeController@show');
   //Create new cardtype
   Route::post('cardtype', 'References\CardtypeController@create');
   //Update cardtype
   Route::put('cardtype/{id}', 'References\CardtypeController@update');
   //Delete cardtype
   Route::put('cardtype/delete/{id}', 'References\CardtypeController@delete');
   //Check if cardtype was used
   Route::get('cardtypecheck/{id}', 'References\CardtypeController@checkIfUsed');
   // END cardtypes

   //List checktypes
   Route::get('checktypes', 'References\ChecktypeController@index');
   //List single checktype
   Route::get('checktype/{id}', 'References\ChecktypeController@show');
   //Create new checktype
   Route::post('checktype', 'References\ChecktypeController@create');
   //Update checktype
   Route::put('checktype/{id}', 'References\ChecktypeController@update');
   //Delete checktype
   Route::put('checktype/delete/{id}', 'References\ChecktypeController@delete');
   //Check if checktype was used
   Route::get('checktypecheck/{id}', 'References\ChecktypeController@checkIfUsed');
   // END checktypes

   //List gctypes
   Route::get('gctypes', 'References\GCtypesController@index');
   //List single checktype
   Route::get('gctype/{id}', 'References\GCtypesController@show');
   //Create new gctype
   Route::post('gctype', 'References\GCtypesController@create');
   //Update gctype
   Route::put('gctype/{id}', 'References\GCtypesController@update');
   //Delete gctype
   Route::put('gctype/delete/{id}', 'References\GCtypesController@delete');
   //Check if checkgctypetype was used
   Route::get('gctypecheck/{id}', 'References\GCtypesController@checkIfUsed');
   // END gctypes

   //List discounttypes
   Route::get('discounttypes', 'References\DiscounttypeController@index');
   //List single discounttype
   Route::get('discounttype/{id}', 'References\DiscounttypeController@show');
   //Create new discounttype
   Route::post('discounttype', 'References\DiscounttypeController@create');
   //Update discounttype
   Route::put('discounttype/{id}', 'References\DiscounttypeController@update');
   //Delete discounttype
   Route::put('discounttype/delete/{id}', 'References\DiscounttypeController@delete');
   //Check if discounttypecheck was used
   Route::get('discounttypecheck/{id}', 'References\DiscounttypeController@checkIfUsed');
   // END discounttypes

   //List suppliers
   Route::get('suppliers', 'References\SupplierController@index');
   //List single supplier
   Route::get('supplier/{id}', 'References\SupplierController@show');
   //Create new supplier
   Route::post('supplier', 'References\SupplierController@create');
   //Update supplier
   Route::put('supplier/{id}', 'References\SupplierController@update');
   //Delete supplier
   Route::put('supplier/delete/{id}', 'References\SupplierController@delete');
   //Check if suppliercheck was used
   Route::get('suppliercheck/{id}', 'References\SupplierController@checkIfUsed');
   // END suppliers

   //List products
   Route::get('products', 'References\ProductController@index');
   //List single product
   Route::get('product/{id}', 'References\ProductController@show');
   //Create new product
   Route::post('product', 'References\ProductController@create');
   //Update product
   Route::put('product/{id}', 'References\ProductController@update');
   //Delete product
   Route::put('product/delete/{id}', 'References\ProductController@delete');
   //Check if productcheck was used
   Route::get('productcheck/{id}', 'References\ProductController@checkIfUsed');
   // END products

   //List purchaseorderlists
   Route::get('purchaseorderlists', 'Inventory\PurchaseOrderListController@index');
   //List single purchaseorderlist
   Route::get('purchaseorderlist/{id}', 'Inventory\PurchaseOrderListController@show');
   //Create new purchaseorderlist
   Route::post('purchaseorderlist', 'Inventory\PurchaseOrderListController@create');
   //Update purchaseorderlist
   Route::put('purchaseorderlist/{id}', 'Inventory\PurchaseOrderListController@update');
   //Delete purchaBseorderlist
   Route::put('purchaseorderlist/delete/{id}', 'Inventory\PurchaseOrderListController@delete');
   //Check if purchaseorderlist was used
   Route::get('purchaseorderlistcheck/{id}', 'Inventory\PurchaseOrderListController@checkIfUsed');
   // END purchaseorderlists

   //List receivinglists
   Route::get('receivinglists', 'Inventory\ReceivingListController@index');
   //List single receivinglist
   Route::get('receivinglist/{id}', 'Inventory\ReceivingListController@show');
   //Create new receivinglist
   Route::post('receivinglist', 'Inventory\ReceivingListController@create');
   //Update receivinglist
   Route::put('receivinglist/{id}', 'Inventory\ReceivingListController@update');
   //Delete receivinglist
   Route::put('receivinglist/delete/{id}', 'Inventory\ReceivingListController@delete');
   //Check if receivinglist was used
   Route::get('receivinglistcheck/{id}', 'Inventory\ReceivingListController@checkIfUsed');
   // END receivinglists
   Route::get('getpoitems/{id}', 'Inventory\ReceivingListController@getPoItems');

   //List issuances
   Route::get('issuances', 'Inventory\IssuancesController@index');
   //List single issuance
   Route::get('issuance/{id}', 'Inventory\IssuancesController@show');
   //Create new issuance
   Route::post('issuance', 'Inventory\IssuancesController@create');
   //Update issuance
   Route::put('issuance/{id}', 'Inventory\IssuancesController@update');
   //Delete issuance
   Route::put('issuance/delete/{id}', 'Inventory\IssuancesController@delete');
   //Check if issuance was used
   Route::get('issuancecheck/{id}', 'Inventory\IssuancesController@checkIfUsed');
   // END issuance

   //List adjustmentlist
   Route::get('adjustmentlists', 'Inventory\AdjustmentListController@index');
   //List single adjustmentlist
   Route::get('adjustmentlist/{id}', 'Inventory\AdjustmentListController@show');
   //Create new adjustmentlist
   Route::post('adjustmentlist', 'Inventory\AdjustmentListController@create');
   //Update adjustmentlist
   Route::put('adjustmentlist/{id}', 'Inventory\AdjustmentListController@update');
   //Delete adjustmentlist
   Route::put('adjustmentlist/delete/{id}', 'Inventory\AdjustmentListController@delete');
   //Check if adjustmentlist was used
   Route::get('adjustmentlistcheck/{id}', 'Inventory\AdjustmentListController@checkIfUsed');
   // END adjustmentlist

   //List poss
   Route::get('pos', 'Pos\PosController@index');
   //List single adjustmentlist
   Route::get('pos/{id}', 'Pos\PosController@show');
   //Delete pos
   Route::put('pos/delete/{id}', 'Pos\PosController@delete');
   
  
});

