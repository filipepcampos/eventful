@extends('layouts.app')

@section('content')
<div class="container w-50 d-flex justify-content-center mt-5">
    <div class="card w-50">
        <div class="card-header"><br></div>
        <div class="card-body">@yield('form-content')</div>
    </div>
</div>
@endsection
