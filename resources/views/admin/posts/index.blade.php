@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Post Archive</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th colspan="3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)

            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->created_at }}</td>
                <td>{{ $post->updated_at }}</td>
                <td><a href="#" class="btn btn-success">Show</a></td>
                <td><a href="#" class="btn btn-primary">Edit</a></td>
                <td><a href="#" class="btn btn-danger">Delete</a></td>
            </tr>
            @endforeach

        </tbody>
    </table>


    <div class="wrap-pagination mt-5 d-flex justify-content-end">
        {{ $posts->links() }}
    </div>

</div>
@endsection
