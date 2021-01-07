  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="Cines FLex Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Cines Flex</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
          </div>
        </div>
    
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            {{-- <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Simple Link
                  <span class="right badge badge-danger">New</span>
                </p>
              </a>
            </li> --}}
            <li class="nav-item">
              <a href="{{ route('regions.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  {{ trans('message.sidebar.region') }}
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('cinemas.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  {{ trans('message.sidebar.cinema') }}
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('casters.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  {{ trans('message.sidebar.caster') }}
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('languages.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  {{ trans('message.sidebar.language') }}
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('categories.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  {{ trans('message.sidebar.category') }}
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('screens.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  {{ trans('message.sidebar.screen') }}
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('promotions.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  {{ trans('message.sidebar.promotion') }}
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('products.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  {{ trans('message.sidebar.product') }}
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('movies.index') }}" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  {{ trans('message.sidebar.movie') }}
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    <!-- /.sidebar -->
  </aside>