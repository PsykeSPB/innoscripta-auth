<?php

use Illuminate\Support\Facades\Route;
use Innoscripta\Domain\Auth\Http\Controllers\AuthenticatedUserController;
use Innoscripta\Domain\Auth\Http\Controllers\LoginController;
use Innoscripta\Domain\Auth\Http\Controllers\LogoutController;

Route::post('login', LoginController::class);

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', LogoutController::class);
    Route::get('user', AuthenticatedUserController::class);
});
