@extends('layout.user.auth')

@section('title', __('lang.title.dashboard'))

@php
  $isJaLocale = app()->getLocale() === 'ja';
@endphp

@section('content')
  <div class="container__dashboard">
    {{-- Central width wrapper --}}
    <div class="card__dashboard-container">
      {{-- Flash message --}}
      @include('components.flash-message')
      {{-- Welcome message --}}
      <div class="title__dashboard col-span-2">
        <div class="flex justify-between">
          <h1 class="title__md">
            {{ __('lang.note.dashboard_welcome', ['name' => $user->name]) }}
          </h1>
          <div>Logout</div>
        </div>
      </div>

      {{-- Resume Section --}}
      <div class="card__resume col-span-2">
        @if ($user->resume_path)
          <div class="card__resume__container">
            <div class="check-container">✓</div>
            <span class="label__sm-semi-bold">{{ __('lang.label.resume_uploaded') }}</span>
          </div>
          <div class="flex gap-2">
            <button class="button__light">{{ $user->resumeFileName }}</button>
            <form action="{{ route('user.resume.delete') }}" method="POST">
              @csrf
              @method('PUT')
              <button class="button__light label__sm-semi-bold bg-red-100">{{ __('lang.button.delete') }}</button>
            </form>
          </div>
        @else
          <div class="card__resume__container">
            <div class="ballot-container">✘</div>
            <span class="label__sm-semi-bold">{{ __('lang.label.no_uploaded_resume') }}</span>
          </div>
          <div class="flex flex-row gap-2">
            <form action="{{ route('user.resume.upload') }}" method="POST" class="resume-form" id="form" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <input type="file" name="resume_path" accept=".pdf" id="resumeInput" class="button__light">
              @error('resume_path')
                <p class="error">{{ $message }}</p>
              @enderror
              <button type="submit" class="button__light" id="submitBtn">{{ __('lang.button.upload') }}</button>
            </form>
          </div>
        @endif
      </div>

      {{-- Bottom Nav Buttons --}}
      <div class="container__dashboard__botton-nav">
        <a href="#" class="button__lg label__sm-semi-bold">{{ __('lang.button.browse_all_jobs') }}</a>
        <a href="#" class="button__lg label__sm-semi-bold">{{ __('lang.button.update_profile') }}</a>
        <a href="#" class="button__lg label__sm-semi-bold">{{ __('lang.button.my_applications') }}</a>
      </div>

      {{-- Suggested Jobs --}}
      <div class="card__dashboard-wrapper">
        <h2 class="label__lg-bold">{{ __('lang.label.suggested_jobs') }}</h2>
        <ul class="space-y-3">
          @forelse ($suggestedJobs as $suggestedJob)
            <li class="list__card">
              <div class="list__card-wrapper">
                <div class="list__item"></div>
                <div class="text-sm">
                  <p class="font-medium">{{ $suggestedJob->title }}</p>
                  <p class="label__light-sm">{{ $suggestedJob->description }}</p>
                </div>
              </div>
              <button class="{{ $isJaLocale ? 'flex-shrink-0' : '' }} button__light">{{ __('lang.button.apply') }}</button>
            </li>
          @empty
            <li class="list__card">
              <div class="list__card-wrapper">
                <div class="list__item"></div>
                <div class="text-sm">
                  <p class="font-medium">No data.</p>
                  <p class="label__light-sm">No description.</p>
                </div>
              </div>
            </li>
          @endforelse
        </ul>
      </div>

      {{-- My Applications --}}
      <div class="card__dashboard-wrapper">
        <h2 class="label__lg-bold">{{ __('lang.label.my_applications') }}</h2>
        <ul class="space-y-3">
          @forelse ($recentApplications as $recentApplication)
            <li class="list__card">
              <div class="list__card-wrapper">
                <div class="list__item"></div>
                <div class="text-sm">
                  <p class="font-medium">{{ $recentApplication->job->title }}</p>
                  <p class="label__light-sm">
                    {{ __('lang.label.date_applied') }}: {{ $recentApplication->appliedDate }}
                  </p>
                </div>
              </div>
              <span class="button__disabled-light">{{ $recentApplication->status->toJapanese() }}</span>
            </li>
          @empty
            <li class="list__card">
              <div class="list__card-wrapper">
                <div class="list__item"></div>
                <div class="text-sm">
                  <p class="font-medium">No data.</p>
                  <p class="label__light-sm">No description.</p>
                </div>
              </div>
            </li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>

  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection
