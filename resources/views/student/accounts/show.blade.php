@extends('layouts.app')

@section('title', $student->last_name . ' ' . $student->first_name . 'さんのマイページ')

@section('content')
  <div class="w-11/12 md:w-8/12 mx-auto">
    <div class="lg:flex items-top mt-12 py-8">
      <div class="lg:w-1/2">
        @if ($student->profile_image_filename)
          <img src="{{ asset('storage/students/profiles/' . $student->profile_image_filename) }}"
            alt="{{ $student->last_name }}{{ $student->first_name }}さんのプロフィール画像">
        @else
          <img src="{{ asset('/images/no-image.jpg') }}" alt="プロフィール画像がありません。">
        @endif
        <div class="mt-8 flex space-x-12 items-center">
          <button
            class="font-semibold py-1 px-2 inline-block bg-primary-button text-primary-button rounded-lg hover:bg-secondary-button hover:text-secondary-button border border-primary-button transition-all"
            onclick="location.href='{{ route('student.threads', ['student' => $student->id]) }}'">スレッド一覧</button>
          @if ($student->id == Auth::id())
            <button
              class="font-semibold py-1 px-2 inline-block bg-primary-button text-primary-button rounded-lg hover:bg-secondary-button hover:text-secondary-button border border-primary-button transition-all"
              onclick="location.href='{{ route('student.comments', ['student' => $student->id]) }}'">コメント一覧</button>
          @endif
        </div>
      </div>

      <div class="lg:w-1/2 lg-4">
        <div class="text-xl font-semibold">
          <div class="w-full pl-8">
            <span class="{{ $faculty_bg_color }} my-4 py-1 px-2 rounded-md text-white inline-block">
              {{ $student->faculty->faculty_name }}</span>
            @if ($student->id === Auth::id())
              <a href="{{ route('student.accounts.edit', ['student' => $student->id]) }}"
                class="pl-8 text-sm text-gray-500 hover:text-gray-800 underline">プロフィールを編集する</a>
            <a href="{{ route('student.notification', ['student' => Auth::id()]) }}"
              class="text-sm text-gray-500 hover:text-gray-800 underline">通知</a>
            <a href="{{ route('student.showToken', ['student' => $student->id]) }}"
              class="text-sm text-gray-500 hover:text-gray-800 underline">APIの利用</a>
            @endif
          </div>
          <div class="w-full pl-12 text-3xl mt-4 mb-2">
            <ruby>{{ $student->last_name }}<rt>{{ $student->last_name_kana }}</rt> {{ $student->first_name }}<rt>
                {{ $student->first_name_kana }}</rt></ruby>
            <span class="text-primary ml-4">{{ $student->email }}</span>
          </div>
          {{-- Profile --}}
          <div class="w-3/4 rounded-lg pl-12 text-normal mb-8">
            {{ $student->profile }}
          </div>
          <div class="w-full">
            <div class="">
              <div class="w-10/12 mx-auto flex flex-col space-y-4">
                <div class="flex space-x-4">
                  @if ($student->twitter)
                    <div class="w-12">
                      <a href="{{ $student->twitter }}" target="_blank">
                        <x-sns.twitter />
                      </a>
                    </div>
                  @endif
                  @if ($student->instagram)
                    <div class="w-12">
                      <a href="{{ $student->instagram }}" target="_blank">
                        <x-sns.instagram />
                      </a>
                    </div>
                  @endif
                  @if ($student->github)
                    <div class="w-12">
                      <a href="{{ $student->github }}" target="_blank">
                        <x-sns.github />
                      </a>
                    </div>
                  @endif
                  @if ($student->youtube)
                    <div class="w-12">
                      <a href="{{ $student->youtube }}" target="_blank">
                        <x-sns.youtube />
                      </a>
                    </div>
                  @endif
                  @if ($student->url)
                    <div class="w-12">
                      <a href="{{ $student->url }}" target="_blank">
                        <x-sns.url />
                      </a>
                    </div>
                  @endif
                </div>
                <div>
                  <div class="w-full mt-8">課外活動・事業内容・その他</div>
                  <div class="w-full mt-4">
                    @if ($student->information)
                      <p class="text-normal pl-8">{{ $student->information }}</p>
                    @else
                      <p class="text-gray-700 text-sm pl-8">データが登録されていません。</p>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
