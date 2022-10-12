<?php

use App\Http\Controllers\admin\Comments;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'access.type:comments']], function () {
    Route::group(['prefix' => 'comments'], function () {
        Route::get('/list', [Comments::class, 'index'])->name('admin.comments.index');
        Route::get('/item/add', [Comments::class, 'create'])->name('admin.comments.create');
        Route::post('/item/save', [Comments::class, 'store'])->name('admin.comments.store');
        Route::get('/item/edit/{id}', [Comments::class, 'edit'])->name('admin.comments.edit');
        Route::post('/item/save/{id}', [Comments::class, 'update'])->name('admin.comments.update');
        Route::get('/item/status/{id}/{status}', [Comments::class, 'status'])->name('admin.comments.status');
        Route::post('/item/trash', [Comments::class, 'trash'])->name('admin.comments.trash');
    });
});
