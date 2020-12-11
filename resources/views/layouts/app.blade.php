<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Google Lobster font -->
  <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">

  <Title>LazyMillennial.me</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <!-- FAVICON -->
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-96x96.png">

</head>

<body>
  <div id="app">
    @auth
    <div class="row justify-content-end mr-2">
      @section('edit/delete')
      @show
      <li class="nav dropdown d-block justify-content-end">
        <a id="navbarDropdown" class="nav-link dropdown-toggle h4 text-muted mt-1 pr-4" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('projects.create') }}">
            Create New
          </a>

          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </li>
    </div>

    @endauth

    <div class="text-center mt-2" style="padding: 1%;" id="top">
      <div class="container" style="width: 50%">
        <div class="row align-items-center">
          <div class="col-md-12">
            <h1 class="text-nowrap text-danger">a lazy</h1>
          </div>
          <div class="col-md-12"><img src="{{ asset('photos/kyle2.jpg') }}" alt="Kyle" class="rounded-circle header-small-img  border border-danger"></div>
          <div class="col-md-12">
            <h1 class="text-danger">millennial</h1>
          </div>
        </div>
      </div>
    </div>
    <ul class="nav justify-content-center header-boot-copy">
      <li class="nav-item">
        <a class="nav-link @if(isset($page) && $page == 'projects') text-danger @else text-dark @endif" id="projects" href="/">Projects</a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if(isset($page) && $page == 'experiences') text-danger @else text-dark @endif" id="quick_cash" href="/experiences">Experiences</a>
      </li>
      <li class="nav-item">
        <a class="nav-link @if(isset($page) && $page == 'aboutme') text-danger @else text-dark @endif" id="about_me" href="/aboutme">About Me</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-dark" id="contact" href="http://kyleweb.dev">Web Dev</a>
      </li>
    </ul>
    <br>

    <main class="py-4 mx-2 mx-md-0">
      @yield('content')
    </main>

    <div class="foot text-center my-4">
      <h4 class="text-muted">kyleweb.dev</h4>
    </div>
  </div>
</body>

</html>