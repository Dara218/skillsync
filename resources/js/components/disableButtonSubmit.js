import $ from 'jquery';

$(() => {
  // Loop through all forms on the page
  $('form').each(function () {
    const $form = $(this);
    const $submitBtn = $form.find('button[type="submit"]');
    const $fileInput = $form.find('input[type="file"]');

    // If the form has a file input, disable the submit button initially
    if ($fileInput.length > 0) {
      $submitBtn.prop('disabled', true).addClass('button--disabled');

      $fileInput.on('change', function () {
        if (this.files.length > 0) {
          $submitBtn.prop('disabled', false).removeClass('button--disabled');
        } else {
          $submitBtn.prop('disabled', true).addClass('button--disabled');
        }
      });
    }

    // On form submit, always disable the submit button to prevent double submission
    $form.on('submit', function () {
      $submitBtn.prop('disabled', true).addClass('button--disabled');
    });
  });
});
