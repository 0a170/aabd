<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Question;
use App\AnsweredQuestion;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{

    public function __construct()
    {
       // $this->middleware('auth');
    }

    public function submitComment(Request $req) {

      $new_comment = new Comment;

      $new_comment->u_id = (int)$req['userId'];
      $new_comment->commenter_id = $req['commenterId'];
      //$new_comment->commenter_icon = $req['cCommenterIcon'];
      $new_comment->comment = $req['comment'];
      $new_comment->u_votes = 0;
      $new_comment->d_votes = 0;

      $save_new_comment = $new_comment->save();

      if($save_new_comment) {
         return Response()->json(['success' => 'Comment Submitted']);
      }
      else {
         return Response()->json(['failure' => 'Unsuccessful, try again later']);
      }

    }

    public function editComment(Request $req) {

      $newComment = $req['newComment'];
      $commentId = $req['commentId'];
      $comment_model = Comment::findOrFail($commentId);

      //SAVE EDITED COMMENT
      $comment_model->comment = $newComment;
      $edit_comment_model = $comment_model->save();

      if($edit_comment_model) {
         return Response()->json(['editSuccess' => 'Successfully Edited!']);
      }
      else {
         return response()->json(['editFailure' => 'Error, try again later']);
      }

   }

    public function deleteComment(Request $req) {

      $comment_id = $req['dCommentId'];
      $user_page_id = $req['dUserPageId'];
      $comment_model = Comment::find($comment_id);

      //DELETE COMMENT AND RETURN TO SELECTED USER'S PAGE
      $comment_model->delete();
      return redirect()->back();

    }

}
