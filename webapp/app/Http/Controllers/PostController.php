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

        $request->validate([
                'text' => 'required|max:16384',
                ]);
        if($request->input('text') )
        $post = new Post();
        // TODO: Disallow invalid posts
        $post->text = $request->input('text');
        $post->event_id = $event->id;
        $post->save();
        return response($post->id, 200); // TODO: If this isn't an horribly idea, it should be documented on a7
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

        $request->validate([
            'text' => 'required|max:16384',
            ]);

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
