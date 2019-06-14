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
      <li class="active treeview">
        <a href="#">
          <i class="fa fas fa-cogs"></i> <span> Administración</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('administracion_usuarios') }}"><i class="far fa-circle"></i> Administración Usuarios</a></li>
          <li class="active"><a href="{{ route('configuracion_proyecto') }}"><i class="far fa-circle"></i> Configuración de Proyecto</a></li>
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
          <li><a href="{{ route('dashboards') }}"><i class="far fa-circle"></i> DashBoards</a></li>-->li>
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
	      		<a style="color :#DD4B39;" href="{{ route('principal') }}">SSOMA</a>
	    	</li>
	    	<li class="breadcrumb-item">
	    		<a style="color :#DD4B39;" href="{{ route('configuracion_proyecto') }}">Configuración de Proyecto</a>
	    	</li>
	    	<li class="breadcrumb-item active">Registrar Configuración</li>
	  	</ol>
	  	
	  	<div class="row">
	  		
	  		<div class="col-md-12">
	  			<div class="box box-danger">
			  		<div class="box-header with-border" >
			  			<h3 class="box-title"><i class="glyphicon glyphicon-wrench"></i>  Configuración Proyectos</h3>
			  		</div>
			  		<form method="post" action="/configuracion_proyecto_registro/grabarConfiguraciónProyecto">
  					@csrf
			  			<div class="box-body">
			  				<div class="form-group row" style="margin-left: 0;margin-right: 0">
			  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
			  						<label for="selectUN">Empresa</label>
							      	<select id="selectUN" required="required" name="selectUN" class="form-control" autofocus="autofocus">
							        	<option value="-1" selected>Seleccione Empresa</option>
							        	@foreach($unidades as $unid) 
							        			<option  style="font-size: 90%" value="{{ $unid->COD_EMPRESA }}" {{ old('selectUN')==$unid->COD_EMPRESA ? 'selected' : '' }}>{{ $unid->NOMBRE_EMPRESA }}</option>
							      		@endforeach
							      	</select>
			  					</div>
			  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
			  						<label for="selectProy">Proyecto</label>
							      	<select id="selectProy" disabled="true" required="required" name="selectProy" class="form-control">
							      		<option value="-1">Seleccione Proyecto</option>
							      	</select>
			  					</div>
			  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
			  						<label for="inputTipoP">Tipo Proyecto</label>
							      	<input type="text" readonly="true" class="form-control" id="inputTipoP" value="{{ old('inputTipoP') }}" name="inputTipoP" placeholder="Tipo Proyecto">
			  					</div>
				  				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  					<label for="selectJef">Jefe SSOMA</label>
							      	<select id="selectJef" required="required" name="selectJef" class="form-control">
							        	<option value="-1" selected>Seleccione Jefe</option>
							      	</select>
				  				</div>
				  				<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
			  						<label for="nombreProy" style="display: none;">Proyecto</label>
								    <input type="text" readonly="true" style="display: none;"  value="{{ old('nombreProy') }}"  class="form-control" id="nombreProy" name="nombreProy" placeholder="Nombre Proyecto" >
								     <input type="text" readonly="true" style="display: none;"  value="{{ old('idproy') }}"  class="form-control" id="idproy" name="idproy" placeholder="id Proyecto" >
			  					</div>
				  			</div>
				  			<div class="form-group row" style="margin-left: 0;margin-right: 0">
				  				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  					<label for="inputGerente">Gerente Proyecto</label>
							      	<input type="text" readonly="true" class="form-control" id="inputGerente" value="{{ old('inputGerente') }}" name="inputGerente" placeholder="Gerente Proyecto">
				  				</div>
				  				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  					<label for="inputResidente">Residente Proyecto</label>
							      	<input type="text" readonly="true" class="form-control" id="inputResidente"  value="{{ old('inputResidente') }}" name="inputResidente" placeholder="Residente Proyecto">
				  				</div>
				  				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  					<label for="inputCliente">Cliente</label>
							      	<input type="text" readonly="true" class="form-control" id="inputCliente"  value="{{ old('inputCliente') }}" name="inputCliente" placeholder="Cliente Proyecto">
				  				</div>
				  				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  					<label for="inputValor">Valor Contrato $</label>
							      	<input type="text" readonly="true" class="form-control"  value="{{ old('inputValor') }}" name="inputValor" id="inputValor" placeholder="$ Valor Contrato ">
				  				</div>
				  			</div>
				  			<div class="form-group row" style="margin-left: 0;margin-right: 0">
				  				<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
				  					<label for="areaAlcance">Alcance del Proyecto</label>
								    <textarea class="form-control" id="areaAlcance" name="areaAlcance" readonly="true" rows="9">{{ old('areaAlcance') }}</textarea>
				  				</div>
				  			</div>
				  			<div class="form-group row" style="margin-left: 0;margin-right: 0">
				  				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  					<label for="inputFechaI">Fecha Inicio Proyecto</label>
							      	<input type="date" class="form-control" id="inputFechaI"  value="{{ old('inputFechaI') }}" name="inputFechaI" placeholder="Fecha Inicio Proyecto">
				  				</div>
				  				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  					<label for="inputFechaF">Fecha Fin Proyecto</label>
							      	<input type="date" class="form-control" id="inputFechaF" value="{{ old('inputFechaF') }}"  name="inputFechaF" placeholder="Fecha Fin Proyecto">
				  				</div>
				  				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  					<label for="inputMetasH">Metas Hombre</label>
							     	<input type="number" min="0" class="form-control" required="required" id="inputMetasH" name="inputMetasH" value="{{ old('inputMetasH') }}" placeholder="N° Horas">
				  				</div>
				  				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  					<label for="selectRegimen">Regimen</label>
							      	<select id="selectRegimen" name="selectRegimen"  required="required" class="form-control">
							        	<option value="-1" {{ old('selectRegimen')==-1 ? 'selected' : '' }} selected>--Seleccione--</option>
							        	<option value="1" {{ old('selectRegimen')==1 ? 'selected' : '' }} >Construcción</option>
							        	<option value="2" {{ old('selectRegimen')==2 ? 'selected' : '' }}>Minería</option>
							      	</select>
				  				</div>
				  			</div>
				  			<div class="form-group row" style="margin-left: 0;margin-right: 0">
				  				<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  					<label for="inputFactor">Factor Indicador Especifico</label>
							      	<input type="text" readonly="true" class="form-control" id="inputFactor" name="inputFactor" value="{{ old('inputFactor') }}" placeholder="Factor Indicador Especifico ">
				  				</div>
				  			</div>
				  			<div class="form-group row" style="margin-left: 0;margin-right: 0">
				  				<div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
				  					<button class="btn btn-danger"><a href="{{ route('grabar_configurar_proyecto') }}" style="color:#ffffff"><i class="far fa-save"></i></a> Grabar</button>
				  				</div>
				  			</div>
			  			</div>
  					</form>	
			  	</div>
  			</div>
	  	</div>
	</section>
</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js-proyect/admin/proyectos/proyectos.js') }}"></script>
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection
