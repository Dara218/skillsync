@extends('layout.user.guest')

@section('title', __('lang.title.user_registration'))

@section('content')
<div>
  <form action="{{ route('user.register.store') }}" method="POST">
    @csrf
    <h1>{{ __('lang.label.user_registration') }}</h1>

    <div>
      <label for="name" class="label">{{ __('lang.label.full_name') }}</label>
      <input type="text" name="name" id="name" class="input">
      @error('name')
        <p>{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="email" class="label">{{ __('lang.label.email') }}</label>
      <input type="text" name="email" id="email" class="input">
      @error('email')
        <p>{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="password" class="label">{{ __('lang.label.password') }}</label>
      <input type="password" name="password" id="password" class="input">
      <div>
        Is at least 8 characters long (or more, e.g., 12)
        Includes uppercase letters
        Includes lowercase letters
        Includes numbers
        Includes symbols
        Does not contain whitespace
      </div>
      @error('password')
        <p>{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="role" class="label">{{ __('lang.label.role') }}</label>
      <select name="role" id="role">
        @foreach (App\Enums\common\UserRole::cases() as $role)
          <option value="{{ $role }}">{{ $role->toJapanese() }}</option>
        @endforeach
      </select>
      @error('role')
        <p>{{ $message }}</p>
      @enderror
    </div>
    
    <button type="submit">{{ __('lang.button.register') }}</button>
  </form>
</div>
@endsection