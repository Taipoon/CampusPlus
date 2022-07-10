<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <style>
    main {
      background-image: url("{{ asset('images/bg-image-top.png') }}");
      background-size: 60px;
    }

  </style>

  <!-- Original CSS -->
  <link rel="stylesheet" href="{{ asset('css/original.css') }}">
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased relative">
  {{-- Header --}}
  <div class="min-h-screen bg-gray-100">
    <div class="w-full h-3 bg-top-bar fixed"></div>
    <header class="w-full bg-header fixed mt-3 border-b-2 border-gray-300">
      {{-- Header Navigation Menu --}}
      <nav class="w-3/4 mx-auto flex justify-between items-top">
        <h1 class="text-2xl pt-4 pb-6">
          <img src="{{ asset('images/title-side-mark.svg') }}" class="w-6 inline-block">
          開志専門職大学
        </h1>
        <img src="{{ asset('images/title.png') }}" class="block h-9 mt-2">
      </nav>
    </header>

    {{-- Main Contents --}}
    <main class="pb-16 pt-24">
      @yield('content')
    </main>
    {{-- Footer --}}
    <footer class="bg-footer text-white">
      <div class="py-12 w-9/12 xl:w-8/12 mx-auto">
        <p class="my-4">開志専門職大学 電子掲示板システム </p>
        <p><small>Copyright &copy; 2021 Taiki Hirayama All Rights Reserved.</small></p>
      </div>
    </footer>
  </div>
</body>

</html>
