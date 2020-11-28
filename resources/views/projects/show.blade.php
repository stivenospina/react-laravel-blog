@extends('layouts.app')

@section('content')
<div class="container px-md-5 pb-5">
    <div class="text-center">
        <br>
        <h2>{{ $project->name }}</h2>
        <br>
    </div>
    @foreach($project->item as $item)
    <div class="row justify-content-center">
        @if($item->type == 'paragraph')
        <div class="row mt-3 mb-2 mx-2">
            <p class="paragraph">{{ $item->data }}</p>
        </div>
        @elseif($item->type == 'video')
        <div class="row justify-content-center my-4 embed-responsive embed-responsive-16by9 video-sm">
            
            <iframe width="560" height="315" src="{{ $item->data }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="embed-responsive-item" allowfullscreen></iframe>
            
        </div>
        @elseif($item->type == 'one')
        <div class="row justify-content-center my-4">
            <div class="col-md-10">
                <img src="{{  $item->photos[0]  }}" class="img-fluid border" />
            </div>
        </div>
        @elseif($item->type == 'two')
        <div class="row justify-content-center my-4" key={index}>
            <div class="col-md-6">
                <img src="{{  $item->photos[0]  }}" class="img-fluid border" />
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <img src="{{  $item->photos[1]  }}" class="img-fluid border" />
            </div>
        </div>
        @elseif($item->type == 'four')
        <div class="row justify-content-center my-4">
            <div class="col-md-6">
                <img src="{{  $item->photos[0]  }}" class="img-fluid border" />
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <img src="{{  $item->photos[1]  }}" class="img-fluid border" />
            </div>
        </div>
        <div class="row justify-content-center mb-md-4 mt-1">
            <div class="col-md-6">
                <img src="{{  $item->photos[2]  }}" class="img-fluid border" />
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <img src="{{  $item->photos[3]  }}" class="img-fluid border" />
            </div>
        </div>
        @endif
    </div>
    @endforeach
</div>
@endsection