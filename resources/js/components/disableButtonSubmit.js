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
});