@extends('admin.layouts.app')

@section('title', '管理ユーザー新規登録')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <h1 class="auth-title">管理ユーザー新規登録</h1>

        @if ($errors->any())
            <div class="error-box">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.register.store') }}">
            @csrf

            <label class="label" for="name">ユーザーネーム</label>
            <input
                class="input"
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                autofocus
            >

            <label class="label" for="kana">ユーザーネーム（カナ）</label>
            <input
                class="input"
                id="kana"
                type="text"
                name="kana"
                value="{{ old('kana') }}"
            >

            <label class="label" for="email">メールアドレス</label>
            <input
                class="input"
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
            >

            <label class="label" for="password">パスワード</label>
            <input
                class="input"
                id="password"
                type="password"
                name="password"
            >

            <label class="label" for="password_confirmation">パスワード（確認）</label>
            <input
                class="input"
                id="password_confirmation"
                type="password"
                name="password_confirmation"
            >

            <button class="btn-primary" type="submit">登録</button>

            <div class="auth-footer">
                <a class="link" href="{{ route('admin.show.login') }}">ログイン画面へ戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection