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

    public function showAll() {

      $ip = $req->getIp();
      //$ip = request()->ip();

      $answers = AnsweredQuestion::where('answered', 1)
                                        ->orderBy('updated_at', 'desc')
                                        //->get();
                                        ->paginate(10);

      return view('recent', ['answers' => $answers]);

    }

    public function like(Request $req) {

      $user_id = $req['UIDName'];
      $answer = $req['answeredQuestionName'];
      $answer_id = (int)$req['AIDName'];
      //$ip_add = request()->ip();
      $ip_add = $req->getIp();

      // COMPARE CLIENT'S IP ADDRESS WITH IP ADDRESSES IN VOTE TABLE FOR SPECIFIC ANSWER VOTE
      $vote_check = Vote::where('ip_address', $ip_add)
                               ->where('answer_id', $answer_id)
                               ->first();

      //IF USER HAS NOT VOTED, CREATE A LIKE
      if(!$vote_check) {
         $new_vote = new Vote;
         $new_vote->answer_id = $answer_id;
         $new_vote->answer = $answer;
         $new_vote->vote_up = 1;
         $new_vote->vote_down = 0;
         $new_vote->ip_address = $ip_add;
         $new_vote->save();

         //INCREMEMT USER SCORE
         User::where('id', $user_id)->increment('score', 10);

         //INCREMENT LIKE COUNTER
         AnsweredQuestion::where('answer_id', $answer_id)->increment('up_votes');

         $new_up_votes = AnsweredQuestion::select('up_votes')
                                                ->where('answer_id', $answer_id)
                                               ->first();

         $new_up_votes = (int)$new_up_votes->up_votes;

         //echo $new_up_votes[0];
         return Response()->json(['newVote' => $new_up_votes]);
      }
      //ELSE EITHER ALREADY LIKED OR CHANGING VOTE TO LIKE
      else {
         if($vote_check->vote_up == 1) {
            return Response()->json(['alreadyLiked' => 'Already liked']);
         }
         else
      // CHANGE VOTE FROM DISLIKE TO LIKE
         if(($vote_check->vote_up == 0) && ($vote_check->vote_down == 1)) {
            // CHANGE VOTE TO LIKE
            $vote_check->vote_up = 1;
            $vote_check->vote_down = 0;
            $vote_check->save();

            User::where('id', $user_id)->increment('score', 10);

            //INCREMENT ANSWER LIKE COUNT AND DECREMENT DISLIKE COUNT
            AnsweredQuestion::where('answer_id', $answer_id)
                                   ->increment('up_votes', 1);
            AnsweredQuestion::where('answer_id', $answer_id)
                                   ->decrement('down_votes', 1);

            $change_to_upvote = AnsweredQuestion::select('up_votes', 'down_votes')
                                                        ->where('answer_id', $answer_id)
                                                        ->first();

            return Response()->json(['changedToUp' =>
                                                   ['changedUp' => $change_to_upvote->up_votes,
                                                    'changedDown' => $change_to_upvote->down_votes]]);
         }
      }
    }

    public function dislike(Request $req) {

      $user_id = $req['UIDName'];
      $answer = $req['answeredQuestionName'];
      $answer_id = (int)$req['AIDName'];
      //$ip_add = request()->ip();
      $ip_add = $req->getIp();

      // COMPARE CLIENT'S IP ADDRESS WITH IP ADDRESSES IN VOTE TABLE FOR SPECIFIC ANSWER VOTE
      $vote_check = Vote::where('ip_address', $ip_add)
                                ->where('answer_id', $answer_id)
                                ->first();

      //CREATE A NEW DISLIKE IF IP ADDRESS HAS NOT VOTED ON THIS ANSWER
      if(!$vote_check) {

         $new_vote = new Vote;
         $new_vote->answer_id = $answer_id;
         $new_vote->answer = $answer;
         $new_vote->vote_up = 0;
         $new_vote->vote_down = 1;
         $new_vote->ip_address = $ip_add;
         $new_vote->save();

         //DECREMENT USER SCORE
         User::where('id', $user_id)->decrement('score', 10);
         //User::where('id', $user_id)->increment('score', -10);

         //ADD DOWNVOTE TO ANSWER
         AnsweredQuestion::where('answer_id', $answer_id)->increment('down_votes');

         //PASS NEW DOWNVOTE SCORE TO VOTE TO VOTING AJAX SCRIPT
         $new_down_votes = AnsweredQuestion::select('down_votes')
                                                   ->where('answer_id', $answer_id)
                                                   ->first();

         $new_down_votes = (int)$new_down_votes->down_votes;

         return Response()->json(['newDislike' => $new_down_votes]);
      }
      //ELSE EITHER ALREADY DISLIKED OR CHANGING VOTE TO DISLIKE
      else {
         //ALREADY DISLIKED
         if(($vote_check->vote_down == 1) && ($vote_check->vote_up == 0)) {
            return Response()->json(['alreadyDisliked' => 'Already disliked']);
         }
         else
         //CHANGE VOTE FROM LIKE TO DISLIKE
         if(($vote_check->vote_up == 1) && ($vote_check->vote_down == 0)) {
         //CHANGE VOTER VOTE TO DISLIKE
            $vote_check->vote_up = 0;
            $vote_check->vote_down = 1;
            $vote_check->save();

            //DECREMENT USER SCORE
            User::where('id', $user_id)->decrement('score', 10);

            //INCREMENT NUMBER OF DISLIKES AND DECREMENT NUMBER OF LIKES FOR ANSWER
            AnsweredQuestion::where('answer_id', $answer_id)
                                   ->decrement('up_votes', 1);
            AnsweredQuestion::where('answer_id', $answer_id)
                                   ->increment('down_votes', 1);

            $change_to_downvote = AnsweredQuestion::select('up_votes', 'down_votes')
                                                          ->where('answer_id', $answer_id)
                                                          ->first();

            return Response()->json(['changedToDown' =>
                                                   ['changedUp' => $change_to_downvote->up_votes,
                                                    'changedDown' => $change_to_downvote->down_votes]]);
         }
      }
    }

    public function fivePerPage() {

    }

    public function tenPerPage() {

    }

    public function fifteenPerPage() {

    }

    public function twentyPerPage() {

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
