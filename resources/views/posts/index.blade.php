@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Posts</h2>
        <!-- Form Pencarian -->
        <form action="{{ route('posts.search') }}" method="GET">
            <input type="text" name="query" placeholder="Search posts..." class="form-control">
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </form>
        <br>

        <a href="{{ route('categories.create') }}" class="btn btn-info">Tambah Category</a>
        <a href="{{ route('posts.create') }}" class="btn btn-info">Tambah Content</a>
        <br>
        <br><hr>
        <!-- Jika Ada Posts -->
        <h2>All Categories</h2>
        @if ($posts->count() > 0)
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ Str::limit($post->content, 100) }}</td>
                            <td>
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">View</a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No posts found.</p>
        @endif

        <hr>
        <br>

        <h2>All Categories</h2>
        <!-- Jika Ada Categories -->
        @if ($categories->count() > 0)
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>
                                {{-- <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info">View</a> --}}
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No categories found.</p>
        @endif
    </div>
@endsection
