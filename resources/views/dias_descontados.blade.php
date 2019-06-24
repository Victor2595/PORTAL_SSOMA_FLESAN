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
      <li class="active treeview">
        <a href="#">
          <i class="fa fas fa-cogs"></i> <span> Administración</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('administracion_usuarios') }}"><i class="far fa-circle"></i> Administración Usuarios</a></li>
          <li><a href="{{ route('configuracion_proyecto') }}"><i class="far fa-circle"></i> Configuración de Proyecto</a></li>
          <li class="active"><a href="{{ route('dias_descontados') }}"><i class="far fa-circle"></i> Días Descontados</a></li>
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
  	      		<a href="{{ route('principal') }}">SSOMAC</a>
  	    	</li>
  	    	<li class="breadcrumb-item active">Dias Descontados</li>
  	  	</ol>

        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><i class="glyphicon glyphicon-list"></i> Listado Dias Descontados</h3>
          </div>
          <div class="box-body">
            <table class="table table-bordered table-striped" id="dataTableD" width="100%" cellspacing="0">
                  <thead class="hidden-xs hidden-sm hidden-md">
                    <tr>
                      <th style="font-size: 90%">Regimen</th>
                      <th style="font-size: 90%">Nombre</th>
                      <th style="font-size: 90%">Acción</th>
                    </tr>
                  </thead>
                  <tfoot class="hidden-xs hidden-sm hidden-md">
                    <tr>
                      <th style="font-size: 90%">Regimen</th>
                      <th style="font-size: 90%">Nombre</th>
                      <th style="font-size: 90%">Acción</th>
                    </tr>
                  </tfoot>
                  <tbody class="hidden-xs hidden-sm hidden-md">
                    @foreach($data as $item)
                      <tr class="item{{ $item->id_dias_desc }}">
                        <td style="font-size: 90%">{{ $item->regimen }}</td>
                        <td style="font-size: 90%">{{ $item->nombre }}</td>
                        <td style="font-size: 90%">
                          <form action="{{ route('dias.destroy', $item->id_dias_desc) }}" method="GET">
                            <a href="{{ route('dias.edit', $item->id_dias_desc) }}" class="btn btn-primary btn-sm modificar" style="background-color: #DD4B39;border-color: #DD4B39;" value="Modificar"><i class="fa far fa-edit"></i> Modificar</a>

                            @csrf
                              @method('DELETE')
                            <a id="submit" href="{{ route('dias.destroy', $item->id_dias_desc) }}" name="submit" class="btn btn-danger btn-sm"  value="Eliminar" style="background-color: #444242;border-color: #444242"><i class="fa fa-trash"></i> Eliminar</a> 
                          </form>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                  <thead class="hidden-xs hidden-sm hidden-lg">
                    <tr>
                      <th style="font-size: 85%">Regimen</th>
                      <th style="font-size: 85%">Nombre</th>
                      <th style="font-size: 85%">Acción</th>
                    </tr>
                  </thead>
                  <tfoot class="hidden-xs hidden-sm hidden-lg">
                    <tr>
                      <th style="font-size: 85%">Regimen</th>
                      <th style="font-size: 85%">Nombre</th>
                      <th style="font-size: 85%">Acción</th>
                    </tr>
                  </tfoot>
                  <tbody class="hidden-xs hidden-sm hidden-lg">
                    @foreach($data as $item)
                      <tr class="item{{ $item->id_dias_desc }}">
                        <td style="font-size: 85%">{{ $item->regimen }}</td>
                        <td style="font-size: 85%">{{ $item->nombre }}</td>
                        <td style="font-size: 85%">
                          <form action="{{ route('dias.destroy', $item->id_dias_desc) }}" method="GET">
                            <a href="{{ route('dias.edit', $item->id_dias_desc) }}" class="btn btn-primary btn-sm modificar" style="background-color: #DD4B39;border-color: #DD4B39;" value="Modificar"><i class="fa far fa-edit"></i></a>

                            @csrf
                              @method('DELETE')
                            <a id="submit" href="{{ route('dias.destroy', $item->id_dias_desc) }}" name="submit" class="btn btn-danger btn-sm"  value="Eliminar" style="background-color: #444242;border-color: #444242"><i class="fa fa-trash"></i></a> 
                          </form>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                  <thead class="hidden-xs hidden-md hidden-lg">
                    <tr>
                      <th style="font-size: 75%">Regimen</th>
                      <th style="font-size: 75%">Nombre</th>
                      <th style="font-size: 75%">Acción</th>
                    </tr>
                  </thead>
                  <tfoot class="hidden-xs hidden-md hidden-lg">
                    <tr>
                      <th style="font-size: 75%">Regimen</th>
                      <th style="font-size: 75%">Nombre</th>
                      <th style="font-size: 75%">Acción</th>
                    </tr>
                  </tfoot>
                  <tbody class="hidden-xs hidden-md hidden-lg">
                    @foreach($data as $item)
                      <tr class="item{{ $item->id_dias_desc }}">
                        <td style="font-size: 75%">{{ $item->regimen }}</td>
                        <td style="font-size: 75%">{{ $item->nombre }}</td>
                        <td style="font-size: 75%">
                          <form action="{{ route('dias.destroy', $item->id_dias_desc) }}" method="GET">
                            <a href="{{ route('dias.edit', $item->id_dias_desc) }}" class="btn btn-primary btn-sm modificar" style="background-color: #DD4B39;border-color: #DD4B39;" value="Modificar"><i class="fa far fa-edit"></i></a>

                            @csrf
                              @method('DELETE')
                            <a id="submit" href="{{ route('dias.destroy', $item->id_dias_desc) }}" name="submit" class="btn btn-danger btn-sm"  value="Eliminar" style="background-color: #444242;border-color: #444242"><i class="fa fa-trash"></i></a> 
                          </form>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                  <thead class="hidden-sm hidden-md hidden-lg">
                    <tr>
                      <th style="font-size: 66%">Regimen</th>
                      <th style="font-size: 66%">Nombre</th>
                      <th style="font-size: 66%">Acción</th>
                    </tr>
                  </thead>
                  <tfoot class="hidden-sm hidden-md hidden-lg">
                    <tr>
                      <th style="font-size: 66%">Regimen</th>
                      <th style="font-size: 66%">Nombre</th>
                      <th style="font-size: 66%">Acción</th>
                    </tr>
                  </tfoot>
                  <tbody class="hidden-sm hidden-md hidden-lg">
                    @foreach($data as $item)
                      <tr class="item{{ $item->id_dias_desc }}">
                        <td style="font-size: 66%">{{ $item->regimen }}</td>
                        <td style="font-size: 66%">{{ $item->nombre }}</td>
                        <td>
                          <form action="{{ route('dias.destroy', $item->id_dias_desc) }}" method="GET">
                            <a href="{{ route('dias.edit', $item->id_dias_desc) }}" class="btn btn-primary btn-sm modificar" style="background-color: #DD4B39;border-color: #DD4B39;font-size: 62%" value="Modificar"><i class="fa far fa-edit"></i></a>

                            @csrf
                              @method('DELETE')
                            <a id="submit" href="{{ route('dias.destroy', $item->id_dias_desc) }}" name="submit" class="btn btn-danger btn-sm"  value="Eliminar" style="background-color: #444242;border-color: #444242;font-size: 62%"><i class="fa fa-trash"></i></a> 
                          </form>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
                @if($count[0]->contador == 1)
                <div class="container">
                  <div class="row">
                    <div class="col-md-3 ">
                      <a href="{{ route('dias_descontados_registro') }}" class="btn btn-primary" style="background-color: #DD4B39;border-color: #DD4B39;font-size: 90%"><i class="far fa-calendar-alt"></i> Registrar Dias Descontados</a>
                    </div>
                  </div>
              </div>
              @endif
          </div>
        </div>
	    </section>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('datatables/dataTables.bootstrap4.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sb-admin.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js-proyect/admin/proyectos/configuracion_tablas.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection
