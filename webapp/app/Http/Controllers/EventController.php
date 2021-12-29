<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EventCreateRequest;



use App\Models\User; // TODO DELETE THIS PLEASE

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

    public function showCreateForm(){
        if (!Auth::check()) return redirect('/login');
        return view('pages.createEvent');
    }

     /** TODO: Remove
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'birthdate' => 'required|date|before:today',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }*/

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
        $event->event_image = 'ola';
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

        return route('event/' . $event->id); // TODO: I have no idea if this works...
    }

    /**
     * Shows all cards.
     *
     * @return Response
     */
    public function list()
    {
      /*
      if (!Auth::check()) return redirect('/login');
      $this->authorize('list', Card::class);
      $cards = Auth::user()->cards()->orderBy('id')->get();
      return view('pages.cards', ['cards' => $cards]);
      */
      $events = Event::all();
      // TODO: Filter private events
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
     * @param  \App\Models\Event  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        $this->authorize('viewInformation', $event);
        return view('pages.event', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
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
