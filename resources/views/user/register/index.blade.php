@extends('layout.user.guest')

@section('title', __('lang.title.signup'))

@section('content')
  <div class="card">
    <h1 class="title">{{ __('lang.title.signup') }}</h1>
    <form action="{{ route('user.register.store') }}" method="POST" class="form">
      @csrf
      {{-- Name --}}
      <div>
        <label for="name" class="label">
          {{ __('lang.label.full_name') }}
        </label>
        <input
          type="text"
          name="name"
          id="name"
          class="input"
          value="{{ old('name') }}"
        >
        @error('name')
          <p class="error">{{ $message }}</p>
        @enderror
      </div>

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

      <div>
        <label for="username" class="label">
          {{ __('lang.label.username') }}
        </label>
        <input
          type="text"
          name="username"
          id="username"
          class="input"
          value="{{ old('username') }}"
        >
        @error('username')
          <p class="error">{{ $message }}</p>
        @enderror
      </div>

      {{-- Password --}}
      <div>
        <label for="password" class="label">
          {{ __('lang.label.password') }}
        </label>
        <input type="password" name="password" id="password" class="input">
        @error('password')
          <p class="error mb-2">{{ $message }}</p>
        @enderror
        <ul class="list__container">
          <li class="list">{{ __('lang.note.password.8_min_chars') }}</li>
          <li class="list">{{ __('lang.note.password.uppercase') }}</li>
          <li class="list">{{ __('lang.note.password.lowercase') }}</li>
          <li class="list">{{ __('lang.note.password.numbers') }}</li>
          <li class="list">{{ __('lang.note.password.symbols') }}</li>
        </ul>
      </div>

      <div>
        <label for="role" class="label">{{ __('lang.label.role') }}</label>
        <select name="role" id="role" class="input__selectbox">
          @foreach (App\Enums\common\UserRole::cases() as $role)
            <option value="{{ $role }}">{{ $role->toJapanese() }}</option>
          @endforeach
        </select>
        @error('role')
          <p class="error">{{ $message }}</p>
        @enderror
      </div>

      <button type="submit" class="button__submit">
        {{ __('lang.button.register') }}
      </button>
      
      <p class="label__link-wrapper">
        {{ __('lang.label.already_a_member') }}
        <a href="{{ route('user.login.index') }}" class="link">
          {{ __('lang.link.login_here') }}
        </a>
      </p>
    </form>
  </div>

  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection
