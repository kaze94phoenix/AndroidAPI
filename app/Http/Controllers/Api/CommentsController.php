<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index(Request $request)
    {

    }

    public function create(Request $request)
    {
        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $request->post_id;
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'comment added'
        ]);

    }

    public function update(Request $request)
    {
        $comment = Comment::find($request->id);
        if ($request->user_id != auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }

        $comment->comment = $request->comment;
        $comment->save();
        return response()->json([
            'success' => true,
            'message' => 'comment updated'
        ]);


    }

    public function delete(Request $request)
    {
        $comment = Comment::find($request->id);
        if ($request->user_id != auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }

        $comment->delete();
        return response()->json([
            'success' => true,
            'message' => 'comment deleted'
        ]);

    }

    public function comments(Request $request)
    {
        $comments = Comment::where('post_id', $request->id)->get();

        foreach ($comments as $comment) {
            $comment->user;
        }

        return response()->json([
            'success'=> true,
            'comments'=> $comments,
            ]);

    }
}