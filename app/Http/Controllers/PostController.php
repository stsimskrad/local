<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index(){
        $data = Post::with('type')->with('user.profile')->orderBy('created_at','DESC')->take(3)->get();
        return PostResource::collection($data);
    }
    
}
