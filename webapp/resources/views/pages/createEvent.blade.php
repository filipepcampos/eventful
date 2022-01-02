@extends('layouts.base')

@section('title', 'Create Event')

@section('content')
<h1>Create Event</h1>
<form method="POST" action="{{ route('event') }}" enctype="multipart/form-data">
    {{ csrf_field() }}

    <label for="title" class="form-label">Title</label>
    <input id="title" type="text" name="title" value="{{ old('title') }}" class="form-control" required autofocus>
    @if ($errors->has('title'))
        <span class="error">
          {{ $errors->first('title') }}
        </span>
    @endif

    <label class="form-label" for="event_image">Event Image</label>
    <input type="file" name="event_image" class="form-control-file" id="event_image" accept="image/*" required>
    @if ($errors->has('event_image'))
        <span class="error">
          {{ $errors->first('event_image') }}
        </span>
    @endif

    <label for="description" class="form-label">Description</label>
    <input id="description" type="textarea" name="description" value="{{ old('description') }}" class="form-control" required>
    @if ($errors->has('description'))
        <span class="error">
          {{ $errors->first('description') }}
        </span>
    @endif

    <label for="location" class="form-label">Location</label>
    <input id="location" type="text" name="location" value="{{ old('location') }}" class="form-control" required>
    @if ($errors->has('location'))
        <span class="error">
          {{ $errors->first('location') }}
        </span>
    @endif
    
    <label for="realization_date" class="form-label">Realization Date</label>
    <input id="realization_date" type="datetime-local" name="realization_date" value="{{ old('realization_date') }}" class="form-control">
    @if ($errors->has('realization_date'))
        <span class="error">
          {{ $errors->first('realization_date') }}
        </span>
    @endif

    <label for="is_visible" class="form-label">Visibility</label>
    <input id="is_visible" type="checkbox" name="is_visible" value="{{ old('is_visible') }}" class="form-check-input">
    @if ($errors->has('is_visible'))
        <span class="error">
          {{ $errors->first('is_visible') }}
        </span>
    @endif

    <label for="is_accessible" class="form-label">Accessability</label>
    <input id="is_accessible" type="checkbox" name="is_accessible" value="{{ old('is_accessible') }}" class="form-check-input">
    @if ($errors->has('is_accessible'))
        <span class="error">
          {{ $errors->first('is_accessible') }}
        </span>
    @endif

    <label for="capacity" class="form-label">Capacity</label>
    <input id="capacity" type="text" name="capacity" value="{{ old('capacity') }}" class="form-control" required>
    @if ($errors->has('capacity'))
        <span class="error">
          {{ $errors->first('capacity') }}
        </span>
    @endif

    <label for="price" class="form-label">Price</label>
    <input id="price" type="number" name="price" value="{{ old('price') }}" class="form-control" required>
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
