<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">



<script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/rate_ajax.js') }}"></script>


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

   <div class="row">

      <div style="float: none; margin: 0 auto;">

                <h1> Recent Answers </h1>

                <br>

                  @foreach($answers as $answer)

                  <br>

                  <div class="rateDiv">

                    <form id="{{ $answer->answer_id }}" class="rateForm" method="POST">

                        <br>
                        <input type="hidden" value="{{ $answer->user_id }}" name="UIDName">
                        <input type="hidden" value="{{ $answer->answer_score }}" name="answerScoreName">
                        <input type="hidden" value="{{ $answer->user_answer }}" name="answeredQuestionName">
                        <input type="hidden" value="{{ $answer->up_votes }}" name="upVoteName">
                        <input type="hidden" value="{{ $answer->down_votes }}" name="downVoteName">
                        <input type="hidden" value="{{ $answer->answer_id }}">

                        <input type="hidden" value="{{ csrf_token() }}">


                        <p> Question: {{ $answer->answered_question }} </p>
                        <br>
                        <p> User Answer: {{ $answer->user_answer }} </p>
                        <br>

                        <button type="button" id="voteButton" style="class="btn btn-default btn-lg voteButtonClass" value="upButtonVal">
                           <span class="glyphicon glyphicon-thumbs-up">
                              {{ $answer->up_votes }}
                           </span>
                        </button>

                        &nbsp

                        <button type="button" id="voteButton" class="btn btn-default btn-lg voteButtonClass" value="downButtonVal">
                           <span class="glyphicon glyphicon-thumbs-down">
                              {{ $answer->down_votes }}
                           </span>
                        </button>
                        <br>
                        <br>
                        <div id="rate_failure{{ $answer->answer_id }}" class="ajax_failure"></div>
                    </form>
                  </div>
                  <br>
                  <br>
                 @endforeach
                <br>
      </div>
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
