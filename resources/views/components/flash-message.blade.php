@if (session('success'))
  <?php
    $message = session()->get('success');
    session()->forget('success');
  ?>
  <div class="flex-center-center">
    <div class="flash-message flash-message--success">
      <p class="flash-message__text">{{ $message }}</p>
      <i class="icon-[mdi--close-thick] flash-message__icon js-hide-flash"></i>
    </div>
  </div>
@endif
@if (session('error'))
  <?php
    $message = session()->get('error');
    session()->forget('error');
  ?>
  <div class="flex-center-center">
    <div class="flash-message flash-message--error">
      <p class="flash-message__text">{{ $message }}</p>
      <i class="icon-[mdi--close-thick] flash-message__icon js-hide-flash"></i>
    </div>
  </div>
@endif
@if (session('warning'))
  <?php
    $message = session()->get('warning');
    session()->forget('warning');
  ?>
  <div class="flex-center-center">
    <div class="flash-message flash-message--warning">
      <p class="flash-message__text">{{ $message }}</p>
      <i class="icon-[mdi--close-thick] flash-message__icon js-hide-flash"></i>
    </div>
  </div>
@endif
