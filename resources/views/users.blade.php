<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>AABD - Browse Users</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

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
   <h2 style="color: #4981ce;"> Browse Users </h2>
   <div class="divider"></div><br>
   <div class="row">
      <div class="searchDiv">
         <input type="text" id="userNId" style="width: 100%; text-align: center;" name="userN" class="userNClass form-control" placeholder="Search User">
         <table class="response-table"></table><br>
         <button type="button" id="topBG" class="bSearch btn btn-warning"><span class="glyphicon glyphicon-king"></span></button>
         <button type="button" id="newestBG" class="bSearch btn btn-success">Newest Bored Guys</button>
         <button type="button" id="closeBG" class="bSearch btn btn-danger" style="float: right;"><span class="glyphicon glyphicon-remove"></span></button>
         <div id="failedRequest" class="ajax_failure"></div>
         <br>
      </div><br><br>
      <div class="loader"></div>
      <div id="button-results"></div><br>
   </div>
</div>
<footer id="aabdFooter" class="footer">
    <div id="footer-container" class="container-fluid">
        <p class="footer-text"> Copyright © 2018 <p>
    </div>
</footer>
<script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.lazyloadxt.min.js') }}"></script>
<script src="{{ asset('js/user_search_ajax.js') }}"></script>
</body>
</html>
