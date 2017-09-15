<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('css/rate_style.css')}}">



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ asset('js/rate_ajax.js') }}"></script>


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
      <a class="navbar-brand" href="{{ url('/ask') }}">Ask a Brotha</a>
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



<div class="div1">


                <h1> Recent Answers </h1>


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
                        <p> User ID: {{ $answer->user_id }} </p>

                        <br>

                        <button type="button" id="voteButton" class="btn btn-default btn-lg" value="upButtonVal">
                           <span class="glyphicon glyphicon-thumbs-up">
                              {{ $answer->up_votes }}
                           </span>
                        </button>

                        &nbsp &nbsp &nbsp &nbsp

                        <button type="button" id="voteButton" class="btn btn-default btn-lg" value="downButtonVal">
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



</body>

<script>

   $(document).ready(function() {

      $("#logOutForm").submit(function(e) {

         e.preventDefault();

      });

   });

</script>

</html>
