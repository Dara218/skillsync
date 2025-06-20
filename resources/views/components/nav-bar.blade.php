<header class="navbar__container">
  <div class="navbar__wrapper">
    {{-- Logo --}}
    <div class="flex-shrink-0">
      <img src="{{ Vite::asset('resources/images/skillsync_logo.jpeg') }}" alt="SkillSync Logo" class="logo">
    </div>

    {{-- Hamburger (Mobile Only) --}}
    <button id="navToggle" 
        class="hamburger-icon"
        aria-label="Toggle navigation menu"
        aria-expanded="false">
      <div class="hamburger-icon">
        <span class="hamburger-icon__lines__first-layer"></span>
        <span class="hamburger-icon__lines__second-layer"></span>
        <span class="hamburger-icon__lines__second-layer"></span>
      </div>
    </button>

    {{-- Nav Links --}}
    <nav id="navMenu" class="navbar-navMenu hidden md:block">
      <ul class="navbar-navMenu__wrapper">
        @if (Route::is('user.dashboard'))
          <li>
            <a href="{{ route('user.jobs.index') }}" class="navbar-navMenu__item">
              <i class="fas fa-briefcase"></i> 
              {{ __('lang.link.browse_all_jobs') }}
            </a>
          </li>
        @endif

        @if (Route::is('user.jobs.index'))
          <li>
            <a href="{{ route('user.dashboard') }}" class="navbar-navMenu__item">
              <i class="fas fa-tachometer-alt"></i> 
              {{ __('lang.link.dashboard') }}
            </a>
          </li>
        @endif

        <li>
          <a href="#" class="navbar-navMenu__item">
            <i class="fas fa-user-edit"></i> 
            {{ __('lang.link.update_profile') }}
          </a>
        </li>
        
        <li>
          <a href="#" class="navbar-navMenu__item">
            <i class="fas fa-folder-open"></i> 
            {{ __('lang.link.my_applications') }}
          </a>
        </li>
        
        <li class="md:border-l md:border-gray-200 md:pl-4 md:ml-2">
          <form action="{{ route('user.logout') }}" method="POST">
            @csrf
            <button type="submit" class="navbar-navMenu__item__logout">
              <i class="fas fa-sign-out-alt"></i> 
              {{ __('lang.link.logout') }}
            </button>
          </form>
        </li>
      </ul>
    </nav>
  </div>
</header>