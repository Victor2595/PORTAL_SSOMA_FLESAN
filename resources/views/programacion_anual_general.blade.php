@extends('layouts.template')

@section("sidebar")
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
    <!--<form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Buscar...">
        <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>-->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU DE NAVEGACIÓN</li>
      <li class="treeview">
        <li><a href="{{ route('principal') }}">
          <i class="fa fas fa-home"></i> <span> Principal</span>
        </a></li>
      </li>
      @if(Auth::user()->rol[0]->id_rol == '6')
      <li class="treeview">
        <a href="#">
          <i class="fa fas fa-cogs"></i> <span> Administración</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('administracion_usuarios') }}"><i class="far fa-circle"></i> Administración Usuarios</a></li>
          <li><a href="{{ route('configuracion_proyecto') }}"><i class="far fa-circle"></i> Configuración de Proyecto</a></li>
          <li><a href="{{ route('dias_descontados') }}"><i class="far fa-circle"></i> Días Descontados</a></li>
        </ul>
      </li>
      @endif
      <li class="active treeview">
        <a href="#">
          <i class="fa fas fa-network-wired"></i><span> Programación</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @if(Auth::user()->rol[0]->id_rol == '7')
          <li><a href="{{ route('programacion_anual') }}"><i class="far fa-circle"></i> Programación Anual</a></li>
          @elseif(Auth::user()->rol[0]->id_rol == '6')
          <li class="active"><a href="{{ route('programacion_anual_general') }}"><i class="far fa-circle"></i> Programación Anual General</a></li>
          @endif
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-bar-chart"></i> <span> Indicadores</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @if(Auth::user()->rol[0]->id_rol == '7')
          <li><a href="{{ route('indicadores_listado') }}"><i class="far fa-circle"></i> Listado</a></li>
          @elseif(Auth::user()->rol[0]->id_rol == '6')
          <li><a href="{{ route('indicadores_listado_general') }}"><i class="far fa-circle"></i> Seguimiento</a></li>
          @endif
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fas fa-tachometer-alt"></i> <span> Reportes</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @if(Auth::user()->rol[0]->id_rol == '6')
          <!--<li><a href="{{ route('reportes_consolidados') }}"><i class="far fa-circle"></i> Reporte Consolidado</a></li>
          <li><a href="{{ route('dashboards') }}"><i class="far fa-circle"></i> DashBoards</a></li>-->
          <li><a href="{{ route('reportes_indicadores') }}"><i class="far fa-circle"></i> Reporte Indicadores</a></li>
          @elseif(Auth::user()->rol[0]->id_rol == '6')
          <li><a href="{{ route('reportes_individuales') }}"><i class="far fa-circle"></i> Reporte Estadísticos</a></li>
          @endif
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
@endsection

