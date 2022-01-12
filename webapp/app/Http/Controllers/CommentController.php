<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use App\Models\Event;
use App\Http\Requests\CommentCreateRequest;

class CommentController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentCreateRequest $request, $eventId)
    {
        if (!Auth::check()) return redirect('/login');
        $event = Event::find($eventId);
        $this->authorize('create', $event);

        $comment = new Comment();
        $event = Event::find($eventId);

        $comment->author_id = Auth::user()->id;
        $comment->event_id = $event->id;
        $comment->content = $request->input('content');

        if ($request->has('files')) {
            $files = !empty($request->file('files')) ? $request->file('files') : [];

            $insertions = array();
            foreach ($files as $file) {
                $path = $file->store('comments');
                $insertions[] = [
                    'path' => $path,
                    'comment_id' => $comment->id
                ];
            }
            DB::table('file')->insert($insertions);
        }

        $comment->save();

        return redirect('event/' . $eventId); // TODO: NOT REDIRECT
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
