@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <br>
    <div class="text-center">
		<h2 class="text-center">About me</h2>
        <br>
{{--
    <img src="{{ asset('photos/kyleprofesional2.jpg') }}" alt="kyle professional" class="header-small-img border border-dark rounded">
--}}
  </div>
    <br>
		<p class="mt-4"> Hello, my name is Kyle! I am a web developer from the United States. I built this website originally as a blog and as my first public website. Since then, the site has become a showcase of my previous projects, acomplishments, and a way that I can share some past experiences and cool photos. This website along with the CMS were built with PHP and Laravel. For more web dev stuff and info about me, please take a look at my web development portfolio by clicking the link in the menu above. Thanks for visiting the site!</p>
    <p class="text-center mt-2">{{-- <img src="{{ asset('photos/wink.jpg') }}"> --}} &nbsp - Sincerely, Kyle </p>
    <br>
    </div>
</div>
@endsection
