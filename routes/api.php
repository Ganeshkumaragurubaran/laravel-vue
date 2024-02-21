<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

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
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
    Route::post('login', [AuthController::class,'login']);
    Route::post('blog-posts', [PostController::class,'store']);
    Route::get('categories', [PostController::class,'sendCategories']);
    Route::get('posts', [PostController::class,'posts']);
    Route::get('my/posts', [PostController::class,'myPosts']);
    Route::post('posts/{postId}/like', [PostController::class,'likePost']);
    Route::post('/comments', [PostController::class, 'storeComments']);
    Route::get('/comments/{post}', [PostController::class, 'comments']);
});

Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
