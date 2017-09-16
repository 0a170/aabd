<?php

namespace App\Http\Controllers;

use Mail;
use App\AnsweredQuestion;
use App\Vote;
use App\User;
use App\Mail\AnswerMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Redirect;

//use App\AnsweredQuestion;

class AnsweredQuestionController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /*public function logOut(Request $req) {

      Auth::logout();

      return view('ask');

    } */

    public function showAll() {


      $answers = AnsweredQuestion::where('answered', 1)
                                        ->orderBy('updated_at', 'desc')
                                        ->get();

      //return $answers;
      //return View::make('recent', $answers);
      //return view('recent')->with($answers);
      return view('recent', ['answers' => $answers]);

    }


    public function like(Request $req) {


      $user_id = $req['UIDName'];
      $answer = $req['answeredQuestionName'];
      $answer_id = (int)$req['AIDName'];
      //$ip_add = $req->ip();
      $ip_add = \Request::getClientIp();

      // COMPARE CLIENT'S IP ADDRESS WITH IP ADDRESSES IN VOTE TABLE FOR SPECIFIC ANSWER VOTE

      /*NOT SURE WHAT'S HAPPENING TO WHERE VOTES FROM THE SAME IP ADDR STILL WORK FOR THE SAME
      ANSWER AFTER A FEW SECONDS OR SOMETHING*/
      //$vote_exists = Vote::where('answer_id', '=', $answer_id)->where('ip_address', '=', $ip_add)->first();

      $vote_exists = Vote::where('answer_id', $answer_id)->where('ip_address', $ip_add)->first();

      //if(Vote::where('answer_id', '=', $answer_id)->where('ip_address', '=', $ip_add)->get()) {
      if(!(is_null($vote_exists))) {

         echo "Already voted";

      }

      else

      if(is_null($vote_exists)) {

         $new_vote = new Vote;

         //$new_answer->vote_id = $userId;
         $new_vote->answer_id = $answer_id;
         $new_vote->answer = $answer;
         $new_vote->vote_up = 1;
         $new_vote->vote_down = 0;
         $new_vote->ip_address = $ip_add;


         $new_vote->save();

         User::where('id', $user_id)->increment('score', 10);

         AnsweredQuestion::where('answer_id', $answer_id)->increment('up_votes');

         $new_up_votes = AnsweredQuestion::select('up_votes')->where('answer_id', $answer_id)->get();
         //$new_up_votes = AnsweredQuestion::select('up_votes')->where('answer_id', $answer_id)->first();

         echo $new_up_votes[0];
         //echo $new_up_votes;
      }

    }


    public function dislike(Request $req) {

      $user_id = $req['UIDName'];
      $answer = $req['answeredQuestionName'];
      $answer_id = (int)$req['AIDName'];
      //$ip_add = $req->ip();
      $ip_add = \Request::getClientIp();

      $vote_exists = Vote::where('answer_id', '=', $answer_id)->where('ip_address', '=', $ip_add)->first();

      if(!(is_null($vote_exists))) {
      //if(DB::table('votes')->where('answer_id', '=', $answer_id)->where('ip_address', '=', $ip_add)->first()) {

         echo "Already voted";

      }

      else

      if(is_null($vote_exists)) {

         $new_vote = new Vote;

         //$new_answer->vote_id = $userId;
         $new_vote->answer_id = $answer_id;
         $new_vote->answer = $answer;
         $new_vote->vote_up = 1;
         $new_vote->vote_down = 0;
         $new_vote->ip_address = $ip_add;

         $new_vote->save();



         User::where('id', $user_id)->increment('score', -10);

         AnsweredQuestion::where('answer_id', $answer_id)->increment('down_votes');

         $new_down_votes = AnsweredQuestion::select('down_votes')->where('answer_id', $answer_id)->get();
         //$new_down_votes = AnsweredQuestion::select('down_votes')->where('answer_id', $answer_id)->first();

         echo $new_down_votes[0];
         //echo $new_down_votes;
      }

    }





    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        return view('recent');
    }
}
