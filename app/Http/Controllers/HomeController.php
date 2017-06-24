<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    
    
   /* public function showQues() {
    
      $answers = AnsweredQuestion::all();
      
      //return $answers;
      //return View::make('recent', $answers);
      //return view('recent')->with($answers);
      return view('home', ['questions' => $questions]);
      
    } */
    
    /*public funtion getImage() {
      
      
      
    } */
    
    
    
    
    
}
