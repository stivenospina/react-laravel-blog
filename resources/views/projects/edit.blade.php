@extends('layouts.app')

@section('content')

{{-- Here pass the current flow array from model to javascript --}}
<input id="flow-data" type="hidden" value="{{ json_encode($projectFlow) }}" />

{{-- pass in the project id --}}
<input id="project-id" type="hidden" value="{{ $id }}" />


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			<h2 class="text-center text-danger mb-5">Edit Project</h2>
			<form action="/projects/{{ $id }}" method="POST" class="form-group" enctype="multipart/form-data">
					@csrf
					@method('PUT')

					<label for="name"><h5>Project Name:</h5></label>
					<input id="name" name="name" type="text" class="form-control mb-4" value="{{ $name }}"/>

					<label for="main-photo"><h5>Main Photo:</h5></label>
				
					<img id="main-photo-edit" src="{{ asset($mainPhoto) }}" alt="photo: {{ $name }}" />
					<br>

					<input id="main-photo" name="main-photo" type="file" class="mb-3" />

					<div class="row justify-content-center">
						{{-- on submit backend will return the edit project view with react component --}}
						<button type="submit" class="btn btn-primary text-center mt-3">Submit Edit Above</button>
					</div>
				</form> 
			</div>
		</div>
	</div>
	<hr class="my-4">
	<div class="row justify-content-center">
        <div class="col-md-8">
			<h2 class="text-center text-danger my-5">Project Flow</h2>
			
				<form name="flowForm">

					{{-- Flow react component will mount here and handle this form--}}
					<div id="flow"></div>

				</form>
			</div>
		</div>
	</div>
</div>
@endsection
