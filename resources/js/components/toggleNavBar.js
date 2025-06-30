import $ from 'jquery';

$(() => {
  const $toggleBtn = $('#navToggle');
  const $navMenu = $('#navMenu');
  const $hamburgerIcon = $('.hamburger-icon');

  // Toggle mobile menu
  $toggleBtn.on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();

    const isExpanded = $(this).attr('aria-expanded') === 'true';

    if (!isExpanded) {
      // Unhide immediately
      $navMenu.removeClass('hidden');

      setTimeout(() => {
        // Triggers transition
        $navMenu.addClass('show');
      }, 10);
    } else {
      // Start transition
      $navMenu.removeClass('show');

      setTimeout(() => {
        // Fully hide after animation
        $navMenu.addClass('hidden');
      }, 300);
    }

    $hamburgerIcon.toggleClass('active');

    $(this).attr('aria-expanded', !isExpanded);

    if (!isExpanded) {
      $('body').addClass('overflow-hidden md:overflow-visible');
    } else {
      $('body').removeClass('overflow-hidden');
    }
  });

  // Close menu when clicking outside
  $(document).on('click', function(e) {
    if (
        !$toggleBtn.is(e.target)
        && !$navMenu.is(e.target)
        && $navMenu.has(e.target).length === 0
    ) {
      if ($navMenu.hasClass('show')) {
        $navMenu.removeClass('show');
        $hamburgerIcon.removeClass('active');

        $toggleBtn.attr('aria-expanded', 'false');

        $('body').removeClass('overflow-hidden');
      }
    }
  });
  
  // Close menu when pressing Escape key
  $(document).on('keydown', function(e) {
    if (e.key === 'Escape' && $navMenu.hasClass('show')) {
      $navMenu.removeClass('show');
      $hamburgerIcon.removeClass('active');

      $toggleBtn.attr('aria-expanded', 'false');

      $('body').removeClass('overflow-hidden');
      
      // Return focus to toggle button
      $toggleBtn.focus();
    }
  });

  // Close menu when window is resized to desktop size
  $(window).on('resize', function() {
    if ($(window).width() >= 768) { // md breakpoint
      $navMenu.removeClass('show');

      $hamburgerIcon.removeClass('active');

      $toggleBtn.attr('aria-expanded', 'false');

      $('body').removeClass('overflow-hidden');
    }
  });
});