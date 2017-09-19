<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">

<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.steps.css') }}">



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/quest_submit_ajax.js') }}"></script>
<script src="{{ asset('js/jquery.steps.min.js') }}"></script>
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
      <a class="navbar-brand" href="{{ url('/ask') }}">AABD</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav">
      @if (Auth::check())
        <li><a href="{{ url('/ask') }}" class="link1"> <span class="glyphicon glyphicon-question-sign"></span> Ask</a></li>
        <li><a href="{{ url('/home') }}" class="link2"><span class="glyphicon glyphicon-pencil"></span> Answer</a></li>
        <li><a href="{{ url('/users') }}" class="link4"><span class="glyphicon glyphicon-user"></span> Users</a></li>
        <li>
            <a href="#" onclick="event.preventDefault();
                                 document.getElementById('logOutForm').submit();" class="link3">
            <span class="glyphicon glyphicon-log-out"></span>
            Logout</a>

               <form id="logOutForm" method="POST" action="{{ url('/logout') }}" style="display: none;">

                  {{ csrf_field() }}

               </form>

        </li>
      @else
        <li><a href="{{ url('/ask') }}" class="link1"><span class="glyphicon glyphicon-question-sign"></span> Ask</a></li>
        <li><a href="{{ url('/login') }}" class="link2"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        <li><a href="{{ url('/register') }}" class="link3"><span class="glyphicon glyphicon-check"></span> Register</a></li>
        <li><a href="{{ url('/users') }}" class="link4"><span class="glyphicon glyphicon-user"></span> Users</a></li>
      @endif
      </ul>
    </div>
  </div>
</nav>


<div class="container">

   <div class="div1">

      <h1> Sorry, an Error has occurred. Try again later </h1>

   </div>

</div>

</body>


<script>

   $(document).ready(function() {

      $("#logOutForm").submit(function(e) {

         e.preventDefault();

      });

   });

</script>

</html>
