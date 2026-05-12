<!DOCTYPE html>
    <html lang="ja">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>@yield('title', '管理画面')</title>
            <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
        </head>
        <body>

        @unless (request()->routeIs('admin.show.login') || request()->routeIs('admin.show.register'))
        <header class="admin-header">
            <div class="admin-header-inner">
                <div class="admin-header-left">
                    <a href="{{ route('admin.show.top') }}" class="admin-brand">管理画面</a>

                    <nav class="admin-nav">
                        <a class="admin-link" href="{{ url('/admin/curriculums') }}">授業管理</a>
                        <a class="admin-link" href="{{ url('/admin/articles') }}">お知らせ管理</a>
                        <a class="admin-link" href="{{ route('admin.show.banner.edit') }}">バナー管理</a>
                    </nav>
                </div>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="admin-logout-btn">ログアウト</button>
                </form>
            </div>
        </header>
        @endunless

        <main class="admin-main">
            @yield('content')
        </main>

        </body>
    </html>