<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagsController;
use App\Models\Category;
use App\Models\News;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tags', TagsController::class);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('news', NewsController::class);


});


/*
Route::get('/greeting', function () {
    $news = new News();
    $news->title = 'Breaking News';
    $news->brief = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
    $news->save();
    $news->categories()->attach([11, 16]);

    return $news ;
});

 */
