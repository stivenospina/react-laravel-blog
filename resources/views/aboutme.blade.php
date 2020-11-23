@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <br>
    <div class="text-center">
		<h2 class="text-center">About me</h2>
		<br>
    <img src="{{ asset('photos/kyleprofesional2.jpg') }}" alt="kyle professional" class="header-small-img border border-dark rounded">
  </div>
    <br>
		<p class="mt-4"> Hello, my name is Kyle! I am a web developer from the United States. I built this website originally as a blog and as my first public website. Since then, the site it has evolved into somewhat of a shocase of my previous projects and a way that I can share my past experiences. Please take a look at my web development portfolio by clicking the link in the menu above. Thanks for visiting the site!</p>
    <p class="text-center"><img src="{{ asset('photos/wink.jpg') }}"><br> &nbsp - Sincerely, Kyle </p>
    <br>
    </div>
</div>
@endsection
