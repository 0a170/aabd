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

//USER ANSWERING ROUTES
Route::get('/home', 'QuestionController@showQues');

Route::get('/recent', 'AnsweredQuestionController@showAll');

//Route::post('logout', 'AnsweredQuestionController@logOut');
//Route::post('/logout', 'Auth\LoginController@logOut');


//Route::get('/recent', function() {
 //  return view('recent', );
//});

Route::get('/ask', function() {
    return view('ask');
});

Route::post('submit', 'QuestionController@submit');

Route::post('answer', 'QuestionController@answer');

/*Route::post('answer', function(\Illuminate\Http\Request $request,
   \Illuminate\Mail\Mailer $mailer) {
      $mailer
      ->to($request->input('ema'))
      ->send(new \App\Mail\AnswerMail($request->input('answerInput')));

      //AnsweredQuestion::find(Auth::user()->user_id;



   return redirect()->back();
})->name('answer'); */



Route::post('like', 'AnsweredQuestionController@like');

Route::post('dislike', 'AnsweredQuestionController@dislike');

Route::post('upload_image', 'UserController@upload');

Route::post('change_description', 'UserController@updateDescription');

//ERROR ROUTE STILL IN TESTING
Route::get('/error', function() {
   return view('error');
});
