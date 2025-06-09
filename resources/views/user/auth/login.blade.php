@extends('layout.user.guest')

@section('title', __('lang.title.login'))

@section('content')
  <div>
    <h1>{{ __('lang.label.user_login') }}</h1>
    <form action="{{ route('user.login.authenticate') }}" method="POST" id="form">
      @csrf

      <div>
        <label for="email" class="label">{{ __('lang.label.email') }}</label>
        <input type="text" name="email" id="email" class="input" value="{{ old('email') }}">
        @error('email')
          <p>{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password" class="label">{{ __('lang.label.password') }}</label>
        <input type="password" name="password" id="password" class="input">
        @error('password')
          <p>{{ $message }}</p>
        @enderror
      </div>

      @error('error')
        <p>{{ $message }}</p>
      @enderror

      <button type="submit" id="submitBtn" class="button__submit">{{ __('lang.button.login') }}</button>

      <p>{{ __('lang.label.not_a_member') }} <a href="{{ route('user.register.index') }}">{{ __('lang.link.become_a_member') }}</a></p>
    </form>
  </div>
  
  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection