<?php

namespace App\Http\Controllers;
//include composer autoload
//require '../vendor/autoload.php';


use View;
use App\User;
use Image;
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
      //$user = User::find($id)->first();

      //return View::make('user.profile', array('user_name' => $user));

      //return view('user_profile', compact('user'));
      return view('user_profile', ['user' => $user]);
      //$user_info = User::where($username)->first();
   }

   public function userList() {

      //$users = User::selec
      //$users = DB::table('users')->select('SELECT id, user_name, description, profile_image, questions_answered, score FROM users')-get();
      $users = User::select('id', 'user_name', 'description', 'profile_image', 'questions_answered', 'score')->get();
      return view('users', ['users' => $users]);
   }


   public function userAnswers($id) {

      $user = User::findOrFail($id);

      $user_answers = AnsweredQuestion::where('user_id', $id)
                                             ->orderBy('updated_at', 'desc')
                                             ->get();

      //return view('user_profile', array('user' => $user, 'user_answers' => '$user_answers'));
      return view('user_profile', compact('user', 'user_answers'));

   }


   public function upload(Request $req) {


      $file = $req->file('userImage');

      // TIME TO ADD A FILE SIZE CHECK
      $path = public_path('thumbnails' . $file);
      $username_sans_ext = $req->input('hidUsn');

      // UPLOAD FILE TO FILE SYSTEM
      $ext = $file->getClientOriginalExtension();

      $username = $username_sans_ext . '.' . $ext;

      $file->storeAs('/public/images/', $username);

      //$manager = new ImageManager(array('driver' => 'imagick'));

      //$file->storeAs('/public/thumbnails/', $username_sans_ext . '_thumbnail' . $ext)->resize(100, 100)->save();
      //$image = Image::make('/public/thumbnails/' . $username_sans_ext . '_thumbnail' . "." . $ext)->resize(100, 100);

      //$file->storeAs(''/public)

      $thumb = Image::make($req->file('userImage'))->resize(100, 100)->save(public_path() . 'thumbnails/' . $file . '.' . $ext);
      //working on image manager stuff
      //Image::make($file)->getRealPath();

      // UPDATE PROFILE IMAGE FILE NAME IN DATABASE AND REFRESH PAGE
      $user_prof = User::where('user_name', $username_sans_ext)->first();

      $user_prof->profile_image = $username;

      $user_prof->save();

      return redirect()->back();

   }


   public function updateDescription(Request $req) {

      // UPDATE PROFILE DESCRIPTION IN DATABASE AND REFRESH PAGE
      $desc = $req->input('newDesc');

      $usernameD = $req->input('hidUsnD');

      $user_desc = User::where('user_name', $usernameD)->first();

      $user_desc->description = $desc;

      $user_desc->save();

      return redirect()->back();

   }

}
