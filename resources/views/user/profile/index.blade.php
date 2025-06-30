@extends('layout.user.auth')

@section('title', 'Sydney')

@section('content')
  <div class="container__dashboard">
    {{-- Flash message --}}
    @include('components.flash-message')

    <div class="card__dashboard-container">
      {{-- Resume Section --}}
      <div class="card__resume sm:col-span-2">
        @if ($user->resume_path)
          <div class="card__resume__container">
            <div class="check-container">✓</div>
            <span class="label__sm-semi-bold">
              {{ __('lang.label.resume_uploaded') }}
            </span>
          </div>

          <div class="flex_col_layout sm:flex-row gap-2">
            <button class="button__light">
                {{ $user->resumeFileName }}
            </button>
            {{-- Delete Resume --}}
            <form action="{{ route('user.resume.delete') }}" method="POST">
              @csrf
              @method('PUT')
              <button class="button__light label__sm-semi-bold bg-red-100 w-full sm:w-auto">
                {{ __('lang.button.delete') }}
              </button>
            </form>
          </div>
        @else
          <div class="card__resume__container">
            <div class="ballot-container">✘</div>
            <span class="label__sm-semi-bold">
              {{ __('lang.label.no_uploaded_resume') }}
            </span>
          </div>

          <div class="flex flex-row gap-2">
            <form action="{{ route('user.resume.upload') }}"
              method="POST"
              class="resume-form fgap-2"
              enctype="multipart/form-data"
            >
              @csrf
              @method('PUT')
              <input
                type="file"
                name="resume_path"
                accept=".pdf"
                id="resumeInput"
                class="button__light w-full sm:w-auto"
              >
              @error('resume_path')
                <p class="error">{{ $message }}</p>
              @enderror
              <button type="submit" class="button__light w-full sm:w-auto mt-2 sm:mt-0">
                {{ __('lang.button.upload') }}
              </button>
            </form>
          </div>
        @endif
      </div>

      {{-- Left Column: Personal Details --}}
      <div class="card__dashboard-wrapper flex_col_layout">
        <h2 class="label__lg-bold">{{ __('lang.label.personal_details') }}</h2>
        <form 
          action="{{ route('user.profile.update', ['id' => $user->id]) }}"
          method="POST"
          class="form flex_col_layout gap-3"
        >
          @csrf
          @method('PUT')
          <div>
            <label for="name" class="label">
              {{ __('lang.label.full_name') }}
            </label>
            <input
              type="text"
              name="name"
              id="name"
              class="input"
              value="{{ old('name', $user->name) }}"
            >
            @error('name')
              <p class="error">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="email" class="label">
              {{ __('lang.label.email') }}
            </label>
            <div class="input button--disabled">
                {{ $user->email }}
            </div>
            {{-- <input
              type="text"
              name="email"
              id="email"
              class="input"
              value="{{ old('email', $user->email) }}"
            >
            @error('email')
              <p class="error">{{ $message }}</p>
            @enderror --}}
          </div>
          <div>
            <label for="address" class="label">
              {{ __('lang.label.address') }}
            </label>
            <input
              type="text"
              name="address"
              id="address"
              class="input"
              value="{{ old('address', $user->address) }}"
            >
            @error('address')
              <p class="error">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="tel" class="label">
              {{ __('lang.label.contact_number') }}
            </label>
            <input
              type="text"
              name="tel"
              id="tel"
              class="input"
              value="{{ old('tel', $user->tel) }}"
            >
            @error('tel')
              <p class="error">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="birth_date" class="label">
              {{ __('lang.label.birth_date') }}
            </label>
            <input
              type="date"
              name="birth_date"
              id="birth_date"
              class="input"
              value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
            >
            @error('birth_date')
              <p class="error">{{ $message }}</p>
            @enderror
          </div>

          <button type="submit" class="button__submit">
            {{ __('lang.button.update') }}
          </button>
        </form>
      </div>

      {{-- Right Column: Profile + Password --}}
      <div class="flex_col_layout gap-4">
        <div class="card__dashboard-wrapper">
          <h2 class="label__lg-bold">{{ __('lang.label.update_profile_photo') }}</h2>
          <div class="flex_col_layout items-center">
            <img src="https://i.redd.it/fcnh4ty49i791.png" alt="{{ $user->name }}" class="profile_photo mb-2">
            <form action="#"
              method="POST"
              class="resume-form fgap-2 mt-2 sm:flex justify-center gap-2"
              enctype="multipart/form-data"
            >
              @csrf
              @method('PUT')
              <input
                type="file"
                name="profile_picture_path"
                class="button__light w-full sm:w-auto"
              >
              @error('profile_picture_path')
                <p class="error">{{ $message }}</p>
              @enderror

              <button type="submit" class="button__light w-full sm:w-auto mt-2 sm:mt-0">
                {{ __('lang.button.upload') }}
              </button>
            </form>
          </div>
        </div>

        <div class="card__dashboard-wrapper">
          <div class="form flex_col_layout">
            <a href="#" class="button__lg w-full">
              {{ __('lang.button.update_email_address') }}
            </a>
            <a href="#" class="button__lg w-full">
              {{ __('lang.button.updated_password') }}
            </a>
            <a href="#" class="button__lg w-full text-red-800">
              {{ __('lang.button.delete_account') }}
            </a>
            {{-- <div>
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
            </div> --}}

            {{-- <button type="submit" class="button__submit">
              {{ __('lang.button.update') }}
            </button> --}}
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    @vite([
        'resources/js/components/disableButtonSubmit.js',
        'resources/js/components/toggleNavBar.js',
    ])
  @endpush
@endsection