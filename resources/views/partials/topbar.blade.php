<header class="app-topbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn-icon-circular d-md-none" data-toggle="sidebar" aria-label="Buka menu">
            <i class="bi bi-list"></i>
        </button>
        <span class="page-title">@yield('title', 'Dashboard')</span>
    </div>

    <div class="d-flex align-items-center gap-3">
        <span class="text-muted-custom" style="font-size: 14px;">
            <i class="bi bi-person-circle"></i> {{ Auth::user()->name ?? 'Admin' }}
        </span>
    </div>
</header>


