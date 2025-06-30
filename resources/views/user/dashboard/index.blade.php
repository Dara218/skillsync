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
    {{-- Flash message --}}
    @include('components.flash-message')

    <div class="card__dashboard-container">
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
    @vite([
        'resources/js/components/disableButtonSubmit.js',
        'resources/js/components/toggleNavBar.js',
    ])
  @endpush
@endsection
