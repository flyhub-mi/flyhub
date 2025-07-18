<aside class="main-sidebar sidebar-light-primary elevation-4" id="sidebar-wrapper">
    <a href="/" class="brand-link">
        <img src="{{ asset('images/logo.png')  }}" alt="FlyHub Logo" class="brand-image">
        <span class="brand-text font-weight-light">FlyHub</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('tenant.partials.menu')
            </ul>
        </nav>
    </div>
</aside>
