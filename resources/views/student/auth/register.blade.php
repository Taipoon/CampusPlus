<x-guest-layout>
  <x-auth-card>
    <x-slot name="logo">
      <a href="/">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
      </a>
    </x-slot>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('student.register') }}">
      @csrf

      <!-- Name -->
      <div>
        <div class="flex flex-wrap -m-2">
          <div class="p-2 w-1/2">
            <x-label for="last_name" class="block w-full" :value="__('Last Name')" />
            <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"
              autofocus required />

            <span class="text-sm text-gray-500">(例) 山田</span>
          </div>
          <div class="p-2 w-1/2">
            <x-label for="first_name" class="block w-full" :value="__('First Name')" />
            <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')"
              required />

            <span class="text-sm text-gray-500">(例) 太郎</span>
          </div>
        </div>
      </div>

      <!-- Name Kana -->
      <div class="mt-4">
        <div class="flex flex-wrap -m-2">
          <div class="p-2 w-1/2">
            <x-label for="last_name_kana" class="block w-full" :value="__('Last Name Kana')" />

            <x-input id="last_name_kana" class="block mt-1 w-full" type="text" name="last_name_kana"
              :value="old('last_name_kana')" required />

            <span class="text-sm text-gray-500">(例) ヤマダ</span>
          </div>
          <div class="p-2 w-1/2">
            <x-label for="first_name_kana" class="block w-full" :value="__('First Name Kana')" />

            <x-input id="first_name_kana" class="block mt-1 w-full" type="text" name="first_name_kana"
              :value="old('first_name_kana')" required />
            <span class="text-sm text-gray-500">(例) タロウ</span>
          </div>
        </div>
      </div>

      <!-- Email Address -->
      <div class="mt-4">
        <x-label for="email" :value="__('Email')" />

        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />

        <span class="text-sm text-gray-500">(推奨: 大学用メールアドレス) 学籍番号@kaishi-pu.ac.jp</span>
      </div>

      <!-- Password -->
      <div class="mt-4">
        <x-label for="password" :value="__('Password')" />

        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
          autocomplete="new-password" />

        <span class="text-sm text-gray-500">パスワードは8文字以上である必要があります。</span>
      </div>

      <!-- Confirm Password -->
      <div class="mt-4">
        <x-label for="password_confirmation" :value="__('Confirm Password')" />

        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
          required />
      </div>

      <div class="flex items-center justify-end mt-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('student.login') }}">
          {{ __('Already registered?') }}
        </a>

        <x-button class="ml-4">
          {{ __('Register') }}
        </x-button>
      </div>
    </form>
  </x-auth-card>
</x-guest-layout>
