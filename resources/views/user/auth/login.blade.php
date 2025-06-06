@extends('layout.user.guest')

@section('title', 'Login Page')

@section('content')
  <div>
    <form action="{{ route('user.login.authenticate') }}" method="POST" id="form">
      @csrf

      <div>
        <label for="email" class="label">Email</label>
        <input type="text" name="email" id="email" class="input" value="{{ old('email') }}">
        @error('email')
          <p>{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password" class="label">Password</label>
        <input type="password" name="password" id="password" class="input">
        @error('password')
          <p>{{ $message }}</p>
        @enderror
      </div>

      @error('error')
        <p>{{ $message }}</p>
      @enderror

      <button type="submit" id="submitBtn" class="button__submit">Login</button>
    </form>
  </div>
  
  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection