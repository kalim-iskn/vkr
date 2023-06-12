<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(["namespace" => "App\Http\Controllers", "middleware" => ["eduTatarSession"]], function () {
    Route::get("home", function () {
        return redirect()->route('profile', ['id' => auth()->id()]);
    })->name("home");

    Route::get('/', "LoginController@showForm")
        ->name("login");

    Route::post('/login', "LoginController@login")
        ->name("login-send");

    Route::group(['middleware' => 'auth'], function () {
        Route::get('user/{id}', 'UserController@showProfile')
            ->name("profile");

        Route::get('logout', 'LogoutController@logOut')
            ->name('logout');

        Route::get("term", "TermController@getTerm")
            ->name("term");

        Route::get("term/saved/{userId}", "TermController@getSavedTerm")
            ->name("saved-term");

        Route::get("diary", "DiaryController@getDiary")
            ->name("diary");

        Route::get("rating", "RatingController@get")
            ->name("rating");

        Route::get("forecasting", "GradeForecastingController@forecasting")
            ->name("forecasting");
    });
});
