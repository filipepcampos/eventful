<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;

class EventController extends Controller
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

    public function join($event_id){
        if (!Auth::check()) return redirect('/login');
        $event = Event::find($event_id);
        $this->authorize('join', $event);
        $user = Auth::user();
        DB::table('attendee')->insert([
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);
        return redirect('event/' . $event->id);
    }

    public function leave($event_id){
        if (!Auth::check()) return redirect('/login');
        $event = Event::find($event_id);
        $this->authorize('leave', $event);
        $user = Auth::user();
        DB::table('attendee')->where([['user_id', '=', $user->id], 
                                    ['event_id', '=', $event->id]])->delete();
        return redirect('/');
    }

    public function search(Request $request)
    {
        $search = $request->query('search');
        $searchString = str_replace(' ', ':*&', $search);
        $tagsSelected = $request->query('tag');
        $tags = Tag::all();
        if (empty($tagsSelected)) {
            $events = Event::whereRaw('tsvectors @@ to_tsquery(\'english\', ?)', [$searchString])->orderByRaw('ts_rank(tsvectors, to_tsquery(\'english\', ?)) DESC', [$searchString])->get();
        } else {
            $events = Event::whereHas('tags', function($q) use ($tagsSelected) {$q->whereIn('id', $tagsSelected);})->whereRaw('tsvectors @@ to_tsquery(\'english\', ?)', [$searchString])->orderByRaw('ts_rank(tsvectors, to_tsquery(\'english\', ?)) DESC', [$searchString])->get();
        }
        return view('pages.search')->with('search', $search)->with('tagsSelected', $tagsSelected)->with('tags', $tags)->with('events', $events);
    }

    public function showCreateForm(){
        if (!Auth::check()) return redirect('/login');
        return view('pages.createEvent');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function showUpdateForm($id){
        // TODO: APENAS HOST PODE EDITAR
        if (!Auth::check()) return redirect('/login');
        $event = Event::find($id);
        return view('pages.updateEvent', ['event'=>$event]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EventCreateRequest $request)
    {
        if (!Auth::check()) return redirect('/login');
        $this->authorize('create', Event::class);

        $validated = $request->validated(); // TODO: Is this necessary btw?

        $event = new Event();

        $event->host_id = Auth::user()->id;
        $event->title = $request->input('title');
        if($request->has('event_image')){
            $event->event_image = $request->file('event_image')->store('images');
        } else {
            $event->event_image = 'images/default.png';
        }
        $event->description = $request->input('description');
        $event->location = $request->input('location');
        $event->realization_date = $request->input('realization_date');
        $event->is_visible = $request->input('is_visible') ? true : false;
        $event->is_accessible = $request->input('is_accessible') ? true : false;
        if($request->has('capacity')){
            $event->capacity = $request->input('capacity');
        } else {
            $event->capacity = +INF;
        }
        $event->price = $request->input('price');

        $event->save();

        return redirect('event/' . $event->id);
    }

    /**
     * Shows all cards.
     *
     * @return Response
     */
    public function list()
    {
        $has_auth = Auth::check();
        if($has_auth && Auth::user()->is_admin){
            $events = Event::paginate(16);
            return view('pages.events', ['events' => $events]);
        } else {
            $events = Event::where('is_visible', '=', 'true'); // Visible events
            if(Auth::check()){
                $user = Auth::user();
                $hosting = Event::where('host_id', $user->id);
                $attending = Event::whereHas('attendees', function($q) use ($user){
                    $q->where('id', $user->id);
                });
                $events = $events->union($attending)->union($hosting);
            }
            $events = $events->paginate(16);
            return view('pages.events', ['events' => $events]);
        }
    }

    public function getImage($id){
        $event = Event::find($id);
        $this->authorize('viewInformation', $event);
        return Storage::response($event->event_image);
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
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        $this->authorize('viewInformation', $event);
        return view('pages.event', ['event' => $event]);
    }

    public function kick(Request $request, $id){
        $event = Event::find($id);
        $this->authorize('update', $event);
        $user_id = $request->input('user_id');
        if($user_id != null){
            DB::table('attendee')->where([['user_id', '=', $user_id], 
                                    ['event_id', '=', $event->id]])->delete();
        }
        // TODO: Should include error if user_id doesnt exist?
        return response(null, 200);
    }

    public function invite(Request $request, $id){
        $event = Event::find($id);
        $this->authorize('viewContent', $event);
        $username = $request->input('username');

        $inviter_id = Auth::id();
        $invitee_id = User::where('username', $username)->first()->id;

        DB::table('invite')->insert([
            'invitee_id' => $invitee_id,
            'inviter_id' => $inviter_id,
            'event_id' => $event->id
        ]);
        return response(null, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\EventUpdateRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventUpdateRequest $request, $id)
    {
        if (!Auth::check()) return redirect('/login');
        $event = Event::find($id);
        $this->authorize('update', $event);

        $validated = $request->validated();

        if(!is_null($request->input('capacity'))){
            $capacity = (int)$request->input('capacity');
            if($capacity < $event->number_attendees) return redirect()->back();
            $event->capacity = $capacity;
        }
        
        if(!is_null($request->input('title'))){
            $event->title = $request->input('title');
        }
        if(!is_null($request->file('event_image'))){
            $event->event_image = $request->file('event_image')->store('images');
        }
        if(!is_null($request->input('description'))){
            $event->description = $request->input('description');
        }
        if(!is_null($request->input('location'))){
            $event->location = $request->input('location');
        }
        if(!is_null($request->input('realization_date'))){
            $event->realization_date = $request->input('realization_date');
        }
        $event->is_visible = $request->input('is_visible') ? true : false;
        $event->is_accessible = $request->input('is_accessible') ? true : false;
        if(!is_null($request->input('price'))){
            $event->price = $request->input('price');
        }
        $event->save();
        
        return redirect('event/' . $event->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function delete(Event $event)
    {
        //
    }
}
