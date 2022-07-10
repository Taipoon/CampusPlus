@extends('layouts.app')

@section('title', 'ダイレクトメッセージ')

@section('content')
  <div class="w-11/12 lg:w-2/3 mx-auto pt-8">
    <div class="bg-base mt-12 py-4 md:py-8 px-2 md:px-8">
      <p class="text-primary text-black font-semibold">{{ Auth::user()->last_name }}
        {{ Auth::user()->first_name }}さんのダイレクトメッセージ</p>
      <p class="text-sm text-gray-700">個人間のプライベートなコンタクトツール</p>
      <button class="text-lg text-primary-button bg-primary-button rounded-md px-2 py-1"
        onclick="location.href='{{ route('student.direct.create', ['student' => Auth::id()]) }}'">新規</button>
      <div class="h-2 my-4 border-b-2 border-separator"></div>

      <div class="flex w-full bg-white h-96">
        <div class="bg-second-row w-1/3 min-h-full overflow-x-scroll">
          ダイレクトメッセージ
          @foreach ($direct_messages as $direct_message)
            <div class="border-b">
              {{ $direct_message }}
            </div>
          @endforeach
        </div>
        <div class="bg-second-row w-2/3 min-h-full">
          ダイレクトメッセージ中身一覧
        </div>
      </div>
    </div>
  </div>
@endsection
