<!DOCTYPE html>

<html>

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>AABD - Home</title>

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

   @if ($errors->any())
      <div class="alert alert-danger">
         <ul>
            @foreach ($errors->all() as $error)
               <li> {{ $error }} </li>
            @endforeach
         </ul>
      </div>
   @endif

<div class="container-fluid">
   <div class="col-sm-12">

<!-- ************************************ USER IMAGE AND STATS/MODALS************************************************** -->

      <div class="col-sm-4 lefty">
       <div class="divLeft">
         <div class="row">
            <div id="profImgContainer">
               <button type="button" id="changeProfImgButton" class="btn btn-primary" data-toggle="modal" data-target="#popupLogin"><span class="glyphicon glyphicon-user"></span></button>
               <img data-src="{{ Storage::disk('s3')->url('profile_images/' . Auth::user()->profile_image) }}" class="profImg" style="border-radius: 50%;">
            </div>
            <div class="name-and-score-div">
               <div class="name-div" style="display: inline-block; margin: 0 auto;">
                  <h2 style="text-align: center; color: #4981ce;"> {{ Auth::user()->user_name }} </h2>
               </div>
               <div class="score-div" style="display: inline-block;">
                  @if(Auth::user()->score < 10)
                     <i class="fa fa-trophy fa-2x" style="color: black;" aria-hidden="true" data-toggle="modal" data-target="#scoreModal"></i>
                  @elseif(Auth::user()->score >= 10 && Auth::user()->score < 100)
                     <i class="fa fa-trophy fa-2x" style="color: #cd7f32;" aria-hidden="true" data-toggle="modal" data-target="#scoreModal"></i>
                  @elseif(Auth::user()->score >= 100 && Auth::user()->score < 1000)
                     <i class="fa fa-trophy fa-2x" style="color: silver;" aria-hidden="true" data-toggle="modal" data-target="#scoreModal"></i>
                  @elseif(Auth::user()->score >= 1000)
                     <i class="fa fa-trophy fa-2x" style="color: gold;" aria-hidden="true" data-toggle="modal" data-target="#scoreModal"></i>
                  @endif
               </div>
            </div>
         </div>
         <div class="divider"></div><br>
         @if(Session::has('successfulVerification'))
            <div class="alert alert-success">
               <h4> Success! </h4>
               <p> {{ Session::get('successfulVerification') }} </p><!-- show the message -->
            </div><br>
         @endif
         @if(Session::has('successfulResend'))
            <div class="alert alert-success">
               <h4> Resent! </h4>
               <p> {{ Session::get('successfulResend') }} </p>
            </div>
         @endif
         @if(Auth::user()->verified == 0)
            <div class="alert alert-info">
               <h4> Not Verified </h4>
               <p>Check Your Email For The Verification Email</p>
               <form action="{{ url('/resendEmailVerification') }}">
                  <input type="submit" class="btn btn-primary" value="Resend Verification Email">
               </form>
            </div><br>
         @endif
         <div class="descDiv">
            <p style="text-align: left;"> {{ Auth::user()->description }} </p>
            <!-- <input type="button" id="editDescId" class="glyphicon glyphicon-edit btn btn-primary" data-toggle="modal" data-target="#editDescModal"> -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editDescModal"><span class="glyphicon glyphicon-edit"></span></button><br>
         </div><br>

         <div role="dialog" id="popupLogin" class="modal fade">
		      <div class="modal-content">
			      <div class="modal-header">
				      <button type="button" class="close" data-dismiss="modal">&times;</button>
				      <h3 class="modal-title">Change your profile picture</h3>
			      </div>

			      <div class="modal-body">
	               <form id="upl_img" enctype="multipart/form-data" action="upload_image" method="POST">
                     {{ csrf_field() }}
                     <div style="padding:10px 20px;">
				  	         <input type="file" name="userImage"><br>
                        <input type="hidden" name="hidUsn" value="{{ Auth::user()->user_name }}">
                        <input type="hidden" value="{{ csrf_token() }}">
					         <input type="submit" class="btn btn-primary" id="Up_Img" name="Upload_Image" value="Upload">
					      </div>
				      </form>
                  @if ($errors->any())
                     <div class="alert alert-danger">
                        <ul>
                           @foreach ($errors->all() as $error)
                              <li> {{ $error }} </li>
                           @endforeach
                        </ul>
                     </div>
                  @endif

                  <p id="msg"></p>
			      </div>
            </div>
         </div>

         <div class="modal" id="scoreModal" style="height:200px; width: 200px;" class="modal fade" role="dialog">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title">Your Score</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                    </button>
                 </div>
                 <div class="modal-body">
                    <p>{{ Auth::user()->score }}</p>
                 </div>
              </div>
           </div>
        </div>

         <div role="dialog" id="editDescModal" class="modal fade">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" style="float: right;">&times;</button>
                  <h3 class="modal-title">Change your profile description</h3>
               </div>

               <div class="modal-body">
                  <form id="upd_desc" action="change_description" method="POST">
                     {{ csrf_field() }}
                     <div style="padding: 10px 20px;">
                        <textarea id="nD" class="form-control" style="margin: 0 auto; width: 90%; max-width: 100%;" rows="3" name="newDesc"></textarea><br>
                        <input type="hidden" name="hidUsnD" value="{{ Auth::user()->user_name }}">
                        <input type="hidden" value="{{ csrf_token() }}">
                        <br>
                        <input type="submit" class="btn btn-primary" id="upDescButton" class="ui-btn ui-corner-all ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check" name="Update_Description" value="Update">
                     </div>
                     <p id="editDescStatus"></p>
                  </form><br>
               </div>
            </div>
         </div>
      </div>
      </div> <br>

