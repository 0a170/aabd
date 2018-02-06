<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>AABD - {{ $user->user_name }}</title>

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

<div class="container-fluid">
   <div class="col-sm-12">
      <div class="col-sm-4 lefty">
         <div class="divLeft">
            <div class="row">
               <img data-src="{{ Storage::disk('s3')->url('profile_images/' . $user->profile_image) }}" class="profImg" style="border-radius: 50%;">
               <h2 style="color: #4981ce; padding: 7px; display: inline-block;"> {{ $user->user_name }} </h2>
               @if($user->score < 10)
                  <i class="fa fa-trophy fa-2x" style="display: inline-block; color: black;" aria-hidden="true"></i>
               @elseif($user->score >= 10 && $user->score < 100)
                  <i class="fa fa-trophy fa-2x" style="display: inline-block; color: #cd7f32;" aria-hidden="true"></i>
               @elseif($user->score >= 100 && $user->score < 1000)
                  <i class="fa fa-trophy fa-2x" style="display: inline-block; color: silver;" aria-hidden="true"></i>
               @elseif($user->score >= 1000)
                  <i class="fa fa-trophy fa-2x" style="display: inline-block; color: gold;" aria-hidden="true"></i>
               @endif
            </div>

            <div class="divider"></div><br>

            <div class="descDiv">
               <p style="text-align: left;"> {{ $user->description }} </p>
            </div>
            <div class="divider"></div>

         </div>
      </div><br>

<!-- ************************************* USER'S ANSWERS SECTION ********************************************** -->

      <div class="col-sm-4">
      <div class="divCenter">
         <h3 class="blue-text"> {{ $user->user_name }}'s answers </h3>
         <div class="divider"></div><br>
         @if($user_answers->isEmpty())
            <div class="rateDiv">
               <p> {{ $user->user_name }} hasn't answered any questions yet </p>
            </div> <br><br>
         @else
         @foreach($user_answers as $user_answer)
            <div class="rateProfileDiv">
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
                  <button type="button" id="upVoteButtonId_{{ $user_answer->answer_id }}" class="btn btn-default btn-lg voteButtonClass" value="upButtonVal">
                     <span class="glyphicon glyphicon-thumbs-up">
                        {{ $user_answer->up_votes }}
                     </span>
                  </button>

                  &nbsp &nbsp &nbsp &nbsp

                  <button type="button" id="downVoteButtonId_{{ $user_answer->answer_id }}" class="btn btn-default btn-lg voteButtonClass" value="downButtonVal">
                     <span class="glyphicon glyphicon-thumbs-down">
                        {{ $user_answer->down_votes }}
                     </span>
                  </button>
                  <div id="rate_failure{{ $user_answer->answer_id }}" class="rate-status">placeholder</div>
               </form>
            </div>
            <br>
            <br>
         @endforeach
         <br>
         <div style="margin: 0 auto;"> {!! $user_answers->render() !!} </div>
         @endif
         <br>
      </div>
      </div>

