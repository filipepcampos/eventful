<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Http\Request;

class RatingController extends Controller
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

    private function getRating($input) {
        return $input == 'true' ? 'Upvote' : 'Downvote';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function store(Request $request, $commentId)
    {
        $comment = Comment::find($commentId);

        $rating = new Rating();
        $rating->comment_id = $commentId;
        $rating->user_id = Auth::user()->id;
        $rating->vote = $this->getRating($request->input('rating'));

        $rating->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return response(null, 200);
    }

    public function addRating(Request $request, $commentId)
    {
        if (!Auth::check() || !$request->has('rating')) return;
        
        $comment = Comment::find($commentId);
        $this->authorize('ratingComment', $comment);

        $rating = Rating::where('user_id', '=', Auth::user()->id)->where('comment_id', '=', $commentId)->first();
        if ($rating) {
            $this->destroy($rating);
            if ($this->getRating($request->input('rating')) != $rating->vote)
                $this->store($request, $commentId);
        } else
            $this->store($request, $commentId);
    }
}
