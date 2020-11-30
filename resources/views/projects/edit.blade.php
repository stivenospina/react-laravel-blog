@extends('layouts.app')

@section('content')

{{-- Here pass the project from model to javascript --}}
<input id="project-data" type="hidden" value="{{ json_encode($project) }}" />

{{-- Here pass the items related to the project to javascript --}}
<input id="items-data" type="hidden" value="{{ json_encode($project->Item) }}" />


<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<h2 class="text-center text-danger mb-5">Edit @if($project->projOrExp == 'project') Project @else Experience @endif</h2>
			<form action="/projects/{{ $project->id }}" method="POST" class="form-group" enctype="multipart/form-data">
				@csrf
				@method('PUT')

				<div class="text-center">
					<label for="project">
						<h5>Project: </h5>
					</label>
					<input type="radio" name="proj-or-exp" value="project" class="mr-3" @if($project->projOrExp == 'project') checked @endif/>

					<label for="project">
						<h5>Experience: </h5>
					</label>
					<input type="radio" name="proj-or-exp" value="experience" @if($project->projOrExp == 'experience') checked @endif/>
				</div>

				<label for="name">
					<h5>@if($project->projOrExp == 'project') Project @else Experience @endif Name:</h5>
				</label>
				<input id="name" name="name" type="text" class="form-control mb-4" value="{{ $project->name }}" />

				<label for="main-photo" className="mt-4">
					<h5>Main Photo:</h5>
				</label>
				<div class="row justify-content-center">
					<div class="square-wrapper border rounded shadow-sm">
						<img id="main-photo-edit" src="{{ asset($project->mainPhoto) }}" alt="photo: {{ $project->name }}" class="img2rows" />
					</div>
				</div>
				<div class="row justify-content-center">
					<input id="main-photo" name="main-photo" type="file" class="mt-1 pl-4 ml-5" />
				</div>
				<div class="row justify-content-center">
					{{-- on submit backend will return the edit project view with react component --}}
					<button type="submit" class="btn btn-primary text-center mt-5">Submit Edit Above</button>
				</div>
			</form>
		</div>
	</div>
	<hr class="my-4">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<h2 class="text-center text-danger my-5">Flow of Items</h2>

			<form name="flowForm">

				{{-- Flow react component will mount here and handle this form--}}
				<div id="flow"></div>

			</form>
		</div>
	</div>
</div>
</div>
@endsection