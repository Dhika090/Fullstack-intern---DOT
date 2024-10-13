@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create New Post</h2>

        <!-- Menampilkan pesan validasi error -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form untuk input post baru -->
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Select a category</option> <!-- Opsi default -->
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
@endsection
