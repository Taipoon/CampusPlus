@extends('layouts.app')
@section('title', 'コメントに返信する')
@section('content')
  <div class="w-11/12 lg:w-7/12 mx-auto pt-8">

    {{-- Create New Comment --}}
    <div class="mt-12 py-4 md:py-8 px-2 md:px-8 bg-base">
      <p class="mb-4 text-primary text-black font-semibold">以下のコメントに返信する</p>
      <div class="bg-white my-4 border border-gray-500">
        <div class="flex items-center px-8 py-2">
          @if ($comment->thread->is_anonymous)
            <img src="{{ asset('/images/anonymous.jpg') }}" alt="匿名アイコン"
              class="w-16 rounded-full inline-block border-2 border-gray-500">
          @else
            @if ($comment->student->icon_image_filename)
              <img src="{{ asset('/storage/students/icons/' . $comment->student->icon_image_filename) }}"
                class="w-16 rounded-full inline-block border-2 border-primary-button">
            @else
              <img src="{{ asset('/images/default-profile-icon.png') }}"
                class="w-16 rounded-full inline-block border-2 border-primary-button">
            @endif
          @endif
          <div class="text-primary text-normal md:flex">
            @if ($comment->thread->is_anonymous)
              <p class="ml-4 mr-8 text-logout font-semibold text-lg">
                匿名希望さん
              </p>
            @else
              <p class="ml-4 mr-8 text-logout font-semibold text-lg">
                {{ $comment->student->last_name }} {{ $comment->student->first_name }}さん
              </p>
            @endif
            <p class="ml-4 font-semibold text-md md:text-lg">
              {{ $comment->created_at->format('Y年m月d日 H:i:s') }}
              ({{ $comment->created_at->diffForHumans() }})</p>
          </div>
        </div>
        <div class="mb-4 border-b-2 border-separator"></div>
        {{-- Text of Comment --}}
        <div class="px-8 md:px-16 lg:px-32 pb-4">
          {!! nl2br(e($comment->text)) !!}
        </div>
        {{-- Image --}}
        @if ($comment->imageFirst)
          <div class="px-2 md:px-8 md:max-w-2xl pb-4 mx-auto">
            <img src="{{ asset('storage/comments/' . $comment->imageFirst->filename) }}" class="rounded-md">
          </div>
        @endif
      </div>

      <div class="h-2 my-4 border-b-2 border-separator"></div>

      <form
        action="{{ route('student.threads.comments.send-reply', ['thread' => $comment->thread, 'comment' => $comment->id]) }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div id="input-field" class="p-4 bg-white">
          {{-- Validation Errors --}}
          <x-validation-errors />
          <textarea name="text" autofocus
            class="bg-input-field h-40 py-2 w-full border border-gray-500 shadow-inner focus:outline-none block"
            placeholder="コメントへの返信を入力">{{ old('text') }}</textarea>
          <div class="text-center md:flex justify-around items-center my-4">
            <input type="file" id="image" name="image" accept=".jpg,.png">
            <button
              class="bg-primary-button text-primary-button mt-4 py-2 px-4 mx-4 md:mx-8 rounded-xl text-lg font-semibold">返信する</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
