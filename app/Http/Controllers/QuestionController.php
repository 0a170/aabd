<?php

namespace App\Http\Controllers;

use Mail;
use App\Question;
use App\AnsweredQuestion;
use App\User;
use App\Mail\AnswerMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class QuestionController extends Controller
{

    public function __construct()
    {
       // $this->middleware('auth');
    }


    public function submit(Request $req) {

      $question = $req['question'];
      $email = $req['email'];


      $new_question = new Question;

      $new_question->question = $question;
      $new_question->asker_email = $email;

      $new_question->save();

      echo "Question submitted, we'll get back to you by email soon";

   }



   public function showQues() {

      if(Auth::check()) {

         $userId = Auth::user()->id;

      }
      else {

         return view('auth.login')->with('status', 'Not logged in');

      }



      //$questions = AnsweredQuestion::where('answered', 0)->get();
      /*$questions = Question::where('user_id', '!=', $userId)
                                            //->where('answered', 0)
                                            ->get(); */

      /*$questions = DB::table('answered_questions')
                          ->join('users', 'answered_questions.user_id', '=' ,'users.id')
                          ->where('users.id ')*/


      $questions = DB::table('questions')
                          /*->leftJoin('answered_questions', function($join) use($userId)
                          //->leftJoin('questions', function($join) use($userId)
                          {
                           $join->on('questions.question', '=', 'answered_questions.answered_question');
                           //$join->on('answered_questions.answered_question' , '=', 'questions.question')

                           //->where('answered_questions.answered_question', null);
                           //->where('answered_questions.user_id', '!=', $userId);
                           $join->where('answered_questions.user_id', '!=', $userId);
                           $join->orWhereNull('answered_questions.answered_question');
                           $join->orWhereNull('answered_questions.user_id');
                          }) */

                          ->leftJoin('answered_questions', 'answered_questions.answered_question', '=' ,'questions.question')

                          ->where('answered_questions.answered_question', null)
                          ->get();


      return view('home', ['questions' => $questions]);


   }



   public function answer(Request $req) {

      $answer_val = $req['answerInput'];
      $question_val = $req['ques'];
      $email_val = $req['ema'];
      //$userId = $req['use'];

      if(Auth::check()) {

         $userId = Auth::user()->id;

      }
      else {

         return view('auth\login')->with('status', 'Not logged in');

      }



      Mail::to($email_val)->send(new AnswerMail($answer_val));


      $new_answer = new AnsweredQuestion;

      $new_answer->user_id = $userId;
      $new_answer->user_answer = $answer_val;
      $new_answer->answered_question = $question_val;
      $new_answer->answer_score = 0;
      $new_answer->up_votes = 0;
      $new_answer->down_votes = 0;
      $new_answer->answered = 1;
      $new_answer->email_address = $email_val;

      $new_answer->save();



      return redirect()->back();


   }


}
