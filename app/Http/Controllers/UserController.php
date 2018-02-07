<?php

namespace App\Http\Controllers;
//include composer autoload
//require '../vendor/autoload.php';


use View;
use Image;
use Storage;
use App\User;
use App\Comment;
use App\AnsweredQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller {


   public function __construct() {
       // $this->middleware('auth');
   }

   public function profile($id) {

      $user = User::findOrFail($id);
      return view('user_profile', ['user' => $user]);

   }

   public function userList() {

      $users = User::select('id', 'user_name', 'description', 'profile_image', 'questions_answered', 'score')->get();
      return view('users', ['users' => $users]);

   }

   public function userAnswers($id, Request $req) {

      //GET USER OBJECT
      $user = User::findOrFail($id);

      //$answered_question = AnsweredQuestion::find($id);

      $ip_add = $req->ip();
      //GET ALL ANSWERED QUESTIONS BY USER
      $user_answers = AnsweredQuestion::where('user_id', $id)
                                             ->orderBy('updated_at', 'desc')
                                             //->get();
                                             ->paginate(10);

      /*$user_answers = DB::table('answered_questions')
                         ->join('votes', function($join) use ($id) {
                              $join->on('answered_questions.answer_id', '=', 'votes.answer_id')
                                   ->where('answered_questions.user_id', '=', $id);
                         })
                         ->where('votes.user_id', '=', $id)
                         ->paginate(10);*/

      //GET ALL COMMENTS FOR A USER PAGE
      $user_comments = DB::table('comments')
                          ->join('users', function($join) use ($id) {
                               $join->on('comments.commenter_id', '=', 'users.id')
                                    ->where('u_id', '=', $id);
                          })
                          ->select('u_id', 'profile_image', 'comment_id', 'comment', 'commenter_id',
                                   'comments.created_at', 'comments.updated_at')
                          ->orderBy('comments.created_at', 'desc')
                          ->paginate(10);

      /*$user_comments = DB::table('comments')
                            ->leftJoin('users', 'comments.commenter_id', '=', 'users.id')
                            ->where('u_id', '=', $id)
                            ->select('u_id', 'profile_image', 'comment_id', 'comment', 'commenter_id',
                                     'comments.created_at', 'comments.updated_at')
                            ->orderBy('comments.created_at')
                            ->paginate(10);*/

      //GET COMMENTER USER NAME IF COMMENTER HAS NOT ALREADY COMMENTED ON THE USER'S PAGE
      if(Auth::check()) {
         $commenter_name_check = Comment::where('u_id', $id)
                                               ->where('commenter_id', Auth::user()->id)
                                               ->select('comment_id', 'commenter_id', 'comment')
                                               ->first();
      }
      else {
         $commenter_name_check = null;
      }

      //RETURN USER, USER ANSWERS, AND USER COMMENTS TO  USER PROFILE VIEW
      return view('user_profile', compact('user', 'user_answers', 'user_comments', 'commenter_name_check'));

   }

   public function userSearch(Request $req) {

      $output = "";

      $users = DB::table("users")
               ->select("id","user_name", "profile_image")
                //->where('user_name','LIKE',"%$search%")
               ->where('user_name', 'ILIKE', '%' . $req->user_input . '%')
               ->get();

      if($users) {
         foreach($users as $user)
            $output .= '<tr class="user-table" style="height: 50px; border: 1px solid black; background: white; color: blue;"><td><a href="user/' . $user->id . '" style="float: left; display: flex; width: 100%;""><img src="' . Storage::disk('s3')->url('thumbnails/thumbnail_' . $user->profile_image) . '" style="float: left; display: inline-block;"><h3 style="display: inline-block;">' . $user->user_name . '</h3></a></td></tr>';
         }

      return Response($output);

   }

   public function topBoredGuys() {

      //ARRAY FOR TOP USERS
      $tOutput = [];

      $topUsers = DB::table("users")
                  ->select("id","user_name", "profile_image", "score")
                  ->orderBy('score', 'desc')
                  ->take(25)
                  ->get();

    /* foreach($topUsers as $topUser) {
        $tOutput .= '<div class="userDiv"><p>' . $topUser->user_name . '</p> <p>' . $topUser->score . '</div><br>';
      } */
      foreach ($topUsers as $topUser) {
        $tOutput[] = ["id" => $topUser->id, "username" => $topUser->user_name, "score" => $topUser->score, "profileImage" => Storage::disk('s3')->url('thumbnails/thumbnail_' . $topUser->profile_image)];
      }

      //return Response($tOutput);
      return Response()->json($tOutput, 200);
   }

   public function newestBoredGuys() {

     //ARRAY FOR NEWEST USERS
     $nOutput = [];

     $newestUsers = DB::table("users")
                 ->select("id","user_name", "profile_image", "score")
                 ->orderBy('created_at', 'desc')
                 ->take(25)
                 ->get();

     foreach ($newestUsers as $newestUser) {
       $nOutput[] = ["id" => $newestUser->id, "username" => $newestUser->user_name, "score" => $newestUser->score, "profileImage" => Storage::disk('s3')->url('thumbnails/thumbnail_' . $newestUser->profile_image)];
     }

     return Response()->json($nOutput, 200);
   }

   public function upload(Request $req) {

      $file = $req->file('userImage');

      $this->validate($req, [
         'userImage' => 'required|mimes:jpeg,jpg,png|max:500000',
      ]);

      $username_sans_ext = $req->input('hidUsn');

      // REMOVE PREVIOUS PROFILE IMAGE FROM S3 BUCKET IF IT EXISTS
      if(Storage::disk('s3')->exists('profile_images/' . Auth::user()->profile_image)) {
         Storage::disk('s3')->delete('profile_images/' . Auth::user()->profile_image);
      }
      if(Storage::disk('s3')->exists('thumbnails/thumbnail_' . Auth::user()->profile_image)) {
         Storage::disk('s3')->delete('thumbnails/thumbnail_' . Auth::user()->profile_image);
      }
      if(Storage::disk('s3')->exists('icons/icon_' . Auth::user()->profile_image)) {
         Storage::disk('s3')->delete('icons/icon_' . Auth::user()->profile_image);
      }

      // UPLOAD FILE TO FILE SYSTEM
      $ext = $file->getClientOriginalExtension();

      $username = $username_sans_ext . '.' . $ext;

      // CREATE AND STORE PROFILE IMAGE
      $file_avatar = Image::make($req->file('userImage'))->resize(300, 300);

      $file_avatar = $file_avatar->stream();

      Storage::disk('s3')->put('profile_images/' . $username, $file_avatar->__toString());

      // CREATE AND STORE THUMBNAIL
      $file_thumbnail = Image::make($req->file('userImage'))->resize(50, 50);

      $file_thumbnail = $file_thumbnail->stream();

      Storage::disk('s3')->put('thumbnails/thumbnail_' . $username, $file_thumbnail->__toString());

      // CREATE AND STORE ICON
      $file_icon = Image::make($req->file('userImage'))->resize(25, 25);

      $file_icon = $file_icon->stream();

      Storage::disk('s3')->put('icons/icon_' . $username, $file_icon->__toString());

      // UPDATE PROFILE IMAGE FILE NAME IN DATABASE AND REFRESH PAGE
      $user_prof = User::where('user_name', $username_sans_ext)->first();

      $user_prof->profile_image = $username;
      $user_prof->save();

      return redirect()->back();
   }

   public function updateDescription(Request $req) {

      // UPDATE PROFILE DESCRIPTION IN DATABASE AND REFRESH PAGE
      $desc = $req['newDesc'];

      $usernameD = $req['hidUsnD'];

      $user_desc = User::where('user_name', $usernameD)->first();

      $user_desc->description = $desc;
      $user_desc->save();

      return redirect()->back();
   }

   public function resendEmailVerification(Request $req) {
      //$user = User::where('id', '=', Auth::user()->id)->firstOrFail();
      $user = User::findOrFail(Auth::user()->id);
      $user->sendVerificationEmail();

      return Redirect('/home')->with(["successfulResend" =>
                                          "Succesfully Resent Email Verification!"]);
   }

}
