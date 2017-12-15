<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>AABD - {{ $user->user_name }}</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

<scr<script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://use.fontawesome.com/4269355819.js"></script>
<script src="{{ asset('js/home_rate_ajax.js') }}"></script>

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

   <div class="col-sm-12">

      <div class="col-sm-4">

         <div class="divLeft">

            <div class="row">
               <img src="{{ Storage::disk('s3')->url('profile_images/' . $user->profile_image) }}" class="profImg" style="border-radius: 50%;">
               <h2 style="color: #4981ce; padding: 7px;"> {{ $user->user_name }} </h2>
               <i class="fa fa-trophy fa-2x" style="color: gold;" aria-hidden="true"></i>
            </div>

            <div class="divider"></div>

            <div class="row">
               <p style="color: #4981ce;"> {{ $user->description }} </p>
            </div>

         </div>
      </div><br>

<!-- ************************************* USER'S ANSWERS SECTION ********************************************** -->

      <div class="col-sm-4">
         <h1 style="color: #4981ce;"> {{ $user->user_name }}'s answers </h1>
         <br>
         @if($user_answers->isEmpty())
            <div class="rateDiv">
               <p> {{ $user->user_name }} hasn't answered any questions yet </p>
            </div> <br><br>
         @else
         @foreach($user_answers as $user_answer)
            <div class="rateDiv">
               <form id="{{ $user_answer->answer_id }}" class="rateForm" method="POST">
                  <br>
                  <input type="hidden" value="{{ $user_answer->user_id }}" name="UIDName">
                  <input type="hidden" value="{{ $user_answer->answer_score }}" name="answerScoreName">
                  <input type="hidden" value="{{ $user_answer->user_answer }}" name="answeredQuestionName">
                  <input type="hidden" value="{{ $user_answer->up_votes }}" name="upVoteName">
                  <input type="hidden" value="{{ $user_answer->down_votes }}" name="downVoteName">
                  <input type="hidden" value="{{ $user_answer->answer_id }}">
                  <input type="hidden" value="{{ csrf_token() }}">
                  <p> Question: {{ $user_answer->answered_question }} </p>
                  <br>
                  <p> Answer: {{ $user_answer->user_answer }} </p>
                  <br>
                  <button type="button" id="voteButton" class="btn btn-default btn-lg" value="upButtonVal">
                     <span class="glyphicon glyphicon-thumbs-up">
                        {{ $user_answer->up_votes }}
                     </span>
                  </button>

                  &nbsp &nbsp &nbsp &nbsp

                  <button type="button" id="voteButton" class="btn btn-default btn-lg" value="downButtonVal">
                     <span class="glyphicon glyphicon-thumbs-down">
                        {{ $user_answer->down_votes }}
                     </span>
                  </button>
                  <br>
                  <br>
                  <div id="rate_failure{{ $user_answer->answer_id }}" class="ajax_failure"></div>
               </form>
            </div>
            <br>
            <br>
         @endforeach
         @endif
         <br>
      </div>

<!-- ****************************************** ADS SECTION ************************************************** -->

      <div class="col-sm-4" style="padding-left: 20px;">

         <div class="divRight">

            <a href="https://twitter.com/askaboredguy" class="twitter-follow-button" data-show-count="false" style="margin: 0 auto; display: block;">Follow @askaboredguy</a>

            <div class="well">
               <p>Text</p>
               <p>Text</p>
               <p>Text</p>
               <p>Text</p>
            </div>
            <div class="well">
               <p>Text</p>
               <p>Text</p>
               <p>Text</p>
               <p>Text</p>
            </div>

         </div>

      </div>
<!-- ********************************************************************************************************** -->
   </div>
</div>
</body>
</html>
