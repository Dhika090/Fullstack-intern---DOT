@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Edit Post</h2>
        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" value="{{ $post->title }}" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" name="content" rows="5" required>{{ $post->content }}</textarea>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Update Post</button>
        </form>
    </div>
@endsection
