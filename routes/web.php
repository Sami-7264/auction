<?php

use App\Http\Controllers\CronController;
use App\Lib\Router;
use Illuminate\Support\Facades\Route;


// Cron Job
Route::get('select/winners', [CronController::class, 'winners'])->name('auction.product.winners');



// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->group(function () {
    Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');

    Route::get('/category/product/{id}', 'categoryProduct')->name('category.product');

    Route::get('/auctions', 'allProduct')->name('product');
    Route::get('fetch/product', 'fetchProductData')->name('fetch.product');
    Route::get('product/details/{slug}/{id}', 'productDetails')->name('product.details');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('blog', 'allBlog')->name('blog');

    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');
    Route::get('/blog/search', 'blogSearch')->name('blog.search');

    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');

    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');


    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});


