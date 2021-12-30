@extends('layouts.app')

@section('title', 'Update Event')

@section('content')
<h1>Update Event</h1>
<form method="PUT" action="{{ route('updateEvent', ['event_id' => $event->id]) }}" enctype="multipart/form-data">
    {{ csrf_field() }}

    <label for="title" class="form-label">Title</label>
    <input id="title" type="text" name="title" placeholder="{{ $event->title }}" class="form-control">
    @if ($errors->has('title'))
        <span class="error">
          {{ $errors->first('title') }}
        </span>
    @endif

    <label class="form-label" for="event_image">Event Image</label>
    <input type="file" name="event_image" class="form-control-file" id="event_image" accept="image/*">
    @if ($errors->has('event_image'))
        <span class="error">
          {{ $errors->first('event_image') }}
        </span>
    @endif

    <label for="description" class="form-label">Description</label>
    <input id="description" type="textarea" name="description" placeholder="{{ $event->description }}" class="form-control">
    @if ($errors->has('description'))
        <span class="error">
          {{ $errors->first('description') }}
        </span>
    @endif

    <label for="location" class="form-label">Location</label>
    <input id="location" type="text" name="location" placeholder="{{ $event->location }}" class="form-control">
    @if ($errors->has('location'))
        <span class="error">
          {{ $errors->first('location') }}
        </span>
    @endif
    
    <label for="realization_date" class="form-label">Realization Date</label>
    <input id="realization_date" type="datetime-local" name="realization_date" placeholder="{{ $event->realization_date }}" class="form-control">
    @if ($errors->has('realization_date'))
        <span class="error">
          {{ $errors->first('realization_date') }}
        </span>
    @endif

    <label for="is_visible" class="form-label">Visibility</label>
    <input id="is_visible" type="checkbox" name="is_visible" placeholder="{{ $event->is_visible }}" class="form-check-input">
    @if ($errors->has('is_visible'))
        <span class="error">
          {{ $errors->first('is_visible') }}
        </span>
    @endif

    <label for="is_accessible" class="form-label">Accessability</label>
    <input id="is_accessible" type="checkbox" name="is_accessible" placeholder="{{ $event->is_accessible }}" class="form-check-input">
    @if ($errors->has('is_accessible'))
        <span class="error">
          {{ $errors->first('is_accessible') }}
        </span>
    @endif

    <label for="capacity" class="form-label">Capacity</label>
    <input id="capacity" type="text" name="capacity" placeholder="{{ $event->capacity }}" class="form-control">
    @if ($errors->has('capacity'))
        <span class="error">
          {{ $errors->first('capacity') }}
        </span>
    @endif

    <label for="price" class="form-label">Price</label>
    <input id="price" type="number" name="price" placeholder="{{ $event->price }}" class="form-control">
    @if ($errors->has('price'))
        <span class="error">
          {{ $errors->first('price') }}
        </span>
    @endif

    <button type="submit" class="btn btn-primary">
        Submit
    </button>
</form>
@endsection
