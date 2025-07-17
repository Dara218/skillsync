@extends('layout.user.auth')

@section('title', __('lang.title.update_password'))

@section('content')
  <div class="card">
    <h1 class="title">{{ __('lang.title.update_password') }}</h1>
    @include('components.flash-message')

    <form action="{{ route('user.update.password.update') }}" method="POST" class="form">
      @csrf
      @method('PUT')
        <div>
          <label for="current_password" class="label">
            {{ __('lang.label.current_password') }}
          </label>
          <input
            type="password"
            name="current_password"
            id="current_password"
            class="input"
          >
          @error('current_password')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="password" class="label">
            {{ __('lang.label.new_password') }}
          </label>
          <input
            type="password"
            name="password"
            id="password"
            class="input"
          >
          @error('password')
            <p class="error">{{ $message }}</p>
          @enderror
          <ul class="list__container mt-2">
            <li class="list">{{ __('lang.note.password.8_min_chars') }}</li>
            <li class="list">{{ __('lang.note.password.uppercase') }}</li>
            <li class="list">{{ __('lang.note.password.lowercase') }}</li>
            <li class="list">{{ __('lang.note.password.numbers') }}</li>
            <li class="list">{{ __('lang.note.password.symbols') }}</li>
          </ul>
        </div>
        <div>
          <label for="password_confirmation" class="label">
            {{ __('lang.label.confirm_password') }}
          </label>
          <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="input"
          >
          @error('password_confirmation')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" class="button__submit">
          {{ __('lang.button.update') }}
        </button>
    </form>
  </div>

  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection