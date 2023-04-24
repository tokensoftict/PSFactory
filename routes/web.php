<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['as' => 'index', 'uses' => 'Auth\LoginController@index']);

Route::post('login', ['as' => 'login_process', 'uses' => 'Auth\LoginController@loginprocess']);

Route::get('/auth', ['as' => 'login', 'uses' => 'Auth\LoginController@index']);

Route::match(['get', 'post'], 'logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::middleware(['auth'])->group(function () {

    Route::match(['post','get'],'/profile','Auth\LoginController@profile')->name('profile');

    Route::get('/dashboard','DashboardController@index')->name('dashboard');

    Route::get('/reports','ReportsController@index')->name('reports');


    Route::prefix('ajax')->namespace('Ajax')->group(function () {
        Route::get('/findstock', ['as' => 'findstock', 'uses' => 'AjaxController@findstock']);
        Route::get('/findcustomer', ['as' => 'findcustomer', 'uses' => 'AjaxController@findcustomer']);
        Route::get('/findpurchaseorderstock', ['as' => 'findpurchaseorderstock', 'uses' => 'AjaxController@findpurchaseorderstock']);
        Route::get('/profitandlossdatatable', ['as' => 'profitandlossdatatable', 'uses' => 'AjaxController@profitandlossdatatable']);
    });


    Route::middleware(['permit.task'])->group(function () {

        Route::prefix('accesscontrol')->namespace('AccessControl')->group(function () {

            Route::prefix('user-group')->as('user.group.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'GroupController@index', 'visible' => true]);
                Route::get('list', ['as' => 'list', 'uses' => 'GroupController@list_all']);
                Route::get('create', ['as' => 'create', 'uses' => 'GroupController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'GroupController@store']);
                Route::match(['get', 'post'], '{group}/permission', ['as' => 'permission', 'uses' => 'GroupController@permission']);
                Route::get('{id}/fetch_task', ['as' => 'task', 'uses' => 'GroupController@fetch_task']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'GroupController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'GroupController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'GroupController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'GroupController@update']);
                Route::get('{id}', ['as' => 'destroy', 'uses' => 'GroupController@destroy']);
            });

            Route::prefix('user')->as('user.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'UserController@index', 'visible' => true]);
                Route::get('list', ['as' => 'list', 'uses' => 'UserController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'UserController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'UserController@store']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'UserController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'UserController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'UserController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'UserController@update']);
                Route::get('{id}', ['as' => 'destroy', 'uses' => 'UserController@destroy']);
            });

        });

        Route::prefix('settings')->namespace('Settings')->group(function () {

            Route::prefix('bank')->as('bank.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'BankController@index', 'visible' => true, 'custom_label'=>'Bank Account Manager']);
                Route::get('list', ['as' => 'list', 'uses' => 'BankController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'BankController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'BankController@store']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'BankController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'BankController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'BankController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'BankController@update']);
                Route::delete('{id}', ['as' => 'destroy', 'uses' => 'BankController@destroy']);
            });

            Route::prefix('department')->as('department.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'DepartmentController@index', 'visible' => true, 'custom_label'=>'Departments']);
                Route::get('list', ['as' => 'list', 'uses' => 'DepartmentController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'DepartmentController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'DepartmentController@store']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'DepartmentController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'DepartmentController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'DepartmentController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'DepartmentController@update']);
                Route::delete('{id}', ['as' => 'destroy', 'uses' => 'DepartmentController@destroy']);
            });

            Route::prefix('manufacturer')->as('manufacturer.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'ManufacturerController@index', 'visible' => true, 'custom_label'=>'Manufacturers']);
                Route::get('list', ['as' => 'list', 'uses' => 'ManufacturerController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'ManufacturerController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'ManufacturerController@store']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'ManufacturerController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'ManufacturerController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'ManufacturerController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'ManufacturerController@update']);
                Route::delete('{id}', ['as' => 'destroy', 'uses' => 'ManufacturerController@destroy']);
            });

            Route::prefix('payment_method')->as('payment_method.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'PaymentMethodController@index', 'visible' => true, 'custom_label'=>'Payment Methods']);
                Route::get('list', ['as' => 'list', 'uses' => 'PaymentMethodController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'PaymentMethodController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'PaymentMethodController@store']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'PaymentMethodController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'PaymentMethodController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'PaymentMethodController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'PaymentMethodController@update']);
                Route::delete('{id}', ['as' => 'destroy', 'uses' => 'PaymentMethodController@destroy']);
            });

            Route::prefix('tank')->as('tank.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'TankManagerController@index', 'visible' => true, 'custom_label'=>'Tank or Lines Manager']);
                Route::get('list', ['as' => 'list', 'uses' => 'TankManagerController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'TankManagerController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'TankManagerController@store']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'TankManagerController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'TankManagerController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'TankManagerController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'TankManagerController@update']);
                Route::delete('{id}', ['as' => 'destroy', 'uses' => 'TankManagerController@destroy']);
            });

            Route::prefix('store_settings')->as('store_settings.')->group(function () {
                Route::get('', ['as' => 'view', 'uses' => 'StoreSettings@show', 'visible' => true, 'custom_label'=>"System Settings"]);
                Route::put('update', ['as' => 'update', 'uses' => 'StoreSettings@update']);
               // Route::get('backup', ['as' => 'backup', 'uses' => 'StoreSettings@backup', 'visible' => true,'custom_label'=>"Back Up Database"]);
            });

        });

        Route::prefix('CustomerManager')->namespace('CustomerManager')->group(function () {

            Route::prefix('customer')->as('customer.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'CustomerController@index', 'visible' => true, 'custom_label'=>'Customer Manager']);
                Route::get('list', ['as' => 'list', 'uses' => 'CustomerController@list_all']);
                Route::get('create', ['as' => 'create', 'uses' => 'CustomerController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'CustomerController@store']);
                Route::get('{id}/show', ['as' => 'show', 'uses' => 'CustomerController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'CustomerController@edit']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'CustomerController@update']);
                Route::match(['get','post'],'/credit_report', ['as' => 'credit_report', 'uses' => 'CustomerController@credit_report', 'custom_label'=>"Customer Credit Report"]);
                Route::match(['get','post'],'/payment_report', ['as' => 'payment_report', 'uses' => 'CustomerController@payment_report', 'custom_label'=>"Customer Payment Report"]);
                Route::match(['get','post'],'/balance_sheet', ['as' => 'balance_sheet', 'uses' => 'CustomerController@balance_sheet', 'custom_label'=>"Customer Balance Sheet"]);
            });

        });

        Route::prefix('RawMaterialManager')->namespace('RawMaterialManager')->group(function () {

            Route::prefix('materialtypes')->as('materialtypes.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'MaterialTypeController@index', 'visible' => true, 'custom_label'=>'Material Types']);
                Route::get('list', ['as' => 'list', 'uses' => 'MaterialTypeController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'MaterialTypeController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'MaterialTypeController@store']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'MaterialTypeController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'MaterialTypeController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'MaterialTypeController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'MaterialTypeController@update']);
                Route::delete('{id}', ['as' => 'destroy', 'uses' => 'MaterialTypeController@destroy']);
            });


            Route::prefix('rawmaterial')->as('rawmaterial.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'RawMaterialController@index', 'visible' => true, 'custom_label'=>'Material Manager']);
                Route::get('list', ['as' => 'list', 'uses' => 'RawMaterialController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'RawMaterialController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'RawMaterialController@store']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'RawMaterialController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'RawMaterialController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'RawMaterialController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'RawMaterialController@update']);
                Route::delete('{id}', ['as' => 'destroy', 'uses' => 'RawMaterialController@destroy']);


                Route::get('material/requests', ['as' => 'request', 'uses' => 'RawMaterialController@requests', 'visible' => true, 'custom_label'=>'Material Requests']);

                Route::get('material/requests/new', ['as' => 'new_request', 'uses' => 'RawMaterialController@new_request',  'custom_label'=>'Request For Material']);

                Route::get('material/requests/{materialRequest}/edit', ['as' => 'edit_request', 'uses' => 'RawMaterialController@edit_request',  'custom_label'=>'Edit Material Request']);

                Route::get('material/requests/{materialRequest}/show', ['as' => 'showrequest', 'uses' => 'RawMaterialController@showrequest',  'custom_label'=>'Show Transfer Requests']);

                Route::get('material/requests/{materialRequest}/approve', ['as' => 'approverequest', 'uses' => 'RawMaterialController@approverequest',  'custom_label'=>'Approve Transfer Requests']);

                Route::get('material/requests/{materialRequest}/decline', ['as' => 'declinerequest', 'uses' => 'RawMaterialController@declinerequest',  'custom_label'=>'Decline Transfer Requests']);



                Route::get('material/returns', ['as' => 'returns', 'uses' => 'RawMaterialController@returns', 'visible' => true, 'custom_label'=>'Material Returns']);

                Route::get('material/returns/new', ['as' => 'new_return', 'uses' => 'RawMaterialController@new_return',  'custom_label'=>'Return Material']);

                Route::get('material/returns/{materialReturn}/edit', ['as' => 'edit_return', 'uses' => 'RawMaterialController@edit_return',  'custom_label'=>'Edit Return Material']);

                Route::get('material/returns/{materialReturn}/show', ['as' => 'showreturns', 'uses' => 'RawMaterialController@showreturns',  'custom_label'=>'Show List of Material Returns']);

                Route::get('material/returns/{materialReturn}/approve', ['as' => 'approvereturns', 'uses' => 'RawMaterialController@approvereturns',  'custom_label'=>'Approve Material Returns']);

                Route::get('material/returns/{materialReturn}/decline', ['as' => 'declinereturns', 'uses' => 'RawMaterialController@declinereturns',  'custom_label'=>'Decline Material Returns']);
            });

        });

        Route::prefix('purchaseorders')->namespace('PurchaseOrders')->group(function () {

            Route::prefix('supplier')->as('supplier.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'SupplierController@index', 'visible' => true, 'custom_label'=>'Supplier Manager']);
                Route::get('list', ['as' => 'list', 'uses' => 'SupplierController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'SupplierController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'SupplierController@store']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'SupplierController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'SupplierController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'SupplierController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'SupplierController@update']);
                Route::delete('{id}', ['as' => 'destroy', 'uses' => 'SupplierController@destroy']);
            });

            Route::prefix('purchaseorders')->as('purchaseorders.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'PurchaseOrder@index', 'visible' => true, 'custom_label'=>'Purchase']);
                Route::get('{purchaseOrder}/show', ['as' => 'show', 'uses' => 'PurchaseOrder@show']);
                Route::get('create', ['as' => 'create', 'uses' => 'PurchaseOrder@create', 'visible' => true, 'custom_label'=>'Add Purchase']);
                Route::post('store', ['as' => 'store', 'uses' => 'PurchaseOrder@store']);
                Route::get('{purchaseOrder}/remove', ['as' => 'destroy', 'uses' => 'PurchaseOrder@destroy']);

                Route::get('{purchaseOrder}/edit', ['as' => 'edit', 'uses' => 'PurchaseOrder@edit']);
                Route::get('{purchaseOrder}/markAsComplete', ['as' => 'markAsComplete', 'uses' => 'PurchaseOrder@markAsComplete', 'custom_label'=>'Complete Purchase']);
                Route::put('{purchaseOrder}/update', ['as' => 'update', 'uses' => 'PurchaseOrder@update']);

            });


        });

        Route::prefix('productmanager')->namespace('ProductManager')->group(function () {

            Route::prefix('category')->as('category.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'CategoryController@index', 'visible' => true, 'custom_label'=>'Product Category']);
                Route::get('list', ['as' => 'list', 'uses' => 'CategoryController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'CategoryController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'CategoryController@store']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'CategoryController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'CategoryController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'CategoryController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'CategoryController@update']);
                Route::delete('{id}', ['as' => 'destroy', 'uses' => 'CategoryController@destroy']);
            });


            Route::prefix('product')->as('product.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'ProductController@index', 'visible' => true,'vue'=>'/stock/new','custom_label'=>'List Product']);
                Route::get('create', ['as' => 'create', 'uses' => 'ProductController@create','visible' => true, 'custom_label'=>'Add Product']);
                Route::get('expired', ['as' => 'expired', 'uses' => 'ProductController@expired','visible' => true]);
                Route::get('disable', ['as' => 'disable', 'uses' => 'ProductController@disabled','visible' => true,'vue'=>'/stock/disabled','custom_label'=>'List Disabled Stock']);
                Route::get('export', ['as' => 'export', 'uses' => 'ProductController@export']);

                Route::post('', ['as' => 'store', 'uses' => 'ProductController@store']);
                Route::get('{stock}/show', ['as' => 'show', 'uses' => 'ProductController@show']);
                Route::get('{stock}/edit', ['as' => 'edit', 'uses' => 'ProductController@edit','custom_label'=>'Edit Product']);
                Route::put('{stock}', ['as' => 'update', 'uses' => 'ProductController@update']);
                Route::get('{stock}/toggle', ['as' => 'toggle', 'uses' => 'ProductController@toggle','custom_label'=>'Toggle Product']);
                Route::post('/find', ['as' => 'find', 'uses' => 'ProductController@find']);
                Route::post('/findAvailable', ['as' => 'findAvailable', 'uses' => 'ProductController@findAvailable']);

                Route::get('/changeCostPrice', ['as' => 'changeCostPrice', 'uses' => 'ProductController@changeCostPrice',
                    'custom_label'=>'Change Product Cost Price']);

                Route::get('/changeSellingPrice', ['as' => 'changeSellingPrice', 'uses' => 'ProductController@changeSellingPrice', 'custom_label'=>'Change Product Selling Price']);

                Route::get('transfers', ['as' => 'transfers', 'uses' => 'ProductController@product_transfer','visible' => true, 'custom_label'=>'Product Transfer']);

                Route::get('approveTransfer', ['as' => 'approveTransfer', 'uses' => 'ProductController@approveTransfer','custom_label'=>'Approve Product Transfer']);
            });


            Route::prefix('template')->as('template.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'ProductionTemplateController@index', 'visible' => true, 'custom_label'=>'Production Template']);
                Route::get('list', ['as' => 'list', 'uses' => 'ProductionTemplateController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'ProductionTemplateController@create','visible' => true, 'custom_label'=>'Add Production Template']);
                Route::post('', ['as' => 'store', 'uses' => 'ProductionTemplateController@store']);
                Route::get('{productionTemplate}', ['as' => 'show', 'uses' => 'ProductionTemplateController@show']);
                Route::get('{productionTemplate}/edit', ['as' => 'edit', 'uses' => 'ProductionTemplateController@edit']);
                Route::get('{productionTemplate}/toggle', ['as' => 'toggle', 'uses' => 'ProductionTemplateController@toggle']);
                Route::put('{productionTemplate}', ['as' => 'update', 'uses' => 'ProductionTemplateController@update']);
                Route::delete('{productionTemplate}', ['as' => 'destroy', 'uses' => 'ProductionTemplateController@destroy']);
            });

        });

        Route::prefix('ProductionManager')->namespace('ProductionManager')->group(function(){
            Route::prefix('production')->as('production.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'ProductionController@index', 'visible' => true]);
                Route::get('list', ['as' => 'list', 'uses' => 'ProductionController@listAll']);
                Route::get('{production}/show', ['as' => 'show', 'uses' => 'ProductionController@show']);
                Route::get('create', ['as' => 'create', 'uses' => 'ProductionController@create', 'visible' => true, 'custom_label'=> 'New Production']);
                Route::post('', ['as' => 'store', 'uses' => 'ProductionController@store']);
                Route::get('{production}/edit', ['as' => 'edit', 'uses' => 'ProductionController@edit']);
                Route::put('{production}', ['as' => 'update', 'uses' => 'ProductionController@update']);
                Route::get('{production}/delete', ['as' => 'destroy', 'uses' => 'ProductionController@destroy']);
                Route::get('{production}/complete', ['as' => 'complete', 'uses' => 'ProductionController@complete']);
                Route::get('{production}/transfer', ['as' => 'transfer', 'uses' => 'ProductionController@transfer', 'custom_label'=> 'Transfer Production']);
            });
        });

        Route::prefix('invoiceandsales')->namespace('InvoiceAndSales')->group(function () {

            Route::prefix('invoice')->as('invoiceandsales.')->group(function () {
                Route::get('create', ['as' => 'create', 'uses' => 'InvoiceController@create', 'custom_label'=>'New Invoice', 'visible'=>true]);
                Route::get('', ['as' => 'draft', 'uses' => 'InvoiceController@draft', 'visible' => true, 'custom_label'=>'Draft Invoice']);
                Route::get('paid', ['as' => 'paid', 'uses' => 'InvoiceController@paid', 'visible' => true, 'custom_label'=>'Paid Invoice']);
                Route::get('dispatched', ['as' => 'dispatched', 'uses' => 'InvoiceController@dispatched', 'visible' => true, 'custom_label'=>'Dispatched Invoice']);
                Route::get('{invoice}/pos_print', ['as' => 'pos_print', 'uses' => 'InvoiceController@print_pos','custom_label'=>'Print Thermal' ]);
                Route::get('{invoice}/print_afour', ['as' => 'print_afour', 'uses' => 'InvoiceController@print_afour', 'custom_label'=>'Print A4 Invoice']);
                Route::get('{invoice}/dispatchInvoice', ['as' => 'dispatchInvoice', 'uses' => 'InvoiceController@dispatchInvoice', 'custom_label'=>'Dispatch Invoice']);
                Route::get('{invoice}/print_way_bill', ['as' => 'print_way_bill', 'uses' => 'InvoiceController@print_way_bill', 'custom_label'=>'Print WayBill']);
                Route::get('{invoice}/view', ['as' => 'view', 'uses' => 'InvoiceController@view']);

                Route::get('{invoice}/applyInvoiceDiscount', ['as' => 'applyInvoiceDiscount', 'uses' => 'InvoiceController@applyInvoiceDiscount', "custom_label"=>"Apply Invoice Discount"]);

                Route::get('{invoice}/applyProductDiscount', ['as' => 'applyProductDiscount', 'uses' => 'InvoiceController@applyProductDiscount', "custom_label"=>"Apply Product Discount"]);

                Route::get('{invoice}/edit', ['as' => 'edit', 'uses' => 'InvoiceController@edit']);
                Route::get('{invoice}/destroy', ['as' => 'destroy', 'uses' => 'InvoiceController@destroy']);
                Route::put('{invoice}/update', ['as' => 'update', 'uses' => 'InvoiceController@update']);
            });

            Route::prefix('returns')->as('returns.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'InvoiceReturnController@index', 'visible' => true, 'custom_label'=>'List Return Invoice']);

                Route::get('create', ['as' => 'create', 'uses' => 'InvoiceReturnController@create', 'custom_label'=>'New Invoice Return', 'visible'=>true]);

                Route::get('{invoiceReturn}/edit', ['as' => 'edit', 'uses' => 'InvoiceReturnController@edit', 'custom_label'=>'Edit Invoice Return',]);

                Route::get('{invoiceReturn}/destroy', ['as' => 'destroy', 'uses' => 'InvoiceReturnController@destroy', 'custom_label'=>'Delete Invoice Return',]);

                Route::get('{invoiceReturn}/show', ['as' => 'view', 'uses' => 'InvoiceReturnController@show', 'custom_label'=>'View Invoice Return',]);

                Route::get('{invoiceReturn}/approve', ['as' => 'approve', 'uses' => 'InvoiceReturnController@approve', 'custom_label'=>'Approve Invoice Returns']);

                Route::get('{invoiceReturn}/decline', ['as' => 'decline', 'uses' => 'InvoiceReturnController@decline', 'custom_label'=>'Decline Invoice Returns']);

            });

            Route::prefix('returns/reason')->as('reason.')->group(function () {
                Route::get('', ['as' => 'index', 'uses' => 'InvoiceReasonController@index', 'visible' => true, 'custom_label'=>'Return Reasons']);
                Route::get('list', ['as' => 'list', 'uses' => 'InvoiceReasonController@listAll']);
                Route::get('create', ['as' => 'create', 'uses' => 'InvoiceReasonController@create']);
                Route::post('', ['as' => 'store', 'uses' => 'InvoiceReasonController@store']);
                Route::get('{id}', ['as' => 'show', 'uses' => 'InvoiceReasonController@show']);
                Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'InvoiceReasonController@edit']);
                Route::get('{id}/toggle', ['as' => 'toggle', 'uses' => 'InvoiceReasonController@toggle']);
                Route::put('{id}', ['as' => 'update', 'uses' => 'InvoiceReasonController@update']);
                Route::delete('{id}', ['as' => 'destroy', 'uses' => 'InvoiceReasonController@destroy']);
            });

        });

        Route::prefix('paymentmanager')->namespace('PaymentManager')->group(function () {
            Route::prefix('payment')->as('payment.')->group(function () {
                Route::get('create', ['as' => 'create', 'uses' => 'PaymentController@create', 'custom_label'=>'Add Payment', 'visible'=>true]);
                Route::get('list', ['as' => 'list', 'uses' => 'PaymentController@list_payment', 'custom_label'=>'List Payment', 'visible'=>true]);
                Route::get('{payment}/show', ['as' => 'show', 'uses' => 'PaymentController@show', 'custom_label'=>'View Payment Details']);
                Route::get('{payment}/destroy', ['as' => 'destroy', 'uses' => 'PaymentController@destroy', 'custom_label'=>'Delete Payment', ]);
                Route::get('{payment}/print', ['as' => 'print', 'uses' => 'PaymentController@print_payment', 'custom_label'=>'Print Payment Receipt']);
                Route::get('createInvoicePayment', ['as' => 'createInvoicePayment', 'uses' => 'PaymentController@createInvoicePayment', 'custom_label'=>'Add Invoice Payment']);

                Route::get('createCreditPayment', ['as' => 'createCreditPayment', 'uses' => 'PaymentController@createCreditPayment', 'custom_label'=>'Add Credit Payment']);

                Route::get('createDepositPayment', ['as' => 'createDepositPayment', 'uses' => 'PaymentController@createDepositPayment', 'custom_label'=>'Add Deposit Payment']);
            });
        });

        Route::prefix('reports')->as('reports.')->group(function(){

            Route::prefix('purchasesReport')->as('purchase.')->namespace('PurchaseReport')->group(function(){
                Route::match(['get','post'],'by_date', ['as' => 'by_date', 'uses' => 'PurchaseReportsController@index', 'custom_label'=>'Purchase Report By Date']);

                Route::match(['get','post'],'by_supplier', ['as' => 'by_supplier', 'uses' => 'PurchaseReportsController@by_supplier', 'custom_label'=>'Purchase Report By Supplier']);

                Route::match(['get','post'],'by_system_user', ['as' => 'by_system_user', 'uses' => 'PurchaseReportsController@by_system_user', 'custom_label'=>'Purchase Report By User']);

                Route::match(['get','post'],'by_material', ['as' => 'by_material', 'uses' => 'PurchaseReportsController@by_material', 'custom_label'=>'Purchase Report By Material']);

                Route::match(['get','post'],'by_status', ['as' => 'by_status', 'uses' => 'PurchaseReportsController@by_status', 'custom_label'=>'Purchase Report By Status']);

                Route::match(['get','post'],'by_department', ['as' => 'index', 'uses' => 'PurchaseReportsController@by_department', 'custom_label'=>'Purchase Report By Department']);
            });

            Route::prefix('paymentReport')->as('payment.')->namespace('PaymentReport')->group(function(){
                Route::match(['get','post'],'by_date', ['as' => 'by_date', 'uses' => 'PaymentReportsController@index', 'custom_label'=>'Payment Report By Date']);

                Route::match(['get','post'],'by_customer', ['as' => 'by_customer', 'uses' => 'PaymentReportsController@by_customer', 'custom_label'=>'Payment Report By Customer']);

                Route::match(['get','post'],'by_system_user', ['as' => 'by_system_user', 'uses' => 'PaymentReportsController@by_system_user', 'custom_label'=>'Payment Report By User']);

                Route::match(['get','post'],'by_payment_method', ['as' => 'by_payment_method', 'uses' => 'PaymentReportsController@by_payment_method', 'custom_label'=>'Payment Report By Method']);

                Route::match(['get','post'],'profit_and_loss', ['as' => 'profit_and_loss', 'uses' => 'PaymentReportsController@profit_and_loss', 'custom_label'=>'Profit and Loss Analysis Report']);

                Route::match(['get','post'],'payment_method', ['as' => 'payment_method', 'uses' => 'PaymentReportsController@payment_method', 'custom_label'=>'Payment Method Report(s)']);
            });


            Route::prefix('productionReport')->as('production.')->namespace('ProductionReport')->group(function(){

                Route::match(['get','post'],'by_date', ['as' => 'by_date', 'uses' => 'ProductionReportsController@index', 'custom_label'=>'Production Report By Date']);

                Route::match(['get','post'],'by_system_user', ['as' => 'by_system_user', 'uses' => 'ProductionReportsController@by_system_user', 'custom_label'=>'Production Report By System User']);

                Route::match(['get','post'],'by_status', ['as' => 'by_status', 'uses' => 'ProductionReportsController@by_status', 'custom_label'=>'Production Report By Status']);

                Route::match(['get','post'],'by_product', ['as' => 'by_product', 'uses' => 'ProductionReportsController@by_product', 'custom_label'=>'Production Report By Product']);

                Route::match(['get','post'],'by_product_template', ['as' => 'by_product_template', 'uses' => 'ProductionReportsController@by_product_template', 'custom_label'=>'Production Report By Product Template']);

                Route::match(['get','post'],'by_productionline', ['as' => 'by_productionline', 'uses' => 'ProductionReportsController@by_productionline', 'custom_label'=>'Production Report By Lines']);
            });


            Route::prefix('invoiceReport')->as('invoice.')->namespace('InvoiceReport')->group(function(){

                Route::match(['get','post'],'by_date', ['as' => 'by_date', 'uses' => 'InvoiceReportController@index', 'custom_label'=>'Invoice Report By Date']);

                Route::match(['get','post'],'by_system_user', ['as' => 'by_system_user', 'uses' => 'InvoiceReportController@by_system_user', 'custom_label'=>'Invoice Report By System User']);

                Route::match(['get','post'],'by_status', ['as' => 'by_status', 'uses' => 'InvoiceReportController@by_status', 'custom_label'=>'Invoice Report By Status']);

                Route::match(['get','post'],'by_product', ['as' => 'by_product', 'uses' => 'InvoiceReportController@by_product', 'custom_label'=>'Invoice Report By Product']);

                Route::match(['get','post'],'by_customer', ['as' => 'by_customer', 'uses' => 'InvoiceReportController@by_customer', 'custom_label'=>'Invoice Report By Customer']);

                Route::match(['get','post'],'by_batch_number', ['as' => 'by_batch_number', 'uses' => 'InvoiceReportController@by_batch_number', 'custom_label'=>'Invoice Report By Batch Number']);
            });


            Route::prefix('productTransferReport')->as('producttransferreport.')->namespace('ProductTransferReport')->group(function(){

                Route::match(['get','post'],'by_date', ['as' => 'by_date', 'uses' => 'ProductTransferReportController@index', 'custom_label'=>'Product Transfer Report By Date']);

                Route::match(['get','post'],'by_system_user', ['as' => 'by_system_user', 'uses' => 'ProductTransferReportController@by_system_user', 'custom_label'=>'Product Transfer Report By System User']);


                Route::match(['get','post'],'by_status', ['as' => 'by_status', 'uses' => 'ProductTransferReportController@by_status', 'custom_label'=>'Product Transfer Report By Status']);

                Route::match(['get','post'],'by_product', ['as' => 'by_product', 'uses' => 'ProductTransferReportController@by_product', 'custom_label'=>'Product Transfer Report By Product']);

                Route::match(['get','post'],'bincard', ['as' => 'bincard', 'uses' => 'ProductTransferReportController@bincard', 'custom_label'=>'Bin Card Report ']);

                Route::match(['get','post'],'bincard_by_product', ['as' => 'bincard_by_product', 'uses' => 'ProductTransferReportController@bincard_by_product', 'custom_label'=>'Bin Card Report By Product ']);

            });


            Route::prefix('materialTransferReport')->as('materialtransferreport.')->namespace('MaterialTransferReport')->group(function(){

                Route::match(['get','post'],'by_date', ['as' => 'by_date', 'uses' => 'MaterialTransferReportController@index', 'custom_label'=>'Material Request Report By Date']);

                Route::match(['get','post'],'by_system_user', ['as' => 'by_system_user', 'uses' => 'MaterialTransferReportController@by_system_user', 'custom_label'=>'Material Request Report By System User']);

                Route::match(['get','post'],'by_status', ['as' => 'by_status', 'uses' => 'MaterialTransferReportController@by_status', 'custom_label'=>'Material Request Report By Status']);

                Route::match(['get','post'],'by_material', ['as' => 'by_material', 'uses' => 'MaterialTransferReportController@by_material', 'custom_label'=>'Material Request Report By Material']);

                Route::match(['get','post'],'bincard', ['as' => 'bincard', 'uses' => 'MaterialTransferReportController@bincard', 'custom_label'=>'Bin Card Report ']);

                Route::match(['get','post'],'bincard_by_material', ['as' => 'bincard_by_material', 'uses' => 'MaterialTransferReportController@bincard_by_material', 'custom_label'=>'Bin Card Report By Material ']);

            });

            Route::prefix('MaterialReturnsReport')->as('materialreturnsreport.')->namespace('MaterialReturnsReport')->group(function(){

                Route::match(['get','post'],'by_date', ['as' => 'by_date', 'uses' => 'MaterialReturnsReportController@index', 'custom_label'=>'Material Request Report By Date']);

                Route::match(['get','post'],'by_system_user', ['as' => 'by_system_user', 'uses' => 'MaterialReturnsReportController@by_system_user', 'custom_label'=>'Material Request Report By System User']);

                Route::match(['get','post'],'by_status', ['as' => 'by_status', 'uses' => 'MaterialReturnsReportController@by_status', 'custom_label'=>'Material Request Report By Status']);

                Route::match(['get','post'],'by_material', ['as' => 'by_material', 'uses' => 'MaterialReturnsReportController@by_material', 'custom_label'=>'Material Request Report By Material']);

            });


            Route::prefix('customerReport')->as('customerReport.')->namespace('CustomerReport')->group(function(){

                Route::match(['get','post'],'balance_sheet', ['as' => 'balance_sheet', 'uses' => 'CustomerReportController@balance_sheet', 'custom_label'=>'Customer Balance Sheet']);

                Route::match(['get','post'],'customer_ledger', ['as' => 'customer_ledger', 'uses' => 'CustomerReportController@customer_ledger', 'custom_label'=>'Customer Ledger']);

                Route::match(['get','post'],'customer_incentive', ['as' => 'customer_incentive', 'uses' => 'CustomerReportController@customer_incentive', 'customer_incentive'=>'Customer Incentive Report']);

            });


            Route::prefix('invoiceReturnReport')->as('invoiceReturnReport.')->namespace('invoiceReturnsReport')->group(function(){

                Route::match(['get','post'],'by_date', ['as' => 'by_date', 'uses' => 'invoiceReturnsReport@index', 'custom_label'=>'Invoice Return Report By Date']);

                Route::match(['get','post'],'by_system_user', ['as' => 'by_system_user', 'uses' => 'invoiceReturnsReport@by_system_user', 'custom_label'=>'Invoice Return Report By System User']);

                Route::match(['get','post'],'by_status', ['as' => 'by_status', 'uses' => 'invoiceReturnsReport@by_status', 'custom_label'=>'Invoice Return Report By Status']);

                Route::match(['get','post'],'by_product', ['as' => 'by_product', 'uses' => 'invoiceReturnsReport@by_product', 'custom_label'=>'Invoice Return Report By Product']);

                Route::match(['get','post'],'by_customer', ['as' => 'by_customer', 'uses' => 'invoiceReturnsReport@by_customer', 'custom_label'=>'Invoice Return Report By Customer']);

            });




        });

    });

});

