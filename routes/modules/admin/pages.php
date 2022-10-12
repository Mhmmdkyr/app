<?php

use App\Http\Controllers\admin\Pages;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'access.type:pages']], function () {
    Route::group(['prefix' => 'pages'], function () {
        Route::get('/list', [Pages::class, 'index'])->name('admin.pages.index');
        Route::get('/item/add', [Pages::class, 'create'])->name('admin.pages.create');
        Route::post('/item/save', [Pages::class, 'save'])->name('admin.pages.save');
        Route::post('/item/save/{id}', [Pages::class, 'save'])->name('admin.pages.edit_save');
        Route::get('/item/edit/{id}', [Pages::class, 'create'])->name('admin.pages.edit');
        Route::post('/item/update', [Pages::class, 'update'])->name('admin.pages.update');
        Route::post('/item/trash', [Pages::class, 'trash'])->name('admin.pages.trash');
        Route::post('/item/revert', [Pages::class, 'revert'])->name('admin.pages.revert');
        Route::post('/item/delete', [Pages::class, 'delete'])->name('admin.pages.delete');
    });
});
