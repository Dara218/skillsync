@extends('layout.admin.guest')

@section('title', __('lang.title.admin_login'))

@section('content')
  <div class="card">
    <h1 class="title">{{ __('lang.title.admin_login') }}</h1>
    <form action="{{ route('admin.login.authenticate') }}" method="POST" class="form">
      @csrf
      {{-- Email --}}
      <div>
        <label for="email" class="label">
          {{ __('lang.label.email') }}
        </label>
        <input
          type="text"
          name="email"
          id="email"
          class="input"
          value="{{ old('email') }}"
        >
        @error('email')
          <p class="error">{{ $message }}</p>
        @enderror
      </div>

      {{-- Password --}}
      <div>
        <label for="password" class="label">
          {{ __('lang.label.password') }}
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
      </div>

      {{-- Login Error --}}
      @error('error')
        <p class="error text-center">{{ $message }}</p>
      @enderror

      {{-- Submit Button --}}
      <div>
        <button type="submit" class="button__submit">
          {{ __('lang.button.login') }}
        </button>
      </div>
    </form>
  </div>

  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection
