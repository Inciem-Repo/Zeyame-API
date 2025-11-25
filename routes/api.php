<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PosterController;
use App\Http\Controllers\ViewCategoryController;
use App\Http\Controllers\ViewCategoryControllerTwo;
use App\Http\Controllers\ViewCategoryControllerThree;
use App\Http\Controllers\Website\FontController;
use App\Http\Controllers\Website\ImageController;
use App\Http\Controllers\Website\BackgroundController;
use App\Http\Controllers\WebFont\FontController as FFont;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login',[ViewCategoryController::class,'jsonlogin']);
Route::post('/category',[ViewCategoryController::class,'jsoncat']);
Route::post('/slider',[ViewCategoryController::class,'jsonslider']);
Route::post('/slidernew',[ViewCategoryController::class,'jsonslidernew']);
Route::post('/poster/{id?}',[ViewCategoryController::class,'jsonposter']);
Route::get('/logo/{id?}',[ViewCategoryController::class,'jsonlogo']);
Route::post('/goldrate/{id?}',[ViewCategoryController::class,'jsongoldrate']);
Route::post('/goldrateupdate/{id?}',[ViewCategoryController::class,'jsongoldrateupdate']);
Route::post('/generate/{id}/{res}',[ViewCategoryController::class,'jsongenerate']);
Route::post('/generatebase/{id}/{res}',[ViewCategoryController::class,'jsongeneratebase']);
Route::get('/generatedirect/{id}/{res}/{userid}',[ViewCategoryController::class,'jsongeneratedirect']);
Route::get('/generatedirectapp/{id}/{res}/{userid}',[ViewCategoryController::class,'jsongeneratedirectapp']);
Route::get('/generatedirectappedit/{id}/{res}/{userid}',[ViewCategoryController::class,'jsongeneratedirectappedit']);
Route::get('/generatedirectappvideo/{id}/{res}/{userid}',[ViewCategoryController::class,'jsongeneratedirectappvideo']);
Route::get('/generatedirectdownload/{id}/{res}/{userid}',[ViewCategoryController::class,'jsongeneratedirectdownload']);
Route::post('/download',[ViewCategoryController::class,'jsondownload']);
Route::get('/fonts', [FFont::class, 'getFonts'])->name('get.fonts');
//version 2
Route::post('/categoryvtwo',[ViewCategoryController::class,'jsoncatvtwo']);
Route::post('/categoryvtwodet',[ViewCategoryController::class,'jsoncatvtwodet']);

//ffmpeg test
//version 7
Route::post('/generatebasevideo/{id}/{res}',[ViewCategoryController::class,'jsongeneratebasevideo']);

Route::get('/ffmpeg',[ViewCategoryController::class,'ffmpeg']);


