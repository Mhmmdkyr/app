<?php

use App\Http\Controllers\admin\Newsletters;
use App\Http\Controllers\admin\Roles;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'access.type:newsletters']], function () {
    Route::group(['prefix' => 'newsletter'], function () {
        Route::get('/list', [Newsletters::class, 'index'])->name('admin.newsletters.index');
        Route::post('/editor', [Newsletters::class, 'editor'])->name('admin.newsletters.editor');
        Route::get('/send-mail', [Newsletters::class, 'index'])->name('admin.newsletters.sendmail');
        Route::post('/send', [Newsletters::class, 'send'])->name('admin.newsletters.send');
        Route::post('/item/trash', [Newsletters::class, 'trash'])->name('admin.newsletters.trash');
    });
});
