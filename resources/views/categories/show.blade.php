@extends('layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $category->name }}</h2>
                    <p class="text-muted">{{ $category->description }}</p>
                </div>
                <div class="card-body">
                    <h4>投稿一覧</h4>
                    @foreach($posts as $post)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                </h5>
                                <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                                <div class="text-muted">
                                    投稿者: {{ $post->user->name }} | 
                                    投稿日時: {{ $post->created_at->format('Y/m/d H:i') }} |
                                    いいね: {{ $post->likes->count() }} |
                                    コメント: {{ $post->comments->count() }}
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 