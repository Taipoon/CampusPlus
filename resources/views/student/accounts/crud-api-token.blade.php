@extends('layouts.app')
@section('title', $user->last_name . ' ' . $user->first_name . 'さんの投稿一覧')
@section('content')
  <div class="w-11/12 lg:w-2/3 mx-auto pt-8">
    {{-- Threads --}}
    <div class="bg-base mt-12 py-4 md:py-8 px-2 md:px-8">
      <div class="my-4 flex justify-end">
        @if ($user->api_access_token)
          <form action="{{ route('student.deleteToken', ['student' => Auth::id()]) }}" method="POST">
            @csrf
            <button type="submit"
              class="bg-primary-button text-primary-button hover:bg-secondary-button hover:text-secondary-button border border-primary-button py-2 px-4 rounded-md ease-in transition-all">API
              キーを削除</button>
          </form>
        @else
          <form action="{{ route('student.createToken', ['student' => Auth::id()]) }}" method="POST">
            @csrf
            <button type="submit"
              class="bg-primary-button text-primary-button hover:bg-secondary-button hover:text-secondary-button border border-primary-button py-2 px-4 rounded-md ease-in transition-all">API
              キーを新規作成</button>
          </form>
        @endif
      </div>
      <div class="bg-gray-100 py-8 px-2 text-center text-lg">
        <p class="text-primary font-bold mb-8">{{ $user->last_name }} {{ $user->first_name }} さんのAPIアクセスキー</p>
        @if ($user->api_access_token)
          <input
            class="w-11/12 text-center py-2 px-4 text-2xl bg-input-field border-2 focus:outline-none focus:outline-fuchsia-200"
            id="apiKeyText" value="{{ $user->api_access_token }}" readonly>
          <br>
          <button type="button" class="rounded-lg mt-8 py-2 px-4 bg-ict text-white border-2 border-green-400"
            onclick="copyToClipboard()">クリップボードへコピー</button>
        @else
          <span class="text-2xl">アクセスキーがありません。</span>
        @endif
      </div>
    </div>
  </div>
  <script>
    function copyToClipboard() {
      // コピー対象をJavaScript上で変数として定義する
      const copyTarget = document.getElementById("apiKeyText");

      // コピー対象のテキストを選択する
      copyTarget.select();

      // 選択しているテキストをクリップボードにコピーする
      document.execCommand("Copy");

      // コピーをお知らせする
      alert('クリップボードへコピーしました。');
    }
  </script>
@endsection
