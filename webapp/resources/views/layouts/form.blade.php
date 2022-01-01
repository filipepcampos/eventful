@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 d-flex mt-5 justify-content-center">
        <div class="card">
            <div class="card-header"><br></div>
            <div class="card-body">@yield('form-content')</div>
        </div>
    </div>
</div>
@endsection
