<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\PurchaseOrderController;
// --------------------------
// Custom Backpack Routes






// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('product', 'ProductCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('supplier', 'SupplierCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('product-supplier', 'ProductSupplierCrudController');

    Route::get('index', 'PosController@index')->name('index'); // Màn hình POS chính
    Route::get('search-products','PosController@searchProducts')->name('searchProducts'); // Route để tìm kiếm sản phẩm (AJAX)
    Route::post('submit-sale', 'PosController@submitSale')->name('submitSale'); 


    Route::resource('purchase-orders', PurchaseOrderController::class)->parameters(['purchase-orders' => 'purchaseOrder'])->except(['edit', 'update', 'destroy'])->names([
        'index' => 'purchase-orders.index',
        'create' => 'purchase-orders.create',
        'store' => 'purchase-orders.store',
        'show' => 'purchase-orders.show',
    ]);
    Route::post('purchase-order/{purchaseOrder}/receive', 'PurchaseOrderController@receive')->name('purchase-orders.receive');

    // Route để tìm kiếm sản phẩm cho việc thêm vào phiếu nhập (AJAX)
    // Đảm bảo controller và hàm là đúng
    Route::get('product-search-for-po', 'PosController@searchProducts')->name('products.searchForPo');
    


    



    
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
