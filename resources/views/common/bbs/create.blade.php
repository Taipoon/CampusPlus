@extends('layouts.app')
@section('title', 'スレッド新規作成')
@section('content')

  <div class="w-11/12 lg:w-7/12 mx-auto pt-8">
    {{-- Thread Card --}}
    <div class="bg-base">
      <div class="mt-8 py-4 md:py-8 px-2 md:px-8">
        <p class="text-primary text-black font-semibold">新規スレッド作成</p>
        <div class="h-2 my-4 border-b-2 border-separator"></div>
        {{-- Form --}}
        <form action="{{ route('student.threads.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div id="input-field" class="p-4 bg-white border border-gray-200">
            {{-- Validation Errors --}}
            <x-validation-errors />
            <input type="text" placeholder="タイトルを入力" max="40" name="title" value="{{ old('title') }}"
              class="bg-input-field py-2 w-full border border-gray-500 shadow-inner focus:outline-none block" autofocus>
            <span class="text-sm text-gray-700">最大40文字で入力してください。</span>
            <textarea name="text"
              class="bg-input-field h-40 py-2 mt-8 w-full border border-gray-500 shadow-inner focus:outline-none block"
              placeholder="コメントを入力">{{ old('text') }}</textarea>
            <span class="text-sm text-gray-700">最大700文字で入力してください。</span>
            <div class="lg:flex justify-start lg:space-x-8 my-8 px-4">
              <div>
                <label for="category" class="w-full inline-block font-semibold text-lg">カテゴリ</label>
                <select name="category" id="category" class="w-full">
                  @foreach ($primary_categories as $primary_category)
                    <optgroup label="{{ $primary_category->name }}">
                      @foreach ($primary_category->secondary_categories as $secondary_category)
                        <option value="{{ $secondary_category->id }}" @if (old('category') == $secondary_category->id) selected @endif>
                          {{ $secondary_category->name }}</option>
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
              </div>
              <div class="mt-4 lg:m-0">
                <label for="image" class="w-full inline-block font-semibold text-lg">画像</label>
                <input type="file" id="image" accept=".jpg,.png" class="w-full" name="image">
              </div>
            </div>
            <div class="border border-primary-button p-2 bg-first-row">
              <p class="">
                <b>「回答を募集する」</b>を選択した場合、スレッドは赤色で表示され、<br>
                書き込まれるコメントのうち1つを
                <span class="text-secondary-button bg-yellow-400 p-1 rounded-md">ベストアンサー</span>
                に選べます。
                <br>
                <span class="text-secondary-button bg-yellow-400 p-1 rounded-md">ベストアンサー</span>
                が決定したスレッドは、引き続きコメントの投稿は可能ですが「解決済み」扱いとなり、緑色で表示されます。
              </p>
              <p class="mt-8">
                <b class="text-red-500">「匿名スレッドにする」</b>を選択した場合、スレッドの作成者とコメント投稿者が匿名化されます。<br>
                また、他人があなたの「<a class="text-blue-500 hover:text-blue-700 underline"
                  href="{{ route('student.threads', ['student' => Auth::id()]) }}">スレッド一覧</a>」を閲覧しても、匿名スレッドは表示されません。(自分の匿名スレッドは表示されます。)
              </p>
            </div>
            <div class="text-center my-4">
              <div class="w-full mb-4 flex justify-around">
                <div class="w-1/2">
                  <input type="checkbox" name="request_for_answer" id="request_for_answer" @if (old('request_for_answer') == 1) checked @endif>
                  <label for="request_for_answer" class="pl-2">回答を募集する</label>
                </div>
                <div class="w-1/2">
                  <input type="checkbox" name="is_anonymous" id="is_anonymous" @if (old('is_anonymous') == 1) checked @endif>
                  <label for="is_anonymous" class="pl-2 font-semibold text-red-500">匿名スレッドにする</label>
                </div>
              </div>
              <button
                class="bg-primary-button text-primary-button py-2 px-4 mx-4 md:mx-8 rounded-xl text-lg font-semibold">投稿する</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
