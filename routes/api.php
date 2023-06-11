<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SpecialityController;

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

// Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tags', TagsController::class);
    Route::apiResource('speciality', SpecialityController::class);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('article', NewsController::class);
    Route::apiResource('banner', BannerController::class);
    Route::get('/categories', [CategoryController::class, 'getCategories']);
    Route::get('/subcategories', [CategoryController::class, 'getSubCategories']);
    Route::get('/childcategories', [CategoryController::class, 'getChildCategories']);
    Route::get('/subcategories/category/{id}', [CategoryController::class, 'getSubCategoriesByCategoryId']);

    Route::get('/articles/category/{slug}', [CategoryController::class, 'getArticlesbyslug']);
    Route::get('/articles/speciality/{slug}', [NewsController::class, 'getArticlesbySpeciality']);
    Route::get('/articles/{slug}', [NewsController::class, 'getArticlesbyslug']);
    Route::put('/article/status/{id}', [NewsController::class, 'updateStatus']);
    Route::get('/allbanner', [BannerController::class, 'getallbanners']);
    Route::get('/allsectionnames', [SpecialityController::class, 'getallsectionnames']);
    Route::get('/tagswitharticles', [TagsController::class, 'getallarticles']);




// });


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
