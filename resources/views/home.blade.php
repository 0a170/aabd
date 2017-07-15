<!DOCTYPE html>

<html>

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>AABD - Home</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/style2.css') }}">



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{ asset('js/answer_ajax.js') }}"></script>

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

        <li><a href="{{ url('/ask') }}" class="link1"><span class="glyphicon glyphicon-question-sign"></span> Ask </a></li>
        <li><a href="{{ url('/recent') }}" class="link2"><span class="glyphicon glyphicon-thumbs-up"></span> Recent </a></li>
        <li><a href="{{ url('/users') }}" class="link4"><span class="glyphicon glyphicon-user"></span> Users </a></li>
        <li>
            <a href="#" onclick="event.preventDefault();
                                                     document.getElementById('logOutForm').submit();" class="link3">
            <span class="glyphicon glyphicon-log-out"></span> Logout</a>

               <form id="logOutForm" method="POST" action="{{ route('logout') }}" style="display: none;">


                  {{ csrf_field() }}


               </form>


        </li>

      </ul>
    </div>
  </div>
</nav>


   @if(file_exists('storage\\images\\' . Auth::user()->user_name . '.jpg'))
      <img src="{{ asset('storage\\images\\' . Auth::user()->profile_image) }}" class="profileImg"  data-toggle="modal" data-target="#popupLogin">
   @elseif(file_exists('storage\\images\\' . Auth::user()->user_name . '.png'))
      <img src="{{ asset('storage\\images\\' . Auth::user()->profile_image) }}" class="profileImg"  data-toggle="modal" data-target="#popupLogin">
   @elseif(file_exists('public\\storage\\images\\' . Auth::user()->user_name . '.png'))
      <img src="{{ asset('storage\\images' . Auth::user()->profile_image) }}" class="profileImg"  data-toggle="modal" data-target="#popupLogin">
   @elseif(file_exists('public\\images\\' . Auth::user()->user_name . '.jpg'))
      <img src="{{ asset('storage\\images\\' . Auth::user()->profile_image) }}" class="profileImg"  data-toggle="modal" data-target="#popupLogin">
   @else
      <img src="{{ asset('storage\\images\\prof_def.png') }}" class="profileImg" data-toggle="modal" data-target="#popupLogin">
   @endif


      <div class="container" style="inline-block; text-align: center; background-color: #e4e4e4;">

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

						      <input type="submit" class="btn-primary" id="Up_Img" name="Upload_Image" value="Upload">

					     </div>

				     </form>

				     <p id="msg"></p>

			    </div>

		   </div>

	   </div>

      <br>

      <h2 style="display: inline-block; text-align: center; background-color: #888888; color: white; border-radius: 7px; padding: 7px;"> {{ Auth::user()->user_name }} </h2> <br>


	   <h3 style="display: inline-block; text-align: center; background-color: #888888; color: white; border-radius: 7px; padding: 7px;" data-toggle="modal" data-target="#popupDesc"> {{ Auth::user()->description }} </h3> <br>


      <h2 style="display: inline-block; text-align: center; background-color: #888888; color: white; border-radius: 7px; padding: 7px;"> Score: {{ Auth::user()->score }} </h2> <br>


      <div role="dialog" id="popupDesc" class="modal fade">

		   <div class="modal-content">

			   <div class="modal-header">

				   <button type="button" class="close" data-dismiss="modal">&times;</button>

               <h3 class="modal-title">Change your profile description</h3>

			   </div>

			   <div class="modal-body">

				   <form id="upd_desc" action="change_description" method="POST">
				   {{ csrf_field() }}

					   <div style="padding: 10px 20px;">

						   <input type="text" id="nD" class="ui-btn ui-corner-all ui-shadow ui-btn-b ui-btn-icon-left" name="newDesc"><br>

                     <input type="hidden" name="hidUsnD" value="{{ Auth::user()->user_name }}">

                     <input type="hidden" value="{{ csrf_token() }}">

						   <input type="submit" class="btn-primary" id="Up_Desc" class="ui-btn ui-corner-all ui-shadow ui-btn-b ui-btn-icon-left ui-icon-check" name="Update_Description" value="Update">

					   </div>

				   </form>

				   <p id="msg2"></p>

			   </div>

		   </div>

	   </div>

   	<br>


	<!-- <a href="#sPage" class="ui-btn ui-shadow ui-corner-all ui-icon-star ui-btn-icon-notext" style="display: inline-block; text-align: center;"></a> -->


	   <br>

	   </div>

	   <div style="background-color: #bfbfbf;">
		   <br><br>
	   </div>


      <div class="div2">


      @foreach($questions as $question)

         <br>

         <div id="aDiv{{ $question->question_id }}" class="answerDiv">

            <p style="color: #888888;"><b>Question: {{ $question->question }}</b></p>

            <!-- <p style="color: #888888;"><b>Email: {{ $question->asker_email }}</b></p> -->

            <!-- <p style="color: #888888;"><b>Question ID: {{ $question->question_id }}</b></p> -->



            <form id="{{ $question->question_id }}" class="aForm" method="POST">


               <input type="text" id="answerID{{ $question->question_id }}" name="answerInput" class="answers" style="max-width: 60%; display: block; margin: 0 auto;"></textarea>

               <input type="hidden" id="questionID{{ $question->question_id }}" name="ques" value="{{ $question->question }}">

               <input type="hidden" id="emailID{{ $question->question_id }}" name="ema" value="{{ $question->asker_email }}">

               <input type="hidden" value="{{ csrf_token() }}">

               <br>

               <input type="submit" style="background-color: #80bfff; width: 60%; display: block; margin: 0 auto;" class="fbox" id="ent{{ $question->question_id }}" name="theAnswer" value="Answer this">

               <br>

               <div id="answer_failure{{ $question->question_id }}" class="ajax_failure"></div>
					     <div id="answer_success{{ $question->question_id }}" class="ajax_success"></div>
					     <div id="server_error{{ $question->question_id }}" class="ajax_failure"></div>

               <br>

            </form>

         </div>

         <br>
         <br>

      @endforeach

      <br>


   </div>




</body>
</html>
