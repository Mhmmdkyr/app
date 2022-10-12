<?php

use App\Http\Controllers\admin\Roles;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'access.type:users']], function () {
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/list', [Roles::class, 'index'])->name('admin.roles.index');
        Route::get('/item/add', [Roles::class, 'create'])->name('admin.roles.create');
        Route::post('/item/save', [Roles::class, 'save'])->name('admin.roles.save');
        Route::get('/item/edit/{id}', [Roles::class, 'edit'])->name('admin.roles.edit');
        Route::post('/item/save/{id}', [Roles::class, 'save'])->name('admin.roles.update');
        Route::post('/item/trash', [Roles::class, 'trash'])->name('admin.roles.trash');
    });
});
