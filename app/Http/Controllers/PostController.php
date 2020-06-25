<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;


class PostController extends Controller
{
    /**
     * Posts archive
     */
    public function index()
    {
        $posts = Post::orderBy("created_at", "desc")->paginate(5);

        return view("guest.posts.index", compact("posts"));
    }
}
