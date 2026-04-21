<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Ticket System')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="icon" type="image/png" href="{{ asset('img/HelpTK--.png') }}">
  <link rel="preload" as="image" href="{{ asset('img/HelpTK-.png') }}">
  <link rel="stylesheet" href="{{ url('css/layout.css') }}">
  @stack('styles')

</head>

<body>

  <div class="mobile-sheet-overlay" id="sheetOverlay"></div>
  <nav class="navbar-pro">
    <div class="container-fluid">
      <a class="brand-wrapper"
        href="{{ Auth::user()->role == 1 ? route('admin.dashboard') : route('user.dashboard') }}">
        <div class="brand-logo-wrap">
          <img src="{{ asset('img/HelpTK-.png') }}" alt="Logo" width="115" height="115">
        </div>
        <div class="brand-divider"></div>
        <span class="brand-title">Support Ticket System</span>
      </a>

      <button class="mobile-toggle" id="navbarToggle" aria-label="Toggle navigation">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
          stroke-linejoin="round">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </button>

      <div class="nav-actions" id="navActions">
        <button class="mobile-close-btn d-lg-none" id="mobileCloseBtn" aria-label="Close Menu">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </button>
        @auth
          <div class="drawer-user-header d-lg-none">
            <div class="drawer-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="drawer-user-info">
              <span class="drawer-username">{{ Auth::user()->name }}</span>
              <span class="drawer-role">{{ Auth::user()->role == 1 ? 'Administrator' : 'User' }}</span>
            </div>
          </div>
        @endauth
        @auth
          @if(Auth::user()->role == 1)
            <!-- Admin Navbar (Minimalist Tabs) -->
            <div class="d-flex align-items-center gap-4 me-3">
              <a href="{{ route('admin.dashboard') }}"
                class="admin-tab {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Dashboard
              </a>
              <a href="{{ route('admin.knowledge-base.index') }}"
                class="admin-tab {{ request()->routeIs('admin.knowledge-base.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                  <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                </svg>
                Knowledge Base
              </a>
              <a href="{{ route('admin.users.index') }}"
                class="admin-tab {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path
                    d="M12 4.354a4 4 0 1 1 0 5.292M15 21H3v-1a6 6 0 0 1 12 0v1zm0 0h6v-1a6 6 0 0 0-9-5.197m13.5-9a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                </svg>
                Users
              </a>
              <a href="{{ route('admin.ranking.index') }}"
                class="admin-tab {{ request()->routeIs('admin.ranking.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M12 20V10M18 20V4M6 20v-4" />
                </svg>
                Ranking
              </a>
            </div>

            <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.15);"></div>

            <form method="POST" action="{{ route('logout') }}" style="margin:0; margin-left: 5px;">
              @csrf
              <button type="submit" class="btn-logout" style="border: none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                  <polyline points="16 17 21 12 16 7" />
                  <line x1="21" y1="12" x2="9" y2="12" />
                </svg> Logout
              </button>
            </form>
          @else
            <!-- User Navbar (Minimalist Tabs) -->
            <div class="d-flex align-items-center gap-4 me-3">
              <a href="{{ route('user.dashboard') }}"
                class="admin-tab {{ request()->routeIs('user.dashboard') || request()->routeIs('tickets.show') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Dashboard
              </a>

              <a href="{{ route('tickets.create') }}"
                class="admin-tab {{ request()->routeIs('tickets.create') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M12 5v14M5 12h14" />
                </svg>
                Create Ticket
              </a>
            </div>

            <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.15);"></div>

            <form method="POST" action="{{ route('logout') }}" style="margin:0; margin-left: 5px;">
              @csrf
              <button type="submit" class="btn-logout" style="border: none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                  <polyline points="16 17 21 12 16 7" />
                  <line x1="21" y1="12" x2="9" y2="12" />
                </svg> Logout
              </button>
            </form>
          @endif
        @else
          @if(Route::has('login') && request()->path() != 'login')
            <a href="{{ route('login') }}" class="btn-create">Login</a>
          @endif
        @endauth
      </div>
    </div>
    <div class="navbar-gold-line"></div>
  </nav>
  <main>
    @yield('content')
  </main>

  <footer class="footer-pro">
    <div class="footer-container">
      <div class="footer-copyright">
        &copy; {{ date('Y') }} <span style="color: #d4af53; font-weight: 500;">HelpTK</span>. All rights reserved.
      </div>
    </div>
  </footer>



  {{-- Global Lightbox Overlay --}}
  <div id="globalLightbox" class="lb-overlay" onclick="closeGlobalLightbox(event)">
    <div class="lb-content">
      <button class="lb-close" onclick="closeGlobalLightbox(event)">&times;</button>
      <img src="" id="globalLbImg" class="lb-img">
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
  <script>
    function openGlobalLightbox(src) {
      const lb = document.getElementById('globalLightbox');
      const img = document.getElementById('globalLbImg');
      img.src = src;
      lb.style.display = 'flex';
      setTimeout(() => lb.classList.add('active'), 10);
      document.body.style.overflow = 'hidden';
    }

    function closeGlobalLightbox(e) {
      if (!e || e.target.classList.contains('lb-overlay') || e.target.classList.contains('lb-close')) {
        const lb = document.getElementById('globalLightbox');
        lb.classList.remove('active');
        setTimeout(() => {
          lb.style.display = 'none';
          document.body.style.overflow = '';
        }, 300);
      }
    }

    document.addEventListener('DOMContentLoaded', function () {
      const toggle = document.getElementById('navbarToggle');
      const menu = document.getElementById('navActions');
      const overlay = document.getElementById('sheetOverlay');
      const closeBtn = document.getElementById('mobileCloseBtn');

      function openSheet() {
        menu.classList.add('active');
        overlay.style.display = 'block';
        setTimeout(() => overlay.classList.add('active'), 10);
      }

      function closeSheet() {
        menu.classList.remove('active');
        overlay.classList.remove('active');
        setTimeout(() => { overlay.style.display = 'none'; overlay.style.pointerEvents = 'none'; }, 320);
      }

      if (toggle && menu) {
        toggle.addEventListener('click', function (e) {
          e.stopPropagation();
          menu.classList.contains('active') ? closeSheet() : openSheet();
        });

        overlay.addEventListener('click', closeSheet);
        if (closeBtn) closeBtn.addEventListener('click', closeSheet);

        const navLinks = menu.querySelectorAll('a');
        navLinks.forEach(link => link.addEventListener('click', closeSheet));
      }
    });
  </script>
</body>

</html>