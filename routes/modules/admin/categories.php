<?php

use App\Http\Controllers\admin\Categories;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'access.type:categories']], function () {
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/list', [Categories::class, 'index'])->name('admin.categories.index');
        Route::get('/item/add', [Categories::class, 'create'])->name('admin.categories.create');
        Route::post('/item/save', [Categories::class, 'store'])->name('admin.categories.store');
        Route::get('/item/edit/{id}', [Categories::class, 'edit'])->name('admin.categories.edit');
        Route::post('/item/save/{uniq_id}', [Categories::class, 'store'])->name('admin.categories.update');
        Route::post('/item/trash', [Categories::class, 'trash'])->name('admin.categories.trash');
    });
});
