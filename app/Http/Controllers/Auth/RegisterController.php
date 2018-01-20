<?php

namespace App\Http\Controllers\Auth;

use Image;
use Storage;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {


        //GET DEFAULT USER IMAGE AND CREATE A COPY RENAMED FOR NEW USER, THEN UPLOAD TO S3

        //$default_image = Storage::disk('local')->get('/images/prof_def.png');
        $default_image = Storage::disk('s3')->get('profile_images/prof_def.png');
        $image_name = $data['user_name'] . '.png';

        //CREATE AND UPLOAD BASIC PROFILE IMAGE TO S3 BUCKET
        $profile_image = Image::make($default_image)->resize(300, 300);
        $profile_image = $profile_image->stream();
        Storage::disk('s3')->put('profile_images/' . $image_name, $profile_image->__toString());

        //CREATE AND UPLOAD THUMBNAIL TO S3 BUCKET
        $thumbnail_image = Image::make($default_image)->resize(50, 50);
        $thumbnail_image = $thumbnail_image->stream();
        Storage::disk('s3')->put('thumbnails/thumbnail_' . $image_name, $thumbnail_image->__toString());

        //CREATE AND UPLOAD ICON TO S3 BUCKET
        $icon_image = Image::make($default_image)->resize(25, 25);
        $icon_image = $icon_image->stream();
        Storage::disk('s3')->put('icons/icon_' . $image_name, $icon_image->__toString());

        return User::create([
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            //'profile_image' => 'prof_def.png',
            'profile_image' => $image_name,
            'description' => 'Click here to change your description',
            'questions_answered' => 0,
			'score' => 0,
        ]);
    }
}
