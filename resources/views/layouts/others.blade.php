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

  <!-- Original CSS -->
  <link rel="stylesheet" href="{{ asset('css/original.css') }}">
  <style>
    /* main {
      background-image: url("{{ asset('images/bg-image-top.png') }}");
      background-size: 60px;
    } */
    header {
      background-color: '#FAFAFA';
      border-bottom: 2px solid '#CCCCCC';
    }

    h1 {
      font: bold 24px "Century Schoolbook", Georgia, Times, serif;
    }

    #name-bar {
      background-color: '#F0F0F0';
    }

  </style>

  {{-- Toastr --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
  <header class="w-full border-b border-gray-300">
    <nav class="flex justify-between items-center py-2 w-full lg:w-7/12 mx-auto">
      <div class="flex items-center">
        <img src="{{ asset('images/ui/systemT.png') }}" class="w-44">
        <h1 class="ml-8">CampusPlus BBS</h1>
      </div>
      <div class="flex">
        <div class="flex flex-col items-center">
          <button class="rounded-full w-8"></button>
          <a href="{{ route('student.dashboard') }}">
            <span>CampusPlus へ戻る</span></a>
        </div>
      </div>
    </nav>
  </header>
  <div class="w-full border-b border-gray-300 bg-others-name-bar" id="name-bar">
    <div class="w-full lg:w-7/12 mx-auto py-1 pl-8">
      <img src="{{ asset('images/ui/list.png') }}" class="w-6 inline-block mr-4">
      <img src="{{ asset('images/ui/name-bar-icon.png') }}" class="w-6 inline-block">
      <span class="text-secondary-button pl-4">{{ $student->last_name }} {{ $student->first_name }} 様</span>
    </div>
  </div>
  <main class="py-12">
    @yield('content')
  </main>
  <footer>
  </footer>
</body>

</html>
