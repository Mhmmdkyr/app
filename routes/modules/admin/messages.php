<?php

use App\Http\Controllers\admin\ContactMessages;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'access.type:messages']], function () {
    Route::group(['prefix' => 'messages'], function () {
        Route::get('/list', [ContactMessages::class, 'index'])->name('admin.messages.index');
        Route::get('/item/add', [ContactMessages::class, 'create'])->name('admin.messages.create');
        Route::post('/item/save', [ContactMessages::class, 'store'])->name('admin.messages.store');
        Route::get('/item/edit/{id}', [ContactMessages::class, 'edit'])->name('admin.messages.edit');
        Route::post('/item/save/{id}', [ContactMessages::class, 'update'])->name('admin.messages.update');
        Route::get('/item/status/{id}/{status}', [ContactMessages::class, 'status'])->name('admin.messages.status');
        Route::post('/item/trash', [ContactMessages::class, 'trash'])->name('admin.messages.trash');
    });
});
