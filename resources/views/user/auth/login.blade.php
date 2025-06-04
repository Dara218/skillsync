@extends('layout.user.guest')

@section('title', 'Login Page')

@section('content')
  <div>
    <form action="#" method="#" id="form">
      <div>
        <label for="email" class="label">Email</label>
        <input type="email" name="email" id="email" class="input">
      </div>
      <div>
        <label for="password" class="label">Password</label>
        <input type="password" name="password" id="password" class="input">
      </div>
      <button type="submit" id="submitBtn" class="button__submit">Login</button>
    </form>
  </div>
  
  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection