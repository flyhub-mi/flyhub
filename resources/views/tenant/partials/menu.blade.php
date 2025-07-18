<li class="nav-item">
    <a href="/" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
        <img src="{{ asset('icons/monitor.svg') }}" class="nav-icon">
        <p>Painel</p>
    </a>
</li>

<li class="nav-item {{ Request::is('sales/orders*') ? 'menu-open' : '' }}">
    <a href="{{ route('orders.index') }}" class="nav-link {{ Request::is('sales/orders*') ? 'active' : '' }}">
        <img src="{{ asset('icons/cart.svg') }}" class="nav-icon">
        <p>Pedidos</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('shipments.index') }}" class="nav-link {{ Request::is('sales/shipments*') ? 'active' : '' }}">
        <img src="{{ asset('icons/truck.svg') }}" class="nav-icon">
        <p>Envios</p>
    </a>
</li>

<li class="nav-item has-treeview {{ Request::is('catalog*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('catalog*') ? 'active' : '' }}">
        <img src="{{ asset('icons/website_store.svg') }}" class="nav-icon">
        <p>
            Catálogo
            <i class="nav-icon fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('catalog/products*') ? 'active' : '' }}"
                href="{{ route('products.index') }}">
                <img src="{{ asset('icons/t-shirt.svg') }}" class="nav-icon">
                <p>Produtos</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ Request::is('catalog/attribute*') ? 'active' : '' }}"
                href="{{ route('attribute-sets.index') }}">
                <i class="nav-icon fas fa-tags"></i>
                <p>Atributos</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ Request::is('catalog/categories*') ? 'active' : '' }}"
                href="{{ route('categories.index') }}">
                <i class="nav-icon fas fa-list-alt"></i>
                <p>Categorias</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a class="nav-link  {{ Request::is('customers*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Clientes</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link  {{ Request::is('channels*') ? 'active' : '' }}" href="{{ route('channels.index') }}">
        <img src="{{ asset('icons/hub.svg') }}" class="nav-icon">
        <p>Canais</p>
    </a>
</li>

<li class="nav-item has-treeview {{ Request::is('configurations*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('configurations*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-cogs"></i>
        <p>
            Configurações
            <i class="nav-icon fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a class="nav-link  {{ Request::is('configurations/users*') ? 'active' : '' }}"
                href="{{ route('users.index') }}">
                <img src="{{ asset('icons/avatar.svg') }}" class="nav-icon">
                <p>Usuários</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ Request::is('configurations/inventory*') ? 'active' : '' }}"
                href="{{ route('inventory-sources.index') }}">
                <img src="{{ asset('icons/cart_with_box.svg') }}" class="nav-icon">
                <p>Inventários</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('configurations/tax*') ? 'active' : '' }}"
                href="{{ route('tax-groups.index') }}">
                <img src="{{ asset('icons/libra.svg') }}" class="nav-icon">
                <p>Tributos</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ Request::is('configurations/tokens*') ? 'active' : '' }}"
                href="{{ route('tokens.index') }}">
                <i class="nav-icon fas fa-key"></i>
                <p>Tokens</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ Request::is('configurations/channel-sync-logs*') ? 'active' : '' }}"
                href="{{ route('sync-logs.index') }}">
                <i class="nav-icon fas fa-book"></i>
                <p>Logs de Sincronização</p>
            </a>
        </li>
    </ul>
</li>

@role('admin')
    <li class="nav-item has-treeview {{ Request::is('admin*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link">
            <img src="{{ asset('icons/administrator.svg') }}" class="nav-icon">
            <p>
                Administrador
                <i class="nav-icon fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/tenants*') ? 'active' : '' }}"
                    href="{{ route('tenants.index') }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Inquilinos</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ Request::is('admin/roles*') ? 'active' : '' }}"
                    href="{{ route('roles.index') }}">
                    <img src="{{ asset('icons/avatar.svg') }}" class="nav-icon">
                    <p>Permissões</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/integrations*') ? 'active' : '' }}"
                    href="{{ route('integrations.index') }}">
                    <i class="nav-icon fas fa-database"></i>
                    <p>Integrações</p>
                </a>
            </li>
        </ul>
    </li>
@endrole
