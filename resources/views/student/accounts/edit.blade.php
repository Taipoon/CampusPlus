@extends('layouts.app')

@section('title', 'マイページ編集')

@section('content')
  <div class="w-11/12 lg:w-1/2 mx-auto pt-8">
    {{-- Thread Card --}}
    <div class="bg-base">
      <div class="mt-8 py-4 md:py-8 px-2 md:px-8">
        <p class="text-primary text-black font-semibold">プロフィール編集</p>
        {{-- Validation Errors --}}
        <x-validation-errors />
        <div class="h-2 my-4 border-b-2 border-separator"></div>
        <div id="input-field" class="p-4 bg-white border border-gray-200">
          <h2 class="text-xl font-semibold">基本情報
            <p class="text-sm text-gray-700">基本情報の編集は<a href="mailto:20120065@kaishi-pu.ac.jp"
                class="text-sm text-blue-500 hover:text-blue-700">管理人</a>にお問い合わせください。</p>
          </h2>
          <div class="h-2 mb-4 border-t-2 border-separator"></div>
          {{-- メールアドレス --}}
          <div class="flex">
            <div class="text-lg w-1/2">登録メールアドレス</div>
            <div class="text-lg w-1/2">
              {{ $student->email }}
            </div>
          </div>
          {{-- 姓 --}}
          <div class="flex mt-4">
            <div class="text-lg w-1/2">姓</div>
            <div class="text-lg w-1/2">
              <ruby>
                {{ $student->last_name }}<rt>{{ $student->last_name_kana }}</rt>
              </ruby>
            </div>
          </div>
          {{-- 名 --}}
          <div class="flex mt-4">
            <div class="text-lg w-1/2">名</div>
            <div class="text-lg w-1/2">
              <ruby>
                {{ $student->first_name }}<rt>{{ $student->first_name_kana }}</rt>
              </ruby>
            </div>
          </div>
          {{-- 学部 --}}
          <div class="flex mt-4">
            <div class="text-lg w-1/2">学部</div>
            <div class="text-lg w-1/2">
              {{ $student->faculty->faculty_name }}
            </div>
          </div>
          {{-- 登録日 --}}
          <div class="flex mt-4">
            <div class="text-lg w-1/2">登録日</div>
            <div class="text-lg w-1/2">
              {{ $student->created_at->format('Y年m月d日') }}
            </div>
          </div>
          <h2 class="text-xl font-semibold mt-12">パスワード変更</h2>
          <div class="h-2 mb-4 border-t-2 border-separator"></div>
          <form action="{{ route('student.accounts.update', ['student' => Auth::id()]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="flex mb-4">
              <label class="text-lg w-1/2 block" for="current_password">現在のパスワード</label>
              <input type="password" class="w-1/2 bg-input-field border border-gray-500 shadow-inner focus:outline-none"
                id="current_password" name="current_password">
            </div>
            <div class="flex mb-4">
              <label class="text-lg w-1/2 block" for="new_password">新しいパスワード</label>
              <input type="password" class="w-1/2 bg-input-field border border-gray-500 shadow-inner focus:outline-none"
                id="new_password" name="new_password">
            </div>
            <div class="flex mb-4">
              <label class="w-1/2 text-lg block" for="new_password_confirmation">新しいパスワード(確認)</label>
              <input type="password" class="w-1/2 bg-input-field border border-gray-500 shadow-inner focus:outline-none"
                id="new_password_confirmation" name="new_password_confirmation">
            </div>
            <h2 class="text-xl font-semibold mt-8">自己紹介<span class="ml-4 text-sm text-gray-700">最大100文字まで。</span></h2>
            <div class="h-2 mb-4 border-t-2 border-separator"></div>
            <textarea name="profile" max="100"
              class="h-36 w-3/4 mx-auto bg-input-field shadow-inner block border border-gray-500 focus:outline-none">{{ old('profile') ?? $student->profile }}</textarea>
            <h2 class="text-xl font-semibold mt-8">プロフィール画像</h2>
            <span class="text-sm text-gray-500">「マイページ」で表示されるプロフィール画像です。16 : 9に自動的にリサイズされます。</span>
            <div class="h-2 mb-4 border-t-2 border-separator"></div>
            <div class="text-center">
              @if ($student->profile_image_filename)
                <img src="{{ asset('/storage/students/profiles/' . $student->profile_image_filename) }}"
                  alt="{{ $student->last_name }}{{ $student->first_name }}さんのプロフィール画像"
                  class="w-2/3 mx-auto rounded-md object-cover border border-gray-500 mb-4">
              @endif
              <input type="file" accept=".jpg,.png" name="profile_image">
            </div>
            <h2 class="text-xl font-semibold mt-8">アイコン画像</h2>
            <span class="text-sm text-gray-500">投稿するコメントのアイコンに使用されます。1 : 1に自動的にリサイズされます。</span>
            <div class="h-2 mb-4 border-t-2 border-separator"></div>
            <div class="text-center">
              @if ($student->icon_image_filename)
                <img src="{{ asset('/storage/students/icons/' . $student->icon_image_filename) }}"
                  alt="{{ $student->last_name }}{{ $student->first_name }}さんのプロフィール画像"
                  class="w-1/2 mx-auto rounded-md object-cover border border-gray-500 mb-4">
              @endif
              <input type="file" accept=".jpg,.png" name="icon_image">
            </div>
            <h2 class="text-xl font-semibold mt-8">WebサイトURL・SNSアカウント・その他</h2>
            <p class="text-sm text-gray-500">あなたのSNSアカウントのトップページURLを登録できます。</p>
            <div class="h-2 mb-4 border-t-2 border-separator"></div>
            <div class="flex mb-4">
              <label class="text-lg w-1/2 block" for="twitter">Twitter URL</label>
              <input type="text" class="w-1/2 bg-input-field border border-gray-500 shadow-inner focus:outline-none"
                value="{{ old('twitter') ?? $student->twitter }}" id="twitter" name="twitter">
            </div>
            <div class="flex mb-4">
              <label class="text-lg w-1/2 block" for="instagram">Instagram URL</label>
              <input type="text" class="w-1/2 bg-input-field border border-gray-500 shadow-inner focus:outline-none"
                value="{{ old('instagram') ?? $student->instagram }}" id="instagram" name="instagram">
            </div>
            <div class="flex mb-4">
              <label class="text-lg w-1/2 block" for="github">GitHub URL</label>
              <input type="text" class="w-1/2 bg-input-field border border-gray-500 shadow-inner focus:outline-none"
                value="{{ old('github') ?? $student->github }}" id="github" name="github">
            </div>
            <div class="flex mb-4">
              <label class="text-lg w-1/2 block" for="youtube">Youtube URL</label>
              <input type="text" class="w-1/2 bg-input-field border border-gray-500 shadow-inner focus:outline-none"
                value="{{ old('youtube') ?? $student->youtube }}" id="youtube" name="youtube">
            </div>
            <div class="flex mb-4">
              <label class="text-lg w-1/2 block" for="url">Web Site URL</label>
              <input type="text" class="w-1/2 bg-input-field border border-gray-500 shadow-inner focus:outline-none"
                value="{{ old('url') ?? $student->url }}" id="url" name="url">
            </div>
            <div class="flex mb-4">
              <label class="text-lg w-1/2 block" for="information">課外活動・事業紹介</label>
              <textarea class="w-1/2 bg-input-field border border-gray-500 shadow-inner focus:outline-none"
                id="information" name="information">{{ old('information') ?? $student->information }}</textarea>
            </div>
            <div class="w-full text-center">
              {{-- Information Save Button --}}
              <button type="submit"
                class="bg-secondary-button text-secondary-button rounded-xl py-4 px-4 font-bold z-50 border border-primary-button my-8 hover:bg-primary-button hover:text-primary-button">
                保存する</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
