<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EventCreateRequest;
use Illuminate\Support\Facades\DB;

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
        $events = Event::whereRaw('tsvectors @@ to_tsquery(\'english\', ?)', [$search])->orderByRaw('ts_rank(tsvectors, to_tsquery(\'english\', ?)) DESC', [$search])->get();
        return view('pages.search')->with('events', $events)->with('search', $search);
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

        return route('event/' . $event->id);
    }

    /**
     * Shows all cards.
     *
     * @return Response
     */
    public function list()
    {
      $events = Event::all();
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\EventUpdateRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventUpdateRequest $request, Event $event)
    {
        if (!Auth::check()) return redirect('/login');
        $this->authorize('update', Event::class);

        $validated = $request->validated();

        /*
        $event->title = $request->input('title');
        $event->event_image = $request->file('event_image')->store('images');
        $event->description = $request->input('description');
        $event->location = $request->input('location');
        $event->realization_date = $request->input('realization_date');
        $event->is_visible = $request->input('is_visible') ? true : false;
        $event->is_accessible = $request->input('is_accessible') ? true : false;
        if($request->has('capacity')){ // NAO PERMITIR CAPACIDADE MENOR QUE ATUAL
            $event->capacity = $request->input('capacity');
        }
        $event->price = $request->input('price');

        $event->save();
        */
        return route('event/' . $event->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
