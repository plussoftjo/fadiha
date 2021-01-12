<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Likes;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as RequestOrg;
use App\Models\Posts;
use App\Models\Comments;

class PostController extends Controller
{
    public function store(RequestOrg $request)
    {

        if(Request::hasFile('video')){

            $file = Request::file('video');
            $filename = $file->getClientOriginalName();
            $path = public_path().'/uploads/';
            $file->move($path, $filename);

            $uri = $filename;

            $post = Posts::create([
                'video'=> $uri,
                'post' => $request->post,
                'user_id' => $request->user_id,
                'tags' => $request->tags
            ]);

            return response()->json(['message'=>'UploadSuccess','post' => $post]);
        }else {
            return response()->json(['message' => 'NotFoundVideo']);
        }

    }

    public function LikeController(RequestOrg $request) {
        $like = Likes::where('user_id',$request->user_id)->where('posts_id',$request->posts_id)->first();
        if($like) {
            Likes::where('user_id',$request->user_id)->where('posts_id',$request->posts_id)->delete();
        }else {
            $l = Likes::create([
                'user_id' => $request->user_id,
                'posts_id' => $request->posts_id
            ]);

            return response()->json(['message '=> 'success']);
        }
    }

    public function CommentController(RequestOrg $request) {
        $comment = Comments::create([
            'user_id' => $request->user_id,
            'posts_id' => $request->posts_id,
            'comment' => $request->comment
        ]);

        $_comment = Comments::where('id',$comment->id)->first();

        return response()->json($_comment);
    }

    public function removePost(RequestOrg $request) {
        $post = Posts::where('id',$request->id)->delete();
        $posts = Posts::where('user_id',$request->user_id)->get();

        return response()->json($posts);
    }
}