Route::prefix('v2')->group(function () {
    Route::post('/login',[ViewCategoryControllerTwo::class,'jsonlogin']);
    Route::post('/category',[ViewCategoryControllerTwo::class,'jsoncat']);
    Route::post('/slider',[ViewCategoryControllerTwo::class,'jsonslider']);
    Route::post('/slidernew',[ViewCategoryControllerTwo::class,'jsonslidernew']);
    Route::post('/poster/{id?}',[ViewCategoryControllerTwo::class,'jsonposter']);
    Route::get('/logo/{id?}',[ViewCategoryControllerTwo::class,'jsonlogo']);
    Route::post('/goldrate/{id?}',[ViewCategoryControllerTwo::class,'jsongoldrate']);
    Route::post('/goldrateupdate/{id?}',[ViewCategoryControllerTwo::class,'jsongoldrateupdate']);
    Route::post('/generate/{id}/{res}',[ViewCategoryControllerTwo::class,'jsongenerate']);
    Route::post('/generatebase/{id}/{res}',[ViewCategoryControllerTwo::class,'jsongeneratebase']);
    Route::get('/generatedirect/{id}/{res}/{userid}',[ViewCategoryControllerTwo::class,'jsongeneratedirect']);
    Route::get('/generatedirectapp/{id}/{res}/{userid}',[ViewCategoryControllerTwo::class,'jsongeneratedirectapp']);
    Route::get('/generatedirectappedit/{id}/{res}/{userid}',[ViewCategoryControllerTwo::class,'jsongeneratedirectappedit']);
    Route::get('/generatedirectappvideo/{id}/{res}/{userid}',[ViewCategoryControllerTwo::class,'jsongeneratedirectappvideo']);
    Route::get('/generatedirectdownload/{id}/{res}/{userid}',[ViewCategoryControllerTwo::class,'jsongeneratedirectdownload']);
    Route::post('/download',[ViewCategoryControllerTwo::class,'jsondownload']);
    
    //version 2
    Route::post('/categoryvtwo',[ViewCategoryControllerTwo::class,'jsoncatvtwo']);
    Route::post('/categoryvtwodet',[ViewCategoryControllerTwo::class,'jsoncatvtwodet']);
     Route::get('/generatedirectaws/{id}',[ViewCategoryControllerTwo::class,'jsongeneratedirectaws']);
     Route::get('/demo',[ViewCategoryControllerTwo::class,'jsondemo']);
    Route::get('/categoryaws/{id}',[ViewCategoryControllerTwo::class,'jsoncataws']);
    Route::get('/custaws/{id}',[ViewCategoryControllerTwo::class,'jsoncustaws']);
    
    //ffmpeg test
    //version 7
    Route::post('/generatebasevideo/{id}/{res}',[ViewCategoryControllerTwo::class,'jsongeneratebasevideo']);
    
    Route::get('/ffmpeg',[ViewCategoryControllerTwo::class,'ffmpeg']);
    
   
});
Route::prefix('v3')->group(function () {
    Route::post('/login',[ViewCategoryControllerThree::class,'jsonlogin']);
    Route::post('/category',[ViewCategoryControllerThree::class,'jsoncat']);
    Route::post('/slider',[ViewCategoryControllerThree::class,'jsonslider']);
    Route::post('/slidernew',[ViewCategoryControllerThree::class,'jsonslidernew']);
    Route::post('/poster/{id?}',[ViewCategoryControllerThree::class,'jsonposter']);
    Route::get('/logo/{id?}',[ViewCategoryControllerThree::class,'jsonlogo']);
     Route::get('/endscreen/{id?}',[ViewCategoryControllerThree::class,'jsonendscreen']);
    Route::post('/goldrate/{id?}',[ViewCategoryControllerThree::class,'jsongoldrate']);
    Route::post('/goldrateupdate/{id?}',[ViewCategoryControllerThree::class,'jsongoldrateupdate']);
    Route::post('/generate/{id}/{res}',[ViewCategoryControllerThree::class,'jsongenerate']);
    Route::post('/generatebase/{id}/{res}',[ViewCategoryControllerThree::class,'jsongeneratebase']);
    Route::get('/generatedirect/{id}/{res}/{userid}',[ViewCategoryControllerThree::class,'jsongeneratedirect']);
    Route::get('/generatedirectapp/{id}/{res}/{userid}',[ViewCategoryControllerThree::class,'jsongeneratedirectapp']);
    Route::get('/generatedirectappedit/{id}/{res}/{userid}',[ViewCategoryControllerThree::class,'jsongeneratedirectappedit']);
    Route::get('/generatedirectappvideo/{id}/{res}/{userid}',[ViewCategoryControllerThree::class,'jsongeneratedirectappvideo']);
    Route::get('/generatedirectdownload/{id}/{res}/{userid}',[ViewCategoryControllerThree::class,'jsongeneratedirectdownload']);
    Route::post('/download',[ViewCategoryControllerThree::class,'jsondownload']);
    
    //version 2
    Route::post('/categoryvtwo',[ViewCategoryControllerThree::class,'jsoncatvtwo']);
    Route::post('/categoryvtwodet',[ViewCategoryControllerThree::class,'jsoncatvtwodet']);
     Route::get('/generatedirectaws/{id}',[ViewCategoryControllerThree::class,'jsongeneratedirectaws']);
     Route::get('/demo',[ViewCategoryControllerThree::class,'jsondemo']);
    Route::get('/categoryaws/{id}',[ViewCategoryControllerThree::class,'jsoncataws']);
    Route::get('/custaws/{id}',[ViewCategoryControllerThree::class,'jsoncustaws']);
    Route::post('/fetchcategorys', [ViewCategoryControllerThree::class, 'loginAndFetchCategories']);
    Route::post('/fetch-subcategories', [ViewCategoryControllerThree::class, 'fetchSubCategories']);
    // Route::post('/fetch-sub-subcategories', [ViewCategoryControllerThree::class, 'fetchSubSubCategories']);
    Route::post('/fetch-banners', [ViewCategoryControllerThree::class, 'fetchBanners']);
    Route::post('/fetch-templates', [ViewCategoryControllerThree::class, 'fetchtemplates']);




    
    
    //ffmpeg test
    //version 7
    Route::post('/generatebasevideo/{id}/{res}',[ViewCategoryControllerThree::class,'jsongeneratebasevideo']);
    
    Route::get('/ffmpeg',[ViewCategoryControllerThree::class,'ffmpeg']);
    Route::post('/editor/{id}',[ViewCategoryControllerThree::class,'editorjson']);
    Route::post('/logoimages',[ViewCategoryControllerThree::class,'logoimagesjson']);
    
   
});
Route::post('/upload-font', [FontController::class,'uploadJson']);
Route::get('/font-files', [FontController::class,'getJsonFiles']);
Route::get('/font-files-sub', [FontController::class,'getJsonFilesSub']);
Route::get('/font-files-search', [FontController::class,'getJsonFilesSearch']);
Route::get('/font', [FontController::class,'getCategories']);


Route::post('/upload-image', [ImageController::class,'uploadJson']);
Route::get('/image-files', [ImageController::class,'getJsonFiles']);
Route::get('/image-files-sub', [ImageController::class,'getJsonFilesSub']);
Route::get('/image-files-search', [ImageController::class,'getJsonFilesSearch']);
Route::get('/image-files-search-v2', [ImageController::class,'getJsonFilesSearchv2']);
Route::get('/image', [ImageController::class,'getCategories']);


Route::post('/upload-background', [BackgroundController::class,'uploadJson']);
Route::get('/background-files', [BackgroundController::class,'getJsonFiles']);
Route::get('/background-files-sub', [BackgroundController::class,'getJsonFilesSub']);
Route::get('/background-files-search', [BackgroundController::class,'getJsonFilesSearch']);
Route::get('/background', [BackgroundController::class,'getCategories']);