<!-- ************************************ QUESTIONS SECTION ****************************************************************************************** -->

      <div class="col-sm-4 c">
      <div class="divCenter">
         <h3 class="blue-text"> Newest Questions </h3>
         <div class="divider"></div><br>
         <div class="scrollbar">
         @if(Auth::user()->verified == 0)
            <div class="answerDiv">
               <p> You must have your email verified to start answering questions </p>
            </div><br><br>
         @elseif(Auth::user()->verified == 1)
            @if($questions->isEmpty())
               <div class="answerDiv">
                  <p> No questions to answer now. Check back later. </p>
               </div> <br><br>
            @else
            @foreach($questions as $question)
               <div id="aDiv{{ $question->question_id }}" class="answerDiv">
                  <p style="color: #888888;"><b>{{ $question->question }}</b></p>
                  <form id="{{ $question->question_id }}" class="aForm" method="POST">
                     <!-- <input type="text" id="answerID{{ $question->question_id }}" name="answerInput" class="answers" style="max-width: 80%; display: block; margin: 0 auto;">-->
                     <textarea class="answer-text form-control" name="answerInput_{{ $question->question_id }}" rows="3"></textarea>
                     <input type="hidden" id="questionID{{ $question->question_id }}" name="ques" value="{{ $question->question }}">
                     <input type="hidden" id="questionKey{{ $question->question_id }}" name="quesId" value="{{ $question->question_id }}">
                     <input type="hidden" value="{{ csrf_token() }}">
                     <br><br>
                     <input type="submit" class="btn btn-primary button-margin" id="ent{{ $question->question_id }}" name="theAnswer" value="Answer This">
                     <p id="aStatus{{ $question->question_id }}" class="answer-status">place holder</p>
                  </form>
               </div>
               <br>
            @endforeach
            <div style="margin: 0 auto;"> {!! $questions->render() !!} </div>
            @endif
         @endif
         <br>
         </div>
      </div>
      </div>

<!-- **************************************  COMMENTS SECTION ****************************************************************************************** -->

      <div class="col-sm-4 righty">
         <div class="divRight">
            <h3 class="blue-text"> Your Comments </h3>
            <div class="divider"></div><br>
            <div class="scrollbar">
            @if($comments->isEmpty())
               <div class="commentDiv" style="text-align: center;">
                  <p> You have no comments </p>
               </div>
               <br>
            @else
            @foreach($comments as $comment)
               <div class="commentDiv">
                  <div class="icon-container">
                     <a href="{{ url('user/' . $comment->commenter_id) }}">
                        <img data-src="{{ Storage::disk('s3')->url('icons/icon_' . $comment->profile_image) }}" class="iconImg">
                     </a>
                  </div>
                  <p> {{ $comment->comment }} </p>
                  <div class="inside-div-divider"></div>
                  <p class="smaller-text"> {{ $comment->created_at }} </p>
               </div><br>
            @endforeach
            <br>
            @endif
            </div>
         </div>
      </div>
<!-- ************************************************************************************************************ -->
   </div>
</div>
<br><br>
<footer id="aabdFooter" class="footer">
    <div id="footer-container" class="container-fluid">
        <p class="footer-text"> Copyright © 2018 </p>
    </div>
</footer>

<script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.lazyloadxt.min.js') }}"></script>
<script src="{{ asset('js/home.js') }}"></script>

</body>
</html>
