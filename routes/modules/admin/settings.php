<?php

use App\Http\Controllers\admin\Navigations;
use App\Http\Controllers\admin\Settings;
use App\Http\Controllers\admin\Themes;

Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'access.type:settings']], function () {
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/themes', [Themes::class, 'index'])->name('admin.themes.index');
        Route::get('/themes/set-theme/{id}', [Themes::class, 'setTheme'])->name('admin.themes.set_theme');
        Route::get('/ad-spaces', [Settings::class, 'adSpaces'])->name('admin.settings.adspaces');
        Route::post('/ad-spaces', [Settings::class, 'adSpacesSave'])->name('admin.settings.savespaces');
        Route::get('/localizations', [Settings::class, 'localizations'])->name('admin.settings.localizations');
        Route::post('/save-language', [Settings::class, 'saveLanguage'])->name('admin.settings.saveLang');
        Route::get('/edit-translate/{slug}', [Settings::class, 'editTranslations'])->name('admin.settings.editTranslates');
        Route::post('/save-translations', [Settings::class, 'saveTranslations'])->name('admin.settings.saveTranslates');
        Route::get('/db-backups', [Settings::class, 'dbBackups'])->name('admin.settings.dbbackups');
        Route::post('/download-backup', [Settings::class, 'downloadBackup'])->name('admin.settings.downloadbackup');
        Route::get('/get-backup', [Settings::class, 'getBackup'])->name('admin.settings.downloaddb');

        Route::get('/settings', [Settings::class, 'index'])->name('admin.settings.index');
        Route::post('/settings/save', [Settings::class, 'save'])->name('admin.settings.save');
       
    });
    Route::post('/languages/item/trash', [Settings::class, 'deleteLanguage'])->name('admin.settings.deleteLanguage');
});
