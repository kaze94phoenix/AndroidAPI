<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function like(Request $request)
    {
        $like = new Like();
        $like->post_id = $request->post_id;
        $like->user_id = auth()->user()->id;

        $existLike = Like::where("user_id", $like->user_id)->where("post_id",$like->post_id)->first();

        if ($existLike!=null) {
        if($existLike->count()>0){
            $existLike->delete(); 
            return response()->json([
                "success"=> true,
                "message"=> "post unliked"
                ]);
        }
    }

        $like->save();
        return response()->json([
            "success" => true,
            "message" => "liked post"
        ]);
    }


    public function likes(Request $request){
        $likes = Like::where("post_id", $request->id)->get();

        foreach( $likes as $like ){
            $like->user;
        }
        $likes["likesCount"] = count(Post::find($request->id)->likes);
        return response()->json([
            "success"=> true,
            "likes"=> $likes
            ]);
    } 
}
