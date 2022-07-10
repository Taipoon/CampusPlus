@extends('layouts.app')
@section('title', 'Campus Plus')
@section('content')
  <div class="w-11/12 lg:w-10/12 mx-auto pt-8">
    <div class="text-black font-semibold py-1 px-2 overflow-hidden w-full">
      @if ($unread_notifications_count != 0)
        <div id="notification" class="text-right">
          <a href="{{ route('student.notification', ['student' => Auth::id()]) }}"
            class="text-blue-500 hover:text-blue-700 underline">
            {{ $unread_notifications_count }}
            件の新着通知があります。</a>
        </div>
      @endif
    </div>
    <div class="latest-login flex justify-end">
      <p>
        ログイン日時: {{ $last_login_at->format('Y年m月d日 H:i:s') }}({{ $last_login_at->diffForHumans() }})
      </p>
    </div>
    {{-- Search Area --}}
    <div id="search-area" class="bg-base py-4 md:py-8 px-2 md:px-8">

      <p class="text-primary text-black font-semibold">スレッド検索</p>

      <div class="h-2 my-4 border-b-2 border-separator"></div>

      <form action="{{ route('student.threads.index') }}" method="GET">
        <div id="search-box" class="flex justify-center flex-wrap space-y-2 items-center">
          <input type="text" name="search_word" autofocus value="{{ $search_word }}" placeholder="キーワードでスレッド検索"
            class="bg-white md:py-2 border-2 border-gray-500 rounded-2xl inline-block focus:outline-none focus:bg-input-field md:w-5/12">
          <select name="thread_status" class="rounded-lg bg-secondary-button mx-2">
            <option value="0">すべての種類</option>
            @foreach ($statuses as $status)
              <option value="{{ $status->id }}" @if ($status->id == $thread_status) selected @endif>{{ $status->name }}</option>
            @endforeach
          </select>
          <select name="category" class="rounded-lg bg-secondary-button mx-2">
            <option value="0">すべてのカテゴリ</option>
            @foreach ($primary_categories as $primary_category)
              <optgroup label="{{ $primary_category->name }}">
                @foreach ($primary_category->secondary_categories as $secondary_category)
                  <option value="{{ $secondary_category->id }}" @if ($secondary_category->id == $category) selected @endif>
                    {{ $secondary_category->name }}</option>
                @endforeach
              </optgroup>
            @endforeach
          </select>
          <div>
            <input type="checkbox" id="is_anonymous" name="is_anonymous" value="1" @if ($is_anonymous === 1) checked @endif><label
              for="is_anonymous" class="pl-4">匿名スレッドのみ</label>
          </div>
          <button
            class="bg-primary-button text-primary-button py-2 px-4 mx-4 md:mx-8 rounded-xl text-lg font-semibold">検索</button>
        </div>
      </form>
    </div>

    {{-- Threads --}}
    <div class="bg-base mt-12 py-4 md:py-8 px-2 md:px-8">
      <p class="text-primary text-black font-semibold">新着スレッド一覧</p>
      <p class="text-sm text-gray-700">背景色が緑のスレッドは解決済み、赤のスレッドは回答募集中です。【匿名】が付いているスレッドは、匿名専用のスレッドです。</p>
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
          @foreach ($threads as $thread)
            <tr class="bg-first-row hover:bg-second-row border-b border-gray-500">
              <td class="hidden md:table-cell text-center">{{ $thread->created_at->format('Y/m/d H:i:s') }}</td>
              <td class="border border-gray-500 py-1 md:py-2 text-left @if ($thread->status->id == $status_code['required']) bg-red-200 hover:bg-red-100 @elseif ($thread->status->id == $status_code['resolved']) bg-green-200 hover:bg-green-100 @endif">
                <a href="{{ route('student.threads.show', ['thread' => $thread->id]) }}"
                  class="inline-block w-full h-full">
                  @if ($thread->is_anonymous)
                    <span class="text-normal">【匿名】</span>
                  @endif
                  {{ $thread->title }}
                </a>
              </td>
              @if ($thread->is_anonymous)
                <td></td>
              @else
                <td>{{ $thread->student->last_name }}{{ $thread->student->first_name }}
              @endif
              </td>
              <td class="border border-gray-500">{{ $thread->secondary_category->name }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div id="pagination" class="my-4">
        {{ $threads->links() }}
      </div>
    </div>
  </div>
@endsection
