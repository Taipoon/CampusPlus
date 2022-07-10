@extends('layouts.app')
@section('title', $user->last_name . ' ' . $user->first_name . 'さんの投稿一覧')
@section('content')
  <div class="w-11/12 lg:w-10/12 mx-auto pt-8">
    {{-- Threads --}}
    <div class="bg-base mt-12 py-4 md:py-8 px-2 md:px-8">
      <p class="text-primary text-black font-semibold">{{ $user->last_name }} {{ $user->first_name }}さんのスレッド一覧</p>
      <p class="text-sm text-gray-700">背景色が緑のスレッドは解決済み、赤のスレッドは回答募集中です。</p>
      <div class="h-2 my-4 border-b-2 border-separator"></div>
      @if (count($threads) !== 0)
        <table class="w-full border border-gray-500">
          <thead class="bg-gray-300 text-center border border-gray-500">
            <tr>
              <th class="table-cell h-16">投稿日時</th>
              <th>タイトル</th>
              <th class="hidden md:table-cell">カテゴリ</th>
              <th>コメント数</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($threads as $thread)
              <tr class="bg-first-row hover:bg-second-row border-b border-gray-500">

                <td class="table-cell text-center">{{ $thread->created_at->format('Y/m/d H:i:s') }}</td>

                <td class="border border-gray-500 py-1 md:py-2 text-left @if ($thread->status->id == $status_code['required']) bg-red-200 hover:bg-red-100 @elseif ($thread->status->id == $status_code['resolved']) bg-green-200 hover:bg-green-100 @endif">
                  <a href="{{ route('student.threads.show', ['thread' => $thread->id]) }}"
                    class="inline-block w-full h-full">
                    @if ($thread->is_anonymous)
                      【匿名】
                    @endif
                    {{ $thread->title }}
                  </a>
                </td>
                <td class="hidden md:table-cell border border-gray-500">
                  {{ $thread->secondary_category->primary_category->name . ' >> ' . $thread->secondary_category->name }}
                </td>
                <td class="text-center">{{ $thread->comments->count() }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="text-center">
          <p>まだスレッドを作成していません。</p>
          <p><a href="{{ route('student.threads.create') }}"
              class="text-blue-500 hover:text-blue-700 underline">スレッドを新しく作成</a>してみんなのコメントを募集しましょう！</p>
        </div>
      @endif
    </div>
  </div>
@endsection
