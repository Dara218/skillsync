@extends('layout.user.auth')

@section('title', __('lang.title.dashboard'))

@php
  use App\Enums\common\ApplicationStatus;

  $isJaLocale = app()->getLocale() === 'ja';
  $statusBgColor = [
    ApplicationStatus::PENDING->value => 'bg-gray-200',
    ApplicationStatus::REVIEWED->value => 'bg-blue-200',
    ApplicationStatus::ACCEPTED->value => 'bg-green-200',
    ApplicationStatus::REJECTED->value => 'bg-red-200',
  ];
@endphp

@section('content')
  <div class="container__dashboard">
    <div class="card__dashboard-container">
      {{-- Flash message --}}
      @include('components.flash-message')

      {{-- Resume Section --}}
      <div class="card__resume col-span-2">
        @if ($user->resume_path)
          <div class="card__resume__container">
            <div class="check-container">✓</div>
            <span class="label__sm-semi-bold">
              {{ __('lang.label.resume_uploaded') }}
            </span>
          </div>

          <div class="flex flex-col sm:flex-row gap-2">
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
              class="resume-form"
              id="form"
              enctype="multipart/form-data"
            >
              @csrf
              @method('PUT')
              <input
                type="file"
                name="resume_path"
                accept=".pdf"
                id="resumeInput"
                class="button__light"
              >
              @error('resume_path')
                <p class="error">{{ $message }}</p>
              @enderror
              <button type="submit" class="button__light" id="submitBtn">
                {{ __('lang.button.upload') }}
              </button>
            </form>
          </div>
        @endif
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
              <span class="button__default {{ $statusBgColor[$recentApplication->status->value] ?? '' }}">
                {{ $recentApplication->status->toJapanese() }}
              </span>
            </li>
          @empty
            <div class="text-center">
              <p class="font-medium">{{ __('lang.label.no_info') }}</p>
              <p class="label__light-sm">{{ __('lang.label.no_description') }}</p>
            </div>
          @endforelse
        </ul>
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
              <button class="{{ $isJaLocale ? 'flex-shrink-0' : '' }} button__light ml-2">
                {{ __('lang.button.apply') }}
              </button>
            </li>
          @empty
            <div class="text-center">
              <p class="font-medium">{{ __('lang.label.no_info') }}</p>
              <p class="label__light-sm">{{ __('lang.label.no_description') }}</p>
            </div>
          @endforelse
        </ul>
      </div>
    </div>
  </div>

  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection
