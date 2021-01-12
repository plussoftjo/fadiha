<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use Iman\Streamer\VideoStreamer;
class MainController extends Controller
{
    public function index(Request $request) {
        $myPost = Posts::where('user_id',$request->user_id)->get();
        $explorPosts = Posts::take(30)->inRandomOrder()->get();

        return response()->json([
            'myPost' => $myPost,
            'explorPosts' => $explorPosts
        ]);
    }

    public function stramvideo($id) {
        $path = public_path('uploads/'.$id);
    
        VideoStreamer::streamFile($path);
    }
}
