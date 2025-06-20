@extends('layout.user.auth')

@section('title', __('lang.title.jobs'))

@section('content')
  <div class="container__jobs">
    {{-- Search Bar --}}
    <div class="container__search">
      <input
        type="text"
        placeholder="{{ __('lang.placeholder.search_for_jobs') }}"
        class="input"
      />
      <button class="button__light w-full sm:w-auto">
        {{ __('lang.button.search') }}
      </button>
    </div>

    {{-- Job Listings --}}
    @forelse ($jobs as $job)
      <div class="container__job-list">
        {{-- Thumbnail --}}
        <div class="thumbnail"></div>

        {{-- Todo: Add fake company logo  --}}

        {{-- Job Info --}}
        <div class="flex-1">
          <h2 class="text-lg font-bold">{{ $job->title }}</h2>
          <p class="text-gray-700">{{ $job->company->name }}</p>
          <p class="text-gray-500 text-sm">{{ $job->type->toJapanese() }}</p>
          <p class="text-gray-500 text-sm">{{ $job->salary_range }}</p>
          <p class="text-gray-600 mt-1 text-sm">{{ $job->description }}</p>
        </div>

        {{-- View Button --}}
        <div class="text-right">
          <button class="button__lg transition w-full sm:w-auto">
            {{ __('lang.button.view') }}
        </button>
        </div>
      </div>
    @empty
      <p class="text-center">{{ __('lang.label.no_info') }}</p>
    @endforelse
  </div>

  @push('scripts')
    @vite([
        'resources/js/components/disableButtonSubmit.js',
        'resources/js/components/toggleNavBar.js',
    ])
  @endpush
@endsection
