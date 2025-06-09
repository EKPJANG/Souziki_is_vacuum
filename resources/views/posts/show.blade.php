@extends('layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- 記事本文エリア -->
            <div class="card shadow-sm mb-4" style="border-left: 4px solid #007bff;">
                <div class="card-header bg-primary text-white">
                    <h1 class="mb-2" style="font-size: 1.8rem;">{{ $post->title }}</h1>
                    <div class="text-light">
                        <i class="fas fa-user"></i> 投稿者: {{ $post->user->name }} | 
                        <i class="fas fa-folder"></i> カテゴリー: {{ $post->category->name ?? '未分類' }} | 
                        <i class="fas fa-clock"></i> 投稿日時: {{ $post->created_at->format('Y/m/d H:i') }}
                    </div>
                </div>
                <div class="card-body bg-light" style="font-size: 1.1rem; line-height: 1.8;">
                    <p class="mb-4" style="white-space: pre-wrap; color: #333;">{{ $post->content }}</p>

                    <!-- いいねボタン -->
                    <div class="d-flex align-items-center mb-3 p-3 bg-white rounded border">
                        @auth
                            @if($post->likes->where('user_id', auth()->id())->count() > 0)
                                <form action="{{ route('likes.destroy', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-heart"></i> いいねを取り消す
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('likes.store', $post) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="far fa-heart"></i> いいね
                                    </button>
                                </form>
                            @endif
                        @endauth
                        <span class="ml-3 text-muted"><i class="fas fa-heart text-danger"></i> {{ $post->likes->count() }} いいね</span>
                    </div>
                </div>
            </div>

            <!-- コメントエリア -->
            <div class="card shadow-sm" style="border-left: 4px solid #28a745;">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-comments"></i> コメント ({{ $post->comments->count() }}件)</h4>
                </div>
                <div class="card-body bg-light">
                    @foreach($post->comments as $comment)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body bg-white" style="font-size: 0.9rem;">
                                <p class="mb-2">{{ $comment->content }}</p>
                                <div class="text-muted small">
                                    <i class="fas fa-user-circle"></i> {{ $comment->user->name }} | 
                                    <i class="fas fa-clock"></i> {{ $comment->created_at->format('Y/m/d H:i') }}
                                </div>
                                @auth
                                    @if(auth()->id() === $comment->user_id)
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">削除</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach

                    @if($post->comments->count() == 0)
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-comment-slash fa-2x mb-2"></i>
                            <p>まだコメントがありません</p>
                        </div>
                    @endif

                    <!-- コメント投稿フォーム -->
                    @auth
                        <div class="mt-4 p-3 bg-white rounded border">
                            <h5 class="mb-3"><i class="fas fa-edit"></i> コメントを投稿</h5>
                            <form action="{{ route('comments.store', $post) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea name="content" id="content" 
                                              class="form-control @error('content') is-invalid @enderror" 
                                              rows="3" 
                                              placeholder="コメントを入力してください..." 
                                              required></textarea>
                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-paper-plane"></i> コメントを投稿
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center p-4 bg-white rounded border">
                            <p class="text-muted mb-2">コメントを投稿するにはログインが必要です</p>
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">ログイン</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection