@extends('admin.layouts.app')

@section('title', '管理ログイン')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <h1 class="auth-title">管理ログイン</h1>

        @if ($errors->any())
            <div class="error-box">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}">
            @csrf

            <label class="label" for="email">メールアドレス</label>
            <input
                class="input"
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                autofocus
            >

            <label class="label" for="password">パスワード</label>
            <input
                class="input"
                id="password"
                type="password"
                name="password"
            >

            <button class="btn-primary" type="submit">ログイン</button>

            <div class="auth-footer">
                <a class="link" href="{{ route('admin.show.register') }}">新規登録はこちら</a>
            </div>
        </form>
    </div>
</div>
@endsection