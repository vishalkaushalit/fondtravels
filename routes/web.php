<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GlobalScriptController;
use App\Http\Controllers\SeoMetaController;

Route::controller(WebsiteController::class)->group(function () {
    Route::get('/', 'index')->name('website.index');
    Route::get('/flights', 'flights')->name('website.flights');
    Route::get('/hotels', 'hotels')->name('website.hotels');
    Route::get('/cars', 'cars')->name('website.cars');
    Route::get('/packages', 'packages')->name('website.packages');
    Route::get('/package-details', 'packageDetails')->name('website.package-details');
    Route::get('/about', 'about')->name('website.about');
    Route::get('/blog', 'blog')->name('website.blog');
    Route::get('/blog/{slug}', 'blogDetails')->name('website.blog-details');
    Route::get('/blog-details', 'blogDetails');
    Route::get('/contact', 'contact')->name('website.contact');
    Route::get('/privacy-policy', 'privacyPolicy')->name('website.privacy-policy');
    Route::get('/terms', 'terms')->name('website.terms');

    Route::get('/index.php', 'index');
    Route::get('/flights.php', 'flights');
    Route::get('/hotels.php', 'hotels');
    Route::get('/cars.php', 'cars');
    Route::get('/packages.php', 'packages');
    Route::get('/package-details.php', 'packageDetails');
    Route::get('/about.php', 'about');
    Route::get('/blog.php', 'blog');
    Route::get('/blog-details.php', 'blogDetails');
    Route::get('/contact.php', 'contact');
    Route::get('/privacy-policy.php', 'privacyPolicy');
    Route::get('/terms.php', 'terms');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Contact Controller
    Route::get('contact/index', [ContactController::class, 'index'])->name('contact.index');
    Route::post('contact/create', [ContactController::class, 'create'])->name('contact.create');
    Route::delete('/contact/delete/{id}', [ContactController::class, 'delete'])->name('contact.delete');

    Route::get('subscribe/index', [ContactController::class, 'subscribeIndex'])->name('subscribe.index');
    Route::post('subscribe/create', [ContactController::class, 'subscribeCreate'])->name('subscribe.create');
    Route::delete('/subscribe/delete/{id}', [ContactController::class, 'subscribeDelete'])->name('subscribe.delete');

    Route::get('seo-meta', [SeoMetaController::class, 'index'])->name('seo-meta.index');
    Route::get('seo-meta/create', [SeoMetaController::class, 'create'])->name('seo-meta.create');
    Route::post('seo-meta', [SeoMetaController::class, 'store'])->name('seo-meta.store');
    Route::get('seo-meta/{type}/{key}/edit', [SeoMetaController::class, 'edit'])->name('seo-meta.edit');
    Route::put('seo-meta/{type}/{key}', [SeoMetaController::class, 'update'])->name('seo-meta.update');
    Route::delete('seo-meta/{type}/{key}', [SeoMetaController::class, 'destroy'])->name('seo-meta.destroy');

    Route::get('global-scripts', [GlobalScriptController::class, 'edit'])->name('global-scripts.edit');
    Route::put('global-scripts', [GlobalScriptController::class, 'update'])->name('global-scripts.update');
});

require __DIR__.'/auth.php';
