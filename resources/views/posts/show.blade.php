@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Title: {{ $post->title }}</h2>
    <p>Content: {{ $post->content }}</p>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
