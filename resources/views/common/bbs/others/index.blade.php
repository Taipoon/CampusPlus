@extends('layouts.others')

@section('title', 'その他')

@section('content')
  <div class="mt-18">
    <div class="w-1/2 mx-auto text-center flex justify-start space-x-24 items-center">
      {{-- <div>
        <a href="#">
          <img src="{{ asset('images/ui/buttons/edit-basic-information-button.png') }}">
        </a>
        <span class="inline-block mt-4 font-semibold">基本情報変更(未実装)</span>
      </div>
      <div>
        <a href="#">
          <img src="{{ asset('images/ui/buttons/add-category-button.png') }}">
        </a>
        <span class="inline-block mt-4 font-semibold">カテゴリー追加申請(未実装)</span>
      </div> --}}
      <div>
        <a href="{{ route('student.others.api') }}">
          <img src="{{ asset('images/ui/buttons/api-button.png') }}">
        </a>
        <span class="inline-block mt-4 font-semibold">APIの利用</span>
      </div>
    </div>
  </div>

@endsection
