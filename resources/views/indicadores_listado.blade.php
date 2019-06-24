@extends('layouts.template')

@section("sidebar")
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        @if(is_array(request()->session()->get('avatar')))
          <img src="{{ asset(implode(request()->session()->get('avatar'))) }}" class="img-circle" alt="User Image">
        @endif      
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
      <li class="treeview">
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
          <li><a href="{{ route('programacion_anual_general') }}"><i class="far fa-circle"></i> Programación Anual General</a></li>
          @endif
        </ul>
      </li>
      <li class="active treeview">
        <a href="#">
          <i class="fa fa-bar-chart"></i> <span> Indicadores</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @if(Auth::user()->rol[0]->id_rol == '7')
          <li  class="active"><a href="{{ route('indicadores_listado') }}"><i class="far fa-circle"></i> Listado</a></li>
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
      @if(count($nombPro) != 0)
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ route('principal') }}">SSOMAC</a>
        </li>
        <li class="breadcrumb-item active">Indicadores de Seguimiento</li>
      </ol>  
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><i class="glyphicon glyphicon-equalizer"></i> Indicadores de Seguimiento - "{{ $nombPro[0]->nombre_proyecto }}"</h3> 
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTableIndicadores" width="100%" cellspacing="0">
              <thead class="hidden-xs hidden-sm hidden-md">
                <tr>
                  <th>Mes</th>
                  <th>Fecha Registro</th>
                  <th>Estado</th>
                  <th style="width: 30%">Acción</th>
                </tr>
              </thead>
              <tfoot class="hidden-xs hidden-sm hidden-md">
                <tr>
                  <th>Mes</th>
                  <th>Fecha Registro</th>
                  <th>Estado</th>
                  <th style="width: 30%">Acción</th>
                </tr>
              </tfoot>
              <tbody class="hidden-xs hidden-sm hidden-md">
                @foreach($tablalistado as $table)
                
                <tr class="item{{ $table->id_indicadores }}">
                  @if($table->estado_validacion == 3)                    
                  <td style="color: #E51A2F;font-weight: bold">{{ $table->mes }}</td>
                  <td style="color: #E51A2F;font-weight: bold">{{ $table->fecha }}</td>
                  <td style="color: #E51A2F;font-weight: bold">{{ $table->estado_vali }}</td>
                  <!--<td style="color: #E51A2F;font-weight: bold">{{ $table->descripcion }}</td>-->
                  @else
                  <td>{{ $table->mes }}</td>
                  <td>{{ $table->fecha }}</td>
                  <td>{{ $table->estado_vali }}</td>
                  <!--<td>{{ $table->descripcion }}</td>-->
                  @endif
                  <td>
                    @if($table->estado_validacion == 1||$table->estado_validacion == 3)
                        <a href="{{ route('indicadores_edit',$table->id_indicadores) }}" class="btn btn-primary btn-sm modificar sm-md-3" style="background-color: #DD4B39;border-color: #DD4B39;" value="Modificar"><i class="fa far fa-edit"></i> Modificar</a>
                    @endif
                    @if($table->estado_validacion == 1)
                       <a href="{{ route('indicadores_send',$table->id_indicadores) }}" class="btn btn-primary btn-sm enviar sm-md-3" svalue="Enviar"><i class="fa far fa-paper-plane"></i> Enviar</a> 
                       <a id="submit" href="#" name="submit" class="btn btn-danger btn-sm sm-md-3" value="Eliminar" style="background-color: #444242;border-color: #444242"><i class="fa far fa-trash"></i> Eliminar</a>  
                    @endif
                    @if($table->estado_validacion == 4)
                        <a class="btn btn-success btn-sm modificar" value="Visualizar" href="{{ route('indicadores_aprobacion_observacion',$table->id_indicadores) }}"  value="Visualizar"><i class="fa fas fa-eye"></i> Visualizar</a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        @if(count($contador) == 0)
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <a href="{{ route('indicadores_registro') }}" class="btn btn-primary" style="background-color: #DD4B39;border-color: #DD4B39;"><i class="fa fa-bar-chart-o"></i> Registrar Indicadores SSOMA</a>
            </div>
          </div>
        </div>
        @endif
        <br>
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
    <script src="{{ asset('datatables/dataTables.bootstrap4.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js-proyect/admin/proyectos/indicadores.js') }}"></script>

    <!-- Demo scripts for this page-->
    <script src="{{ asset('js/demo/datatables-demo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection

