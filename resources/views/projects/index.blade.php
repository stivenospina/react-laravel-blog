@extends('layouts.app')

@section('content')
<div class="container px-lg-5 pb-5">
    <div class="text-center">
        <br>
        <h1 class="index-header text-danger">@if (count($projects) > 0 && $projects[0]->projOrExp == "experience") Experiences @else Projects @endif</h1>
        <br>
        <p class="mx-2 mx-md-5 mb-4">@if (count($projects) > 0 && $projects[0]->projOrExp == "experience")
                Here, I would like to share some of my personal experiences from working cool jobs and traveling around. I will slowly be adding more items to this page. Feel free to comment!
            @else
                Welcome! I would like to share with you some of my personal projects. I will slowly be adding more of them to the site. Feel free to comment on any of them!
            @endif </p>
    </div>
    <div class="row justify-content-center">
        @foreach($projects as $project)
        <div class="col-12 col-sm-6 col-lg-4 mt-4 text-center">
            <a href="projects/{{ $project->id }}" class="text-dark link-to-project">
                <div class="square-wrapper border rounded mx-auto shadow-sm square-wrapper-hover">
                    <img src="{{ $project->mainPhoto }}" alt="{{ $project->name }}" class="img2rows">
                </div>
                <p>{{ $project->name }}</p>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection