<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
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



<div class="div1">

   <h1> Sorry, an Error has occurred. Try again later </h1>

</div>

<br>
<br>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<br>
<br>
<br>
<br>



<div class="container">
  <div class="row"
  <div class="col-md-8 col-md-offset-2">
  <div class="panel panel-default">

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


<script>

   $(document).ready(function() {

      $("#logOutForm").submit(function(e) {

         e.preventDefault();

      });

   });

</script>

</html>
