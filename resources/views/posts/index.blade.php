@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">掲示板</h1>
        <div>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary mr-2">カテゴリー一覧</a>
            @auth
                <a href="{{ route('posts.create') }}" class="btn btn-primary mr-2">新規投稿</a>
                <a href="{{ route('logout') }}" class="btn btn-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    ログアウト
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary mr-2">ログイン</a>
                <a href="{{ route('register') }}" class="btn btn-success">新規登録</a>
            @endauth
        </div>
    </div>

    @if($posts->count() > 0)
        @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                    </h4>
                    <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                    <div class="text-muted mb-2">
                        投稿者: {{ $post->user->name ?? '不明' }} |
                        カテゴリー: 
                        @if($post->category)
                            <a href="{{ route('categories.show', $post->category) }}">{{ $post->category->name }}</a>
                        @else
                            未分類
                        @endif
                        |
                        投稿日: {{ $post->created_at->format('Y/m/d H:i') }}
                    </div>
                    <div>
                        <span class="mr-3"><i class="far fa-heart"></i> いいね: {{ $post->likes->count() }}</span>
                        <span><i class="far fa-comment"></i> コメント: {{ $post->comments->count() }}</span>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    @else
        <div class="alert alert-info">投稿がありません。</div>
    @endif
</div>
@endsection 