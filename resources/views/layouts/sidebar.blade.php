<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset(implode(request()->session()->get('avatar'))) }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a ><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Buscar...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU DE NAVEGACIÓN</li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span> Administración</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Configuración de Proyecto</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Días Descontados</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Programación Anual</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Programación Anual General</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span> Indicadores</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Listado</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Seguimiento</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span> Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Reporte Individual</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Reporte Consolidado</a></li>
            <li><a href="index.html"><i class="fa fa-circle-o"></i> Reporte Indicadores</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> DashBoards</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>