@extends('layout.admin.auth')

@section('title', 'Test title')

@section('content')
  <div class="container__dashboard">
    {{-- Flash message --}}
    @include('components.flash-message')
    <p>Test admin dashboard</p>
  </div>

  @push('scripts')
    @vite('resources/js/components/disableButtonSubmit.js')
  @endpush
@endsection