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
          <li class="active"><a href="{{ route('administracion_usuarios') }}"><i class="far fa-circle"></i> Administración Usuarios</a></li>
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
		      		<a style="color :#DD4B39;" href="{{ route('principal') }}">SSOMAC</a>
		    	</li>
		    	<li class="breadcrumb-item active">Administración Usuarios</li>
		  	</ol>

		  	<div class="box">
			  		<div class="box-header">
			  			<h3 class="box-title"><i class="fas fa-users-cog"></i> Listado Usuarios</h3>
			  		</div>
			  		<div class="box-body">
			  			<table class="table  table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
			            <thead class="thead-dark hidden-xs hidden-sm hidden-md">
			              <tr>
			              	<th style="font-size: 90%">Nombre</th>
			                <th style="font-size: 90%">Perfil</th>
			                <th style="font-size: 90%">E-Mail</th>
			                <th style="font-size: 90%">Estado</th>
			                <th style="font-size: 90%">Acción</th>
			              </tr>
			            </thead>
			            <tfoot class="thead-dark  hidden-xs hidden-sm hidden-md">
			              <tr>
			              	<th style="font-size: 90%">Nombre</th>
			                <th style="font-size: 90%">Perfil</th>
			                <th style="font-size: 90%">E-Mail</th>
			                <th style="font-size: 90%">Estado</th>
			                <th style="font-size: 90%">Acción</th>
			              </tr>
			            </tfoot>
			            <tbody class="hidden-xs hidden-sm hidden-md">
			            	@foreach($app as $tabla_user)
			              	<tr class="{{ $tabla_user->id_aplicacion_usuario }}">
			              		<td style="@if($tabla_user->estado == 1)font-size: 80%@elseif($tabla_user->estado==0)font-size: 80%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->name }}</td>
			                	<td style="@if($tabla_user->estado == 1)font-size: 80%@elseif($tabla_user->estado==0)font-size: 80%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->nombre_rol }}</td>
			                	<td style="@if($tabla_user->estado == 1)font-size: 80%@elseif($tabla_user->estado==0)font-size: 80%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->username }}</td>
			                	<td style="@if($tabla_user->estado == 1)font-size: 80%@elseif($tabla_user->estado==0)font-size: 80%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->estado_sesion }}</td>
			                	<td>
			                		@if($tabla_user->estado == 0 && $tabla_user->estado_validacion == 1)
			                		<a href="{{ route('states_usuarios',$tabla_user->id_aplicacion_usuario) }}" class="btn btn-success btn-sm modificar" value="Activar" style="font-size: 90%;"><i class="fas fa-user-check"></i> ACTIVAR</a>
			                		@elseif($tabla_user->estado == 1 && $tabla_user->estado_validacion == 1)
			                		<a href="{{ route('states_usuarios',$tabla_user->id_aplicacion_usuario) }}" class="btn btn-danger btn-sm modificar" value="Inactivar" style="font-size: 80%;"><i class="fas fa-user-times"></i> INACTIVAR</a>
			                		@endif
                          <a href="#" onclick="editUser({{ $tabla_user->id_aplicacion_usuario}});" class="btn btn-success btn-sm modificar" data-toggle="modal" data-target="#modal-default" value="Modificar" style="font-size: 90%;"><i class="fas fa-pencil-alt"></i></a>
			                	</td>
			              	</tr>
			              	@endforeach
			            </tbody>
                  <thead class="thead-dark hidden-xs hidden-sm hidden-lg">
                    <tr>
                      <th style="font-size: 85%">Nombre</th>
                      <th style="font-size: 85%">Perfil</th>
                      <th style="font-size: 85%">E-Mail</th>
                      <th style="font-size: 85%">Estado</th>
                      <th style="font-size: 85%">Acción</th>
                    </tr>
                  </thead>
                  <tfoot class="thead-dark  hidden-xs hidden-sm hidden-lg">
                    <tr>
                      <th style="font-size: 85%">Nombre</th>
                      <th style="font-size: 85%">Perfil</th>
                      <th style="font-size: 85%">E-Mail</th>
                      <th style="font-size: 85%">Estado</th>
                      <th style="font-size: 85%">Acción</th>
                    </tr>
                  </tfoot>
                  <tbody class="hidden-xs hidden-sm hidden-lg">
                    @foreach($app as $tabla_user)
                      <tr class="{{ $tabla_user->id_aplicacion_usuario }}">
                        <td style="@if($tabla_user->estado == 1)font-size: 80%@elseif($tabla_user->estado==0)font-size: 80%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->name }}</td>
                        <td style="@if($tabla_user->estado == 1)font-size: 80%@elseif($tabla_user->estado==0)font-size: 80%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->nombre_rol }}</td>
                        <td style="@if($tabla_user->estado == 1)font-size: 80%@elseif($tabla_user->estado==0)font-size: 80%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->username }}</td>
                        <td style="@if($tabla_user->estado == 1)font-size: 80%@elseif($tabla_user->estado==0)font-size: 80%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->estado_sesion }}</td>
                        <td>
                          @if($tabla_user->estado == 0 && $tabla_user->estado_validacion == 1)
                          <a href="{{ route('states_usuarios',$tabla_user->id_aplicacion_usuario) }}" class="btn btn-success btn-sm modificar" value="Activar" style="font-size: 90%;"><i class="fas fa-user-check"></i> ACTIVAR</a>
                          @elseif($tabla_user->estado == 1 && $tabla_user->estado_validacion == 1)
                          <a href="{{ route('states_usuarios',$tabla_user->id_aplicacion_usuario) }}" class="btn btn-danger btn-sm modificar" value="Inactivar" style="font-size: 80%;"><i class="fas fa-user-times"></i> INACTIVAR</a>
                          @endif
                          <a  href="#"  class="btn btn-success btn-sm modificar" data-toggle="modal" data-target="#modal-default" value="Modificar" style="font-size: 90%;"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                  <thead class="thead-dark hidden-xs hidden-md hidden-lg">
                    <tr>
                      <th style="font-size: 78%">Nombre</th>
                      <th style="font-size: 78%">Perfil</th>
                      <th style="font-size: 78%">E-Mail</th>
                      <th style="font-size: 78%">Estado</th>
                      <th style="font-size: 78%">Acción</th>
                    </tr>
                  </thead>
                  <tfoot class="thead-dark  hidden-xs hidden-md hidden-lg">
                    <tr>
                      <th style="font-size: 78%">Nombre</th>
                      <th style="font-size: 78%">Perfil</th>
                      <th style="font-size: 78%">E-Mail</th>
                      <th style="font-size: 78%">Estado</th>
                      <th style="font-size: 78%">Acción</th>
                    </tr>
                  </tfoot>
                  <tbody class="hidden-xs hidden-md hidden-lg">
                    @foreach($app as $tabla_user)
                      <tr class="{{ $tabla_user->id_aplicacion_usuario }}">
                        <td style="@if($tabla_user->estado == 1)font-size: 70%@elseif($tabla_user->estado==0)font-size: 70%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->name }}</td>
                        <td style="@if($tabla_user->estado == 1)font-size: 70%@elseif($tabla_user->estado==0)font-size: 70%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->nombre_rol }}</td>
                        <td style="@if($tabla_user->estado == 1)font-size: 70%@elseif($tabla_user->estado==0)font-size: 70%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->username }}</td>
                        <td style="@if($tabla_user->estado == 1)font-size: 70%@elseif($tabla_user->estado==0)font-size: 70%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->estado_sesion }}</td>
                        <td>
                          @if($tabla_user->estado == 0 && $tabla_user->estado_validacion == 1)
                          <a href="{{ route('states_usuarios',$tabla_user->id_aplicacion_usuario) }}" class="btn btn-success btn-sm modificar" value="Activar" style="font-size: 90%;"><i class="fas fa-user-check"></i></a>
                          @elseif($tabla_user->estado == 1 && $tabla_user->estado_validacion == 1)
                          <a href="{{ route('states_usuarios',$tabla_user->id_aplicacion_usuario) }}" class="btn btn-danger btn-sm modificar" value="Inactivar" style="font-size: 80%;"><i class="fas fa-user-times"></i></a>
                          @endif
                          <a  href="#"  class="btn btn-success btn-sm modificar" data-toggle="modal" data-target="#modal-default" value="Modificar" style="font-size: 90%;"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                  <thead class="thead-dark hidden-sm hidden-md hidden-lg">
                    <tr>
                      <th style="font-size: 70%">Nombre</th>
                      <th style="font-size: 70%">Perfil</th>
                      <th style="font-size: 70%">E-Mail</th>
                      <th style="font-size: 70%">Estado</th>
                      <th style="font-size: 70%">Acción</th>
                    </tr>
                  </thead>
                  <tfoot class="thead-dark  hidden-sm hidden-md hidden-lg">
                    <tr>
                      <th style="font-size: 70%">Nombre</th>
                      <th style="font-size: 70%">Perfil</th>
                      <th style="font-size: 70%">E-Mail</th>
                      <th style="font-size: 70%">Estado</th>
                      <th style="font-size: 70%">Acción</th>
                    </tr>
                  </tfoot>
                  <tbody class="hidden-sm hidden-md hidden-lg">
                    @foreach($app as $tabla_user)
                      <tr class="{{ $tabla_user->id_aplicacion_usuario }}">
                        <td style="@if($tabla_user->estado == 1)font-size: 62%@elseif($tabla_user->estado==0)font-size: 62%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->name }}</td>
                        <td style="@if($tabla_user->estado == 1)font-size: 62%@elseif($tabla_user->estado==0)font-size: 62%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->nombre_rol }}</td>
                        <td style="@if($tabla_user->estado == 1)font-size: 62%@elseif($tabla_user->estado==0)font-size: 62%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->username }}</td>
                        <td style="@if($tabla_user->estado == 1)font-size: 62%@elseif($tabla_user->estado==0)font-size: 62%;font-weight:bold;color:#DD4B39;@endif">{{ $tabla_user->estado_sesion }}</td>
                        <td>
                          @if($tabla_user->estado == 0 && $tabla_user->estado_validacion == 1)
                          <a href="{{ route('states_usuarios',$tabla_user->id_aplicacion_usuario) }}" class="btn btn-success btn-sm modificar" value="Activar" style="font-size: 90%;"><i class="fas fa-user-check"></i></a>
                          @elseif($tabla_user->estado == 1 && $tabla_user->estado_validacion == 1)
                          <a href="{{ route('states_usuarios',$tabla_user->id_aplicacion_usuario) }}" class="btn btn-danger btn-sm modificar" value="Inactivar" style="font-size: 80%;"><i class="fas fa-user-times"></i></a>
                          @endif
                          <a  href="#"  class="btn btn-success btn-sm modificar" data-toggle="modal" data-target="#modal-default" value="Modificar" style="font-size: 90%;"><i class="fas fa-pencil-alt"></i></a>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
			          </table>
                <button type="button" class="btn btn-danger" style="border-color: #d31a2b;" data-toggle="modal" data-target="#modal-default"><i class="fas fa-user-plus"></i> Registrar Usuarios</button>
			  		</div>
					 <br/>
			  	</div>
          <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header" style="background-color: #d33724 !important;color: #ffffff">
                    <button type="button" class="close" data-dismiss="modal" onclick="cancelar();" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Registrar Usuarios</h4>
                  </div>
                <form method="post" action="/administracion_usuarios/grabarUsuariosNew">
                  @csrf
                  <div class="modal-body">
                    <div class="form-grou row">
                      <div class="align-self-center col col-md-9 col-lg-9 col-sm-12 col-xs-12">
                        <label for="inputEmail">E-Mail Corporativo</label>
                        <input type="text" class="form-control col-md-9 col-lg-9 col-sm-12 col-xs-12 " id="inputEmail" required="true" name="inputEmail" placeholder="ejemplo@flesan.com.pe">
                         
                      </div>
                      <div class="align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
                       <a class="btn btn-danger col-md-4 col-lg-4 col-sm-12 col-xs-12" style="background-color: #ffffff;color:#d31a2b;margin-top: 24px;" onclick="buscarUser()"><i class="fas fa-search"></i> </a>
                      </div>
                    </div>
                    <div class="form-grou row">
                      <div class="align-self-center col col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <label id="mensaje" style="color: #d31a2b;display: none" >No hay usuarios encontrados</label>
                      </div>
                    </div>
                    <div class="form-grou row">
                      <div class=" align-self-center col col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <label for="inputEmpresa" >Empresa</label>
                        <input type="text" class="form-control" id="inputEmpresa" min="0" readonly="true" name="inputEmpresa" placeholder="Empresa Grupo Flesan">
                        <input type="text" class="form-control" id="idEmpresa" style="display: none" min="0" readonly="true" name="idEmpresa" placeholder="id">
                      </div>
                    </div>
                    <br>
                    <div class="form-grou row">
                      <div class=" align-self-center col col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <label for="inputNombres">Nombres</label>
                        <input type="text" class="form-control" id="inputNombres" readonly="true" required="true" name="inputNombres" placeholder="Nombres Completos">
                      </div>
                      <div class=" align-self-center col col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <label for="inputApellidos">Apellidos</label>
                        <input type="text" class="form-control" id="inputApellidos" readonly="true" required="true"  name="inputApellidos" placeholder="Apellidos Completos">
                      </div>
                    </div>
                    <br>
                    <div class="form-grou row">
                      <div class=" align-self-center col col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <label for="inputDni" id="lblDni" name="lblDni">DNI/CARNET EXTRANJERIA</label>
                        <input type="number" class="form-control" id="inputDni" min="0" readonly="true" name="inputDni" placeholder="Documento Nac. Identidad">
                      </div>
                      <div class=" align-self-center col col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <label for="selectPerfil">Perfil</label>
                          <select id="selectPerfil" required="true" name="selectPerfil" class="form-control" autofocus="autofocus">
                            <option value="-1" required="true" selected>Seleccione Perfil</option>
                              @foreach($perfil as $perf)
                              <option  style="font-size: 90%" value="{{ $perf->id_rol }}">{{ $perf->nombre }}</option>
                              @endforeach
                          </select>
                      </div>
                    </div>
                    <br>
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-danger" id="btnGrabar"><a href="{{ route('grabar_usuarios') }}" style="color:#ffffff"><i class="fas fa-user-plus"></i></a> Guardar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
			 </section>
	    </div>
@endsection

@section('scripts')
    
    <script src="{{ asset('datatables.net/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('datatables.net-bs/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js-proyect/admin/proyectos/configuracion_tablas.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js-proyect/admin/proyectos/registro_user.js') }}"></script>
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('css/table_dark.css') }}" rel="stylesheet" type="text/css">
@endsection
