<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewPost;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class PostController extends Controller
{

    // ADMIN CRUD CONTROLLER
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where("user_id", Auth::id())->orderBy("created_at", "desc")->paginate(5);

        return view("admin.posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.posts.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        $data = $request->all();

        $data["user_id"] = Auth::id();
        $data["slug"] = Str::slug($data["title"], "-");

        // IMG STORAGE
        // set the image
        if (!empty($data["path_img"])) {
            $data["path_img"] = Storage::disk("public")->put("images", $data["path_img"]);
        }

        $newPost = new Post();
        $newPost->fill($data);
        $saved = $newPost->save();

        if ($saved) {
            // Send email
            Mail::to("user@test.it")->send(new NewPost($newPost));

            return redirect()->route("admin.posts.show", $newPost->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view("admin.posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view("admin.posts.edit", compact("post"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->validationRules());

        $data = $request->all();
        $data["slug"] = Str::slug($data["title"], "-");

        // IMG UPDATE
        if (!empty($data["path_img"])) {

            // delete previous img:
            if (!empty($post->path_img)) {
                Storage::disk("public")->delete($post->path_img);
            }

            // set new img:
            $data["path_img"] = Storage::disk("public")->put("images", $data["path_img"]);
        }

        $updated = $post->update($data);

        if ($updated) {
            return redirect()->route("admin.posts.show", $post->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (empty($post)) {
            abort("404");
        }

        $title = $post->title;

        $deleted = $post->delete();

        if ($deleted) {
            // remove img
            if (!empty($post->path_img)) {
                Storage::disk("public")->delete($post->path_img);
            }

            return redirect()->route("admin.posts.index")->with("post-deleted", $title);
        }
    }

    /**
     * Validation rules
     */
    private function validationRules()
    {
        return [
            "title" => "required",
            "body" => "required",
            "path_img" => "image"
        ];
    }
}
