<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

// Portal Público de ZonaCountry.com.ar
Route::get('/', [PortalController::class, 'index'])->name('portal.home');
Route::get('/noticias/{slug}', [PortalController::class, 'showArticle'])->name('portal.article');
Route::get('/go/banner/{banner}', [PortalController::class, 'clickBanner'])->name('portal.banner.click');
Route::post('/vecinal-norte/reclamos', [PortalController::class, 'storeClaim'])->name('portal.claim.store');
Route::post('/clasificados', [PortalController::class, 'storeClassified'])->name('portal.classifieds.store');

// Panel de Autogestión en Laravel + IA (/admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Autogestión de Banners y Auspiciantes
    Route::post('/banners', [AdminController::class, 'storeBanner'])->name('banners.store');
    Route::post('/banners/{banner}/toggle', [AdminController::class, 'toggleBanner'])->name('banners.toggle');
    Route::get('/banners/{banner}/reporte-pdf', [AdminController::class, 'sponsorReport'])->name('banners.report');

    // Redactor de Noticias con Laravel IA
    Route::post('/ai/generate-article', [AdminController::class, 'generateArticleWithAi'])->name('ai.article');
    Route::post('/articles', [AdminController::class, 'storeArticle'])->name('articles.store');

    // Clasificados & ZC Inmuebles con IA
    Route::post('/ai/enhance-listing', [AdminController::class, 'enhanceListingWithAi'])->name('ai.listing');
    Route::post('/listings', [AdminController::class, 'storeListing'])->name('listings.store');

    // Sincronizador en vivo con WordPress actual (zonacountry.com.ar/wp-json)
    Route::post('/sync-wordpress', [AdminController::class, 'syncFromWordPress'])->name('sync.wp');
});
