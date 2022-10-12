<?php

use App\Http\Controllers\admin\Users;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'access.type:users']], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::get('/list', [Users::class, 'index'])->name('admin.users.index');
        Route::get('/item/add', [Users::class, 'create'])->name('admin.users.create');
        Route::post('/item/save', [Users::class, 'save'])->name('admin.users.save');
        Route::get('/item/edit/{id}', [Users::class, 'edit'])->name('admin.users.edit');
        Route::post('/item/save/{id}', [Users::class, 'save'])->name('admin.users.update');
        Route::post('/item/trash', [Users::class, 'trash'])->name('admin.users.trash');
        Route::get('/item/status/{id}/{status}', [Users::class, 'status'])->name('admin.users.status');
    });
});
