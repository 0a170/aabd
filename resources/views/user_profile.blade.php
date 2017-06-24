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

   
   <img src="{{ asset('storage\\images\\' . $user->user_name . '.jpg') }}" style="height: auto; width: 100%; border-radius: 50%;" data-toggle="modal" data-target="#popupLogin">

   <div class="container" style="inline-block; text-align: center; background-color: #e4e4e4;">

      
      <br>
      
      
      <h2 style="display: inline-block; text-align: center; background-color: #888888; color: white; border-radius: 7px; padding: 7px;"> {{ $user->user_name }} </h2> <br>
	
	
	   <h3 style="display: inline-block; text-align: center; background-color: #888888; color: white; border-radius: 7px; padding: 7px;" data-toggle="modal" data-target="#popupDesc"> {{ $user->description }} </h3> 


   
   	<br>
	

	<!-- <a href="#sPage" class="ui-btn ui-shadow ui-corner-all ui-icon-star ui-btn-icon-notext" style="display: inline-block; text-align: center;"></a> -->
	
	
	   <br>
	
	</div>
	
	<div style="background-color: #bfbfbf;">
	   <br><br>
	</div>
   
   <br>
   
   <div class="div2">
   
      <br>
   
      @foreach($user_answers as $user_answer) 
      
         <div class="answerDiv">
         
            <p> Question: {{ $user_answer->answered_question }} </p>
            
            <br>
            
            <p> Answer: {{ $user_answer->user_answer }} </p>
         
         </div> 
      
      @endforeach
      
      <br>
   
   </div>   
	   
      
   
	   
</body>
</html>