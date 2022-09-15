<?php

Route::prefix('/admin')->group(function(){
    Route::get('/','Admin\DashboardController@getDashboard')->name('dashboard'); // Inicio

    // Modulo setting

    Route::get('/settings', 'Admin\SettingsController@getHome')->name('settings'); //configuraciones
    Route::post('/settings', 'Admin\SettingsController@postHome')->name('settings'); // Configuraciones

    // modulo usuarios

    Route::get('/users/{status}', 'Admin\UserController@getUsers')->name('user_list'); // Listar usuario
    Route::get('/user/{id}/view', 'Admin\UserController@getUserView')->name('user_view'); // Editar usuario
    Route::get('/user/{id}/banned', 'Admin\UserController@getUserBanned')->name('user_banned'); //Bloquear usuario
    Route::get('/user/{id}/permissions', 'Admin\UserController@getUserPermissions')->name('user_permissions'); //Permisos usuario
    Route::post('/user/{id}/permissions', 'Admin\UserController@postUserPermissions')->name('user_permissions'); //Permisos usuario
    Route::post('/user/{id}/edit', 'Admin\UserController@postUserEdit')->name('user_edit'); //editar usuario

    // Producto module
    Route::get('/products/{status}', 'Admin\ProductController@getHome')->name('products'); // Productos
    Route::get('/product/add', 'Admin\ProductController@getProductAdd')->name('product_add'); //Agregar productos
    Route::post('/product/add', 'Admin\ProductController@postProductAdd')->name('product_add'); //Agregar productos
    Route::post('/product/search', 'Admin\ProductController@postProductSearch')->name('product_search'); //ABuscar Producto
    Route::get('/product/{id}/edit', 'Admin\ProductController@getProductEdit')->name('product_edit'); //Editar Producto
    Route::post('/product/{id}/edit', 'Admin\ProductController@postProductEdit')->name('product_edit'); //Editar Producto    
    Route::get('/product/{id}/delete', 'Admin\ProductController@getProductDelete')->name('product_delete'); //Eliminar producto
    Route::get('/product/{id}/restore', 'Admin\ProductController@getProductRestore')->name('product_delete'); //Eliminar producto
    Route::get('/product/{id}/inventory', 'Admin\ProductController@getProductInventory')->name('product_inventory'); //Inventario Producto
    Route::post('/product/{id}/inventory', 'Admin\ProductController@postProductInventory')->name('product_inventory'); //Inventario Producto
    Route::post('/product/{id}/gallery/add', 'Admin\ProductController@postProductGalleryAdd')->name('product_gallery_add'); // Galeria producto    
    Route::get('/product/{id}/gallery/{gid}/delete', 'Admin\ProductController@getProductGalleryDelete')->name('product_gallery_delete'); // Eliminar galeria

    // Modulo inventario 

    Route::get('/product/inventory/{id}/edit', 'Admin\ProductController@getProductInventoryEdit')->name('product_inventory'); //Editar inventario
    Route::post('/product/inventory/{id}/edit', 'Admin\ProductController@postProductInventoryEdit')->name('product_inventory'); //Editar inventario    
    Route::get('/product/inventory/{id}/delete', 'Admin\ProductController@getProductInventoryDelete')->name('product_inventory'); //Eliminar inventario
    Route::post('/product/inventory/{id}/variant', 'Admin\ProductController@postProductInventoryVariantAdd')->name('product_inventory'); //Variante de inventario
    Route::get('/product/variant/{id}/delete', 'Admin\ProductController@getProductInventoryVariantDelete')->name('product_inventory'); //Eliminar Variante de inventario   
    
    //categorias

    Route::get('/categories/{module}', 'Admin\CategoriesController@getHome')->name('categories'); //Categorias
    Route::post('/category/add/{module}', 'Admin\CategoriesController@postCategoryAdd')->name('category_add'); //Agregar_categoria
    Route::get('/category/{id}/edit', 'Admin\CategoriesController@getCategoryEdit')->name('category_edit'); //Editar_categoria
    Route::post('/category/{id}/edit', 'Admin\CategoriesController@postCategoryEdit')->name('category_edit'); //Editar_categoria
    Route::get('/category/{id}/subs', 'Admin\CategoriesController@getSubCategories')->name('category_edit'); //Editar_subcategoria
    Route::get('/category/{id}/delete', 'Admin\CategoriesController@getCategoryDelete')->name('category_delete'); //Eliminar_categoria

    // Sliders

    Route::get('/sliders', 'Admin\SliderController@getHome')->name('sliders_list'); // Lista de sliders
    Route::post('/slider/add', 'Admin\SliderController@postSliderAdd')->name('slider_add'); // Lista de sliders
    Route::get('/slider/{id}/edit', 'Admin\SliderController@getSliderEdit')->name('slider_edit'); // Lista de sliders
    Route::post('/slider/{id}/edit', 'Admin\SliderController@postSliderEdit')->name('slider_edit'); // Lista de sliders
    Route::get('/slider/{id}/delete', 'Admin\SliderController@getSliderDelete')->name('slider_delete'); // Lista de sliders

    // Coverage Module - MOdulo de covertura de envios
    Route::get('/coverage', 'Admin\CoverageController@getList')->name('coverage_list'); // Lista de coberturas
    Route::post('/coverage/state/add', 'Admin\CoverageController@postCoverageStateAdd')->name('coverage_add'); // Agregar coberturas
    Route::post('/coverage/city/add', 'Admin\CoverageController@postCoverageCityAdd')->name('coverage_add'); // Agregar ciudades de coberturas
    Route::get('/coverage/{id}/edit', 'Admin\CoverageController@getCoverageEdit')->name('coverage_edit'); // Editarr coberturas
    Route::get('/coverage/city/{id}/edit', 'Admin\CoverageController@getCoverageCityEdit')->name('coverage_edit'); // Editarr coberturas de ciudades
    Route::post('/coverage/city/{id}/edit', 'Admin\CoverageController@postCoverageCityEdit')->name('coverage_edit'); // Editarr coberturas
    Route::post('/coverage/state/{id}/edit', 'Admin\CoverageController@postCoverageStateEdit')->name('coverage_edit'); // Editarr coberturas
    Route::get('/coverage/{id}/cities', 'Admin\CoverageController@getCoverageCities')->name('coverage_list'); // Editarr coberturas
    Route::get('/coverage/{id}/delete', 'Admin\CoverageController@getCoverageDelete')->name('coverage_delete'); // Eliminar coberturas

    // Ordenes Routes
    Route::get('/orders/{status}/{type}', 'Admin\OrderController@getList')->name('orders_list');    
    Route::get('/order/{order}/view', 'Admin\OrderController@getOrder')->name('order_view');   
    Route::post('/order/{order}/view', 'Admin\OrderController@postOrderStatusUpdate')->name('order_view');    
    
    // JavaScript Request Apis
    Route::get('/md/api/load/subcategories/{parent}', 'Admin\ApiController@getSubCategories'); // Llama a las subactegorias
        

});

  