@extends('layout.user.guest')

@section('title', __('lang.title.user_registration'))

@section('content')
  <div>
    <form action="{{ route('user.register.store') }}" method="POST" id="form">
      @csrf
      <h1>{{ __('lang.label.user_registration') }}</h1>

      <div>
        <label for="name" class="label">{{ __('lang.label.full_name') }}</label>
        <input type="text" name="name" id="name" class="input" value="{{ old('name') }}">
        @error('name')
          <p>{{ $message }}</p>
        @enderror
      </div>

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
        <ul>
          <li>Is at least 8 characters long (or more, e.g., 12)</li>
          <li>Includes uppercase letters</li>
          <li>Includes lowercase letters</li>
          <li>Includes numbers</li>
          <li>Includes symbols</li>
          <li>Does not contain whitespace</li>
        </ul>
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

      <button type="submit" class="button__submit" id="submitBtn">{{ __('lang.button.register') }}</button>
    </form>
  </div>

  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection