@extends('admin.layouts.app')

@section('title', 'バナー管理')

@section('content')
<a class="back-link" href="{{ route('admin.show.top') }}">← 戻る</a>

<h1 class="page-title">バナー管理</h1>

@if (session('status'))
  <div class="notice">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('admin.banners.update') }}" enctype="multipart/form-data">
  @csrf

  <div class="banner-list" id="bannerList">

    @foreach ($banners as $b)
      <div class="banner-row">
        <div class="banner-preview">
          @if (!empty($b->image))
            <img src="{{ asset('storage/'.$b->image) }}" alt="banner">
          @else
            <div class="banner-empty">No Image</div>
          @endif
        </div>

        <div class="banner-actions">
          <input class="file-input" type="file" name="images[{{ $b->id }}]" accept="image/*">
        </div>

        <div class="banner-delete">
          <input id="del_{{ $b->id }}" type="checkbox" name="delete_ids[]" value="{{ $b->id }}" class="delete-check">
          <label for="del_{{ $b->id }}" class="delete-btn" title="削除"></label>
        </div>
      </div>
    @endforeach

    <template id="newRowTemplate">
      <div class="banner-row banner-row-new">
        <div class="banner-preview">
          <div class="banner-empty">No Image</div>
        </div>

        <div class="banner-actions">
          <input class="file-input" type="file" name="new_images[]" accept="image/*">
        </div>

        <div class="banner-delete">
          <button type="button" class="delete-btn delete-btn-new" title="削除"></button>
        </div>
      </div>
    </template>

  </div>

  <div class="banner-add">
    <button type="button" class="add-btn" id="addBannerBtn" title="追加"></button>
  </div>

  <div class="form-footer">
    <button type="submit" class="submit-btn">登録</button>
  </div>
</form>

<script>
  (function () {
    const addBtn = document.getElementById('addBannerBtn');
    const list = document.getElementById('bannerList');
    const tpl = document.getElementById('newRowTemplate');

    // 追加
    addBtn.addEventListener('click', () => {
      const node = tpl.content.cloneNode(true);
      list.appendChild(node);
    });

    // 新規行の削除（画面上から消す）
    list.addEventListener('click', (e) => {
      if (e.target && e.target.classList.contains('delete-btn-new')) {
        const row = e.target.closest('.banner-row-new');
        if (row) row.remove();
      }
    });

    // プレビュー更新
    list.addEventListener('change', (e) => {
      const input = e.target;
      if (!input || !input.classList.contains('file-input')) return;

      const file = input.files && input.files[0];
      if (!file) return;

      const row = input.closest('.banner-row');
      if (!row) return;

      const previewBox = row.querySelector('.banner-preview');
      if (!previewBox) return;

      let img = previewBox.querySelector('img');
      if (!img) {
        previewBox.innerHTML = '';
        img = document.createElement('img');
        img.alt = 'banner';
        previewBox.appendChild(img);
      }

      const reader = new FileReader();
      reader.onload = (ev) => {
        img.src = ev.target.result;
      };
      reader.readAsDataURL(file);
    });
  })();
</script>
@endsection