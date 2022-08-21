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
    main {
      background-image: url("{{ asset('images/bg-image-top.png') }}");
      background-size: 60px;
    }

  </style>

  {{-- Toastr --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<!--
                                                                             
           ■■      ■■■     ■                                                 
          ■ ■   ■■■■       ■    ■■■■■■■■■■■■                                 
  ■■■■■■■  ■      ■    ■■  ■    ■■   ■■    ■                                 
      ■■■  ■      ■    ■■  ■    ■■   ■■    ■                                 
     ■■        ■■■■■■■ ■■  ■    ■■■■■■■■■■■■                                 
                  ■    ■■  ■    ■■   ■■    ■                                 
                 ■■■   ■■  ■    ■■   ■■    ■                                 
                 ■■■■  ■■  ■    ■■   ■■    ■                                 
 ■■             ■■■ ■■ ■■  ■    ■■■■■■■■■■■■                                 
 ■             ■■ ■    ■■  ■    ■■   ■■    ■                                 
 ■             ■  ■        ■    ■■   ■■    ■                                 
 ■■               ■        ■    ■    ■■    ■                                 
   ■■■■■■■■       ■     ■  ■    ■    ■■    ■                                 
                  ■     ■■■■   ■■       ■■■■                                 
                                                                             
                                                                             
                                                                             
                                                                             
    ■                   ■                                                    
    ■                   ■             ■           ■■ ■   ■■ ■■        ■■     
   ■■■■■■■■■■■■   ■■■■■■■■■■■■■       ■          ■■■■■■■ ■  ■         ■■■■   
   ■              ■              ■■■■■■■■■■■■■■   ■■ ■   ■  ■            ■   
  ■               ■   ■   ■          ■                   ■■■■■■              
 ■■ ■■■■■■■■■     ■■■■■■■■■■■■■      ■           ■■■■■■■■■  ■         ■■■■■  
    ■   ■   ■     ■   ■   ■         ■■■■■■■■■    ■  ■  ■■■  ■      ■■■■   ■■ 
   ■■  ■■   ■     ■   ■■■■■        ■■■      ■    ■■■■■■■■■■■■■■            ■ 
 ■■■■■■■■■■■■■■   ■               ■■■■■■■■■■■       ■    ■  ■              ■ 
   ■   ■    ■     ■ ■■■■■■■■■    ■■ ■■      ■    ■■■■■■■ ■  ■              ■ 
   ■   ■    ■     ■   ■    ■     ■  ■■      ■       ■    ■■■■■■           ■■ 
   ■   ■   ■■     ■    ■  ■         ■■■■■■■■■    ■■■■■■■ ■  ■             ■  
   ■■■■■■■■■■■■  ■■     ■■■         ■■      ■       ■■   ■  ■           ■■■  
  ■■       ■     ■   ■■■■ ■■■■      ■■      ■      ■  ■■ ■■■■■■       ■■■    
        ■■■■     ■ ■■■       ■      ■■   ■■■■    ■■      ■            ■      
                                                                             
                                                                             
                                                                             
                                                                             
                                                                             
           ■■               ■                         ■               ■      
          ■ ■       ■■    ■■■■                        ■               ■■     
  ■■■■■■■  ■         ■   ■ ■    ■                     ■  ■■           ■■     
      ■■■  ■         ■■■■■      ■■      ■■       ■■■■■■■■■■    ■■■■■■■■■■■■■ 
     ■■         ■■■■■■■         ■■       ■            ■               ■■     
                      ■■        ■■       ■■           ■  ■          ■■■■     
                       ■        ■■        ■■      ■■■■■■■■         ■  ■■     
                        ■       ■■        ■■          ■            ■  ■■     
 ■■               ■■■■■■■■       ■         ■          ■            ■  ■■     
 ■               ■■     ■■       ■   ■     ■      ■■■■■             ■■■■     
 ■               ■               ■■ ■■           ■    ■■■             ■■     
 ■■              ■■               ■■■■           ■    ■ ■■■          ■■      
   ■■■■■■■■       ■■■■■■■          ■■             ■■■■    ■         ■■       
                                                                   ■■        
-->
<body class="font-sans antialiased relative">
  {{-- Page Top Button --}}
  <button type="button" onclick="location.href='#top'"
    class="bg-primary-button text-primary-button rounded-xl py-4 px-4 fixed right-2 lg:right-28 xl:right-32 bottom-12 opacity-80 font-bold z-50">
    PAGE TOP</button>

  <div class="min-h-screen bg-gray-100">
    {{-- Header --}}
    <div class="w-full h-3 bg-top-bar fixed"></div>
    <header class="w-full bg-header fixed mt-3 border-b-2 border-gray-300">
      {{-- Header Navigation Menu --}}
      <nav class="hidden lg:w-9/12 lg:flex xl:w-8/12 mx-auto justify-between ">
        <ul class="my-2 flex items-center space-x-2 text-center">
          <a href="{{ route('student.threads.index') }}">
            <li class="inline-block bg-navbar-item pt-2 w-16">
              <div class="flex flex-col items-center">
                <img src="{{ asset('images/ui/home.png') }}" class="w-5 mb-1">
                <span>{{ __('Home') }}</span>
              </div>
            </li>
          </a>
          <a href="{{ route('student.threads.create') }}">
            <li class="inline-block bg-navbar-item pt-2 w-24">
              <div class="flex flex-col items-center">
                <img src="{{ asset('images/ui/create.png') }}" class="w-5 mb-1">
                <span>{{ __('New Thread') }}</span>
              </div>
            </li>
          </a>
          <a href="{{ route('student.threads', ['student' => Auth::id()]) }}">
            <li class="inline-block bg-navbar-item pt-2 w-24">
              <div class="flex flex-col items-center">
                <img src="{{ asset('images/ui/mythread.png') }}" class="w-5 mb-1">
                <span>{{ __('My Threads') }}</span>
              </div>
            </li>
          </a>
          <a href="{{ route('student.bookmark', ['student' => Auth::id()]) }}">
            <li class="inline-block bg-navbar-item pt-2 w-24">
              <div class="flex flex-col items-center">
                <img src="{{ asset('images/ui/bookmark.png') }}" class="w-5 mb-1">
                <span>{{ __('Bookmark') }}</span>
              </div>
            </li>
          </a>
          <a href="{{ route('student.notification', ['student' => Auth::id()]) }}">
            <li class="inline-block bg-navbar-item pt-2 w-24">
              <div class="flex flex-col items-center">
                <img src="{{ asset('images/ui/notification.png') }}" class="w-5 mb-1">
                <span>{{ __('Notification') }}</span>
              </div>
            </li>
          </a>
          <a href="{{ route('student.others.index') }}" target="_blank">
            <li class="inline-block bg-navbar-item pt-2 w-24">
              <div class="flex flex-col items-center">
                <img src="{{ asset('images/ui/info.png') }}" class="w-5 mb-1">
                <span>{{ __('Others') }}</span>
              </div>
            </li>
          </a>
          <a href="{{ route('student.accounts.show', ['student' => Auth::id()]) }}">
            <li class="inline-block bg-navbar-item pt-2 w-24">
              <div class="flex flex-col items-center">
                <img src="{{ asset('images/ui/user.png') }}" class="w-4 mb-1">
                <span>{{ __('My Page') }}</span>
              </div>
            </li>
          </a>
        </ul>
        <div class="flex flex-col items-end justify-center space-y-1">
          @auth('students')
            <p>
            <form action="{{ route('student.logout') }}" method="POST">
              @csrf
              <button type="submit" class="text-logout font-semibold">
                <img src="{{ asset('images/ui/logout.png') }}" class="w-4 inline-block mr-2">ログアウト</button>
            </form>
            </p>
          @endauth
          @auth('teachers')
            <p>
            <form action="{{ route('teacher.logout') }}" method="POST">
              @csrf
              <button type="submit" class="text-logout font-semibold">
                <img src="{{ asset('images/ui/logout.png') }}" class="w-4 inline-block mr-2">ログアウト</button>
            </form>
            </p>
          @endauth
          <p>{{ Auth::user()->last_name }} {{ Auth::user()->first_name }} さん</p>
        </div>
      </nav>
      {{-- Responsive Header Navigation Menu --}}
      <nav class="flex flex-col w-11/12 mx-auto lg:hidden">
        <ul class="mx-auto flex space-x-4 py-2">
          <a href="{{ route('student.threads.index') }}">
            <li class="bg-primary-button text-white py-2 px-1 text-sm rounded-md">
              {{ __('Home') }}
            </li>
          </a>
          <a href="{{ route('student.threads.create') }}">
            <li class="bg-primary-button py-2 px-1 rounded-md text-sm text-white">{{ __('New Thread') }}</li>
          </a>
          <a href="{{ route('student.threads', ['student' => Auth::id()]) }}">
            <li class="py-2 text-sm text-white bg-primary-button rounded-md px-1">{{ __('My Threads') }}
            </li>
          </a>
          <a href="{{ route('student.bookmark', ['student' => Auth::id()]) }}">
            <li class="py-2 text-sm text-white bg-primary-button rounded-md px-1">{{ __('Bookmark') }}</li>
          </a>
          <a href="{{ route('student.notification', ['student' => Auth::id()]) }}">
            <li class="py-2 text-sm text-white bg-primary-button rounded-md px-1">{{ __('Notification') }}</li>
          </a>
          <a href="{{ route('student.others.index') }}">
            <li class="py-2 text-sm text-white bg-primary-button rounded-md px-1">{{ __('Others') }}</li>
          </a>
          <a href="{{ route('student.accounts.show', ['student' => Auth::id()]) }}">
            <li class="py-2 text-sm text-white bg-primary-button rounded-md px-1">{{ __('My Page') }}</li>
          </a>
        </ul>
        <div class="flex justify-around">
          <p>{{ Auth::user()->last_name }} {{ Auth::user()->first_name }} さん</p>
          <form action="{{ route('student.logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-logout font-semibold">
              <img src="{{ asset('images/ui/logout.png') }}" class="w-4 inline-block mr-1">
              ログアウト</button>
          </form>
        </div>
      </nav>
    </header>

    {{-- Main Contents --}}
    <main class="pb-16 pt-24">
      {{-- Flash Message --}}
      <script type="text/javascript">
        @if (session('msg_success'))
          $(function () {
          toastr.success('{{ session('msg_success') }}');
          });
        @elseif (session('msg_error'))
          $(function () {
          toastr.error('{{ session('msg_error') }}');
          });
        @endif
      </script>
      @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-footer text-white">
      <div class="py-12 w-9/12 xl:w-8/12 mx-auto">
        <p class="my-4">開志専門職大学 電子掲示板システム </p>
        <p><small>Copyright &copy; 2021 Taiki Hirayama(<span><a href="mailto:20120065@kaishi-pu.ac.jp">20120065@kaishi-pu.ac.jp</a></span>) All Rights Reserved.</small></p>        
      </div>
    </footer>
  </div>
  <script>
    function strCount(selectorId, maxLength) {
        // 入力した文字数
        const length = document.querySelector(selectorId).value.length;
        // 入力可能な残りの文字数
        const remainingLength = maxLength - length;
        // 文字数を表示
        const strLengthLabel = document.querySelector(`${selectorId}StrLength`);
        if (remainingLength < 0) {
          strLengthLabel.innerHTML = `現在<span class="text-red-500 font-bold">${length - maxLength}</span>文字超過しています。`;
        } else {
          strLengthLabel.innerHTML = `あと<span class="text-blue-500 font-bold">${remainingLength}</span>文字入力できます。`;
        }
      }
  </script>
</body>

</html>
