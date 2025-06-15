<?php

use App\Livewire\Clients;
use App\Livewire\Orders;
use App\Http\Controllers\OrderPdfController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('/clients', Clients::class);

Route::view('/services-page', 'services-page');

Route::get('/orders', Orders::class);

Route::get('/orders/{order}/pdf', [OrderPdfController::class, 'generate'])->name('orders.pdf');