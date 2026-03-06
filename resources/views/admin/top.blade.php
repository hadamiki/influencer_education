@extends('admin.layouts.app')

@section('title', '管理トップ')

@section('content')
<h1 class="page-title">管理アカウントトップページ</h1>

<div class="card">
    <div class="kv">
        <div class="kv-label">ユーザーネーム</div>
        <div class="kv-value">{{ $admin->name }}</div>
    </div>

    <div class="kv">
        <div class="kv-label">メールアドレス</div>
        <div class="kv-value">{{ $admin->email }}</div>
    </div>
</div>
@endsection