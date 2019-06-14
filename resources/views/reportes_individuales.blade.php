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
          <li><a href="{{ route('reportes_indicadores') }}"><i class="far fa-circle"></i> Reporte Indicadores</a></li>
          @elseif( Auth::user()->rol[0]->id_rol == '7')
          <li class="active"><a href="{{ route('reportes_individuales') }}"><i class="far fa-circle"></i> Reporte Estadísticos</a></li>
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
      @if(count($meses) != 0)
      <div class="form-grou row" style="margin-left: 0;margin-right: 0;">
        <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Reportes Estadísticos -  Proyecto "{{ $proyecto[0]->nombre_proyecto }}"</h3>
      </div>
        @if(count($indicadores) != 0)
        <div class="form-grou row">
          <div class="col col-lg-6 col-md-6">
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
                <div id="containerTE"></div>
              </div>    
            </div>
          </div>
          <div class="col col-lg-6 col-md-6">
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
                <div id="containerTFCA"></div>
              </div>    
            </div>
          </div>
        </div>
        <div class="form-grou row">
          <div class="col col-lg-6 col-md-6">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Tasa de Frecuencia de Accidentes Sin Tiempo Perdido</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>   
                  </button>
                </div>
              </div>
              <div class="box-body">
                <div id="containerTFSA"></div>
              </div>    
            </div>
          </div>
          <div class="col col-lg-6 col-md-6">
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
                <div id="containerGravedad"></div>
              </div>    
            </div>
          </div>
        </div>
        <div class="form-grou row">
          <div class="col col-lg-6 col-md-6">
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
                <div id="containerAccidentabilidad"></div>
              </div>    
            </div>
          </div>
        </div>
        <div class="form-grou row">
          <div class="col col-lg-6 col-md-6">
            <button id="export-pdf" style="display: none">Export to PDF</button>
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
                  <p>Usted no a registrado o no le han aprobado ningún indicador en los últimos meses. Alguna duda comunicarse con la Oficina Corporativa de Seguridad, Salud Ocupacional y Medio Ambiente.</p>
                </div>
              </div>    
            </div>
          </div>
        </div>
        @endif
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
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/reportes.css') }}">
    <script type="text/javascript">
    @if(count($meses)!= 0){
      Highcharts.getSVG = function(charts) {
        var svgArr = [],
          top = 0,
          width = 0;

        Highcharts.each(charts, function(chart) {
          var svg = chart.getSVG(),
            // Get width/height of SVG for export
            svgWidth = +svg.match(
              /^<svg[^>]*width\s*=\s*\"?(\d+)\"?[^>]*>/
            )[1],
            svgHeight = +svg.match(
              /^<svg[^>]*height\s*=\s*\"?(\d+)\"?[^>]*>/
            )[1];

          svg = svg.replace(
            '<svg',
            '<g transform="translate(0, '+width+' ) " '
          );
          svg = svg.replace('</svg>', '</g>');

          top += svgHeight;
          width = Math.max(top, svgWidth);
        
          svgArr.push(svg);
        });

        return '<svg height="' + width + '" width="' + top +
          '" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
          svgArr.join('') + '</svg>';
      };

      /**
       * Create a global exportCharts method that takes an array of charts as an
       * argument, and exporting options as the second argument
       */
      Highcharts.exportCharts = function(charts, options) {

        // Merge the options
        options = Highcharts.merge(Highcharts.getOptions().exporting, options);

        // Post to export server
        Highcharts.post(options.url, {
          filename: options.filename || 'chart',
          type: options.type,
          width: options.width,
          svg: Highcharts.getSVG(charts)
        });
      };


      var chart1 = Highcharts.chart('containerTE', {
        chart: {
            type: 'column',
            styledMode: true,
            options3d: {
                enabled: false,
                alpha: 15,
                beta: 15,
                depth: 50
            }
        },
        title: {
            text: 'Tasa de Entrenamiento'
        },
        plotOptions: {
            column: {
                depth: 25,
            },
            series: {
              color: 'red'
            }
        },
        colorAxis: {
            min: 0,
            minColor: '#FFFFFF',
            maxColor: Highcharts.getOptions().colors[8]
        },
        xAxis: {
            categories: [@foreach($meses as $mes){!! json_encode($mes->mes1) !!},{!! json_encode($mes->mes2) !!},{!! json_encode($mes->mes3) !!},{!! json_encode($mes->mes4) !!},{!! json_encode($mes->mes5) !!},@endforeach]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Valores %'
            }
        },
        series: [{
            data: [@foreach($valoresTE as $TasaEnt){!! ($TasaEnt->tasa) !!},@endforeach],
            name: 'Tasa de Entrenamiento',
            colorByPoint: true
        }],
        exporting: {
          enabled: true
        }
    });
    var chart2 = Highcharts.chart('containerTFCA', {
        chart: {
            type: 'column',
            styledMode: true,
            options3d: {
                enabled: false,
                alpha: 15,
                beta: 15,
                depth: 50
            }
        },
        title: {
            text: 'Tasa de Frecuencia de Accidentes con Tiempo Perdido'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        colorAxis: {
            min: 0,
            minColor: '#FFFFFF',
            maxColor: Highcharts.getOptions().colors[8]
        },
        xAxis: {
            categories: [@foreach($meses as $mes){!! json_encode($mes->mes1) !!},{!! json_encode($mes->mes2) !!},{!! json_encode($mes->mes3) !!},{!! json_encode($mes->mes4) !!},{!! json_encode($mes->mes5) !!},@endforeach]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Valores %'
            }
        },
        series: [{
            data: [@foreach($valoresTFCA as $TasaFCA){!! ($TasaFCA->tasa) !!},@endforeach],
            name: 'Tasa de Frecuencia de Accidentes con Tiempo Perdido',
            colorByPoint: true
        }],
        exporting: {
          enabled: true
        }
    });
    var chart3 = Highcharts.chart('containerTFSA', {
        chart: {
            type: 'column',
            styledMode: true,
            options3d: {
                enabled: false,
                alpha: 15,
                beta: 15,
                depth: 50
            }
        },
        title: {
            text: 'Tasa de Frecuencia de Accidentes sin Tiempo Perdido'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        colorAxis: {
            min: 0,
            minColor: '#FFFFFF',
            maxColor: Highcharts.getOptions().colors[8]
        },
        xAxis: {
            categories: [@foreach($meses as $mes){!! json_encode($mes->mes1) !!},{!! json_encode($mes->mes2) !!},{!! json_encode($mes->mes3) !!},{!! json_encode($mes->mes4) !!},{!! json_encode($mes->mes5) !!},@endforeach]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Valores %'
            }
        },
        series: [{
            data: [@foreach($valoresTFSA as $TasaFSA){!! ($TasaFSA->tasa) !!},@endforeach],
            name: 'Tasa de Frecuencia de Accidentes sin Tiempo Perdido',
            colorByPoint: true
        }],
        exporting: {
          enabled: true
        }
    });
    var chart4 = Highcharts.chart('containerGravedad', {
        chart: {
            type: 'column',
            styledMode: true,
            options3d: {
                enabled: false,
                alpha: 15,
                beta: 15,
                depth: 50
            }
        },
        title: {
            text: 'Tasa de Gravedad'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        colorAxis: {
            min: 0,
            minColor: '#FFFFFF',
            maxColor: Highcharts.getOptions().colors[8]
        },
        xAxis: {
            categories: [@foreach($meses as $mes){!! json_encode($mes->mes1) !!},{!! json_encode($mes->mes2) !!},{!! json_encode($mes->mes3) !!},{!! json_encode($mes->mes4) !!},{!! json_encode($mes->mes5) !!},@endforeach]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Valores %'
            }
        },
        series: [{
            data: [@foreach($valoresGravedad as $TasaG){!! ($TasaG->tasa) !!},@endforeach],
            name: 'Tasa de Gravedad',
            colorByPoint: true
        }],
        exporting: {
          enabled: true
        }
    });
    var chart5 = Highcharts.chart('containerAccidentabilidad', {
        chart: {
            type: 'column',
            styledMode: true,
            options3d: {
                enabled: false,
                alpha: 15,
                beta: 15,
                depth: 50
            }
        },
        title: {
            text: 'Tasa de Accidentabilidad'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        colorAxis: {
            min: 0,
            minColor: '#FFFFFF',
            maxColor: Highcharts.getOptions().colors[8]
        },
        xAxis: {
            categories: [@foreach($meses as $mes){!! json_encode($mes->mes1) !!},{!! json_encode($mes->mes2) !!},{!! json_encode($mes->mes3) !!},{!! json_encode($mes->mes4) !!},{!! json_encode($mes->mes5) !!},@endforeach]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Valores %'
            }
        },
        series: [{
            data: [@foreach($valoresGravedad as $TasaG){!! ($TasaG->tasa) !!},@endforeach],
            name: 'Tasa de Accidentabilidad',
            colorByPoint: true
        }],
        exporting: {
          enabled: true
        }
    });

    $('#export-pdf').click(function() {
      Highcharts.exportCharts([chart1, chart2], {
        type: 'application/pdf'
      });
    });
    }
    @endif
    </script>
@endsection

