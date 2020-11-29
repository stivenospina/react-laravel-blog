@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <br>
    <div class="text-center">
      <br>
      <h2 class="index-header text-danger">About Me</h2>
      <br>
      {{--
    <img src="{{ asset('photos/kyleprofesional2.jpg') }}" alt="kyle professional" class="header-small-img border border-dark rounded">
      --}}
    </div>
    <br>
    <p class="my-3 paragraph"> Hello, my name is Kyle! I am a web developer and tech junkie from Georgia USA. I wanted this site to be a showcase of neat things that I've done over the years. This website is special to me not just because it shares with the world some of my old projects and experiences, but because it was originally my first public hand coded website using just HTML and CSS.</p>

    <p class="my-3 paragraph">As my coding journey advanced, the site was improved with PHP which allowed for modularity of parts and less repetitive lines of code. Still though, adding new projects and pages needed lots of boilerplate and repitition. I needed a content management system to solve this problem. So I built one! The front end is a bit of React and Bootstrap. The back end is Laravel (still PHP but a more robust framework). Project data and photos are uploaded to the back end and stored in a SQLite database. Most of the front end pages are templates rendered with dynamic content with the ability to add, delete, and customize project data and appearance without the need to write any more lines of code.

      <p class="my-3 paragraph">I now have a more easy to manage, more centralized portfolio for project outside of web development. For more programming stuff and to see some even cooler web projects, please take a look at my <a href="http://kyleweb.dev">Web Dev Portfolio</a> or follow the link in the top. If you need some web work done, don't be shy! Contact me through my <a href="http://kyleweb.dev/#contact">contact form</a> and I will get right back with you! By the way, thanks for visiting the site!!!</p>
      <p class="text-center mt-2 my-3"><img src="{{ asset('photos/kyleprofesional2.jpg') }}" class="w-25 rounded border shadow mr-3"> - Sincerely, Kyle </p>
      <br>
  </div>
</div>
@endsection