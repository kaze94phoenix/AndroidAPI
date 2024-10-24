<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\LikesController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});
*/

//user
Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);
Route::get('logout',[AuthController::class,'logout']);

//post
Route::get('posts/',[PostsController::class,'index'])->middleware('jwtAuth');
Route::post('posts/create',[PostsController::class,'create'])->middleware('jwtAuth');
Route::get('posts/show',[PostsController::class,'show'])->middleware('jwtAuth');
Route::post('posts/update',[PostsController::class,'update'])->middleware('jwtAuth');
Route::delete('posts/delete',[PostsController::class,'delete'])->middleware('jwtAuth');

//comment
Route::get('posts/comments/',[CommentsController::class,'comments'])->middleware('jwtAuth');
Route::post('comments/create',[CommentsController::class,'create'])->middleware('jwtAuth');
Route::get('comments/show',[CommentsController::class,'show'])->middleware('jwtAuth');
Route::post('comments/update',[CommentsController::class,'update'])->middleware('jwtAuth');
Route::delete('comments/delete',[CommentsController::class,'delete'])->middleware('jwtAuth');

//like
Route::get('posts/likes/',[LikesController::class,'likes'])->middleware('jwtAuth');
Route::post('likes/like',[LikesController::class,'like'])->middleware('jwtAuth');
