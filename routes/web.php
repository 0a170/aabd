<?php

use App\User;
use App\AnsweredQuestion;
use Illuminate\Support\Facades\Auth;

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
    return view('ask');
});


Auth::routes();

//Route::get('/home', 'HomeController@index');

//USER BROWSING ROUTES
Route::get('/users', 'UserController@userList');

Route::get('/user/{id}', 'UserController@userAnswers');

//USER AJAX SEARCH
//Route::get('/search', 'UserController@userSearch');

Route::get('search', 'UserController@userSearch');


//USER ANSWERING ROUTES
Route::get('/home', 'QuestionController@showQues');

Route::get('/recent', 'AnsweredQuestionController@showAll');


Route::get('/ask', function() {
    return view('ask');
});

Route::post('submit', 'QuestionController@submit')->middleware('throttle:5');

Route::post('answer', 'QuestionController@answer')->middleware('throttle:10');

//RATE ROUTES FOR RATING REQUESTS ON THE RECENT PAGE
Route::post('like', 'AnsweredQuestionController@like')->middleware('throttle:10');

Route::post('dislike', 'AnsweredQuestionController@dislike')->middleware('throttle:10');

//RATE ROUTES FOR RATING REQUESTS ON USER PROFILE PAGES
Route::post('/user/{id}/like', 'AnsweredQuestionController@like')->middleware('throttle:10');

Route::post('/user/{id}/dislike', 'AnsweredQuestionController@dislike')->middleware('throttle:10');

//HOME PAGE REQUESTS
Route::post('upload_image', 'UserController@upload')->middleware('throttle:3');

Route::post('change_description', 'UserController@updateDescription')->middleware('throttle:5');

//ERROR ROUTE STILL IN TESTING
Route::get('/error', function() {
   return view('error');
});

//404 PAGE
Route::any('{query}',
   function() { return view('notfound'); })
   ->where('query', '.*');
