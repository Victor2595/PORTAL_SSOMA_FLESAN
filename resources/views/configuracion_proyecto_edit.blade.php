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
		    	<li class="breadcrumb-item">
		    		<a style="color :#DD4B39;" href="{{ route('configuracion_proyecto') }}">Configuración de Proyecto</a>
		    	</li>
		    	<li class="breadcrumb-item active">Editar Configuración</li>
		  	</ol>
		  	<div class="row">
		  		<div class="col-md-12">
		  			<div class="box box-danger">
				  		<div class="box-header with-border" style="margin-bottom: 0" >
				  			<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 0">
				  				<div class="col col-md-9 col-lg-9 col-sm-9 col-xs-10">
				  				<h3 class="box-title"><i class="glyphicon glyphicon-wrench"></i>  Modificar Proyectos</h3>
				  				</div>
				  				<form method="post" action="/configuracion_proyecto/{{ $config_proyecto->id_proyecto }}/save_sincronizar" >
	  							@csrf
					  				<div class=" col col-md-3 col-lg-3 col-sm-2 col-xs-6 hidden-xs hidden-sm">
					  					<button class="btn btn-danger pull-right" style="background-color: #ffffff;border-color: #d31a2b;color:#d31a2b;font-size: 75%"><a  href="{{ route('save_sincronizar',$config_proyecto->id_proyecto) }}" onclick="sincronize({{  $config_proyecto->id_proyecto}})"><i class="fa fas fa-sync"></i></a> Sincronizar</button>
					  				</div>
					  				<div class=" col col-md-3 col-lg-3 col-sm-2 col-xs-6 hidden-sm hidden-md hidden-lg">
					  					<a class="btn btn-danger " style="background-color: #ffffff;border-color: #d31a2b;color:#d31a2b;font-size: 75%" onclick="sincronize({{  $config_proyecto->id_proyecto}})"><i class="fa fas fa-sync"></i>  Sincronizar</a>
					  				</div>
					  				<div class=" col col-md-3 col-lg-3 col-sm-4 col-xs-6 hidden-xs hidden-md hidden-lg">
					  					<a class="btn btn-danger" style="background-color: #ffffff;border-color: #d31a2b;color:#d31a2b;font-size: 75%;margin-right: 10%" onclick="sincronize({{  $config_proyecto->id_proyecto}})"><i class="fa fas fa-sync"></i>  Sincronizar</a>
					  				</div>
				  				</form>
				  				@if($config_proyecto->fecha_sincronize !== null)
				  				<small class="text-muted pull-right" name="fecha_sincronize" id="fecha_sincronize" style="margin-right: 1%;color :#DD4B39;" ><i class="fa fa-clock-o"></i> {{ $config_proyecto->fecha_sincronize }}</small>
				  				@endif
				  			</div>
				  		</div>
				  		<form method="post" action="/configuracion_proyecto/{{ $config_proyecto->id_proyecto }}/updateConfiguraciónProyecto" >
	  					@csrf
		  					<div class="box-body">
				  				<div class="form-group row" style="margin-left: 0;margin-right: 0">
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="selectUN1">Empresa</label>
								      	<select id="selectUN1" name="selectUN1" class="form-control">
								      		<option  value="-1">Seleccione Empresa</option>
								        	@foreach($unidades as $unid) 
								        		@foreach($unidadesf as $unidf)
								        			@if($unid->COD_EMPRESA == $unidf->COD_EMPRESA)
								        				<option  value="{{ $unidf->COD_EMPRESA }} {{ old('selectUN1')==$unidf->COD_EMPRESA ? 'selected' : '' }}" selected >{{ $unidf->NOMBRE_EMPRESA }}</option>
								        			@else	
								        				<option  value="{{ $unid->COD_EMPRESA }} {{ old('selectUN1')==$unid->COD_EMPRESA ? 'selected' : '' }}">{{ $unid->NOMBRE_EMPRESA }}</option>
								        			@endif
								        		@endforeach
								      		@endforeach
								      	</select>
				  					</div>
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="selectProy1">Proyecto</label>
								      	<select id="selectProy1" name="selectProy1" class="form-control">
								      		<option value="-1">Seleccione Proyecto</option>
								      		@foreach($proyectos as $proy)
								      			@foreach($proyectosf as $proyf)
								      				@if($proy->id_proyecto == $proyf->id_proyecto)
								      				  	<option  value="{{ $proyf->id_proyecto }}  {{ old('selectProy1') == $proyf->id_proyecto ? 'selected' : '' }}" selected>{{ $proyf->descripcion_proyecto }}</option>
								        			@else	
								        				<option  value="{{ $proy->id_proyecto }} {{ old('selectProy1') == $proy->id_proyecto ? 'selected' : '' }}" >{{ $proy->descripcion_proyecto }}</option>
								      				@endif
								      			@endforeach
								      		@endforeach
								      	</select>
				  					</div>
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="inputTipoP1">Tipo Proyecto</label>
								      	<input type="text" readonly="true" class="form-control" id="inputTipoP1" value="{{ $config_proyecto->tipo_proyecto }}" name="inputTipoP1" placeholder="Tipo Proyecto">
				  					</div>
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<input type="hidden" id="selectJef1h" value="{{ $selectJef1h }}" name="selectJef1h" class="form-control"></input>

				  						<label for="selectJef1">Jefe SSOMA</label>
								      	<select id="selectJef1" name="selectJef1" class="form-control">
								        	<option value="-1">Seleccione Jefe</option>
								        	@foreach($jefes as $jefs)
								        		@foreach($jefe as $jef)
								        			@if($jefs->id_aplicacion_usuario == $jef->id_usuario)
								        				<option value="{{ $jef->id_usuario }}{{ old('selectJef1') == $jef->id_usuario ? 'selected' : '' }}" selected>{{ $jef->username }}</option>
								        			@else
								        				<option value="{{ $jefs->id_aplicacion_usuario }}{{ old('selectJef1') == $jefs->id_aplicacion_usuario ? 'selected' : '' }}">{{ $jefs->username }}</option>
								        			@endif
								        		@endforeach
								        	@endforeach
								      	</select>
				  					</div>
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="nombreProy1" style="display: none;">Proyecto</label>
								      	<input type="text" readonly="true"  value="{{ $config_proyecto->nombre_proyecto }} {{ old('nombreProy1') == $config_proyecto->nombre_proyecto ? 'selected' : '' }}" style="display: none;" class="form-control" id="nombreProy1" name="nombreProy1" placeholder="Nombre Proyecto">
								      	<input type="text" readonly="true"  style="display: none;"  value="{{ $config_proyecto->codigo_proyecto }} {{ old('idproy') }}"  class="form-control" id="idproy1" name="idproy1" placeholder="id Proyecto" >
				  					</div>
				  				</div>
				  				<div class="form-group row" style="margin-left: 0;margin-right: 0">
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="inputGerente1" >Gerente Proyecto</label>
						      			<input type="text" readonly="true" class="form-control" id="inputGerente1" name="inputGerente1" value="{{ $config_proyecto->gerente_proyecto }}" placeholder="Gerente Proyecto">
				  					</div>
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="inputResidente1">Residente Proyecto</label>
						      			<input type="text" readonly="true" class="form-control" value="{{ $config_proyecto->residente_obra }}" id="inputResidente1" name="inputResidente1" placeholder="Residente Proyecto">
				  					</div>
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="inputCliente1">Cliente</label>
						      			<input type="text" readonly="true" class="form-control" id="inputCliente1" value="{{ $config_proyecto->cliente }}" name="inputCliente1" placeholder="Cliente Proyecto">
				  					</div>
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="inputValor1">Valor Contrato $</label>
						      			<input type="text"  readonly="true" class="form-control" value="{{ $config_proyecto->valor_contrato }}" name="inputValor1" id="inputValor1" placeholder="$ Valor Contrato ">
				  					</div>
				  				</div>
				  				<div class="form-group row" style="margin-left: 0;margin-right: 0">
				  					<div class=" align-self-center col col-md-12 col-lg-12 col-sm-12 col-xs-12">
				  						<label for="areaAlcance1">Alcance del Proyecto</label>
							    		<textarea class="form-control" id="areaAlcance1" name="areaAlcance1" readonly="true" rows="9">{{ $config_proyecto->alcance_proyecto }}</textarea>
				  					</div>
				  				</div>
				  				<div class="form-group row" style="margin-left: 0;margin-right: 0">
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="inputFechaI1">Fecha Inicio Proyecto</label>
						      			<input type="date" class="form-control" value="{{ $config_proyecto->fecha_inicio }}" id="inputFechaI1" name="inputFechaI1" placeholder="Fecha Inicio Proyecto">
				  					</div>
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="inputFechaF1">Fecha Fin Proyecto</label>
						      			<input type="date" class="form-control" value="{{ $config_proyecto->fecha_fin }}" id="inputFechaF1" name="inputFechaF1" placeholder="Fecha Fin Proyecto">
				  					</div>
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="inputMetasH1">Metas Hombre</label>
						      			<input type="number" min="0" class="form-control" value="{{ $config_proyecto->metas_hombre }}" required="required" id="inputMetasH1" name="inputMetasH1" placeholder="N° Horas">
				  					</div>
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="selectRegimen1">Regimen</label>
								      	<select id="selectRegimen1"name="selectRegimen1" class="form-control">
								        	@if($config_proyecto->regimen == 1)
									        	<option value="-1">--Seleccione--</option>
										        <option value="1" selected>Construcción</option>
										        <option value="2">Minería</option>
										    @elseif($config_proyecto->regimen == 2)
										        <option value="-1">--Seleccione--</option>
										        <option value="1">Construcción</option>
										        <option value="2" selected>Minería</option>
										    @else
										        <option value="-1" selected>--Seleccione--</option>
										        <option value="1">Construcción</option>
										        <option value="2">Minería</option>
									        @endif
								      	</select>
				  					</div>
				  				</div>
				  				<div class="form-group row" style="margin-left: 0;margin-right: 0">
				  					<div class=" align-self-center col col-md-3 col-lg-3 col-sm-12 col-xs-12">
				  						<label for="inputFactor1">Factor Indicador Especifico</label>
						      			<input type="text" readonly="true" value="{{ $config_proyecto->factor_indicador_especifico_obra }}" class="form-control" id="inputFactor1" name="inputFactor1" placeholder="Factor Indicador Especifico ">
				  					</div>
				  				</div>
				  				<div class="form-group row" style="margin-left: 0;margin-right: 0">
				  					<div class=" align-self-center col col-md-4 col-lg-4 col-sm-12 col-xs-12">
				  						<button class="btn btn-danger"><a href="{{ route('update_configurar_proyecto',$config_proyecto->id_proyecto) }}" style="color:#ffffff"><i class="far fa-save"></i></a> Actualizar</button>
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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script type="text/javascript" src="{{ asset('js-proyect/admin/proyectos/proyectos_edit.js') }}"></script>
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection
