<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

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
        $this->authorize('create', Comment::class);

        $comment = new Comment();
        $event = Event::find($eventId);

        $comment->author_id = Auth::user()->id;
        $comment->event_id = $event->id;
        if ($request->has('files')) {
            // para cada ficheiro
                // adicionar entrada na tabela File na base de dados
        }
        $comment->content = $request->input('content');

        
        $files = $request->has('files') ? $request->input('files') : [];
        foreach ($files as $file) {
            $insertions[] = [
                //'path' => TODO  
                'comment_id' => $comment->id
            ];
        }
        DB::table('file')->insert($insertions);

        return redirect('event/' . $event->id);
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
