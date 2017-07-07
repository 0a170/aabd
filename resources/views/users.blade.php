<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/style2.css') }}"> 



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ asset('js/answer_ajax.js') }}"></script>

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">Ask a Brotha</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
  
      <ul class="nav navbar-nav">
      
      @if (Auth::check())
      
        <li><a href="{{ url('/ask') }}">Ask</a></li>
        <li><a href="{{ url('/recent') }}">Recent</a></li>
        <li>
            <a href="#" onclick="event.preventDefault();
                                                     document.getElementById('logOutForm').submit();"> 
            Logout</a>
        
               <form id="logOutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
        
                  
                  {{ csrf_field() }}
                  
               
               </form>
               
        
        </li>
        
        @else
        
          <li><a href="{{ url('/login') }}">Login</a></li>
          <li><a href="{{ url('/ask') }}">Ask</a></li>
          <li><a href="{{ url('/register') }}">Register</a></li>
          <li><a href="{{ url('/recent') }}">Recent</a></li>
          
        @endif
        
      </ul>
    </div>
  </div>
</nav>

   
   
   
   <div class="div2">
   
      <h1> Browse Users </h1>
   
      <br>
   
      @foreach($users as $user) 
      
         <a href="user/{{ $user->id }}" style="display: block;">
      
         <div class="userDiv">
         
            @if(file_exists('storage\\images\\' . $user->profile_image))
            
               <img src="{{ asset('storage\\images\\' . $user->profile_image) }}" class="userThumb">
         
            @else
               
               <img src="{{ asset('storage\\images\\prof_def.png') }}" class="userThumb"> 
            
            @endif
            
               <div class="rightText">
            
                  <p> Name: {{ $user->user_name }} </p>
            
                  <p> Description: {{ $user->description }} </p>
               
                  <p> Score: {{ $user->score }} </p>
                  
               </div> 
         
         </div> 
         
         </a>
         
         <br>
      
      @endforeach
      
      <br>
   
   </div>   
	   
      
   
	   
</body>
</html>