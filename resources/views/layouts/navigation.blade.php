<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="https://ui-avatars.com/api/?name={{urlencode(Auth::user()->name) }}" class="img-circle elevation-2" alt="User Image" />
        </div>
        <div class="info">
            <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @foreach ($menus as $menu)
            @if(count($menu->childs) > 0)
            <li class="nav-item {{ DB::table('role_has_menus')->where('menu_id', $menu->id)->where('role_id', Auth()->user()->roles[0]->id)->get()->count() > 0 ? '': 'd-none' }} {{ (request()->segment(1) == explode('/', $menu->childs[0]->link)[1]) ? 'menu-open' : '' }}">
                <a href="{{$menu->link}}" class="nav-link {{ (request()->segment(1) == explode('/', $menu->childs[0]->link)[1]) ? 'active' : '' }}">
                    <i class="nav-icon {{$menu->icon}}"></i>
                    <p>
                        {{$menu->name}}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach ($menu->childs as $submenu)
                    <li class="nav-item {{ DB::table('role_has_menus')->where('menu_id', $submenu->id)->where('role_id', Auth()->user()->roles[0]->id)->get()->count() > 0 ? '': 'd-none' }}">
                        <a href="{{$submenu->link}}" class="nav-link {{ (request()->segment(2) == explode('/', $submenu->link)[2]) ? 'active' : '' }}">
                            <i class="nav-icon {{$submenu->icon}}"></i>
                            <p>
                                {{$submenu->name}}
                            </p>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @else
            <li class="nav-item {{ DB::table('role_has_menus')->where('menu_id', $menu->id)->where('role_id', Auth()->user()->roles[0]->id)->get()->count() > 0 ? '': 'd-none' }}">
                <a href="{{$menu->link}}" class="nav-link {{ (request()->segment(1) == 'home') ? 'active' : '' }}">
                    <i class="nav-icon {{$menu->icon}}"></i>
                    <p>
                        {{$menu->name}}
                    </p>
                </a>
            </li>
            @endif
            @endforeach
        </ul>
    </nav>
</div>