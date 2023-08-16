<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImapController;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/imap')->group(function () {
    Route::get('/', [ImapController::class, 'fetchFromSpecificEmail']);
    Route::get('/all', [ImapController::class, 'fetchAll']);
    Route::get('/unseen', [ImapController::class, 'fetchUnseenMessage']);
    Route::get('/txt', [ImapController::class, 'fetchWithSpecificText']);
    Route::get('/since', [ImapController::class, 'fetchSinceSpecificDate']);
});
