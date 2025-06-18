<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>
    @yield('title', 'Default Auth Title')
  </title>

  @vite('resources/scss/user.scss')
</head>
<body>
  <main class="container">
    @yield('content')
  </main>

  @stack('modals')
  @vite('resources/js/app.js')
  @stack('scripts')
</body>
</html>