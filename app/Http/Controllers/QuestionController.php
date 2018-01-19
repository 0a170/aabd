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


      $this->validate($req, [
         'question' => 'required',
         'email' => 'required|email',
      ]);


      $new_question = new Question;

      $new_question->question = $question;
      $new_question->asker_email = $email;

      $new_question->save();

      //echo "Question submitted, we'll get back to you by email soon";
      //return redirect()->back()->with("message", "Question submitted, we'll get back to you by email soon");
      echo "Question submitted, we'll get back to you by email soon";
   }



   public function showQues() {

      if(Auth::check()) {

         $userId = Auth::user()->id;

      }
      else {

         return view('auth.login')->with('status', 'Not logged in');

      }

      $questions = DB::table('questions')
                          ->leftJoin('answered_questions', 'answered_questions.answered_question', '=' ,'questions.question')
                          ->where('answered_questions.answered_question', null)
                          //->get();
                          ->paginate(5);

      $comments = DB::table('comments')
                          ->where('u_id', '=', $userId)
                          ->paginate(10);

      return view('home', ['questions' => $questions, 'comments' => $comments]);

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


      echo "Successfully sent!";
      //return redirect()->back();

   }

}
