  
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ $post->title }}</h1>

    {{-- edit button --}}
    <a class="btn btn-sm btn-primary" href="{{ route("admin.posts.edit", $post->id)}}">Edit</a>
    {{-- delete --}}
    <form class="d-inline" action="{{ route("admin.posts.destroy", $post->id) }}" method="POST">
        @csrf
        @method("DELETE")
        
        <input type="submit" value="Delete" class="btn btn-sm btn-danger">
    </form>

    {{-- Post body --}}
    <p>{{ $post->body }}</p>
    <span class="created font-weight-light font-italic">Created at: </span> 
    <span class="created font-weight-light">
        {{ $post->created_at->format("d/m/Y") }}
    </span>
    <span class="updated font-weight-light font-italic">Updated last time: </span> 
    <span class="updated font-weight-light">
        {{ $post->updated_at->diffForHumans() }}
    </span>
   

</div>


@endsection