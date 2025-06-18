import $ from 'jquery';

$(() => {
  const submitbtn = $('#submitBtn');
  const form = $('#form');

  if (submitbtn && form) {
    form.on('submit', function () {
      submitbtn.prop('disabled', true)
        .addClass('button--disabled');
    });
  }

  toggleResumeSubmit();
});

/**
 * Disable the submit button of upload resume if no file is selected.
 */
function toggleResumeSubmit()
{
    const submitBtn = $('#submitBtn');
    const fileInput = $('#resumeInput');

    if (submitBtn.length && fileInput.length) {
        // Disable button on submit
        submitBtn.prop('disabled', true)
          .addClass('button--disabled');
    }

    // Monitor file input changes
    fileInput.on('change', function () {
      if (this.files.length > 0) {
        submitBtn.prop('disabled', false)
          .removeClass('button--disabled');
      } else {
        submitBtn.prop('disabled', true)
          .addClass('button--disabled');
      }
    });
}