@extends('layout')

@section('content')
<div class= "container mt-5">
    <h2>掲示板</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">新規投稿</a>
    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title">{{ $post->title }}</h3>
                <p class="card-text">{{ $post->content }}</p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">詳細</a>
            </div>
        </div>
    @endforeach
</div>
@endsection 