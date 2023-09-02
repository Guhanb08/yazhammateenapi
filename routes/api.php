<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BkcategoryController;
use App\Http\Controllers\BklistController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SpecialityController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\TkcategoryController;
use App\Models\Category;
use App\Models\News;
use App\Http\Controllers\TknewsController;




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
    Route::apiResource('banner', BannerController::class);
    Route::apiResource('general', GeneralController::class);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('article', NewsController::class);
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


    Route::apiResource('tkcategory', TkcategoryController::class);
    Route::apiResource('tkarticle', TknewsController::class);
    Route::get('/tkcategories', [TkcategoryController::class, 'getCategories']);
    Route::get('/tksubcategories', [TkcategoryController::class, 'getSubCategories']);
    Route::get('/tkchildcategories', [TkcategoryController::class, 'getChildCategories']);
    Route::get('/tksubcategories/category/{id}', [TkcategoryController::class, 'getSubCategoriesByCategoryId']);

    Route::get('/tkarticles/category/{slug}', [TkcategoryController::class, 'getArticlesbyslug']);
    Route::get('/tkarticles/{slug}', [TknewsController::class, 'getArticlesbyslug']);
    Route::put('/tkarticle/status/{id}', [TknewsController::class, 'updateStatus']);
    Route::get('/bookcategories/cat/{id}', [TkcategoryController::class, 'getBookCategories']);




    Route::apiResource('bkcategory', BkcategoryController::class);
    Route::get('/bkallcategories/category/{id}', [BkcategoryController::class, 'getallCategories']);
    Route::get('/bksublistcategory/category/{id}', [BkcategoryController::class, 'getsublistCategories']);
    Route::get('/bkcategories', [BkcategoryController::class, 'getCategories']);
    Route::get('/bksubcategories', [BkcategoryController::class, 'getSubCategories']);
    Route::get('/bkchildcategories', [BkcategoryController::class, 'getChildCategories']);
    Route::get('/bkgrandchildcategories', [BkcategoryController::class, 'getGrandChildCategories']);
    Route::get('/bksubcategories/category/{id}', [BkcategoryController::class, 'getSubCategoriesByCategoryId']);
    Route::get('/bkchildcategories/category/{id}', [BkcategoryController::class, 'getChildCategoriesByCategoryId']);
    Route::get('/booklist', [BkcategoryController::class, 'getbooklist']);




    Route::apiResource('bklist', BklistController::class);
    Route::get('/bklist/cat/{id}', [BklistController::class, 'getBookCategories']);

    Route::get('/bklistsubcategories/category/{id}', [BklistController::class, 'getSubCategoriesByCategoryId']);
    


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
