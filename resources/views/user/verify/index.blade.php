@extends('layout.user.auth')

@section('title', 'Verify Test')

@section('content')
  <div class="card">
    <h1 class="title">{{ __('lang.title.user_verify') }}</h1>
    @include('components.flash-message')
    
    <p class="label">{{ __('lang.note.enter_6_digit_verification_code') }}</p>

    <form action="{{ route('user.verify.process') }}" method="POST" class="form">
      @csrf
      <div>
        <label for="code" class="label">{{ __('lang.label.verification_code') }}</label>
        <input type="text" name="code" id="code" class="input" value="{{ old('code') }}">
        @error('code')
          <p class="error">{{ $message }}</p>
        @enderror
      </div>

      <button type="submit" class="button__submit">{{ __('lang.button.verify') }}</button>
    </form>
  </div>

  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection