<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewCategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\WebFont\FontCategoryController;
use App\Http\Controllers\WebFont\FontController;
use App\Http\Controllers\WebImage\ImageCategoryController;
use App\Http\Controllers\WebImage\ImageController as Img;
use App\Http\Controllers\WebBackground\BackgroundCategoryController;
use App\Http\Controllers\WebBackground\BackgroundController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('image-upload', [ ImageController::class, 'upload' ])->name('image.upload');
Route::get('user-image', [ ImageController::class, 'userimage' ])->name('image.userimage');
Route::post('image-store', [ ImageController::class, 'store' ])->name('image.upload.post');


Route::get('/category',[ViewCategoryController::class,'index']);
Route::get('/poster/{id?}',[ViewCategoryController::class,'poster']);
Route::get('/editor/{id}',[ViewCategoryController::class,'editor']);
Route::get('/generate/{id}/{res}',[ViewCategoryController::class,'generate']);
Route::get('/generatecpy/{id}',[ViewCategoryController::class,'generatecpy'])->name('generatecpy');
Route::get('/demo/{id}',[ViewCategoryController::class,'demo']);
Route::post('/editorsave',[ViewCategoryController::class,'editorsave']);



Route::get('/posters/create/{id}', [ViewCategoryController::class, 'create'])->name('posters.create');
Route::post('/posters/{id}', [ViewCategoryController::class, 'store'])->name('posters.store');

Route::get('/font-categories', [FontCategoryController::class, 'index'])->name('font_categories.index');
Route::get('/font-categories/create', [FontCategoryController::class, 'create'])->name('font_categories.create');
Route::post('/font-categories', [FontCategoryController::class, 'store'])->name('font_categories.store');
Route::get('/font-categories/{id}/edit', [FontCategoryController::class, 'edit'])->name('font_categories.edit');
Route::put('/font-categories/{id}', [FontCategoryController::class, 'update'])->name('font_categories.update');
Route::delete('/font-categories/{id}', [FontCategoryController::class, 'destroy'])->name('font_categories.destroy');

Route::get('/font', [FontController::class, 'index'])->name('font.index');
Route::get('/font/create', [FontController::class, 'create'])->name('font.create');
Route::post('/font', [FontController::class, 'store'])->name('font.store');
Route::get('/font/{id}/edit', [FontController::class, 'edit'])->name('font.edit');
Route::put('/font/{id}', [FontController::class, 'update'])->name('font.update');
Route::delete('/font/{id}', [FontController::class, 'destroy'])->name('font.destroy');


Route::get('/image-categories', [ImageCategoryController::class, 'index'])->name('image_categories.index');
Route::get('/image-categories/create', [ImageCategoryController::class, 'create'])->name('image_categories.create');
Route::post('/image-categories', [ImageCategoryController::class, 'store'])->name('image_categories.store');
Route::get('/image-categories/{id}/edit', [ImageCategoryController::class, 'edit'])->name('image_categories.edit');
Route::put('/image-categories/{id}', [ImageCategoryController::class, 'update'])->name('image_categories.update');
Route::delete('/image-categories/{id}', [ImageCategoryController::class, 'destroy'])->name('image_categories.destroy');

Route::get('/image', [Img::class, 'index'])->name('image.index');
Route::get('/image/create', [Img::class, 'create'])->name('image.create');
Route::post('/image', [Img::class, 'store'])->name('image.store');
Route::get('/image/{id}/edit', [Img::class, 'edit'])->name('image.edit');
Route::put('/image/{id}', [Img::class, 'update'])->name('image.update');
Route::delete('/image/{id}', [Img::class, 'destroy'])->name('image.destroy');





Route::get('/background-categories', [BackgroundCategoryController::class, 'index'])->name('background_categories.index');
Route::get('/background-categories/create', [BackgroundCategoryController::class, 'create'])->name('background_categories.create');
Route::post('/background-categories', [BackgroundCategoryController::class, 'store'])->name('background_categories.store');
Route::get('/background-categories/{id}/edit', [BackgroundCategoryController::class, 'edit'])->name('background_categories.edit');
Route::put('/background-categories/{id}', [BackgroundCategoryController::class, 'update'])->name('background_categories.update');
Route::delete('/background-categories/{id}', [BackgroundCategoryController::class, 'destroy'])->name('background_categories.destroy');

Route::get('/background', [BackgroundController::class, 'index'])->name('background.index');
Route::get('/background/create', [BackgroundController::class, 'create'])->name('background.create');
Route::post('/background', [BackgroundController::class, 'store'])->name('background.store');
Route::get('/background/{id}/edit', [BackgroundController::class, 'edit'])->name('background.edit');
Route::put('/background/{id}', [BackgroundController::class, 'update'])->name('background.update');
Route::delete('/background/{id}', [BackgroundController::class, 'destroy'])->name('background.destroy');
