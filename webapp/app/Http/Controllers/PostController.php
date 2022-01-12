<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $event_id)
    {
        if (!Auth::check()) return redirect('/login');
        $event = Event::find($event_id);
        $this->authorize('host', $event);

        $post = new Post();
        // TODO: Disallow invalid posts
        $post->text = $request->input('text');
        $post->event_id = $event->id;
        $post->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post_id)
    {
        if (!Auth::check()) return redirect('/login');
        $post = Post::find($post_id);
        $this->authorize('host', $post->event()->first()); // TODO: Post policy?
        // TODO: Check for invalid content?
        $post->text = $request->input('text');
        $post->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete($post_id)
    {
        $post = Post::find($post_id);
        $this->authorize('host', $post->event()->first()); // TODO: PostPolicy should be required?
        $post = Post::destroy($post_id); // TODO: This will not work when we add polls
        return response(null, 200);;
    }
}
