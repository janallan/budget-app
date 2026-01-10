<?php

use App\Livewire\CategoryList;
use App\Livewire\Home;
use App\Livewire\Transaction\TransactionList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/', Home::class)->name('home');

    Route::get('categories', CategoryList::class)->name('categories.index');
    Route::get('transactions', TransactionList::class)->name('transactions.index');

});
