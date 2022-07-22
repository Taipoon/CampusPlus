@extends('layouts.app')
@section('title', $thread->title)
@section('content')
  <div class="w-11/12 lg:w-7/12 mx-auto pt-8">
    {{-- Thread Card --}}
    <div class="bg-base">
      {{-- Thread Information --}}
      <div class="mt-12 py-4 md:py-8 px-2 md:px-8">
        <p class="text-primary text-black font-semibold">
          <span class="{{ $tag_color }} text-md font-bold">{{ $tag }}</span>
          @if ($thread->is_anonymous)
            <span>【匿名】</span>
          @endif
          {{ $thread->title }}
          <br>
          @if ($thread->status_id == $status_code['resolved'])
            <p class="font-semibold mt-4">ベストアンサーは<a href="#{{ $thread->best_answer_comment_id }}"
                class="underline text-blue-500 hover:text-blue-700">こちら</a></p>
          @endif
        </p>
        <div class="h-2 my-4 border-b-2 border-separator"></div>
        <div class="flex justify-center md:justify-between items-center">

          <div class="flex justify-around">
            <form action="{{ route('student.threads.registerBookmark', ['thread' => $thread->id]) }}" method="POST">
              @csrf
              <button
                class="bg-primary-button text-primary-button py-2 px-4 mx-4 md:mx-8 rounded-xl text-lg font-semibold">BookMark</button>
            </form>
            <form action="{{ route('student.threads.registerGoodThread', ['thread' => $thread->id]) }}" method="POST">
              @csrf
              <button class="bg-primary-button py-2 px-4 mx-4 md:mx-8 rounded-xl text-lg font-semibold">
                <x-good-thread />
              </button>
            </form>
          </div>
          </form>
          <div class="information md:flex jusitfy-between">
            <div class="hidden md:block text-right">
              <p class="font-semibold">投稿日時：</p>
              <p class="font-semibold">投稿者：</p>
              <p class="font-semibold">カテゴリ：</p>
              <p class="font-semibold">サブカテゴリ：</p>

            </div>
            <div>
              <p>{{ $thread->created_at->format('Y年m月d日 H:i:s') }}</p>
              @if ($thread->is_anonymous)
                <p>匿名希望さん</p>
              @else
                <p>{{ $thread->student->last_name }} {{ $thread->student->first_name }}さん</p>
              @endif
              <p class="hidden md:block">{{ $primary_category->name }}</p>
              <p class="hidden md:block">{{ $secondary_category->name }}</p>
              {{-- Responsive View of Categories --}}
              <p class="md:hidden">{{ $secondary_category->name }} </p>
            </div>
          </div>
        </div>
        <div class="h-2 my-4 border-b-2 border-separator"></div>
        {{-- Comments --}}
        @foreach ($comments as $comment)
          <div class="bg-white my-4 border border-gray-500" id="{{ $comment->id }}">
            <div class="flex items-center px-8 py-2">
              @if ($thread->is_anonymous)
                <img src="{{ asset('/images/anonymous.jpg') }}" alt=""
                  class="w-16 rounded-full inline-block border-2 border-gray-500">
              @else
                @if ($comment->student->icon_image_filename)
                  <a href="{{ route('student.accounts.show', ['student' => $comment->student->id]) }}">
                    <img src="{{ asset('/storage/students/icons/' . $comment->student->icon_image_filename) }}"
                      alt="プロフィールアイコン"
                      class="w-16 h-16 rounded-full inline-block border-2 border-primary-button object-cover">
                  </a>
                @else
                  <img src="{{ asset('images/default-profile-icon.png') }}" alt="プロフィールアイコン"
                    class="w-16 h-16 rounded-full inline-block border-2 border-primary-button">
                @endif
              @endif
              <div class="text-primary text-normal md:flex">
                @if ($thread->is_anonymous)
                  <p class="ml-4 mr-8 text-black font-semibold text-lg">
                    匿名希望さん
                  </p>
                @else
                  <a href="{{ route('student.accounts.show', ['student' => $comment->student->id]) }}">
                    <p class="ml-4 mr-8 text-black font-semibold text-lg hover:text-blue-500 underline">
                      {{ $comment->student->last_name }} {{ $comment->student->first_name }}
                    </p>
                  </a>
                @endif
                <p class="ml-4 font-semibold text-md md:text-lg">
                  {{ $comment->created_at->format('Y年m月d日 H:i:s') }}
                  ({{ $comment->created_at->diffForHumans() }}) <span class="hidden md:inline-block">ID :
                    {{ $comment->id }}</span>
                </p> 
              </div>
            </div>
            <div class="mb-4 border-b-2 border-separator"></div>
            {{-- Text of Comment --}}
            <div class="px-8 md:px-16 lg:px-32 pb-4">
              {{-- Reply To --}}
              @unless($comment->reply_to == 0)
                <p class="text-top-bar font-semibold underline">
                  <a href="#{{ $comment->reply_to }}">
                    >> {{ $comment->reply_to }}
                  </a>
                </p>
              @endunless
              {{-- Contents --}}
              {!! nl2br(e($comment->text)) !!}
            </div>
            {{-- Image --}}
            @if ($comment->imageFirst !== null)
              <div class="px-2 md:px-8 md:max-w-2xl pb-4 mx-auto">
                <img src="{{ asset('storage/comments/' . $comment->imageFirst->filename) }}" class="rounded-md">
              </div>
            @endif
            <div class="w-full flex space-x-4 justify-end items-center text-right pr-4">
              @if (Auth::id() == $thread->student->id && $thread->status_id == $status_code['required'])
                <div>
                  <form
                    action="{{ route('student.threads.comments.bestAnswer', ['thread' => $thread->id, 'comment' => $comment->id]) }}"
                    method="POST">
                    @csrf
                    <button type="submit" class="bg-primary-button text-primary-button mx-8 rounded-lg py-1 px-2">
                      ベストアンサーにする
                    </button>
                  </form>
                </div>
              @endif
              @if ($thread->status_id == $status_code['resolved'] && $thread->best_answer_comment_id == $comment->id)
                <div>
                  <form
                    action="{{ route('student.threads.comments.bestAnswer', ['thread' => $thread->id, 'comment' => $comment->id]) }}"
                    method="POST">
                    @csrf
                    <p type="submit" class="bg-yellow-400 text-secondary-button mx-8 rounded-lg py-1 px-2">
                      ベストアンサー
                    </p>
                  </form>
                </div>
              @endif
              <div>
                <form
                  action="{{ route('student.threads.comments.registerGoodComment', ['thread' => $thread->id, 'comment' => $comment->id]) }}"
                  method="POST">
                  @csrf
                  <div class="flex items-center">
                  <button type="submit">                    
                    <x-good-comment />
                  </button>
                  <p class="mx-2 text-md text-gray-900">{{ $comment->likes->count() }}</p>
                </div>
                </form>    
               
                <a
                  href="{{ route('student.threads.comments.create-reply', ['thread' => $thread->id, 'comment' => $comment->id]) }}">
                  <span class="text-logout underline font-semibold">返信する</span></a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    {{-- Create New Comment --}}
    <div class="bg-base mt-12 py-4 md:py-8 px-2 md:px-8">
      <p class="mb-4 text-primary text-black font-semibold">コメントを投稿する</p>
      <form action="{{ route('student.threads.comments.store', ['thread' => $thread->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div id="input-field" class="p-4 bg-white">
          {{-- Validation Errors --}}
          <x-validation-errors />
          <textarea name="text"
            class="bg-input-field h-40 py-2 w-full border border-gray-500 shadow-inner focus:outline-none block"
            placeholder="コメントを入力">{{ old('text') }}</textarea>
          <span class="text-gray-700 text-sm">最大700文字で入力してください。</span>
          <div class="text-center md:flex justify-around items-center my-4">
            <input type="file" name="image" id="image" accept=".jpg,.png">
            <button type="submit"
              class="bg-primary-button text-primary-button mt-4 py-2 px-4 mx-4 md:mx-8 rounded-xl text-lg font-semibold">コメントする</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
