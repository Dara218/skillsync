@extends('layout.user.auth')

@section('title', 'Verify Test')

@section('content')
  @include('components.flash-message')
  <h1>User Verify Test</h1>

  <form action="{{ route('user.logout') }}" method="POST">
    @csrf
    <button type="submit">Logout Temp</button>
  </form>
  
  <form action="{{ route('user.verify.process') }}" method="POST" id="form">
    @csrf
    <div>
      <label for="code" class="label">Code</label>
      <input type="text" name="code" id="code" class="input" value="{{ old('code') }}">
      @error('code')
        <p>{{ $message }}</p>
      @enderror
    </div>

    <button type="submit" class="button__submit" id="submitBtn">Verify</button>
  </form>
  
  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection