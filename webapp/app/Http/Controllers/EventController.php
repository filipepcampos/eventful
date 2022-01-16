<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Tag;
use App\Models\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Notifications\InviteReceived;

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

    public function join($event_id)
    {
        if (!Auth::check()) return redirect('/login');
        $event = Event::find($event_id);
        $this->authorize('join', $event);
        $user = Auth::user();
        $event->attendees()->attach($user->id);
        return redirect('event/' . $event->id);
    }

    public function leave($event_id)
    {
        if (!Auth::check()) return redirect('/login');
        $event = Event::find($event_id);
        $this->authorize('leave', $event);
        $user = Auth::user();
        $event->attendees()->detach($user->id);
        return redirect('/');
    }

    public function search(Request $request)
    {
        $search = $request->query('search');
        $searchString = str_replace(' ', ':*&', $search);
        $events = Event::whereRaw('tsvectors @@ to_tsquery(\'english\', ?)', [$searchString])->orderByRaw('ts_rank(tsvectors, to_tsquery(\'english\', ?)) DESC', [$searchString]);

        $tagsSelected = $request->query('tag');
        if (!empty($tagsSelected)) {
            $events = $events->whereHas('tags', function ($q) use ($tagsSelected) { $q->whereIn('id', $tagsSelected); });
        }

        $after_date = $request->query('after');
        if (!is_null($after_date)) {
            $events = $events->where('realization_date', '>=', $after_date);
        }

        $before_date = $request->query('before');
        if (!is_null($before_date)) {
            $events = $events->where('realization_date', '<=', $before_date);
        }

        return view('pages.search')->
               with('events', $events->get())->
               with('search', $search)->
               with('tagsSelected', $tagsSelected)->
               with('tags', Tag::all())->
               with('after_date', $after_date)->
               with('before_date', $before_date);
    }

    public function showCreateForm()
    {
        if (!Auth::check()) return redirect('/login');
        return view('pages.createEvent', ['tags' => Tag::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function showUpdateForm($id)
    {
        if (!Auth::check()) return redirect('/login');
        $event = Event::find($id);
        return view('pages.updateEvent', ['event' => $event, 'tags' => Tag::all()]);
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

        $event = new Event();

        $event->host_id = Auth::user()->id;
        $event->title = $request->input('title');
        if ($request->has('event_image')) {
            $event->event_image = $request->file('event_image')->store('images');
        } else {
            $event->event_image = 'images/default.png';
        }
        $event->description = $request->input('description');
        $event->location = $request->input('location');
        $event->realization_date = $request->input('realization_date');

        $event->is_visible = $request->input('visibility') === 'public';
        $event->is_accessible = $request->input('access') === 'public';

        if ($request->has('capacity')) {
            $event->capacity = $request->input('capacity');
        } else {
            $event->capacity = +INF;
        }
        $event->price = $request->input('price');
        $event->save();

        $tagsSelected = $request->has('tag') ? $request->input('tag') : [];
        $event->tags()->attach($tagsSelected);

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
        if ($has_auth && Auth::user()->is_admin) {
            $events = Event::paginate(16);
            return view('pages.events', ['events' => $events]);
        } else {
            $events = Event::where('is_visible', '=', 'true'); // Visible events
            if (Auth::check()) {
                $user = Auth::user();
                $hosting = Event::where('host_id', $user->id);
                $attending = Event::whereHas('attendees', function ($q) use ($user) {
                    $q->where('id', $user->id);
                });
                $events = $events->union($attending)->union($hosting);
            }
            $events = $events->paginate(16);
            return view('pages.events', ['events' => $events]);
        }
    }

    public function getImage($id)
    {
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
        if($event == null){
            abort(404);
        }
        $this->authorize('viewInformation', $event);
        return view('pages.event', ['event' => $event]);
    }

    public function kick(Request $request, $id)
    {
        $event = Event::find($id);
        $this->authorize('update', $event);
        $user_id = $request->input('user_id');
        if ($user_id != null) {
            $event->attending()->detach($user_id);
        }
        return response(null, 200);
    }

    public function invite(Request $request, $id)
    {
        $event = Event::find($id);
        $this->authorize('viewContent', $event);

        $username = $request->input('username');
        $invitee = User::where('username', $username)->first();

        $invite = new Invite();
        $invite->invitee_id = $invitee->id;
        $invite->inviter_id = Auth::id();
        $invite->event_id = $event->id;

        $invitee->notify(new InviteReceived($invite));
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

        if (!is_null($request->input('capacity'))) {
            $capacity = (int)$request->input('capacity');
            if ($capacity < $event->number_attendees) return redirect()->back();
            $event->capacity = $capacity;
        }

        if (!is_null($request->input('title'))) {
            $event->title = $request->input('title');
        }
        if (!is_null($request->file('event_image'))) {
            $event->event_image = $request->file('event_image')->store('images');
        }
        if (!is_null($request->input('description'))) {
            $event->description = $request->input('description');
        }
        if (!is_null($request->input('location'))) {
            $event->location = $request->input('location');
        }
        if (!is_null($request->input('realization_date'))) {
            $event->realization_date = $request->input('realization_date');
        }
        if (!is_null($request->input('visibility'))) {
            $event->is_visible = $request->input('visibility') === 'public';
        }
        if (!is_null($request->input('access'))) {
            $event->is_accessible = $request->input('access') === 'public';
        }
        if (!is_null($request->input('price'))) {
            $event->price = $request->input('price');
        }

        $tagsSelected = $request->has('tag') ? $request->input('tag') : [];
        $event->tags()->sync($tagsSelected);

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
