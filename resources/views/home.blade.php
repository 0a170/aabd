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
            <img src="{{ Storage::disk('s3')->url('profile_images/' . Auth::user()->profile_image) }}" class="profImg" style="border-radius: 50%;" data-toggle="modal" data-target="#popupLogin">
            <h2 style="color: #4981ce; padding: 7px; display: inline-block;"> {{ Auth::user()->user_name }} </h2>
            <i class="fa fa-trophy fa-2x" style="display: inline-block;" style="color: gold;" aria-hidden="true"></i>
         </div>

         <div class="divider"></div><br>

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
         </div> <br><br>


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
                        <textarea id="nD" rows="3" name="newDesc"></textarea><br>
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

      <div class="col-sm-4">
      <div class="divCenter">
         <h3 class="blue-text"> Newest Questions </h3>
         <div class="divider"></div><br>
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
                  <textarea class="answer-text" name="answerInput_{{ $question->question_id }}" rows="3"></textarea>
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
         <br>
      </div>
      </div>

<!-- **************************************  COMMENTS SECTION ****************************************************************************************** -->

      <div class="col-sm-4 righty" style="padding-left: 20px;">

         <div class="divRight">

            <h3 class="blue-text"> Your Comments </h3>

            <div class="divider"></div><br>
            <div class="comment-wrapper">
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
                        <img src="{{ Storage::disk('s3')->url('icons/icon_' . $comment->profile_image) }}" class="iconImg">
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
        <p class="footer-text"> Copyright © 2018 <p>
    </div>
</footer>

<script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/answer_ajax.js') }}"></script>
<script src="{{ asset('js/changeDesc.js') }}"></script>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

</body>
</html>
