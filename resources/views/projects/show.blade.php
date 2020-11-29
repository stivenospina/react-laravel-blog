@extends('layouts.app')

@section('edit/delete')
{{-- This is the edit/delete links with show in the app.blade --}}
<div id="edit-delete-buttons" class="mr-4 mt-1 pt-1"><a href="/projects/{{ $project->id }}/edit"><i class="far fa-edit mr-2 text-muted"></i></a>
/
<a href="delete" onclick="event.preventDefault(); document.getElementById('edit-form').submit();"><i class="far fa-trash-alt ml-2 text-muted"></i></a></div>
<form id="edit-form" action="/projects/{{ $project->id }}" method="POST" style="display: none;">
    @method('delete')
    @csrf
</form>
@endsection

@section('content')
<div class="container px-md-5 pb-5">
    <div class="text-center">
        <br>
        <h2 class="index-header text-danger mb-1">{{ $project->name }}</h2>
    </div>
    @foreach($project->item as $item)
    <div class="row justify-content-center">
        @if($item->type == 'paragraph')
        <div class="row mt-1 mx-2">
            <p class="paragraph">{{ $item->data }}</p>
        </div>
        @elseif($item->type == 'video')
        <div class="row justify-content-center my-5 embed-responsive embed-responsive-16by9 video-sm">

            <iframe width="560" height="315" src="{{ $item->data }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="embed-responsive-item" allowfullscreen></iframe>

        </div>
        @elseif($item->type == 'one')
        <div class="row justify-content-center my-5">
            <div class="col-md-10">
                <img src="{{  $item->photos[0]  }}" class="img-fluid border rounded shadow" />
            </div>
        </div>
        @elseif($item->type == 'two')
        <div class="row justify-content-center my-5" key={index}>
            <div class="col-md-6">
                <img src="{{  $item->photos[0]  }}" class="img-fluid border rounded shadow-sm" />
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <img src="{{  $item->photos[1]  }}" class="img-fluid border rounded shadow-sm" />
            </div>
        </div>
        @elseif($item->type == 'four')
        <div class="row justify-content-center mt-5 mb-4">
            <div class="col-md-6">
                <img src="{{  $item->photos[0]  }}" class="img-fluid border rounded shadow-sm" />
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <img src="{{  $item->photos[1]  }}" class="img-fluid border rounded shadow-sm" />
            </div>
        </div>
        <div class="row justify-content-center mb-5 mt-1">
            <div class="col-md-6">
                <img src="{{  $item->photos[2]  }}" class="img-fluid border rounded shadow-sm" />
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <img src="{{  $item->photos[3]  }}" class="img-fluid border rounded shadow-sm" />
            </div>
        </div>
        @endif
    </div>
    @endforeach

    <p class="text-center mt-2">Thanks for reading and feel free to comment below!</p>
    <br>
    <hr>
    <!-- Back to top button-->
    <div class="text-center">
        <a href="#top"><button type="button" class="btn btn-light border border-dark mt-2">Back to top</button></a>
    </div>
</div>

<!-- DISQUS COMMENTING CODE -->
<div class="container px-md-5">
    <div id="disqus_thread"></div>
</div>
<script>
    /**
     *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
     *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
    /*
    var disqus_config = function () {
    this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
    this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
    };
    */
    (function() { // DON'T EDIT BELOW THIS LINE
        var d = document,
            s = d.createElement('script');
        s.src = 'https://lazymillennial-me-1.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
<!-- END DISCUS CODE -->
@endsection