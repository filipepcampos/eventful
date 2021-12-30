<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Tag;
use App\Models\TagEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;

use Illuminate\Support\Facades\Log;

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

    public function search(Request $request)
    {
        $search = $request->query('search');
        $tags = array_keys($request->except('search'));
        if (empty($tags)) {
            $events = Event::whereRaw('tsvectors @@ to_tsquery(\'english\', ?)', [$search])->orderByRaw('ts_rank(tsvectors, to_tsquery(\'english\', ?)) DESC', [$search])->get();
        } else {
            $events = Event::whereHas('tags', function($q) use ($tags) {$q->whereIn('name', $tags);})->whereRaw('tsvectors @@ to_tsquery(\'english\', ?)', [$search])->orderByRaw('ts_rank(tsvectors, to_tsquery(\'english\', ?)) DESC', [$search])->get();
        }
        $tags = Tag::all();
        return view('pages.search')->with('events', $events)->with('search', $search)->with('tags', $tags);
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

        $validated = $request->validated();

        $event = new Event();

        $event->id_host = Auth::user()->id;
        $event->title = $request->input('title');
        $event->event_image = $request->file('event_image')->store('images');
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
        return view('pages.home', ['events' => $events]);
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

    public function join($id){
        if (!Auth::check()) return redirect('/login');
        $event = Event::find($id);
        $this->authorize('join', $event);
        $user = Auth::user();
        DB::table('attendee')->insert([
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);
        return redirect('event/' . $event->id);
    }

    public function leave($id){
        if (!Auth::check()) return redirect('/login');
        $event = Event::find($id);
        $this->authorize('leave', $event);
        $user = Auth::user();
        DB::table('attendee')->where([['user_id', '=', $user->id], 
                                    ['event_id', '=', $event->id]])->delete();
        return redirect('/');
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
        if(!is_null($request->input('capacity'))){ // TODO: NAO PERMITIR CAPACIDADE MENOR QUE ATUAL
            $event->capacity = $request->input('capacity');
        }
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
