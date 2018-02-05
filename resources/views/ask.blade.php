<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>AABD - Ask</title>

        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


        <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.steps.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">


         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



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

    <div id="pAsk">

	     <h1> Ask a Bored Guy </h1>
	     <br>
	     <div id="askDiv">
	        <form id="frmDemo" class="form-group" method="POST">
		         <h3> Ask</h3>
		         <section>
			          <div id="stepHeader">
				           <h2> Your Question</h2>
			          </div>
			          <input type="text" id="quest" name="question" class="all_inputs form-control" placeholder="Question">
			          <input type="hidden" class="whatev" value="{{ csrf_token() }}">
               </section>
		         <h3> Email </h3>
		         <section>
			          <div id="stepHeader">
				           <h2> Your Email </h2>
			          </div>
			          <input type="text" id="em" name="email"  class="all_inputs form-control" placeholder="Email Address">
                   <br>
		         </section>
		         <h3> Submit </h3>
		         <section>
			          <div id="stepHeader">
				           <h2> Submit Your Question </h2>
			          </div>
			          <br>
		         </section>
	        </form>
	     </div>
        <br>
        <div id="question_status" class="alert initial"></div>
    </div>
    <br>
   </div>
  </div>
  <footer id="aabdFooter" class="footer">
      <div id="footer-container" class="container-fluid">
          <p class="footer-text"> Copyright © 2018 <p>
      </div>
  </footer>
<script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
<script src="{{ asset('js/jquery.steps.min.js') }}"></script>

<script src="{{ asset('js/quest_submit_ajax.js') }}"></script>

<script>
   $(document).ready(function() {
      $("#logOutForm").submit(function(e) {
         e.preventDefault();
      });
   });
</script>
</body>
</html>
