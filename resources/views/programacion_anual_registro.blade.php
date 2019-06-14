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
          <li class="active"><a href="{{ route('programacion_anual') }}"><i class="far fa-circle"></i> Programación Anual</a></li>
          @elseif(Auth::user()->rol[0]->id_rol == '6')
          <li><a href="{{ route('programacion_anual_general') }}"><i class="far fa-circle"></i> Programación Anual General</a></li>
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
          @elseif(Auth::user()->rol[0]->id_rol == '7')
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
    @if($datosProyecto != null)
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
          <a href="{{ route('principal') }}">SSOMA</a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('programacion_anual') }}">Programación Anual</a>
      </li>
      <li class="breadcrumb-item active">Registro Programación Anual</li>
    </ol>
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <div class="box" id="ConfiProNuevo">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fas fa-cogs"></i> Programa de Liderazgo Visible en Seguridad, Salud Ocupacional y Medio Ambiente - "{{ $datosProyecto->nombre_proyecto }}"</h3>
          </div>
          <div class="box-body">
            <form method="POST" action="/programacion_anual_registro/import-excel" enctype="multipart/form-data">
            @csrf
              <div class="row">
                <div class="form-group col-md-4 col-lg-4">
                        <label for="excel" class="control-label">Nuevo Archivo</label>
                        <input type="file" class="form-control" id="excel" name="excel">
                    </div>
              </div>
              <div class="form-row">
                <div class="col-md-6 offset-md-5">
                  <button class="btn btn-primary" style="background-color: #DD4B39;border-color: #DD4B39;"><a  style="color:#ffffff;"><i class="fa fa-file-excel-o"></i></a> Cargar Excel</button>
                </div>
              </div>
            </form> 
          </div>
        </div>
      </div>
    </div>
    @else
    <div class="form-grou row">
        <div class="col col-lg-12 col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="color:#dd4b39"><i class="fa fas fa-exclamation-triangle" style="color:#dd4b39"></i> Alerta</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>   
                </button>
              </div>
            </div>
            <div class="box-body">
              <div>
                <p>{{ $mensaje['mensaje'] }}</p>
              </div>
            </div>    
          </div>
        </div>
      </div>
    @endif
  </section>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sb-admin.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>

@endsection
