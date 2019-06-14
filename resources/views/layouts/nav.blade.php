<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('principal') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="{{ asset('img/flesan-grupo.png') }}" width="50"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="{{ asset('img/flesan-grupo.png') }}" width="150"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset(implode(request()->session()->get('avatar'))) }}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{ Auth::user()->name }}</span>
            </a>

            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset(implode(request()->session()->get('avatar'))) }}" class="img-circle" alt="User Image">
                <p>
                  {{  Auth::user()->name }} -  @if( Auth::user()->rol[0]->id_rol == '7' )
              <i class="nombreSide"  style="font-style: inherit;">Jefe de SSOMA </i><br>
            @elseif( Auth::user()->rol[0]->id_rol == '6' )
              <i class="nombreSide"  style="font-style: inherit;">Asistente Corporativo SSOMA</i>
            @endif
                </p>
              </li>
              <!-- Menu Body -->
              <!--<li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              <!--</li>-->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();document.getElementById('logout-form').submit();" ><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                              @csrf
                      </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!--<li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
        </ul>
      </div>
    </nav>
  </header>