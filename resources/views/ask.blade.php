<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


        <link rel="stylesheet" type="text/css" href="{{asset('css/jquery.steps.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">


         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

         <script src="{{ asset('/js/jquery.steps.min.js') }}"></script>
         <script src="{{ asset('/js/bootstrap.min.js') }}"></script>

       <script src="{{ asset('/js/quest_submit_ajax.js') }}"></script>

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
                     <li><a href="{{ url('/home') }}" class="link1"><span class="glyphicon glyphicon-pencil"></span> Answer</a></li>
                     <li><a href="{{ url('/recent') }}" class="link2"><span class="glyphicon glyphicon-thumbs-up"></span> Recent</a></li>
                     <li>
                     <a href=" {{ url('/logout') }}" onclick="event.preventDefault();
                                                             document.getElementById('logOutForm').submit();" class="link3">
                        <span class="glyphicon glyphicon-log-out"></span>Logout
                     </a>

                     <form id="logOutForm" method="POST" action="{{ url('/logout') }}" style="display: none;">

                        {{ csrf_field() }}

                     </form>

                     </li>
                  @else
                     <li><a href="{{ url('/login') }}" class="link1"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                     <li><a href="{{ url('/register') }}"class="link2"><span class="glyphicon glyphicon-check"></span> Register</a></li>
                     <li><a href="{{ url('/recent') }}" class="link3"><span class="glyphicon glyphicon-thumbs-up"></span> Recent</a></li>
                     <li><a href="{{ url('/users') }}" class="link4"><span class="glyphicon glyphicon-user"></span> Users</a></li>
                  @endif
               </ul>
            </div>
         </div>
      </nav>



      <!-- <div id="pAsk">	-->
    <div id="pAsk">

	     <h1> Ask a question </h1>

	     <br>
	     <br>

	     <div id="askDiv">

	        <form id="frmDemo" class="form-group" method="POST">

		         <h3> Ask</h3>

		         <section>

			          <div id="stepHeader">
				           <h2> Your Question</h2>
			          </div>
			          <input type="text" id="quest" name="question" class="all_inputs" value="Question" onfocus="if(this.value == 'Question') this.value = ''">
			          <input type="hidden" class="whatev" value="{{ csrf_token() }}">

             </section>

		         <h3> Email </h3>

		         <section>

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

		      <div id="success_message" class="ajax_response" style="float:left"></div>
          <div id="error_message" class="ajax_response" style"float:left"></div>

	     </div>

     <!-- </div> -->
    </div>
    </body>

</html>
