@extends('layouts.form')

@section('title', 'Eventful - Create Event')
@section('form-title', 'Create Event')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('homepage') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Create Event</li>
@endsection

@section('form-content')
<div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Dropdown button
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#">Action</a>
    <a class="dropdown-item" href="#">Another action</a>
    <a class="dropdown-item" href="#">Something else here</a>
  </div>
</div>

<form method="POST" action="{{ route('createEvent') }}" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="form-group mb-3">
    <label for="title" class="form-label">Title</label>
    <input id="title" type="text" name="title" value="{{ old('title') }}" class="form-control @if($errors->has('title')) is-invalid @endif" required>
    @if ($errors->has('title'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('title') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label class="form-label" for="event_image">Event Image</label>
    <input type="file" name="event_image" value="{{ old('event_image') }}" class="form-control-file @if($errors->has('file')) is-invalid @endif" id="event_image" accept="image/*">
    @if ($errors->has('event_image'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('event_image') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" maxlength="8192" value="{{ old('description') }}" type="textarea" name="description" class="form-control @if($errors->has('description')) is-invalid @endif" required></textarea>
    @if ($errors->has('description'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('description') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="location" class="form-label">Location</label>
    <input id="location" type="text" name="location" value="{{ old('location') }}" class="form-control @if($errors->has('location')) is-invalid @endif" required>
    @if ($errors->has('location'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('location') }}
      </div>
    @endif
  </div>
  
  <div class="form-group mb-3">
    <label for="realization_date" class="form-label">Realization Date</label>
    <input id="realization_date" type="datetime-local" value="{{ old('realization_date') }}" name="realization_date" class="form-control @if($errors->has('realization_date')) is-invalid @endif" required>
    @if ($errors->has('realization_date'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('realization_date') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="visibility" class="form-check-label">Visibility</label>
    <select class="form-control @if($errors->has('visibility')) is-invalid @endif"  value="{{ old('visibility') }}" id="visibility" name="visibility" required>
      <option value="public">Public</option>
      <option value="private">Private</option>
    </select>
    @if ($errors->has('visibility'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('visibility') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="accessibility" class="form-check-label">Accessibility</label>
    <select class="form-control @if($errors->has('accessibility')) is-invalid @endif" value="{{ old('accessibility') }}" id="accessibility" name="accessibility" required>
      <option value="public">Public</option>
      <option value="private">Private</option>
    </select>
    @if ($errors->has('accessibility'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('accessibility') }}
      </div>
    @endif
  </div>

  
  <div class="form-group mb-3">
    
  </div>

  <div class="form-group mb-3">
    <label for="capacity" class="form-label">Capacity</label>
    <input id="capacity" type="text" name="capacity" value="{{ old('capacity') }}" class="form-control @if($errors->has('capacity')) is-invalid @endif">
    @if ($errors->has('capacity'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('capacity') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="price" class="form-label">Price</label>
    <input id="price" type="number" step=".01" name="price" value="{{ old('price') }}" class="form-control @if($errors->has('price')) is-invalid @endif" required>
    @if ($errors->has('price'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('price') }}
      </div>
    @endif
  </div>

  <button type="submit" class="btn btn-primary">
      Submit
  </button>
</form>
@endsection
