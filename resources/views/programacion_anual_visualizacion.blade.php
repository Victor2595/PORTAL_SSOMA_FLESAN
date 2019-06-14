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
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('principal') }}">SSOMA</a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{ route('programacion_anual_general') }}">Programación Anual General</a>
        </li>
        <li class="breadcrumb-item active">Visualizacion de Programación - {{ $mes[0]->fecha_periodo }}</li>
      </ol>
      <div class="box">
        <div class="box-body">
          <div class="table-responsive">   
             <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th colspan="20" valign="middle" class="text-center">PROYECTO - {{ $proyec[0]->nombre_proyecto }}</th>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th style="font-size: 11px;background-color: #DD4B39;color: #ffff">ACTIVIDADES DE LIDERAZGO VISIBLE / PARTICIPANTES</th>
                    <th colspan="3" style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">Inspecciones Planificadas</th>
                    <th colspan="3" style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">Capacitación/Entrenamiento</th>
                    <th colspan="3" style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">Investigacion de Accidentes</th>
                    <th colspan="3" style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">Observación de Tareas</th>
                    <th colspan="3" style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">Reuniones Programadas SSOMA</th>
                    <th colspan="3" style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">Comité Técnico SST</th>
                    <th style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">PLV</th>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th style="font-size: 11px;">RESIDENTE y/o GERENTE</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Prog.</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Ejec</th>
                    <th style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">%</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Prog.</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Ejec</th>
                    <th style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">%</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Ocur.</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Ejec</th>
                    <th style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">%</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Prog.</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Ejec</th>
                    <th style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">%</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Prog.</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Ejec</th>
                    <th style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">%</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Prog.</th>
                    <th style="font-size: 11px;background-color: #c2c3c9" class="text-center">Ejec</th>
                    <th style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">%</th>
                    <th style="font-size: 11px;background-color: #DD4B39;color: #ffff" class="text-center">%</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($programa as $item)
                  <tr class="item{{ $item->id_liderazgo_det }}">
                    <td style="font-size: 11px;">{{ $item->participante_cargo }}</td>
                    <td style="font-size: 11px;">{{ $item->inspecciones_planificadas_programadas }}</td>
                    <td style="font-size: 11px;">{{ $item->inspecciones_planificadas_ejecutadas }}</td>
                    <td style="font-size: 11px;">{{ $item->inspecciones_planificadas_porcentaje }}</td>
                    <td style="font-size: 11px;">{{ $item->capacitacion_entrenamiento_programadas }}</td>
                    <td style="font-size: 11px;">{{ $item->capacitacion_entrenamiento_ejecutadas }}</td>
                    <td style="font-size: 11px;">{{ $item->capacitacion_entrenamiento_porcentaje }}</td>
                    <td style="font-size: 11px;">{{ $item->investigacion_accidentes_programadas }}</td>
                    <td style="font-size: 11px;">{{ $item->investigacion_accidentes_ejecutadas }}</td>
                    <td style="font-size: 11px;">{{ $item->investigacion_accidentes_porcentaje }}</td>
                    <td style="font-size: 11px;">{{ $item->observacion_tareas_programadas }}</td>
                    <td style="font-size: 11px;">{{ $item->observacion_tareas_ejecutadas }}</td>
                    <td style="font-size: 11px;">{{ $item->observacion_tareas_porcentaje }}</td>
                    <td style="font-size: 11px;">{{ $item->reuniones_programadas_programadas }}</td>
                    <td style="font-size: 11px;">{{ $item->reuniones_programadas_ejecutadas }}</td>
                    <td style="font-size: 11px;">{{ $item->reuniones_programadas_porcentaje }}</td>
                    <td style="font-size: 11px;">{{ $item->comite_tecnico_programadas }}</td>
                    <td style="font-size: 11px;">{{ $item->comite_tecnico_ejecutadas }}</td>
                    <td style="font-size: 11px;">{{ $item->comite_tecnico_porcentaje }}</td>
                    <td style="font-size: 11px;">{{ $item->plv_porcentaje }}</td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  @foreach($progra as $foot)
                  <tr class="item{{ $item->id_liderazgo_ssoma }}">
                    <th style="font-size: 11px;">TOTAL DE PROGRAMADO Y EJECUTADO:</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_insp_plani_progr }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_insp_plani_ejec }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_insp_plani_porce }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_capac_entre_progr }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_capac_entre_ejec }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_capac_entre_porce }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_investi_accide_progr }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_investi_accide_ejec }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_investi_accide_porce }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_observ_tare_progr }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_observ_tare_ejec }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_observ_tare_porce }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_reun_progra_ssoma_progr }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_reun_progra_ssoma_ejec }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_reun_progra_ssoma_porce }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_comi_tecn_sst_progr }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_comi_tecn_sst_ejec }}</th>
                    <th style="font-size: 11px;">{{ $foot->tpe_comi_tecn_sst_porce }}</th>
                    <th style="font-size: 11px;background-color: #DD4B39;color: #ffff">{{ $foot->tpe_plv }}</th>
                  </tr>
                  @endforeach
                </tfoot>
             </table>
          </div>      
        </div>
      </div>  
  </section>
</div>    
	
@endsection

@section('scripts')
    <script src="{{ asset('datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('datatables/dataTables.bootstrap4.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection
