<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    /**
     * Accepts an invite by updating accept boolean of invite to true
     */
    public function accept($invite_id) {
        $invite = Invite::find($invite_id);
        $this->authorize('update', $invite);
        $invite->accepted = TRUE;
        $invite->save();
        $event = $invite->event()->first();
        if ($event->is_accessible) {
            $this->authorize('join', $event);
            app('App\Http\Controllers\EventController')->join($invite->event_id);
        } else {
            app('App\Http\Controllers\RequestController')->send($invite->event_id);
        }
        return response(null, 200);
    }

    /**
     * Rejects an invite by removing it from the database
     */
    public function reject($invite_id) {
        $invite = Invite::find($invite_id);
        $this->authorize('delete', $invite);
        $invite->delete();
        return response(null, 200);
    }

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function show(Invite $invite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function edit(Invite $invite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invite $invite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invite  $invite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invite $invite)
    {
        //
    }
}
