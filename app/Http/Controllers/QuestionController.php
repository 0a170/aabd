<?php

namespace App\Http\Controllers;

use Mail;
use App\Question;
use App\Comment;
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
       //$this->middleware('throttle');
    }

    public function submit(Request $req) {

      $question = $req['question'];
      $email = $req['email'];

      $this->validate($req, [
         'question' => 'required',
         'email' => 'required|email',
      ]);

      $question_check = Question::where('question', '=', $question)
                                  ->first();

      if($question_check) {
         //if question is already in the db send response back to js
         return Response()->json(['failure' => 'Question has already been asked']);
      }
      else {
         $new_question = new Question;
         $new_question->question = $question;
         $new_question->asker_email = $email;
         $new_question->save();

         //echo "Question submitted, we'll get back to you by email soon";
         //return redirect()->back()->with("message", "Question submitted, we'll get back to you by email soon");
         //echo "Question submitted, we'll get back to you by email soon";
         return Response()->json(['success' => 'Question Submitted']);
      }
   }



   public function showHome() {

      if(Auth::check()) {
         $userId = Auth::user()->id;
      }
      else {
         return view('auth.login')->with('status', 'Not logged in');
      }

      $questions = DB::table('questions')
                          ->leftJoin('answered_questions', 'answered_questions.answered_question', '=' ,'questions.question')
                          ->where('answered_questions.answered_question', null)
                          ->orderBy('questions.created_at', 'desc')
                          //->get();
                          ->paginate(5);

      /*$comments = Comment::where('u_id', '=', $userId)
                          ->select('u_id', 'comment_id', 'comment', 'commenter_id',
                                   'created_at', 'updated_at')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);*/
                          //->get();

      $comments = DB::table('comments')
                     ->join('users', function($join) use ($userId) {
                          $join->on('comments.commenter_id', '=', 'users.id')
                               ->where('u_id', '=', $userId);
                     })
                     ->select('u_id', 'profile_image', 'comment_id', 'comment', 'commenter_id',
                              'comments.created_at', 'comments.updated_at')
                     ->orderBy('comments.created_at', 'desc')
                     ->paginate(10);

      /*foreach($comments as $comment) {
         $commenter_icon = User::where('id', '=', $comment->commenter_id)
                                      ->select('profile_image')
                                      ->first();

         $comment['commenter_icon'] = $commenter_icon;
      }*/

      return view('home', ['questions' => $questions, 'comments' => $comments]);
   }

   public function answer(Request $req) {

      $answer_val = $req['answerInput'];
      $question_val = $req['ques'];
      $email_val = $req['ema'];
      //$userId = $req['use'];

      //IF USER IS LOGGED IN, GENERATE MAIL WITH ANSWER, SEND IT, THEN STORE IT IN DB
      if(Auth::check()) {
         $userId = Auth::user()->id;

         //SEND EMAIL WITH ANSWER
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

         //echo "Successfully sent!";
         //RETURN JSON SUCCESS
         return Response()->json(["successfulAnswer" => "Successfully Sent!"]);
      }
      //ELSE GO TO LOGIN PAGE
      else {
         return view('auth\login')->with('status', 'Not logged in');
      }
   }

}
