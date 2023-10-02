<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <router-link :to="{ name: 'TrangChu' }" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt blue"></i>
                <p>
                    Thống kê
                </p>
            </router-link>
        </li>

        <li class="nav-item">
            <router-link :to="{ name: 'xxx'}" class="nav-link">
                <i class="nav-icon fas fa-list orange"></i>
                <p>
                    Product
                </p>
            </router-link>
        </li>

        @can('isAdmin')
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="fa fa-users nav-icon blue"></i>
                    <p>
                        Đoàn sinh
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <router-link :to="{ name: 'ThieuNhi'}" class="nav-link">
                            <i class="nav-icon fas fa-list-ol green"></i>
                            <p>
                                Thiếu nhi
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'HuynhTruong'}" class="nav-link">
                            <i class="nav-icon fas fa-tags green"></i>
                            <p>
                                Huynh truởng
                            </p>
                        </router-link>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-cog green"></i>
                    <p>
                        Nâng cao
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <router-link :to="{ name: 'ThamSo'}" class="nav-link">
                            <i class="nav-icon fas fa-list-ol green"></i>
                            <p>
                                Tham số
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'DiaChi'}" class="nav-link">
                            <i class="nav-icon fas fa-tags green"></i>
                            <p>
                                Địa chỉ
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link :to="{ name: 'CauHinh'}" class="nav-link">
                            <i class="nav-icon fas fa-cogs white"></i>
                            <p>
                                Developer
                            </p>
                        </router-link>
                    </li>
                </ul>
            </li>

        @endcan


        <li class="nav-item">
            <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-power-off red"></i>
                <p>
                    {{ __('Logout') }}
                </p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
