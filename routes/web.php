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

//VERFICATION LINK INSIDE EMAIL
Route::get('/verify/{email_token}', 'VerifyController@verify')->name('verify');

//Route::get('/home', 'HomeController@index');
//RESEND VERFICATION EMAIL LINK
Route::get('/resendEmailVerification', 'UserController@resendEmailVerification');

//TESTING REDIRECT TO USER PAGE AFTER TRYING TO COMMENT WITHOUT BEING LOGGED IN
//Route::get('/returnAfterLogin/{id}', 'Auth\LoginController@returnAfterLogin');
//USER BROWSING ROUTES
Route::get('/users', function() {
   return view('users');
});

Route::get('/user/{id}', 'UserController@userAnswers');

//USER AJAX SEARCH
Route::get('search', 'UserController@userSearch');

//TOP USERS ROUTE
Route::get('topUsers', 'UserController@topBoredGuys');

//NEWEST USERS ROUTE
Route::get('newestUsers', 'UserController@newestBoredGuys');

//HOME PAGE ROUTE
Route::get('/home', 'QuestionController@showHome');

//RECENT PAGE ROUTE
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

//SUMBIT COMMENT REQUEST
Route::post('/user/{id}/makeComment', 'CommentController@submitComment');

//DELETE COMMENT REQUEST
Route::post('/user/{id}/deleteComment', 'CommentController@deleteComment');

//EDIT COMMENT REQUEST
Route::post('/user/{id}/editComment', 'CommentController@editComment')->middleware('throttle:3');
//Route::post('editComment', 'CommentController@editComment')->middleware('throttle:3');

//HOME PAGE REQUESTS
Route::post('upload_image', 'UserController@upload')->middleware('throttle:3');

Route::post('change_description', 'UserController@updateDescription')->middleware('throttle:5');
