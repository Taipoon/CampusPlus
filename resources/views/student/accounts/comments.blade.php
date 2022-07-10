@extends('layouts.app')

@section('title', $student->last_name . ' ' . $student->first_name . 'さんのコメント')

@section('content')
  <div class="w-11/12 lg:w-10/12 mx-auto pt-8">
    <div class="bg-base mt-12 py-4 md:py-8 px-2 md:px-8">
      <p class="text-primary text-black font-semibold">{{ $student->last_name }} {{ $student->first_name }}さんのスレッド一覧
      </p>
      <p class="text-sm text-gray-700">過去に投稿したコメント一覧です。</p>
      <div class="h-2 my-4 border-b-2 border-separator"></div>
      <table class="w-full border border-gray-500">
        <thead class="bg-gray-300 text-center border border-gray-500">
          <th>投稿日</th>
          <th>コメント</th>
          <th>スレッド名</th>
        </thead>
        <tbody>
          @if (count($student->comments) != 0)
            @foreach ($student->comments as $comment)
              <tr class="border-b border-gray-500">
                <td class="text-center">
                  {{ $comment->created_at->format('Y/m/d H:i:s') }}
                </td>

                <td class="border-r border-l border-gray-500 bg-first-row hover:bg-second-row py-1">
                  <a href="{{ route('student.threads.show', ['thread' => $comment->thread->id]) }}"
                    class="block">
                    {{ $common::getOmittedText($comment->text, 30) }}
                  </a>
                </td>

                <td class="bg-first-row hover:bg-second-row">
                  <a href="{{ route('student.threads.show', ['thread' => $comment->thread->id]) }}">
                    @if ($comment->thread->is_anonymous == 1)
                      【匿名】
                    @endif
                    {{ $common::getOmittedText($comment->thread->title, 20) }}
                  </a>
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
@endsection
