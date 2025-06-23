@extends('layout.user.guest')

@section('title', __('lang.title.error', ['PAGE_TITLE' => $statusCode]))

@section('content')
  <section class="container__error-page">
    <div class="max-w-md w-full">
      <h1 class="label__lg-bold">{{ $statusCode }} | {{ $title }}</h1>
      <p class="mt-4 text-md text-gray-600">
        {{ $message ?? __('lang.content.not_found') }}
      </p>

      <div class="mt-8">
        <a href="{{ $errorRedirectRoute }}" class="button__default">
          {{ __('lang.button.go_back') }}
        </a>
      </div>
    </div>
  </section>
@endsection
