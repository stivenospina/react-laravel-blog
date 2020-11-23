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
    <!-- Custom stylesheet lazymillennial.css -->
    <link href="{{ asset('lazymillennial.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
    <div class="text-center" style="padding: 1%;" id="top">
  	<div class="container" style="width: 50%">
  		<div class="row align-items-center pr-md-5">
        	<div class="col-md"><h1 class="text-nowrap float-md-right text-danger">a lazy</h1></div>
      		<div class="col-md"><img src="{{ asset('photos/kyle2.jpg') }}" alt="Kyle" class="img-fluid rounded-circle header-small-img  border border-danger"></div>
	      	<div class="col-md"><h1 class="float-md-left text-danger">millennial</h1></div>
     	</div>
  	</div>
</div>
<ul class="nav justify-content-center header-boot-copy" >
    <li class="nav-item">
      <a class="nav-link text-dark" id="projects" href="/">Projects</a>
    </li>
  	<li class="nav-item">
    	<a class="nav-link text-dark" id="quick_cash" href="/experiences">Experiences</a>
  	</li>
    <li class="nav-item">
    	<a class="nav-link text-dark" id="about_me" href="/aboutme">About Me</a>
  	</li>
    <li class="nav-item">
      <a class="nav-link text-dark" id="contact" href="http://kyleweb.dev">Web Dev</a>
    </li>

</ul>
<br>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
