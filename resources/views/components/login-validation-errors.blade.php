@props(['errors'])

@if ($errors->any())
  <div {{ $attributes }}>
    <div class="font-semibold text-validation-error text-sm">
      {{ __('email or password is uncorrect') }}
    </div>
  </div>
@endif
