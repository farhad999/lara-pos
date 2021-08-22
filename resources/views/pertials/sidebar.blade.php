<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        {{config('app.name')}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul id="sidebar-menu" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">
                <li class="nav-item">
                    <a href="{{route('home')}}"
                       class="nav-link {{ request()->is('/') ? 'active': ''}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <!-- Category -->

                <li class="nav-item has-treeview {{(request()->segment('1') == 'categories' || request()->segment('1') == 'brands') ? 'menu-open': ''}}">
                    <a href="#ddd" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('brands.index')}}" class="nav-link {{request()->segment('1') == 'brands' ? 'active': ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('categories.index')}}" class="nav-link {{request()->segment('1') == 'categories' ? 'active': ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>



        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
