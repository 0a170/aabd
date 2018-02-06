<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>AABD - RECENT</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">

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
            <div style="text-align: center;">
                <h1 style="display: inline-block; color: #4981ce;"> Recent Answers </h1>
                <div class="askrate-divider"></div><br>
                <!--<i style="font-size:24px; position: absolute; right: 3%; color: #4981ce; display: inline-block;" class="fa gear" id="gear">&#xf013;</i><br>
                <div class="header-divider"></div>
                  <div id="gearOptions">
                    <div id="five" class="per-page"><p id="fiveText" style="border-bottom: 1px solid white; color: white;">5 per page </p></div>
                    <div id="ten" class="per-page"><p id="tenText" style="border-bottom: 1px solid white; color: white;">10 per page </p></div>
                    <div id="fifteen" class="per-page"><p id="fifteenText" style="border-bottom: 1px solid white; color: white;">15 per page </p></div>
                    <div id="twenty" class="per-page"><p id="twentyText" style="color: white;">20 per page </p></div>
                 </div>-->
            </div>
                <!-- <br> -->
                  <div class="rate-wrapper scrollbar">
                  @foreach($answers as $answer)
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
                        <button type="button" id="upVoteButtonId_{{ $answer->answer_id }}" class="btn btn-default btn-lg voteButtonClass" value="upButtonVal">
                           <span class="glyphicon glyphicon-thumbs-up">
                              {{ $answer->up_votes }}
                           </span>
                        </button>

                        &nbsp &nbsp &nbsp &nbsp

                        <button type="button" id="downVoteButtonId_{{ $answer->answer_id }}" class="btn btn-default btn-lg voteButtonClass" value="downButtonVal">
                           <span class="glyphicon glyphicon-thumbs-down">
                              {{ $answer->down_votes }}
                           </span>
                        </button>
                        <div id="rate_failure{{ $answer->answer_id }}" class="rate-status">placeholder</div>
                    </form>
                  </div>
                  <br>
                  <br>
                 @endforeach
                 </div>
                <br>
                <div style="margin: 0 auto;"> {!! $answers->render() !!} </div>
                <br><br>
      </div>
   </div>
</div>
<footer id="aabdFooter" class="footer">
    <div id="footer-container" class="container-fluid">
        <p class="footer-text"> Copyright © 2018 <p>
    </div>
</footer>

<script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/rate_ajax.js') }}"></script>
<script>
   $(document).ready(function() {
      $("#logOutForm").submit(function(e) {
         e.preventDefault();
      });
      $("#gear").on('click', function() {
        $("#gear").toggleClass("gear-spin");
        $("#gearOptions").toggle();
        //$("select-options-id").val(1) {
          /*$.ajax({
              type: "GET",
              data: ,
              dataType: "JSON",

          }); */
          //alert("5 selected");
        //}
      });

      $('.per-page').on('click', function() {
        var pOption = $(this);
        var pOptionId = pOption.attr('id');
        //var pOptionTextId = $("#" + pOptionId + ": first-child").attr('id');
        //var pOptionText = $()
        //var pOptionTextId = pOptionText.attr('id');
        if(pOption.attr('id') == "five") {
          $('#five').css("background", "white");
          $("#" + pOptionId).children().css("color", "#4981ce");
        }
      });
   });
</script>

</body>
</html>
