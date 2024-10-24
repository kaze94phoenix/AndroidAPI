<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Storage;

class PostsController extends Controller
{

    public function index()
    {
        $posts = Post::orderBy("id", "desc")->paginate(10);

        foreach ($posts as $post) {
            $post->user;
            $post['commentsCount'] = count($post->comments);
            $post['liesCount'] = count($post->likes);
            $post['selfLike'] = false;

            foreach ($post->likes as $like) {
                if ($like->user_id == $post->user_id) {
                    $post['selfLike'] = true;
                }
            }

        }

        return response()->json([
                'success'=>true,
                'posts'=> $posts
        ]
        );
    }
    public function create(Request $request)
    {
        $post = new Post();
        $post->user_id = auth()->user()->id;
        $post->desc = $request->desc;

        if ($request->photo != "") {
            $photo = time() . '.jpg';
            file_get_contents('storage/posts/' . $photo, base64_decode($request->photo));
            $post->photo = $photo;
        }
        $post->save();
        $post->user;
        return response()->json([
            'success' => true,
            'post' => $post,
            'message' => 'posted'
        ]);
    }

    public function update(Request $request)
    {
        $post = Post::find($request->id);
        if (auth()->user()->id != $request->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }

        $post->desc = $request->desc;
        $post->update();
        return response()->json([
            'success' => true,
            'message' => 'Post updated'
        ]);
    }

    public function delete(Request $request)
    {
        $post = Post::find($request->id);
        if (auth()->user()->id != $request->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }

        if ($post->photo != '') {
            Storage::delete('public/posts' . $post->photo);
        }
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted'
        ]);
    }

}