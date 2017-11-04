<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="{{ asset('css/style2.css') }}">



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset('js/answer_ajax.js') }}"></script>
<script src="{{ asset('js/user_search_ajax.js') }}"></script>
<script src="{{ asset('js/test_search_ajax.js') }}"></script>
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
      <a class="navbar-brand" href="{{ url('/ask') }}">AABG</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav">

      @if (Auth::check())

        <li><a href="{{ url('/ask') }}" class="link1"><span class="glyphicon glyphicon-question-sign"></span>Ask</a></li>
        <li><a href="{{ url('/recent') }}" class="link2"><span class="glyphicon glyphicon-thumbs-up"></span> Recent</a></li>
        <li><a href="{{ url('/home') }}" class="link4"><span class="glyphicon glyphicon-pencil"></span> Answer</a></li>
        <li>
            <a href="#" class="link3" onclick="event.preventDefault();
                                                     document.getElementById('logOutForm').submit();">
            <span class="glyphicon glyphicon-log-out"></span>
            Logout</a>

               <form id="logOutForm" method="POST" action="{{ route('logout') }}" style="display: none;">


                  {{ csrf_field() }}


               </form>


        </li>

        @else

          <li><a href="{{ url('/login') }}" class="link1"><span class="glyphicon glyphicon-log-in"></span> Login </a></li>
          <li><a href="{{ url('/ask') }}" class="link2"><span class="glyphicon glyphicon-question-sign"></span> Ask </a></li>
          <li><a href="{{ url('/register') }}" class="link3"><span class="glyphicon glyphicon-check"></span> Register </a></li>
          <li><a href="{{ url('/recent') }}" class="link4"><span class="glyphicon glyphicon-thumbs-up"></span> Recent </a></li>

        @endif

      </ul>
    </div>
  </div>
</nav>




   <div class="div2">

      <h1> Browse Users </h1>

      <br>

      <div class="searchDiv">

         <!-- <h2>Laravel 5 - Dynamic autocomplete search using select2 JS Ajax</h2>
         <br/> -->
         <select id="itemNameID" class="itemName form-control" name="itemName"></select>

         <br>
         <div id="failedRequest" class="ajax_failure"></div>
         <br>
         <button id="goUser" class="btn btn-primary"> Go </button>

      </div>

      <br>
      <br>

      @foreach($users as $user)

         <a href="user/{{ $user->id }}" style="display: block;">

         <div class="userDiv">

               <img src="{{ Storage::disk('s3')->url('thumbnails/thumbnail_' . $user->profile_image) }}" class="userThumb">

               <div class="rightText">

                  <p class="user_info"> Name: {{ $user->user_name }} </p>

                  <p class="user_info"> Description: {{ $user->description }} </p>

                  <p class="user_info"> Score: {{ $user->score }} </p>

               </div>

         </div>

         </a>

         <br>

      @endforeach

      <br>

   </div>




</body>
</html>
