@php
$menus = \App\Helpers\Helper::menus();
    $user_menu_ids = \App\Helpers\Helper::user_menu_ids();
    $current_path = request()->path();
    $explode_path = explode('/', $current_path)[0];
@endphp
<div class="sidebar-wrapper">
    <div class="sidebar sidebar-collapse" id="sidebar">
        <div class="sidebar__menu-group">
            <ul class="sidebar_nav">
                @foreach ($menus as $m)
                    @php  $p_url = $m['url']? url($m['url']): null; @endphp
                    {{-- li --}}
                    <li
                        class="{{ empty($m['url']) ? 'has-child' : 'no-child' }} @if (!empty($m['url']) && $explode_path == $m['url']) ? active @endif">
                        @if (in_array($m['id'], $user_menu_ids))
                            <a href="{{ $m['url'] ? $p_url : 'javascript:void(0)' }}">
                                <span class="nav-icon uil {{ $m['icon'] == null ? 'las la-stream' : $m['icon'] }}"></span>
                                <span class="menu-text">{{ $m['title'] }}</span>
                                @if (count($m['children']) > 0)
                                    <span class="toggle-icon"></span>
                                @endif
                            </a>
                        @endif
                        @if ($m['children'])
                            <ul class="sub-menu">
                                @foreach ($m['children'] as $child)
                                    @if (in_array($child['id'], $user_menu_ids))
                                        @php $c_url = url($child['url']);  @endphp
                                        <li class="sub-menu-li @if ($explode_path == $child['url']) ? active @endif">
                                            <a href="{{ $c_url }}">{{ $child['title'] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
                @if (Auth::user()->role_id == 1)
                    @php
                        $countData['countshowrooms'] = App\Models\ShowRoom::count();
                        $countexecutive = App\Models\User::where('role_id', 2)
                            ->where('is_active', 1)
                            ->count();
                        $countmanager = App\Models\User::where('role_id', 3)
                            ->where('is_active', 1)
                            ->count();
                        $admin = App\Models\User::where('role_id', 1)
                            ->where('is_active', 1)
                            ->count();
                    @endphp
                    <hr class="my-2">
                    <li class="has-child open">
                        <a href="javascript:void(0)">
                            <span class="nav-icon uil nav-icon-4 fas fa-user-shield fs-6"></span>
                            <span class="menu-text fs-6 fw-bold">Loggedin</span>
                            <span class="toggle-icon fs-6"></span>
                        </a>
                        <ul class="sub-menu" style="display: none; top: 206.953px; left: 177px;">
                            <li class="sub-menu-li ">
                                <a class="d-flex justify-content-between" href="{{ url('active-user-admin') }}"><span>Admin</span> <span class="fw-bold">{{ $admin }}</span> </a>
                            </li>    
                             <li class="sub-menu-li ">
                                <a class="d-flex justify-content-between" href="{{ url('active-user-manager') }}">Retail<span></span><span class="fw-bold">0</span> </a>
                            </li>                        
                            <li class="sub-menu-li ">
                                <a class="d-flex justify-content-between" href="{{ url('active-user-manager') }}"><span>Zone</span><span class="fw-bold">0</span> </a>
                            </li>                        
                            <li class="sub-menu-li ">
                                <a class="d-flex justify-content-between" href="javascript:void(0)"><span>Showroom</span><span class="fw-bold">0</span></a>
                            </li>
                        </ul>
                    </li>
                    {{-- </ul> --}}
                    {{-- <li style="color:#404040" class="px-3 fw-bold text-black mt-3 mb-3"><span class="pe-2 nav-icon-9"><i
                                class="fas fa-user-shield"></i></span>Loggedin</li>
                    <ul class="mt-2 logidin">
                        <li class="d-flex mb-2 fw-500 justify-content-between"><span>Admin</span>
                            <span>{{ $admin }}</span> </li>
                        <li class="d-flex mb-2 fw-500 justify-content-between">
                            <span>Manager</span><span>{{ $countmanager }}</span></li>
                        <li class="d-flex mb-2 fw-500 justify-content-between"><span>Executive</span>
                            <span>{{ $countexecutive }}</span> </li>
                        <li class="d-flex mb-2 fw-500 justify-content-between"><span>Showroom</span>
                            <span>{{ $countData['countshowrooms'] }}</span></li>
                    </ul> --}}
                @endif
            </ul>
        </div>
    </div>
</div>