<!-- ****************************************** COMMENTS SECTION ************************************************** -->

      <div class="col-sm-4 righty">
         <div class="divRight">
            @if(Auth::check())
               @if(Auth::user()->id != $user->id)
                  @if(!$commenter_name_check)
                  <h3 style="text-align: center; color: #4981ce;"> Leave A Comment </h3>
                  <div class="divider"></div><br>
                  <div class="commentDiv" style="text-align: center;">
                     <form id="createCommentForm" class="commentForm" method="POST">
                        <div class="icon-container"``>
                           <a href="{{ url('user/' . Auth::user()->id) }}">
                              <img src="{{ Storage::disk('s3')->url('icons/icon_' . Auth::user()->profile_image) }}" href=""class="iconImg" style="float: left;"><br>
                           </a>
                        </div>
                        <input type="hidden" id="commenterId" name="cCommenterName" value="{{ Auth::user()->id }}">
                        <input type="hidden" id="userId" name="cUserIdName" value="{{ $user->id }}">
                        <textarea id="newCommentId" class="form-control" name="newCommentName" placeholder="Enter Comment"></textarea>
                        <br>
                        <input type="hidden" id="commentToken" value="{{ csrf_token() }}">
                        <input type="submit" id="submitCommentId" class="btn btn-primary">
                        <div id="comStatus">place holder</div>
                     </form>
                  </div>
                  @else
                  <h3 style="text-align: center; color: #4981ce;"> You Said </h3>
                  <div class="divider"></div><br>
                  <div class="commentDiv" style="text-align: center;">
                     <form id="changeCommentForm" class="commentForm" method="POST">
                        <div class="icon-container">
                           <a href="{{ url('/home') }}">
                              <img src="{{ Storage::disk('s3')->url('icons/icon_' . Auth::user()->profile_image) }}" class="iconImg" style="float: left;"><br>
                           </a>
                        </div>
                        <p style="text-align: left;"> {{ $commenter_name_check->comment }} </p>
                        <input type="hidden" id="commentId" name="cCommenterName" value="{{ $commenter_name_check->comment_id }}"><br>
                        <input type="hidden" id="commentToken" value="{{ csrf_token() }}">
                        <div style="text-align: right;">
                           <button type="button" id="editCommentId" class="btn btn-primary" value="Edit" data-toggle="modal" data-target="#editCommentModal">
                              <span class="glyphicon glyphicon-edit"></span>
                           </button>
                           <button type="button" id="deleteCommentPrompt" class="btn btn-danger" value="Delete" data-toggle="modal" data-target="#deleteCommentModal">
                              <span class="glyphicon glyphicon-remove"></span>
                           </button>
                        </div>
                     </form>
                  </div>

                  <div class="modal fade" id="editCommentModal" role="dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h3 class="modal-title">Edit Your Comment</h4>
                           </div>
                           <div class="modal-body">
                              <form id="editCommentForm" method="POST">
                                 {{ csrf_field() }}
                                 <input type="hidden" id="eCommentId" name="eCommentIdName" value="{{ $commenter_name_check->comment_id }}">
                                 <input type="hidden" id="eUserPageId" name="eUserPageIdName" value="{{ $user->id }}">
                                 <input type="hidden" id="editCommentTokenId" name="editCommentToken" value="{{ csrf_token() }}">
                                 <textarea id="newCommentTextId" class="form-control" name="newCommentText"></textarea><br>
                                 <div style="text-align: right;">
                                    <input type="submit" id="editCommentId" class="btn btn-success">
                                 </div>
                                 <div id="editCommentStatus">place holder</div>
                              </form>
                           </div>
                        </div>
                  </div>

                  <div class="modal fade" id="deleteCommentModal" role="dialog">
                     <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h3 class="modal-title">Delete Your Comment</h3>
                           </div>
                           <div class="modal-body">
                              <form id="deleteCommentForm" action="{{ $user->id }}/deleteComment" method="POST">
                                 {{ csrf_field() }}
                                 <h2> Are you sure you want to delete your comment? </h2><br>
                                 <input type="hidden" name="deleteCommentToken" value="{{ csrf_token() }}">
                                 <input type="hidden" name="dCommentId" value="{{ $commenter_name_check->comment_id }}">
                                 <input type="hidden" name="dUserPageId" value="{{ $user->id }}">
                                 <div style="text-align: right;">
                                    <input type="submit" id="deleteCommentId" class="btn btn-danger" value="Delete It">
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endif
               @endif
            @else

            <p> Login or Register to Comment <a href="{{ url('/login')}}">Login</a> | <a href="{{ url('/register') }}">Register</a> </p><br>

            @endif

            <h3 class="blue-text"> {{ $user->user_name }}'s Comments </h3>

            <div class="divider"></div><br>
            <div class="comment-wrapper">
            @if($user_comments->isEmpty())
               <div class="commentDiv" style="text-align: center;">
                  <p> {{ $user->user_name }} has no comments </p>
               </div>
            @else
            @foreach($user_comments as $user_comment)
               <div class="commentDiv">
                  <div class="icon-container">
                     <a href="{{ url('user/' . $user_comment->commenter_id) }}">
                        <img src="{{ Storage::disk('s3')->url('icons/icon_' . $user_comment->profile_image) }}" class="iconImg">
                     </a>
                  </div>
                  <p> {{ $user_comment->comment }} </p>
                  <div class="inside-div-divider"></div>
                  <p class="smaller-text"> {{ $user_comment->updated_at }} </p>
               </div><br>
            @endforeach
            @endif
         </div>
         </div>

      </div>
<!-- ********************************************************************************************************** -->
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
<script src="https://use.fontawesome.com/4269355819.js"></script>
<script src="{{ asset('js/jquery.lazyloadxt.min.js') }}"></script>
<script src="{{ asset('js/user_rate_ajax.js') }}"></script>
<script src="{{ asset('js/comments.js') }}"></script>
</body>
</html>
