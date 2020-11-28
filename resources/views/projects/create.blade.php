@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			<form action="/projects" method="POST" class="form-group" enctype="multipart/form-data">
				@csrf

				<div class="text-center">
					<label for="project"><h5>Project: </h5></label>
					<input type="radio" name="proj-or-exp" value="project" class="mr-3" checked/>

					<label for="project"><h5>Experience: </h5></label>
					<input type="radio" name="proj-or-exp" value="experience" />
				</div>
				
				<br>

				<label for="name"><h5>Project Name:</h5></label>
				<input id="name" name="name" type="text" class="form-control mb-4" required/>

				<label for="main-photo"><h5>Main Photo:</h5></label>
				<br>
				<input id="main-photo" name="main-photo" type="file" class="mb-3" required/>

				<div class="row justify-content-center">
					{{-- on submit backend will return the edit project view with react component --}}
					<button type="submit" class="btn btn-primary text-center mt-3">Create New Project</button>
				</div>
			</form> 
        </div>
    </div>
</div>
@endsection
