@extends('user.layouts.app')

{{-- このページ専用CSS --}}
@section('styles')
<link rel="stylesheet" href="{{ asset('css/curriculum_list.css') }}">
@endsection


@section('content')

<div class="page">

  <h1 class="page-title">時間割</h1>

  @if($curriculums->isEmpty())

    <div class="empty">
      表示できる授業がありません。
    </div>

  @else

    <div class="grid">

      @foreach ($curriculums as $c)

      <article class="card">

        <div class="thumb">

          @if(!empty($c->thumbnail))
            <img src="{{ asset($c->thumbnail) }}" alt="サムネイル">
          @else
            <div class="thumb-placeholder">
              No Image
            </div>
          @endif

        </div>


        <div class="body">

          <div class="title">
            {{ $c->title }}
          </div>


          <div class="meta">

            <span class="badge {{ $c->alway_delivery_flg ? 'badge-on' : 'badge-off' }}">
              {{ $c->alway_delivery_flg ? '常時公開' : '期間公開' }}
            </span>


            <div class="period">

              <div class="label">
                公開期間
              </div>

              <div class="value">

                @if($c->alway_delivery_flg)

                  いつでも

                @else

                  {{ $c->delivery_from ? \Carbon\Carbon::parse($c->delivery_from)->format('Y/m/d H:i') : '未設定' }}
                  〜
                  {{ $c->delivery_to ? \Carbon\Carbon::parse($c->delivery_to)->format('Y/m/d H:i') : '未設定' }}

                @endif

              </div>

            </div>

          </div>


          <div class="actions">
            {{-- 将来ここを配信ページにリンク --}}
            <a class="btn" href="/delivery/{{ $c->id }}">詳細</a>
            <a class="btn primary" href="/delivery/{{ $c->id }}">受講する</a>
          </div>

        </div>

      </article>

      @endforeach

    </div>

  @endif

</div>

@endsection