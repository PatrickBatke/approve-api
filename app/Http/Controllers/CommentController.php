<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Models\Comment;

class CommentController extends Controller
{
    public function createComment(Request $request)
    {
        $comment = new Comment;
        $comment->comment = $request->comment;
        $comment->project_id = $request->project_id;
        $comment->xpos = $request->xpos;
        $comment->ypos = $request->ypos;
        $comment->save();
        return response()->json(['message:'=>"Comment succesfully inserted into Database."]);
    }

    public function showProjectComments($id)
    {
        $comments = Comment::where('project_id', $id)->get();
        return $comments;
    }

    public function deleteComment($id)
    {
        Comment::destroy($id);
        return response()->json(['message:'=>"Comment was succesfully deleted."]);
    }
}
