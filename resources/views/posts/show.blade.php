@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $post->title }}</h2>
                    <div class="text-muted">
                        投稿者: {{ $post->user->name }} | 
                        カテゴリー: {{ $post->category->name ?? '未分類' }} | 
                        投稿日時: {{ $post->created_at->format('Y/m/d H:i') }}
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $post->content }}</p>

                    <!-- いいねボタン -->
                    <div class="d-flex align-items-center mb-4">
                        @auth
                            @if($post->likes->where('user_id', auth()->id())->count() > 0)
                                <form action="{{ route('likes.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-heart"></i> いいねを取り消す
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('likes.store', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="far fa-heart"></i> いいね
                                    </button>
                                </form>
                            @endif
                        @endauth
                        <span class="ml-2">{{ $post->likes->count() }} いいね</span>
                    </div>

                    <!-- コメント一覧 -->
                    <h4>コメント</h4>
                    @foreach($post->comments as $comment)
                        <div class="card mb-2">
                            <div class="card-body">
                                <p class="card-text">{{ $comment->content }}</p>
                                <div class="text-muted">
                                    投稿者: {{ $comment->user->name }} | 
                                    投稿日時: {{ $comment->created_at->format('Y/m/d H:i') }}
                                </div>
                                @auth
                                    @if(auth()->id() === $comment->user_id)
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach

                    <!-- コメント投稿フォーム -->
                    @auth
                        <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-4">
                            @csrf
                            <div class="form-group">
                                <label for="content">コメントを投稿</label>
                                <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="3" required></textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">コメントを投稿</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection