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
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@300;400;500&display=swap');

    body {
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background-color: #f8f9fa;
    }

    main {
      flex: 1;
    }

    .navbar-pro {
      background: rgb(55, 55, 55);
      border-bottom: none;
      padding: 0 0;
      font-family: 'DM Sans', sans-serif;
      position: relative;
      z-index: 1000;
    }

    .navbar-gold-line {
      height: 1.5px;
      width: 100%;
      background: linear-gradient(to right, #d4af53 0%, rgba(212, 175, 83, 0.5) 50%, transparent 100%);
    }

    .navbar-pro .container-fluid {
      padding: 0 2rem;
      height: 75px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .brand-wrapper {
      display: flex;
      align-items: center;
      text-decoration: none;
      flex-shrink: 0;
    }

    .brand-logo-wrap {
      width: 70px;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 14px;
    }

    .brand-logo-wrap img {
      width: 115px;
      height: 115px;
      object-fit: contain;
      display: block;
    }

    .brand-divider {
      width: 1px;
      height: 32px;
      background: linear-gradient(to bottom, transparent, rgba(212, 175, 83, 0.3), transparent);
      margin: 0 0.5rem;
    }

    .brand-title {
      font-family: 'Playfair Display', serif;
      font-weight: 600;
      font-size: 1.1rem;
      letter-spacing: 0.02em;
      background: white;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      white-space: nowrap;
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
    }

    .btn-create {
      background: linear-gradient(135deg, #d4af53, #c9972a);
      color: #0a0a0a;
      border: none;
      border-radius: 7px;
      padding: 7px 18px;
      font-family: 'DM Sans', sans-serif;
      font-weight: 500;
      font-size: 0.8rem;
      letter-spacing: 0.04em;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 2px 12px rgba(212, 175, 83, 0.25);
      display: inline-flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
    }

    .btn-create:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 20px rgba(212, 175, 83, 0.4);
      color: #0a0a0a;
    }

    .btn-create svg {
      width: 13px;
      height: 13px;
    }

    .btn-logout {
      background: transparent;
      color: rgba(255, 255, 255, 0.45);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 7px;
      padding: 7px 16px;
      font-family: 'DM Sans', sans-serif;
      font-weight: 400;
      font-size: 0.8rem;
      letter-spacing: 0.04em;
      cursor: pointer;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      white-space: nowrap;
    }

    .btn-logout:hover {
      color: #ff6b6b;
      border-color: rgba(255, 107, 107, 0.35);
      background: rgba(255, 107, 107, 0.06);
    }

    .btn-logout svg {
      width: 13px;
      height: 13px;
    }

    /* Dropdown Styles */
    .nav-dropdown {
      position: relative;
      display: inline-block;
    }

    .nav-dropdown-menu {
      display: none;
      position: absolute;
      top: 100%;
      right: 0;
      margin-top: 10px;
      background: rgb(65, 65, 65);
      min-width: 180px;
      border-radius: 8px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
      border: 1px solid rgba(255, 255, 255, 0.05);
      z-index: 1000;
      padding: 0.5rem 0;
    }

    .nav-dropdown:hover .nav-dropdown-menu {
      display: block;
      animation: fadeInDown 0.2s ease;
    }

    .nav-dropdown-item {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 0.6rem 1.2rem;
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      font-size: 0.85rem;
      font-family: 'DM Sans', sans-serif;
      transition: all 0.2s;
    }

    .nav-dropdown-item:hover {
      background: rgba(212, 175, 83, 0.1);
      color: #d4af53;
    }

    .nav-dropdown-item svg {
      width: 14px;
      height: 14px;
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-5px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Admin Underline Tabs */
    .admin-tab {
      display: flex;
      align-items: center;
      gap: 6px;
      color: rgba(255, 255, 255, 0.65);
      font-family: 'DM Sans', sans-serif;
      font-weight: 500;
      font-size: 0.85rem;
      letter-spacing: 0.02em;
      text-decoration: none;
      padding: 4px 2px;
      border-bottom: 2px solid transparent;
      transition: all 0.2s ease;
    }

    .admin-tab:hover {
      color: #ffffff;
      border-bottom-color: rgba(212, 175, 83, 0.4);
    }

    .admin-tab.active {
      color: #d4af53;
      font-weight: 600;
      border-bottom-color: #d4af53;
    }

    .admin-tab svg {
      width: 14px;
      height: 14px;
    }

    /* Mobile Toggle Button */
    .mobile-toggle {
      display: none;
      background: transparent;
      border: 1px solid rgba(212, 175, 83, 0.3);
      color: #d4af53;
      border-radius: 18px;
      padding: 5px;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .mobile-toggle:hover {
      background: rgba(212, 175, 83, 0.1);
      border-color: #d4af53;
    }

    .mobile-toggle svg {
      width: 24px;
      height: 24px;
    }

    /* Responsive Adjustments */
    @media (max-width: 991px) {
      .mobile-toggle {
        display: block;
      }

      .nav-actions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: rgba(45, 45, 45, 0.98);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        flex-direction: column;
        padding: 1.5rem;
        gap: 12px;
        border-top: 1px solid rgba(212, 175, 83, 0.15);
        transform: translateY(-10px);
        opacity: 0;
        visibility: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
      }

      .nav-actions.active {
        transform: translateY(0);
        opacity: 1;
        visibility: visible;
      }

      .nav-actions form {
        width: 100%;
      }

      .btn-create,
      .btn-logout {
        width: 100%;
        justify-content: center;
        padding: 8px;
        font-size: 0.8rem;
        border-radius: 10px;
      }

      .btn-logout {
        margin-top: 4px;
        background: rgba(255, 255, 255, 0.05);
      }
    }

    @media (max-width: 768px) {
      .navbar-pro .container-fluid {
        padding: 0 1.2rem;
        height: 65px;
      }

      .brand-logo-wrap {
        width: 72px;
        height: 72px;
        margin-right: 12px;
      }

      .brand-logo-wrap img {
        width: 95px;
        height: 95px;
      }

      .brand-title {
        font-size: 0.95rem;
      }

      .brand-divider {
        margin: 0 0.5rem;
      }
    }

    @media (max-width: 480px) {
      .navbar-pro .container-fluid {
        padding: 0 0.8rem;
        height: 60px;
      }

      .brand-logo-wrap {
        width: 58px;
        height: 58px;
        margin-right: 4px;
      }

      .brand-logo-wrap img {
        width: 75px;
        height: 75px;
      }

      .brand-divider,
      .brand-title {
        display: block;
      }

      .brand-title {
        font-size: 0.85rem;
      }

      .brand-divider {
        margin: 0 0.3rem;
      }
    }

    /* Footer Styles */
    .footer-pro {
      background: #f0f0f0;
      color: #777;
      font-family: 'DM Sans', sans-serif;
      padding: 1.5rem 0;
      margin-top: 4rem;
      border-top: 1px solid rgba(212, 175, 83, 0.2);
    }

    .footer-container {
      padding: 0 2rem;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .footer-copyright {
      font-size: 0.82rem;
      font-weight: 400;
      letter-spacing: 0.02em;
    }

    /* Global Lightbox */
    .lb-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.85);
      backdrop-filter: blur(12px);
      z-index: 99999;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      opacity: 0;
      transition: opacity .3s;
    }

    .lb-overlay.active {
      display: flex;
      opacity: 1;
    }

    .lb-content {
      position: relative;
      max-width: 95%;
      max-height: 95%;
      transform: scale(0.9);
      transition: transform .3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .lb-overlay.active .lb-content {
      transform: scale(1);
    }

    .lb-img {
      border-radius: 12px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
      max-width: 100%;
      max-height: 90vh;
      object-fit: contain;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .lb-close {
      position: absolute;
      top: -40px;
      right: 0;
      background: none;
      border: none;
      color: #fff;
      font-size: 2rem;
      cursor: pointer;
      padding: .5rem;
      line-height: 1;
      transition: color .2s;
    }

    .lb-close:hover {
      color: #facc15;
    }

    /* Custom Scrollbar for Responsive Tables */
    .table-responsive {
      scrollbar-width: thin;
      scrollbar-color: rgba(212, 175, 83, 0.4) transparent;
      padding-bottom: 5px;
      /* Space for scrollbar */
    }

    .table-responsive::-webkit-scrollbar {
      height: 6px;
    }

    .table-responsive::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.02);
      border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
      background: rgba(212, 175, 83, 0.35);
      border-radius: 10px;
      border: 1px solid transparent;
      background-clip: content-box;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
      background: rgba(212, 175, 83, 0.6);
      background-clip: content-box;
    }
  </style>
  @stack('styles')
</head>

<body>


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

            </div>

            <a href="{{ route('tickets.create') }}"
              style="display: flex; align-items: center; gap: 6px; background: rgba(212,175,83,0.15); color: #d4af53; border: 1px solid rgba(212,175,83,0.3); padding: 5px 12px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; text-decoration: none; margin-right: 12px; transition: all 0.2s;"
              onmouseover="this.style.background='#d4af53'; this.style.color='#111';"
              onmouseout="this.style.background='rgba(212,175,83,0.15)'; this.style.color='#d4af53';">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                style="width: 14px; height: 14px;">
                <path d="M12 5v14M5 12h14" />
              </svg>
              Create Ticket
            </a>

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

      if (toggle && menu) {
        toggle.addEventListener('click', function (e) {
          e.stopPropagation();
          menu.classList.toggle('active');

          // Toggle icon
          const svg = toggle.querySelector('svg');
          if (menu.classList.contains('active')) {
            svg.innerHTML = '<line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line>';
          } else {
            svg.innerHTML = '<line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line>';
          }
        });
      }
    });
  </script>
</body>

</html>