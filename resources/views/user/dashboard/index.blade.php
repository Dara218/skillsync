@extends('layout.user.auth')

@section('title', 'Dashboard Test')

@section('content')
  <form action="{{ route('user.logout') }}" method="POST">
    @csrf
    <button type="submit">Logout Temp</button>
  </form>
  <div>Test</div>
@endsection