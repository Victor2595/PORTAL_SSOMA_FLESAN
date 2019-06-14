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
          <li><a href="{{ route('indicadores_listado') }}"><i class="far fa-circle"></i> Listado</a></li>
          @elseif(Auth::user()->rol[0]->id_rol == '6')
          <li class="active"><a href="{{ route('indicadores_listado_general') }}"><i class="far fa-circle"></i> Seguimiento</a></li>
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
  <section class="content">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('principal') }}">SSOMA</a>
      </li>
      <li class="breadcrumb-item active">Indicadores de Seguimiento</li>
    </ol>
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><i class="glyphicon glyphicon-equalizer"></i> Indicadores de Seguimiento</h3> 
      </div>
      <div class="box-body"> 
        <div class="form-group row">
          <div id="containerx" style="height: 400px; min-width: 310px; max-width: 800px; margin: 0 auto"></div>  
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTableLG" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Proyecto</th>
                <th>Mes/Año</th>
                <th>Fecha de Registro</th>
                <th>Detalle</th>
                <th>Acción</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Proyecto</th>
                <th>Mes/Año</th>
                <th>Fecha de Registro</th>
                <th>Detalle</th>
                <th>Acción</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach($tablalistado as $tabla)
              <tr class="item{{ $tabla->id_indicadores }}">
                <td>{{ $tabla->nombre_proyecto }}</td>
                <td>{{ $tabla->mes }}</td>
                <td>{{ $tabla->fecha_registro }}</td>
                <td>{{ $tabla->estado_vali }}</td>
                <td>
                  @if($tabla->estado_validacion == 2 )
                    <a class="btn btn-success btn-sm modificar" value="Modificar"href="{{ route('indicadores_aprobacion_observacion',$tabla->id_indicadores) }}"  value="Modificar"><i class="fa fas fa-eye"></i> Visualizar</a>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('scripts')
<!-- Custom scripts for all pages-->
    <script>
      var toggler = document.getElementsByClassName("caret");
      var i;

      for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
          this.parentElement.querySelector(".nested").classList.toggle("active");
          this.classList.toggle("check-box");
        });
      }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('jquery-easing/jquery.easing.min.js') }}" type="text/javascript"></script>

    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('chart.js/Chart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('datatables/dataTables.bootstrap4.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js-proyect/admin/proyectos/indicadores.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <!-- Demo scripts for this page-->
    <script>
      Highcharts.chart('containerx', {
          chart: {
              type: 'heatmap',
              marginTop: 40,
              marginBottom: 80,
              plotBorderWidth: 0
          },

          title: {
              text: 'Seguimiento de Avance de Proyectos'
          },

          xAxis: {
              categories: [@foreach($meses as $mes){!! json_encode($mes->mes1) !!},{!! json_encode($mes->mes2) !!},{!! json_encode($mes->mes3) !!},{!! json_encode($mes->mes4) !!},{!! json_encode($mes->mes5) !!},@endforeach]
          },

          yAxis: {
              categories: [@foreach($fecha_proyecto as $proye){!!json_encode($proye->nombre_proyecto)!!},@endforeach],
              title: null
          },

          colorAxis: {
              min: 0,
              minColor: '#FFFFFF',
              maxColor: Highcharts.getOptions().colors[8]
          },

          legend: {
              align: 'right',
              layout: 'vertical',
              margin: 0,
              verticalAlign: 'top',
              y: 25,
              symbolHeight: 280,
          },

          tooltip: {
              formatter: function () {
                $variable = null;
                if(this.point.value == 0){
                  $variable = 'No existe indicador';
                }else if(this.point.value == 1){
                  $variable = 'Registrado';
                }else if(this.point.value == 2){
                  $variable = 'Enviado';
                }else if(this.point.value == 3){
                  $variable = 'Observado';
                }else if(this.point.value == 4){
                  $variable = 'Aprobado';
                }

                 return 'Mes <b>' + this.series.xAxis.categories[this.point.x] + '</b><br> Estado Indicador <b>' +
                      $variable  + '</b><br> Proyecto <b>' + this.series.yAxis.categories[this.point.y] + '</b>';
              }
          },

          series: [{
              name: 'ESTADO INDICE',
              borderWidth: 1,
              //data: [[0, 0, 0],[1, 1, 1],[2, 1, 2],[3, 2, 3],[4, 0, 4]],
              data: [@foreach($list as $lista){!! json_encode($lista) !!},@endforeach],
              dataLabels: {
                  enabled: false,
                  color: '#000000'
              }
          }]
      });
    </script>
@endsection

