@extends('layouts.top')
@section('title', 'Campus Plus')
<style>
  button {
    background-color: rgba(0, 0, 0, 0.3);
    color: blue;
    font-weight: 900;
  }

  input:focus {
    transition: 0.2s ease-in-out;
    box-shadow: 0 0 5px 5px #E3AA7F;
  }

</style>
@section('content')

  <div class="w-11/12 mx-auto mt-8 lg:flex lg:flex-wrap lg:w-3/4">
    {{-- Responsive Campus Image --}}
    <div class="hidden lg:inline-block w-7/12 max-w-4xl mx-auto">
      <img src="{{ asset('images/yoneyama_picture.jpg') }}" alt="米山キャンパスの画像">
    </div>

    {{-- REsponsive Login Form and System Information --}}
    {{-- Login Form --}}
    <form action="{{ route('student.login') }}" method="POST"
      class="w-full md:max-w-11/12 md:w-3/4 md:mx-auto lg:w-4/12">
      @csrf
      <div id="login-form" class="w-full bg-base flex flex-col items-center">
        {{-- Email --}}
        <div class="mt-8 w-2/3">
          {{-- Validation Errors --}}
          <x-login-validation-errors />
          <label for="email" class="block text-primary font-semibold">
            <img src="{{ asset('images/title-side-mark.png') }}" class="inline-block w-4">
            メールアドレス</label>

          <input type="email" id="email" name="email" autofocus value="{{ old('email') }}"
            class="border-gray-300 focus:outline-none focus:border-focused-input-field-outline bg-input-field w-full">
        </div>
        {{-- Password --}}
        <div class="my-4 w-2/3">
          <label for="password" class="block text-primary font-semibold">
            <img src="{{ asset('images/title-side-mark.png') }}" class="inline-block w-4"> {{ __('Password') }}
          </label>
          <input type="password" id="password" name="password"
            class="border-gray-300 focus:border-focused-input-field-outline bg-input-field w-full">
        </div>
        {{-- Login Button --}}
        <div class="my-2">
          <button class="bg-primary-button text-primary-button py-2 px-8 hover:bg-hoverd-login-button rounded-md"
            class="submit">ログイン</button>
        </div>

        {{-- Register --}}
        <div class="mb-8 mt-2 text-center">
          <a href="{{ route('student.register') }}" class="text-gray-500 underline hover:text-gray-800">初めての方は新規会員登録</a>
        </div>
    </form>
    {{-- Responsive System Information --}}
    <div class="hidden w-full lg:block mt-4 bg-system-information py-8 px-4">
      <h2 class="text-normal font-semibold">推奨ブラウザ</h2>
      <p>当サイトは、以下のブラウザにて動作確認をしております。</p>
      {{-- PC --}}
      <div class="my-16">
        <ul>
          <li class="py-4">PC (Windows)</li>
          <li class="py-4">Google Chrome 96.0 (最新ver推奨)</li>
        </ul>
      </div>
      {{-- Mobile --}}
      <div class="my-16">
        <p class="my-8">モバイル</p>
        <ul class="pl-4">
          <li>【iOS(※)】Safari, Chrome</li>
        </ul>
      </div>

      {{-- Others --}}
      <div class="my-16">
        <ul>
          <li>(※) システム利用時にエラーが出る可能性があります。その場合管理人に問い合わせてください。</li>
        </ul>
      </div>
    </div>
  </div>

  {{-- Campus Image --}}
  <div class="mt-4 w-full md:max-w-11/12 md:w-3/4 md:mx-auto lg:hidden">
    <img src="{{ asset('images/yoneyama_picture.jpg') }}" alt="米山キャンパスの画像">
  </div>

  {{-- System Information --}}
  <div class="mt-4 bg-system-information py-8 px-4 w-full md:max-w-11/12 md:w-3/4 md:mx-auto lg:hidden">
    <h2 class="text-normal font-semibold">推奨ブラウザ</h2>
    <p>当サイトは、以下のブラウザにて動作確認をしております。</p>
    {{-- PC --}}
    <div class="my-16">
      <ul>
        <li class="py-4">PC (Windows)</li>
        <li class="py-4">Google Chrome 96.0 (最新ver推奨)</li>
      </ul>
    </div>
    {{-- Mobile --}}
    <div class="my-16">
      <p class="my-8">モバイル</p>
      <ul class="pl-4">
        <li>【iOS(※)】Safari, Chrome</li>
      </ul>
    </div>
    {{-- Others --}}
    <div class="my-16">
      <ul>
        <li>(※) システム利用時にエラーが出る可能性があります。その場合管理人に問い合わせてください。</li>
      </ul>
    </div>
  </div>
@endsection
