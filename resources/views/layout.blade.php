<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板アプリ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">掲示板</a>
            <div>
                <a class="nav-link d-inline" href="{{ route('categories.index') }}">カテゴリー一覧</a>
                @auth
                    <a class="nav-link d-inline" href="{{ route('posts.create') }}">新規投稿</a>
                    <a class="nav-link d-inline" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                @else
                    <a class="nav-link d-inline" href="{{ route('login') }}">ログイン</a>
                    <a class="nav-link d-inline" href="{{ route('register') }}">新規登録</a>
                @endauth
            </div>
        </div>
    </nav>
    @yield('content')
</body>
</html>