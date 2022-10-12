<div class="sidebar">

    <div class="sidebar-background"></div>
    <div class="sidebar-wrapper scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav">
                @foreach ($left_menu as  $key => $menu)
                @if (isset($menu['header']))
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">{{ $menu['header'] }}</h4>
                </li>
                @endif
                <li class="nav-item">
                    @if (isset($menu['sub']))
                    <a data-toggle="collapse" href="#menu{{ $key }}">
                        @else
                        <a href="{{ $menu['href'] ? route($menu['href'], isset($menu['params']) ? $menu['params'] : []) : '#' }}">
                        @endif
                        <i class="fas fa-{{ $menu['icon'] }}"></i>
                        <p>{{ $menu['label'] }}</p>
                        @if (isset($menu['sub']))
                        <span class="caret"></span>
                        @endif
                    </a>
                    @if (isset($menu['sub']))
                    <div class="collapse" id="menu{{ $key }}">
                        <ul class="nav nav-collapse">
                            @foreach ($menu['sub'] as $sub)
                            <li>
                                <a href="{{ $sub['href'] ? route($sub['href'], isset($sub['params']) ? $sub['params'] : []) : '#' }}">
                                    <span class="sub-item">{{ $sub['label'] }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
