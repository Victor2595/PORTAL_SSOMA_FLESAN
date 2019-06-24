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
      @if( Auth::user()->rol[0]->id_rol == '6')
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
          @if( Auth::user()->rol[0]->id_rol == '7')
          <li><a href="{{ route('programacion_anual') }}"><i class="far fa-circle"></i> Programación Anual</a></li>
          @elseif( Auth::user()->rol[0]->id_rol == '6')
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
          @if( Auth::user()->rol[0]->id_rol == '7')
          <li><a href="{{ route('indicadores_listado') }}"><i class="far fa-circle"></i> Listado</a></li>
          @elseif( Auth::user()->rol[0]->id_rol == '6')
          <li><a href="{{ route('indicadores_listado_general') }}"><i class="far fa-circle"></i> Seguimiento</a></li>
          @endif
        </ul>
      </li>
      <li class="active treeview">
        <a href="#">
          <i class="fa fas fa-tachometer-alt"></i> <span> Reportes</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @if( Auth::user()->rol[0]->id_rol == '6')
          <!--<li><a href="{{ route('reportes_consolidados') }}"><i class="far fa-circle"></i> Reporte Consolidado</a></li>
          <li><a href="{{ route('dashboards') }}"><i class="far fa-circle"></i> DashBoards</a></li>-->
          <li class="active"><a href="{{ route('reportes_indicadores') }}"><i class="far fa-circle"></i> Reporte Indicadores</a></li>
          @elseif( Auth::user()->rol[0]->id_rol == '7')
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
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><i class="fas fa-chart-line"></i> Reportes Indicadores</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>   
            </button>
          </div>
        </div>
        <div class="box-body">
          <form method="GET" action="/reportes_indicadores" enctype="multipart/form-data">
            
            <div class="form-group row">
              <div class="col col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="selectUN">Empresa</label>
                <select id="selectUN" required="required" name="selectUN" class="form-control" autofocus="autofocus">
                  <option value="-1" selected>Seleccione Empresa</option>
                  @foreach($unidades as $unid) 
                    <option  style="font-size: 90%" value="{{ $unid->COD_EMPRESA }}" {{ old('selectUN')==$unid->COD_EMPRESA ? 'selected' : '' }}>{{ $unid->NOMBRE_EMPRESA }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label for="selectProy">Proyecto</label>
                <select id="selectProy" disabled="true" required="required" name="selectProy" class="form-control">
                  <option value="-1"  selected>Seleccione Proyecto</option>
                </select>
              </div>
              <div class="col col-lg-2 col-md-2 col-sm-12 col-xs-12 ">
                <label for="btnGenerar"></label>
                <button id="btnGenerar" class="btn btn-danger form-control" style="color:#ffffff;font-size: 12px"><i class="far fa-save"></i> GENERAR REPORTES</button>
              </div>
            </div>
          </form>
        </div>    
      </div>
      <div class="form-grou row">
        <div class="col col-lg-12 col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Tasa de Entrenamiento</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>   
                </button>
              </div>
            </div>
            <div class="box-body">
              <div id="container"></div>
              </div>    
          </div>
        </div>
      </div>
      <div class="form-grou row">
        <div class="col col-lg-12 col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Tasa de Frecuencia de Accidentes con Tiempo Perdido</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>   
                </button>
              </div>
            </div>
            <div class="box-body">
              <div id="containerTFC"></div>
              </div>    
          </div>
        </div>
      </div>
      <div class="form-grou row">
        <div class="col col-lg-12 col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Tasa de Frecuencia de Accidentes sin Tiempo Perdido</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>   
                </button>
              </div>
            </div>
            <div class="box-body">
              <div id="containerTFS"></div>
              </div>    
          </div>
        </div>
      </div>
      <div class="form-grou row">
        <div class="col col-lg-12 col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Tasa de Gravedad</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>   
                </button>
              </div>
            </div>
            <div class="box-body">
              <div id="containerTG"></div>
              </div>    
          </div>
        </div>
      </div>
      <div class="form-grou row">
        <div class="col col-lg-12 col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Tasa de Accidentabilidad</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>   
                </button>
              </div>
            </div>
            <div class="box-body">
              <div id="containerTA"></div>
              </div>    
          </div>
        </div>
      </div>
    </section>
</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js-proyect/admin/proyectos/reportes.js') }}"></script>
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/reportes.css') }}">
    <script type="text/javascript">
    Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Tasa de Entrenamiento'
    },
    xAxis: {
        categories: [@foreach($meses as $mes){!! json_encode($mes->mes1) !!},{!! json_encode($mes->mes2) !!},{!! json_encode($mes->mes3) !!},{!! json_encode($mes->mes4) !!},{!! json_encode($mes->mes5) !!}@endforeach],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Valores %'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series:  [
      @foreach($valoresTE as $valor)
      {
        name: '{!! ($valor->nombre_proyecto) !!}',
        data: [{!! ($valor->mes1) !!},{!! ($valor->mes2) !!},{!! ($valor->mes3) !!},{!! ($valor->mes4) !!},{!! ($valor->mes5) !!}]

      },
      @endforeach
    ],
    });
    Highcharts.chart('containerTFC', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Tasa de Frecuencia en Accidentes con Tiempo Pérdido'
    },
    xAxis: {
        categories: [@foreach($meses as $mes){!! json_encode($mes->mes1) !!},{!! json_encode($mes->mes2) !!},{!! json_encode($mes->mes3) !!},{!! json_encode($mes->mes4) !!},{!! json_encode($mes->mes5) !!}@endforeach],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Valores %'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series:  [
      @foreach($valoresTFCA as $valor)
      {
        name: '{!! ($valor->nombre_proyecto) !!}',
        data: [{!! ($valor->mes1) !!},{!! ($valor->mes2) !!},{!! ($valor->mes3) !!},{!! ($valor->mes4) !!},{!! ($valor->mes5) !!}]

      },
      @endforeach
    ],
    });
    Highcharts.chart('containerTFS', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Tasa de Frecuencia en Accidentes sin Tiempo Pérdido'
    },
    xAxis: {
        categories: [@foreach($meses as $mes){!! json_encode($mes->mes1) !!},{!! json_encode($mes->mes2) !!},{!! json_encode($mes->mes3) !!},{!! json_encode($mes->mes4) !!},{!! json_encode($mes->mes5) !!}@endforeach],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Valores %'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series:  [
      @foreach($valoresTFSA as $valor)
      {
        name: '{!! ($valor->nombre_proyecto) !!}',
        data: [{!! ($valor->mes1) !!},{!! ($valor->mes2) !!},{!! ($valor->mes3) !!},{!! ($valor->mes4) !!},{!! ($valor->mes5) !!}]

      },
      @endforeach
    ],
    });
    Highcharts.chart('containerTG', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Tasa de Gravedad'
    },
    xAxis: {
        categories: [@foreach($meses as $mes){!! json_encode($mes->mes1) !!},{!! json_encode($mes->mes2) !!},{!! json_encode($mes->mes3) !!},{!! json_encode($mes->mes4) !!},{!! json_encode($mes->mes5) !!}@endforeach],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Valores %'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series:  [
      @foreach($valoresGravedad as $valor)
      {
        name: '{!! ($valor->nombre_proyecto) !!}',
        data: [{!! ($valor->mes1) !!},{!! ($valor->mes2) !!},{!! ($valor->mes3) !!},{!! ($valor->mes4) !!},{!! ($valor->mes5) !!}]

      },
      @endforeach
    ],
    });
    Highcharts.chart('containerTA', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Tasa de Accidentabilidad'
    },
    xAxis: {
        categories: [@foreach($meses as $mes){!! json_encode($mes->mes1) !!},{!! json_encode($mes->mes2) !!},{!! json_encode($mes->mes3) !!},{!! json_encode($mes->mes4) !!},{!! json_encode($mes->mes5) !!}@endforeach],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Valores %'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series:  [
      @foreach($valoresAccidentabilidad as $valor)
      {
        name: '{!! ($valor->nombre_proyecto) !!}',
        data: [{!! ($valor->mes1) !!},{!! ($valor->mes2) !!},{!! ($valor->mes3) !!},{!! ($valor->mes4) !!},{!! ($valor->mes5) !!}]

      },
      @endforeach
    ],
    });
    </script>
@endsection

