<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Sends a request to enter the event
     */
    public function send($event_id) {
        if (!Auth::check()) return redirect('/login');
        $user = Auth::user();
        $request = new Request;
        $request->user_id = $user->id;
        $request->event_id = $event_id;
        $request->save();
        return response(null, 200);
    }

    /**
     * Accepts a request
     */
    public function accept($request_id) {
        $request = Request::find($request_id);
        $this->authorize('update', $request);
        $request->accepted = TRUE;
        $request->save();
        DB::table('attendee')->insert([
            'user_id' => $request->user_id,
            'event_id' => $request->event_id
        ]);
        return response(null, 200);
    }

    /**
     * Rejects a request
     */
    public function reject($request_id) {
        $request = Request::find($request_id);
        $this->authorize('delete', $request);
        $request->delete();
        return response(null, 200);
    }
}
