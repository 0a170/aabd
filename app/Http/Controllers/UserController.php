<?php

namespace App\Http\Controllers;
//include composer autoload
//require '../vendor/autoload.php';


use View;
use App\User;
use Image;
use Storage;
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


   public function userAnswers($id) {

      $user = User::findOrFail($id);

      $user_answers = AnsweredQuestion::where('user_id', $id)
                                             ->orderBy('updated_at', 'desc')
                                             ->get();

      return view('user_profile', compact('user', 'user_answers'));

   }

   public function userSearch(Request $req) {

      /*$data = [];

      if($req->has('q')){
          $search = $req->q;
          $data = DB::table("users")
                ->select("id","user_name")
                ->where('user_name','LIKE',"%$search%")
                ->get();
      }

      return response()->json($data); */

      //$data = [];

      $output = "";

      //if($req->has('q')){
          //$search = $req->q;
          $users = DB::table("users")
                ->select("id","user_name")
                //->where('user_name','LIKE',"%$search%")
                ->where('user_name', 'LIKE', '%' . $req->user_input . '%')
                ->get();

          if($users) {
             foreach($users as $user)
                $output .= '<tr class="user-table" style="border: 1px solid black; background: white; color: blue;"><td><a href="user/' . $user->id . '"><img src="{{ Storage::disk(\'s3\')->url(\'icons/icon_\' . Auth::user()->profile_image) }}" style="float: left;">' . $user->user_name . '</a></td></tr>';
             }
      //}

      return Response($output);


   }


   public function upload(Request $req) {

      $file = $req->file('userImage');

      $this->validate($req, [
         'userImage' => 'required|mimes:jpeg,jpg,png|max:500000',
      ]);



      $username_sans_ext = $req->input('hidUsn');

      // UPLOAD FILE TO FILE SYSTEM
      $ext = $file->getClientOriginalExtension();

      $username = $username_sans_ext . '.' . $ext;

      // CREATE AND STORE PROFILE IMAGE
      $file_avatar = Image::make($req->file('userImage'))->resize(300, 300);

      $file_avatar = $file_avatar->stream();

      Storage::disk('s3')->put('profile_images/' . $username, $file_avatar->__toString());

      // CREATE AND STORE THUMBNAIL
      $file_thumbnail = Image::make($req->file('userImage'))->resize(100, 100);

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
      $desc = $req->input('newDesc');

      $this->validate($req, [
         'newDesc' => 'required',
      ]);


      $usernameD = $req->input('hidUsnD');

      $user_desc = User::where('user_name', $usernameD)->first();

      $user_desc->description = $desc;

      $user_desc->save();

      return redirect()->back();

   }

}
