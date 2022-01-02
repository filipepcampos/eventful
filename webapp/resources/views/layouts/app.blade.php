<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script type="text/javascript">
      // Fix for Firefox autofocus CSS bug
      // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
      var BASE_URL = {!! json_encode(url('/')) !!};
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <main>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container-fluid">
          
          @if(Route::currentRouteName() != 'homepage')
            <a class="navbar-brand" href="{{ url('/') }}">Eventful</a>
          @endif
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
              <li class="nav-item mb-0">
                <a class="nav-link" href="{{ url('/about')}}">About Us</a>
              </li>
              <li class="nav-item mb-0">
                <a class="nav-link" href="{{ url('/contact') }}">Contact Us</a>
              </li>
            </ul>
            
            <form class="form-inline mx-auto mb-0 w-25" action="{{ url('/event')}}">
              <input class="form-control text-center h-70" type="search" id="search" name="search" placeholder="Search">
            </form>

            <ul class="navbar-nav ms-auto">
              @if (!Auth::check())
                <li class="nav-item mb-0">
                  <a class="nav-link" href="{{ url('/login') }}">Login</a>
                </li>
                <li class="nav-item mb-0">
                  <a class="nav-link" href="{{ url('/register') }}">Register</a>
                </li>
              @else
                <li class="nav-item mb-0">
                  <a class="nav-link" href="{{ url('/logout') }}">Logout</a>
                </li>
                <li class="nav-item mb-0">
                  <a class="nav-link text-white" href="{{ url('/user/' . Auth::id()) }}">{{ Auth::user()->name }}</a>
                </li>
              @endif
            </ul>
          </div>
        </div>
      </nav>
      <section id="content">
        @yield('content')
      </section>
    </main>
  </body>
</html>