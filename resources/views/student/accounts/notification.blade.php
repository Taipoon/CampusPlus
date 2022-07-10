@extends('layouts.app')

@section('title', '通知一覧')

@section('content')
  <div class="w-11/12 lg:w-2/3 mx-auto pt-8">
    <div class="bg-base mt-12 py-4 md:py-8 px-2 md:px-8">
      <p class="text-primary text-black font-semibold">{{ Auth::user()->last_name }}
        {{ Auth::user()->first_name }}さんへのお知らせ</p>
      <p class="text-sm text-gray-700">お知らせ一覧</p>
      <div class="h-2 my-4 border-b-2 border-separator"></div>
      <table class="w-full border border-gray-500">
        <thead class="bg-gray-300 text-center border border-gray-500">
          <th></th>
          <th>通知内容</th>
        </thead>
        <tbody>
          @foreach ($notifications as $notification)
            <tr class="border-b border-gray-500 bg-white @if ($notification->is_already_read) bg-second-row @endif">
              <td class="w-1/12 text-center py-4">
                <span class="flex justify-center space-x-2">
                  @if ($notification->type == $notification_types['good_comment'])
                    <x-good-comment />
                    <x-comment />
                  @elseif ($notification->type == $notification_types['good_thread'])
                    <x-good-comment />
                    <x-thread />
                  @elseif ($notification->type == $notification_types['reply'])
                    <x-reply />
                  @endif
                </span>
              </td>
              <td class="border-gray-600">
                @if ($notification->is_anonymous)
                  匿名希望 さんが
                @else
                  <a href="{{ route('student.accounts.show', ['student' => $notification->from_user_id]) }}"
                    class="text-blue-500 hover:text-blue-700 underline">
                    {{ $notification->sender->last_name }} {{ $notification->sender->first_name }}</a> さんが
                @endif
                @if ($notification->type == $notification_types['good_comment'])
                  あなたのコメント「
                  <b>
                    <a class="text-blue-500 hover:text-blue-700 underline"
                      href="{{ route('student.threads.show', ['thread' => $notification->comment->thread->id]) }}#{{ $notification->comment->id }}">
                      {{ $common->getOmittedText($notification->comment->text, 50) }}
                    </a>
                  </b>
                  」にいいねしました。
                @elseif ($notification->type == $notification_types['good_thread'])
                  あなたのスレッド「
                  <b>
                    <a class="text-blue-500 hover:text-blue-700 underline"
                      href="{{ route('student.threads.show', ['thread' => $notification->thread_id]) }}">
                      {{ $notification->thread->title }}
                    </a>
                  </b>
                  」にいいねしました。
                @elseif ($notification->type == $notification_types['reply'])
                  あなたのコメント「
                  <b>
                    <a class="text-blue-500 hover:text-blue-700 underline"
                      href="{{ route('student.threads.show', ['thread' => $notification->comment->thread->id]) }}#{{ $notification->comment_id }}">
                      {{ $common->getOmittedText($notification->comment->text, 30) }}
                    </a>
                  </b>
                  」に「
                  <b>
                    <a class="text-blue-500 hover:text-blue-700 underline"
                      href="{{ route('student.threads.show', ['thread' => $notification->comment->thread->id]) }}#{{ $notification->reply_comment_id }}">
                      {{ $common->getOmittedText($notification->reply_comment->text, 30) }}
                    </a>
                  </b>
                  」と返信しました。
                @endif
                ({{ $notification->created_at->diffForHumans() }})
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
