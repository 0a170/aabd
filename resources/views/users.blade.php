<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>AABD - Browse Users</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">



<script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset('js/user_search_ajax.js') }}"></script>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed">
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
          <li><a href="{{ url('/ask') }}" class="link"> Ask </a></li>
          <li><a href="{{ url('/home') }}" class="link"> Answer</a></li>
          <li><a href="{{ url('/recent') }}" class="link"> Recent </a></li>
          <li><a href="{{ url('/users') }}" class="link"> Users </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          @if(Auth::check())
             <li>
                <a href=" {{ url('/logout') }}" onclick="event.preventDefault();
                                                       document.getElementById('logOutForm').submit();" class="logOutLink">
                   Logout <img src="{{ Storage::disk('s3')->url('icons/icon_' . Auth::user()->profile_image) }}" class="iconImg">
                </a>

                <form id="logOutForm" method="POST" action="{{ url('/logout') }}" style="display: none;">
                   {{ csrf_field() }}
                </form>
             </li>
          @else
             <li><a href="{{ url('/login') }}" class="link"> Login</a></li>
             <li><a href="{{ url('/register') }}"class="link"> Register</a></li>
          @endif
      </ul>
    </div>
  </div>
</nav>



<div class="container-fluid">

   <h1> Browse Users </h1>

   <br>

   <div class="row">

      <div class="searchDiv">

         <!-- <h2>Laravel 5 - Dynamic autocomplete search using select2 JS Ajax</h2>
         <br/> -->

         <input type="text" style="width: 100%; text-align: center;" name="userN" class="userNClass" placeholder="Search User"><br>
         <table class="response-table"></table>

         <br>
         <button type="button" id="topBG" class="bSearch btn btn-success">Top Bored Guys</button>
         <button type="button" id="newestBG" class="bSearch btn btn-warning">Newest Bored Guys</button>

         <div id="failedRequest" class="ajax_failure"></div>
         <br>
         <!-- <button id="goUser" class="btn btn-primary"> Go </button> -->

      </div>

      <br>
      <br>

      <div class="loader"></div>
      <div id="button-results"></div>



<!-- **********************************************************-->

      <br>

   </div>

</div>



</body>
</html>
