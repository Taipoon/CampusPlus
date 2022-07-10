@extends('layouts.app')
@section('title', $student->last_name . ' ' . $student->first_name . 'さんのブックマーク')
@section('content')
  <div class="w-11/12 lg:w-10/12 mx-auto pt-8">
    {{-- Search Area --}}
    <div id="search-area" class="bg-base py-4 md:py-8 px-2 md:px-8">

      <p class="text-primary text-black font-semibold">スレッド検索</p>

      <div class="h-2 my-4 border-b-2 border-separator"></div>

      <form action="{{ route('student.bookmark', ['student' => Auth::id()]) }}" method="GET">
        <div id="search-box" class="flex justify-center">
          <input type="text" name="search_word" value="{{ $search_word }}" autofocus
            class="bg-white w-1/3 md:py-2 border-2 border-gray-500 rounded-2xl inline-block focus:outline-none focus:bg-input-field md:w-5/12">

          <select name="thread_status" class="rounded-lg bg-secondary-button mx-4">
            <optgroup label="スレッドの状態">
              <option value="0">すべて</option>
              @foreach ($statuses as $status)
                <option value="{{ $status->id }}" @if ($status->id == $thread_status) selected @endif>{{ $status->name }}</option>
              @endforeach
            </optgroup>
          </select>
          <button
            class="bg-primary-button text-primary-button py-2 px-4 md:mx-4 rounded-xl text-lg font-semibold">検索</button>
        </div>
      </form>
    </div>

    {{-- Threads --}}
    <div class="bg-base mt-12 py-4 md:py-8 px-2 md:px-8">
      <p class="text-primary text-black font-semibold">ブックマークしたスレッド一覧</p>
      <p class="text-sm text-gray-700">背景色が緑のスレッドは解決済み、赤のスレッドは回答募集中です。</p>
      <p class="text-sm text-gray-700 font-semibold">ブックマークの一覧が他人に閲覧されることはありません。</p>
      <div class="h-2 my-4 border-b-2 border-separator"></div>

      <table class="w-full border border-gray-500">
        <thead class="bg-gray-300 text-center border border-gray-500">
          <tr>
            <th class="hidden md:table-cell h-16">投稿日時</th>
            <th>タイトル</th>
            <th>投稿者</th>
            <th>カテゴリ</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($student->bookmark_threads as $thread)
            <tr class="bg-first-row hover:bg-second-row border-b border-gray-500">
              <td class="hidden md:table-cell text-center">
                {{ $thread->created_at->format('Y/m/d H:i:s') }}</td>
              <td class="border border-gray-500 py-1 md:py-2 text-left @if ($thread->status->id == $status_code['required']) bg-red-200 hover:bg-red-100 @elseif ($thread->status->id == $status_code['resolved']) bg-green-200 hover:bg-green-100 @endif">
                <a href="{{ route('student.threads.show', ['thread' => $thread->id]) }}"
                  class="inline-block w-full h-full">
                  @if ($thread->is_anonymous)
                    <span class="text-normal">【匿名】</span>
                  @endif
                  {{ $thread->title }}
                </a>
              </td>
              @if ($thread->is_anonymous && Auth::id() != $thread->student->id)
                <td></td>
              @else
                <td>{{ $thread->student->last_name }}{{ $thread->student->first_name }}</td>
              @endif
              <td class="border border-gray-500">{{ $thread->secondary_category->name }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
