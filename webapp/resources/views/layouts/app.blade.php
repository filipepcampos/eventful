<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/milligram.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet"> 

    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <main>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          
          @if(Route::current()->getName() != '')
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
                <a class="nav-link" href="{{ url('/contactUs') }}">Contact Us</a>
              </li>
            </ul>
            
            <form class="form-inline mx-auto mb-0">
              <input class="form-control" type="search" placeholder="&#128269; Search" aria-label="Search">
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
                  <span>{{ Auth::user()->name }}</span>
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
    @include('layouts.scripts')
  </body>
</html>