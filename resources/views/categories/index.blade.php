@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>カテゴリー一覧</h2>
                </div>
                <div class="card-body">
                    @auth
                        <form action="{{ route('categories.store') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="form-group">
                                <label for="name">カテゴリー名</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">説明</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3"></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">カテゴリーを作成</button>
                        </form>
                    @endauth

                    <div class="list-group">
                        @foreach($categories as $category)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">
                                            <a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                                        </h5>
                                        <p class="mb-1 text-muted">{{ $category->description }}</p>
                                        <small>投稿数: {{ $category->posts_count }}</small>
                                    </div>
                                    @auth
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                                        </form>
                                    @endauth
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 