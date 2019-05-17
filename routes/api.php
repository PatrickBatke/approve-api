<?php

use Illuminate\Http\Request;

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

// Routen für den Austausch von Daten zwischen ng und laravel
Route::group(['prefix' => 'project-data'], function () {
    Route::get('overview', 'ProjectController@showProjects');
    Route::get('project/{id}', ['as' => 'Single', 'uses' =>'ProjectController@showSingleProject'])->name('projectsingle');
    Route::post('project-picture', 'ProjectController@showProjectPicture');
    Route::get('tags/{id}', ['as' => 'Tags', 'uses' =>'ProjectController@showTagsForProject'])->name('tagsforproject');
    Route::get('files/{id}', ['as' => 'Files', 'uses' =>'ProjectController@showFilesForProject'])->name('filesforproject');
    // Route::get('product-infos', 'ProjectController@productinfos');
    // Route::get('brand-infos', 'ProjectController@brandinfos');
    Route::get('get_types', 'TypeController@getTypes');
    Route::post('create-project', 'ProjectController@createProject');
    Route::post('upload-file', 'ProjectController@uploadFile');
    Route::post('upload-pic', 'ProjectController@uploadPic');
    Route::post('delete-project', 'ProjectController@deleteProject');
    Route::get('delete-file/{id}', ['as' => 'DeleteFiles', 'uses' =>'ProjectController@deleteFile'])->name('deletefileforproject');
    Route::post('create-tag', 'ProjectController@createTags');
});

// Routen für den Commenter
Route::group(['prefix' => 'commenter'], function () {
    Route::get('comment/{id}', 'CommentController@showProjectComments');
    Route::post('create-comment', 'CommentController@createComment');
    Route::get('delete-comment/{id}', ['as' => 'DeleteComment', 'uses' =>'CommentController@deleteComment'])->name('deletecomment');
});

// Routen für das Login-System
Route::group(['prefix' => 'authentification'], function () {
    Route::post('register', 'Authentification\UserController@register');
    Route::post('login', 'Authentification\UserController@login');
    Route::get('current-user', 'Authentification\UserController@currentUser');
    Route::get('verify/{id}/{email}/{token}', ['as' => 'Verify', 'uses' =>'Authentification\UserController@verify'])->name('verify');
    Route::post('passwordReset', 'Authentification\UserController@passwordReset');
    Route::post('forgot', 'Authentification\UserController@forgot');
    Route::post('resetToken', 'Authentification\UserController@resetToken');
});
