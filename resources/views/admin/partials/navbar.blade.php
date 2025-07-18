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
                <i class="far fa-bell"></i>
                <span class="badge badge-primary navbar-badge">{{$notificationCount ?? '' }}</span>
            </a>
            <div id="accordion" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @forelse ($notificationUnread as $notification)
                <?php
                $dataObjt = json_decode($notification->getAttribute('data'));
                $type = $notification->getNotificationTypeName($dataObjt->type);
                ?>
                <div id="headingOne" class="pt-2 pl-2 pr-2 d-flex justify-content-between">
                    <div>
                        <h4>Notificações</h4>
                    </div>
                    <div>
                        <a href="{{route('notifications.clear')}}">Limpar</a>
                    </div>
                </div>
                <hr style="margin: 0;" />
                <a href="{{ route($dataObjt->type . '.show',  $dataObjt->id) }}" class="dropdown-item">
                    <div class="media">
                        <img src="{{ asset('images/logo.png') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Novo {{$type}}
                            </h3>
                            <p class="text-sm">{{$dataObjt->channel_name}}</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans()}} </p>
                        </div>
                    </div>
                </a>
                @empty
                <div style="height: 50px;padding-top: 10px; text-align: center;"><i style="font-size:16px;margin-right: 15px;" class="far fa-frown"></i> Sem novas notificações</div>
                @endforelse
                <div class="dropdown-divider"></div>
                <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer ">
                    Ver todas as notificações.</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-item text-center">
                    <div class="row">
                        <img src="{{ asset('icons/avatar.svg') }}" class="img-thumbnail img-circle img-lg elevation-2" style="margin: 0 auto;">
                    </div>
                </div>
                <a href="{{ route('users.edit',  Auth::user()->id) }}" class="dropdown-item text-center">
                    <span>{{ Auth::user()->name}}</span>
                </a>
                <a href="{{ route('users.edit',  Auth::user()->id) }}" class="dropdown-item text-center">
                    <span>Meus dados</span>
                </a>
                <a href="#" class="dropdown-item text-center" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Sair
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
