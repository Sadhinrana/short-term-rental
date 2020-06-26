<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/') }}dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" style="font-size: 15px" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route('home') }}" class="nav-link">--}}
{{--                       <i class="fas fa-home"></i>--}}
{{--                        <p>--}}
{{--                            Dashboard--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
                {{-- <li class="nav-item">
                    <a href="{{ url('/datafiniti-import') }}" class="nav-link">
                        <i class="fas fa-upload"></i>
                        <p>
                            Datafiniti Import
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ url('/datafiniti-property-list') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            DataFiniti Property List
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ url('/noo-property-import') }}" class="nav-link">
                        <i class="fas fa-upload"></i>
                        <p>
                            NOO Property Import
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ url('/noo-property-list') }}" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            NOO Property List
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('property.map') }}" class="nav-link">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>
                            NOO Property Map
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('noo.property.owner') }}" class="nav-link">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                            NOO Property Owner
                        </p>
                    </a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route('regions') }}" class="nav-link">--}}
{{--                        <i class="fas fa-history"></i>--}}
{{--                        <p>--}}
{{--                            LeaseAbuse Region List--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route('region.history') }}" class="nav-link">--}}
{{--                        <i class="fas fa-history"></i>--}}
{{--                        <p>--}}
{{--                            LeaseAbuse Property List--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="nav-item">
                    <a href="{{ route('master.property') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Master Property List
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('queue') }}" class="nav-link">
                        <i class="nav-icon fas fa-download"></i>
                        <p>
                           Import Property
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('export.community') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-upload"></i>
                        <p>
                            Export Property
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rental.property.map') }}" class="nav-link">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>
                            Rental Property Map
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('host.list') }}" class="nav-link">
                        <i class="nav-icon fas fa-baby"></i>
                        <p>
                            Host List
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('analytic-view') }}" class="nav-link">
                        <i class="nav-icon fas fa-baby"></i>
                        <p>
                            Analytics view
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.list') }}" class="nav-link">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
