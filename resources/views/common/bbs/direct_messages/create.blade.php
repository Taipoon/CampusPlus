@extends('layouts.app')

@section('title', 'ダイレクトメッセージを作成')

@section('content')
  <div class="w-11/12 lg:w-2/3 mx-auto pt-8">
    <div class="bg-base mt-12 py-4 md:py-8 px-2 md:px-8">
      <p class="text-primary text-black font-semibold">{{ Auth::user()->last_name }}
        {{ Auth::user()->first_name }}さんのダイレクトメッセージ</p>
      <p class="text-sm text-gray-700">個人間のプライベートなコンタクトツール</p>
      <button class="text-lg text-primary-button bg-primary-button rounded-md px-2 py-1"
        onclick="location.href='{{ route('student.direct.create', ['student' => Auth::id()]) }}">新規</button>
      <div class="h-2 my-4 border-b-2 border-separator"></div>

      <div class="flex w-full bg-white h-96">
        <div class="bg-second-row w-1/3 min-h-full overflow-x-scroll">
          ダイレクトメッセージ
        </div>
        <div class="w-2/3 bg-secondary-row">
          <div class="bg-white w-full">
            ダイレクトメッセージ中身一覧
          </div>
          <div class="bg-white w-full py-32">
            これはどうなるんですか?
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
