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


        <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/jquery.steps.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/bootstrap.min.css') }}">
        <link href="{{ secure_asset('css/style.css') }}" rel="stylesheet" type="text/css">


         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


         <script src="{{ secure_asset('js/jquery-3.2.1.js') }}"></script>
         <script src="{{ secure_asset('js/jquery.steps.min.js') }}"></script>

       <script src="{{ secure_asset('js/quest_submit_ajax.js') }}"></script>

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
                  @if (Auth::check())
                     <li><a href="{{ url('/home') }}" class="link"> Answer</a></li>
                     <li><a href="{{ url('/recent') }}" class="link"> Recent</a></li>
                     <li><a href="{{ url('/users') }}" class="link"> Users </a></li>

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
                     <li><a href="{{ url('/recent') }}" class="link"> Recent</a></li>
                     <li><a href="{{ url('/users') }}" class="link"> Users</a></li>
                  @endif
               </ul>
            </div>
         </div>
      </nav>

  <div class="container-fluid" style="float: none; margin: 0 auto;">
  <div class="row">

    <div id="pAsk">

	     <h1> Ask a Bored Guy </h1>

	     <br>
	     <br>

	     <div id="askDiv">

	        <form id="frmDemo" class="form-group" method="POST">

		         <h3> Ask</h3>

		         <section class="center">

			          <div id="stepHeader">
				           <h2> Your Question</h2>
			          </div>
			          <input type="text" id="quest" name="question" class="all_inputs" value="Question" onfocus="if(this.value == 'Question') this.value = ''">
			          <input type="hidden" class="whatev" value="{{ csrf_token() }}">

               </section>

		         <h3> Email </h3>

		         <section class="center">

			          <div id="stepHeader">
				           <h2> Your Email </h2>
			          </div>
			          <input type="text" id="em" name="email"  class="all_inputs" value="Email Address" onfocus="if(this.value == 'Email Address') this.value = ''">
                <br>

		         </section>

		         <h3> Submit </h3>

		         <section>

			          <div id="stepHeader">
				           <h2> Submit your question </h2>
			          </div>
			          <br>

		         </section>

	        </form>

	     </div>
        <br>
        <div id="success_message" class="ajax_response"></div>
        <div id="error_message" class="ajax_response"></div>

    </div>

    <br>

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
