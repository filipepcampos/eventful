<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Models\Comment;
use App\Models\Event;
use App\Models\File;
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

        $comment->save();  // Comment must be saved before file upload, because the files need to know the comment id

        if ($request->hasfile('files')) {
            $files = $request->file('files');

            $insertions = array();
            foreach ($files as $file) {
                $fileModel = new File();
                $fileModel->path = $file->store('comments');
                $fileModel->comment_id = $comment->id;
                $fileModel->original_name = $file->getClientOriginalName();
                $fileModel->save();
            }
        }

        $this->authorize('viewContent', $event);
        $view = View::make('pages.event', ['comments' => $event->comments()->get(), 'event' => $event]);
        $sections = $view->renderSections();
        return $sections['comments']; // TODO: Update on A7
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
    public function destroy($commentId)
    {
        $comment = Comment::find($commentId);
        $this->authorize('deleteComment', $comment);
        $files = $comment->files()->get();
        $paths = array();
        foreach($files as $file) {
            $paths[] = $file->path;
        }
        Storage::delete($paths);
        $comment = Comment::destroy($commentId);
        return response(null, 200);
    }
}
