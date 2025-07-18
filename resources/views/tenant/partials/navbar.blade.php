<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light elevation-2">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-item text-center">
                    <div class="row">
                        <img src="{{ asset('icons/avatar.svg') }}" class="img-thumbnail img-circle img-lg elevation-2"
                            style="margin: 0 auto;">
                    </div>
                </div>
                <div class="dropdown-item text-center">
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <a href="{{ route('users.edit', Auth::user()->id) }}" class="dropdown-item text-center">
                    <span>Meus dados</span>
                </a>
                <a href="#" class="dropdown-item text-center"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Sair
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