@section("content")
<div class="content-wrapper">
    <section class="content ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('principal') }}">SSOMA</a>
        </li>
        <li class="breadcrumb-item active">Programación Anual General</li>
      </ol>
      <div class="box">
        <div class="box-header">
            <h3 class="box-title hidden-xs hidden-sm hidden-md"><i class="fa fas fa-table"></i> Programa de Liderazgo Visible en Seguridad, Salud Ocupacional y Medio Ambiente</h3>
            <h3 class="box-title hidden-xs hidden-sm hidden-lg" style="font-size: 85%"><i class="fa fas fa-table"></i> Programa de Liderazgo Visible en Seguridad, Salud Ocupacional y Medio Ambiente</h3>
            <h3 class="box-title hidden-xs hidden-lg hidden-md" style="font-size: 85%"><i class="fa fas fa-table"></i> Programa de Liderazgo Visible en Seguridad, Salud Ocupacional y Medio Ambiente</h3>
            <h3 class="box-title hidden-lg hidden-sm hidden-md" style="font-size: 90%"><i class="fa fas fa-table"></i> PLV SSOMA</h3>
        </div>
        <div class="box-body">
          <table class="table table-bordered" id="dataTableP" width="100%" cellspacing="0">
            <thead class="hidden-xs hidden-sm hidden-md">
              <tr>
                <th style="font-size: 90%">Proyecto</th>
                <th style="font-size: 90%">Jefe SSOMA</th>
                <th style="font-size: 90%">Periodo</th>
                <th style="font-size: 90%">PLV TOTAL</th>
                <th style="font-size: 90%">ACCIÓN</th>
              </tr>
            </thead>
            <tfoot class="hidden-xs hidden-sm hidden-md">
              <tr>
                <th style="font-size: 90%">Proyecto</th>
                <th style="font-size: 90%">Jefe SSOMA</th>
                <th style="font-size: 90%">Periodo</th>
                <th style="font-size: 90%">PLV TOTAL</th>
                <th style="font-size: 90%">ACCIÓN</th>
              </tr>
            </tfoot>
            <tbody class="hidden-xs hidden-sm hidden-md">
              @foreach($datosTablaProgramacion as $item)
                <tr class="item{{ $item->id_liderazgo_ssoma }}">
                  <td style="font-size: 90%">{{ $item->nombre_proyecto }}</td>
                  <td style="font-size: 90%">{{ $item->name }}</td>
                  <td style="font-size: 90%">{{ $item->fecha_periodo }}</td>
                  <td style="font-size: 90%">{{ $item->tpe_plv }}</td>
                  <td style="font-size: 90%">
                      <a class="btn btn-primary btn-sm modificar" style="background-color: #DD4B39;border-color: #DD4B39;" href="{{ route('visualizacion_programacion',$item->id_liderazgo_ssoma) }}"  value="Modificar"><i class="fa fas fa-eye"></i> Visualizar</a>
                  </td>
                </tr>
                @endforeach
            </tbody>
            <thead class="hidden-xs hidden-sm hidden-lg">
              <tr>
                <th style="font-size: 85%">Proyecto</th>
                <th style="font-size: 85%">Jefe SSOMA</th>
                <th style="font-size: 85%">Periodo</th>
                <th style="font-size: 85%">PLV TOTAL</th>
                <th style="font-size: 85%">ACCIÓN</th>
              </tr>
            </thead>
            <tfoot class="hidden-xs hidden-sm hidden-lg">
              <tr>
                <th style="font-size: 85%">Proyecto</th>
                <th style="font-size: 85%">Jefe SSOMA</th>
                <th style="font-size: 85%">Periodo</th>
                <th style="font-size: 85%">PLV TOTAL</th>
                <th style="font-size: 85%">ACCIÓN</th>
              </tr>
            </tfoot>
            <tbody class="hidden-xs hidden-sm hidden-lg">
              @foreach($datosTablaProgramacion as $item)
                <tr class="item{{ $item->id_liderazgo_ssoma }}">
                  <td style="font-size: 85%">{{ $item->nombre_proyecto }}</td>
                  <td style="font-size: 85%">{{ $item->name }}</td>
                  <td style="font-size: 85%">{{ $item->fecha_periodo }}</td>
                  <td style="font-size: 85%">{{ $item->tpe_plv }}</td>
                  <td style="font-size: 85%">
                      <a class="btn btn-primary btn-sm modificar" style="background-color: #DD4B39;border-color: #DD4B39;" href="{{ route('visualizacion_programacion',$item->id_liderazgo_ssoma) }}"  value="Modificar"><i class="fa fas fa-eye"></i> Visualizar</a>
                  </td>
                </tr>
                @endforeach
            </tbody>
            <thead class="hidden-xs hidden-lg hidden-md">
              <tr>
                <th style="font-size: 80%">Proyecto</th>
                <th style="font-size: 80%">Jefe SSOMA</th>
                <th style="font-size: 80%">Periodo</th>
                <th style="font-size: 80%">PLV TOTAL</th>
                <th style="font-size: 80%">ACCIÓN</th>
              </tr>
            </thead>
            <tfoot class="hidden-xs hidden-lg hidden-md">
              <tr>
                <th style="font-size: 80%">Proyecto</th>
                <th style="font-size: 80%">Jefe SSOMA</th>
                <th style="font-size: 80%">Periodo</th>
                <th style="font-size: 80%">PLV TOTAL</th>
                <th style="font-size: 80%">ACCIÓN</th>
              </tr>
            </tfoot>
            <tbody class="hidden-xs hidden-lg hidden-md">
              @foreach($datosTablaProgramacion as $item)
                <tr class="item{{ $item->id_liderazgo_ssoma }}">
                  <td style="font-size: 80%">{{ $item->nombre_proyecto }}</td>
                  <td style="font-size: 80%">{{ $item->name }}</td>
                  <td style="font-size: 80%">{{ $item->fecha_periodo }}</td>
                  <td style="font-size: 80%">{{ $item->tpe_plv }}</td>
                  <td style="font-size: 80%">
                      <a class="btn btn-primary btn-sm modificar" style="background-color: #DD4B39;border-color: #DD4B39;" href="{{ route('visualizacion_programacion',$item->id_liderazgo_ssoma) }}"  value="Modificar"><i class="fa fas fa-eye"></i> Ver</a>
                  </td>
                </tr>
                @endforeach
            </tbody>
            <thead class="hidden-lg hidden-sm hidden-md">
              <tr>
                <th style="font-size: 75%">Proyecto</th>
                <th style="font-size: 75%">Jefe SSOMA</th>
                <th style="font-size: 75%">Periodo</th>
                <th style="font-size: 75%">PLV TOTAL</th>
                <th style="font-size: 75%">ACCIÓN</th>
              </tr>
            </thead>
            <tfoot class="hidden-lg hidden-sm hidden-md">
              <tr>
                <th style="font-size: 75%">Proyecto</th>
                <th style="font-size: 75%">Jefe SSOMA</th>
                <th style="font-size: 75%">Periodo</th>
                <th style="font-size: 75%">PLV TOTAL</th>
                <th style="font-size: 75%">ACCIÓN</th>
              </tr>
            </tfoot>
            <tbody class="hidden-lg hidden-sm hidden-md">
              @foreach($datosTablaProgramacion as $item)
                <tr class="item{{ $item->id_liderazgo_ssoma }}">
                  <td style="font-size: 75%">{{ $item->nombre_proyecto }}</td>
                  <td style="font-size: 75%">{{ $item->name }}</td>
                  <td style="font-size: 75%">{{ $item->fecha_periodo }}</td>
                  <td style="font-size: 75%">{{ $item->tpe_plv }}</td>
                  <td style="font-size: 75%">
                      <a class="btn btn-primary btn-sm modificar" style="background-color: #DD4B39;border-color: #DD4B39;" href="{{ route('visualizacion_programacion',$item->id_liderazgo_ssoma) }}"  value="Modificar"><i class="fa fas fa-eye"></i></a>
                  </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
    </section>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('datatables.net/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('datatables.net-bs/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js-proyect/admin/proyectos/programa_anual.js') }}"></script>
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection
