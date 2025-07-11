@extends('layout.user.auth')

@section('title', __('lang.title.update_email'))

@section('content')
  <div class="card">
    <h1 class="title">{{ __('lang.title.update_email') }}</h1>
    @include('components.flash-message')

    <p class="label">{{ __('lang.note.link_will_be_sent_to_the_email') }}</p>

    <form action="{{ route('user.profile.update.send-email') }}" method="POST" class="form">
      @csrf
      {{-- <div>
        <div>
          <label for="name" class="label">
            Current Password
          </label>
          <input
            type="text"
            name="name"
            id=""
            class="input"
          >
          @error('')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="email" class="label">
            New Password
          </label>
          <input
            type="text"
            name=""
            id="email"
            class="input"
          >
          @error('')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label for="email" class="label">
            Confirm Password
          </label>
          <input
            type="text"
            name=""
            id="email"
            class="input"
          >
          @error('')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>
      </div> --}}
        <div>
          <label for="email" class="label">
            New Email Address
          </label>
          <input
            type="text"
            name="email"
            id="email"
            class="input"
            value="{{ old('email') }}"
          >
        </div>
        
        @error('email')
          <p class="error">{{ $message }}</p>
        @enderror
      <button type="submit" class="button__submit">{{ __('lang.button.send') }}</button>
    </form>
  </div>

  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection