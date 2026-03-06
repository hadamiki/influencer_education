<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>インフルエンサー教育システム</title>

  {{-- ページ個別CSS --}}
  @yield('styles')
</head>
<body>

  <header style="padding:12px 16px; border-bottom:1px solid #e5e7eb;">
    <h1 style="margin:0; font-size:18px;">インフルエンサー教育システム</h1>
  </header>

  <main style="padding: 16px;">
    @yield('content')
  </main>

</body>
</html>