<?php

namespace App\Http\Controllers;

use App\Models\Request;
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
}
