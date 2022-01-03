@extends('layouts.form')

@section('title', 'Eventful - Create Event')
@section('form-title', 'Create Event')

@section('breadcrumbs')
<li class="breadcrumb-item" aria-current="page"><a href="{{ route('homepage') }}">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Create Event</li>
@endsection

@section('form-content')
<form method="POST" action="{{ route('createEvent') }}" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="form-group mb-3">
    <label for="title" class="form-label">Title</label>
    <input id="title" type="text" name="title" class="form-control @if($errors->has('title')) is-invalid @endif" required>
    @if ($errors->has('title'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('title') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label class="form-label" for="event_image">Event Image</label>
    <input type="file" name="event_image" class="form-control-file @if($errors->has('file')) is-invalid @endif" id="event_image" accept="image/*">
    @if ($errors->has('event_image'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('event_image') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" type="textarea" name="description" class="form-control @if($errors->has('description')) is-invalid @endif" required></textarea>
    @if ($errors->has('description'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('description') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="location" class="form-label">Location</label>
    <input id="location" type="text" name="location" class="form-control @if($errors->has('location')) is-invalid @endif" required>
    @if ($errors->has('location'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('location') }}
      </div>
    @endif
  </div>
  
  <div class="form-group mb-3">
    <label for="realization_date" class="form-label">Realization Date</label>
    <input id="realization_date" type="datetime-local" name="realization_date" class="form-control @if($errors->has('realization_date')) is-invalid @endif" required>
    @if ($errors->has('realization_date'))
      <div class="invalid-feedback d-block">
        {{ $errors->first('realization_date') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <div class="form-check">
      <input id="is_visible" type="checkbox" name="is_visible" class="form-check-input @if($errors->has('is_visible')) is-invalid @endif">
      <label for="is_visible" class="form-check-label">Visibility</label>
    </div>
    @if ($errors->has('is_visible'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('is_visible') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <div class="form-check">
      <input id="is_accessible" type="checkbox" name="is_accessible" class="form-check-input @if($errors->has('is_accessible')) is-invalid @endif">
      <label for="is_accessible" class="form-check-label">Accessability</label>
    </div>
    @if ($errors->has('is_accessible'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('is_accessible') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="capacity" class="form-label">Capacity</label>
    <input id="capacity" type="text" name="capacity" class="form-control @if($errors->has('capacity')) is-invalid @endif">
    @if ($errors->has('capacity'))
      <div class="invalid-feedback d-block">
          {{ $errors->first('capacity') }}
      </div>
    @endif
  </div>

  <div class="form-group mb-3">
    <label for="price" class="form-label">Price</label>
    <input id="price" type="number" name="price" class="form-control @if($errors->has('price')) is-invalid @endif" required>
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
