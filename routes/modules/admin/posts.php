<?php

use App\Http\Controllers\admin\Posts;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'access.type:posts']], function () {
    Route::group(['prefix' => 'posts'], function () {
        Route::get('/list', [Posts::class, 'index'])->name('admin.posts.index');
        Route::get('/select-type', [Posts::class, 'selectType'])->name('admin.posts.types');
        Route::get('/item/add', [Posts::class, 'create'])->name('admin.posts.create');
        Route::post('/item/save', [Posts::class, 'save'])->name('admin.posts.save');
        Route::get('/item/edit/{id}', [Posts::class, 'create'])->name('admin.posts.edit');
        Route::post('/item/update/{post_id}', [Posts::class, 'save'])->name('admin.posts.update');
        Route::post('/item/trash', [Posts::class, 'trash'])->name('admin.posts.trash');
        Route::post('/item/revert', [Posts::class, 'revert'])->name('admin.posts.revert');
        Route::post('/item/delete', [Posts::class, 'delete'])->name('admin.posts.delete');
        Route::post('/video-information', [Posts::class, 'getVideoInformation'])->name('admin.posts.vinformation');
    });
});
