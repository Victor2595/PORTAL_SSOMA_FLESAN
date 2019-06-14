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
	      		<a href="{{ route('principal') }}">SSOMA</a>
	    	</li>
	    	<li class="breadcrumb-item">
	    		<a href="{{ route('dias_descontados') }}">Dias Descontados</a>
	    	</li>
	    	<li class="breadcrumb-item active">Editar Días Descontados</li>
	  	</ol>
	  	<div class="box box-danger">
	  		<div class="box-header with-border" >
	  			<h3 class="box-title"><i class="glyphicon glyphicon-calendar"></i>  Días Descontados/Debitados</h3>
	  		</div>
	  		<div class="box-body">
			  	<form method="post" action="/dias_descontados_registro/updateDiasDescontados/{{ $dat[0]->id_dias_desc }}">
			  	@csrf
			  		<div class="row">
			  			<div class="col-md-3 col-lg-3">
			  				<label for="selectJef">Regimen</label>
					      	<div class="row">
						      	<div class="col-md-9 col-sm-9">	
						      		@foreach($dat as $item)
							      	<select id="selectRegimen1" autofocus="autofocus" name="selectRegimen1" required="true" class="form-control">
							        	
								        	@if($dat[0]->regimen == 1)
								        	<option value="-1">--Seleccione--</option>
									        <option value="1" selected>Construcción</option>
									        <option value="2">Minería</option>
									        @elseif($dat[0]->regimen == 2)
									        <option value="-1">--Seleccione--</option>
									        <option value="1">Construcción</option>
									        <option value="2" selected>Minería</option>
									        @else
									        <option value="-1" selected>--Seleccione--</option>
									        <option value="1">Construcción</option>
									        <option value="2">Minería</option>
								        	@endif
							      	</select>
							      	@endforeach
							    </div>
				  			</div>
			  			</div>
			  		</div>
			  		<br>
			  		<div class="row">
			        	<div class="col-md-9 col-sm-9">
			          		<div role="tabpanel">
				            	<ul class="nav nav-tabs"role="tablist">
				              		<li class="nav-item active" >
				              			<a class="nav-link active hidden-md hidden-xs hidden-sm" href="#tabRegistro1" aria-controls="tabRegistro1" data-toggle="tab" role="tab" tabindex="-1">MUERTE E INCAPACIDAD TOTAL PERMANENTE</a>
				              		</li>
				              		<li class="nav-item">
				              			<a class="nav-link hidden-md hidden-xs hidden-sm" href="#tabRegistro2" aria-controls="tabRegistro2" data-toggle="tab" role="tab" tabindex="-1">INCAPACIDAD PARCIAL PERMANENTE</a>
				              		</li>
				              		<li class="nav-item active" >
				              			<a class="nav-link active hidden-sm hidden-xs hidden-lg" href="#tabRegistro1" aria-controls="tabRegistro1" data-toggle="tab" role="tab" tabindex="-1" style="font-size: 67%">MUERTE E INCAPACIDAD TOTAL PERMANENTE</a>
				              		</li>
				              		<li class="nav-item">
				              			<a class="nav-link hidden-sm hidden-xs hidden-lg" href="#tabRegistro2" aria-controls="tabRegistro2" data-toggle="tab" role="tab" tabindex="-1" style="font-size: 67%">INCAPACIDAD PARCIAL PERMANENTE</a>
				              		</li>
				              		<li class="nav-item active" >
				              			<a class="nav-link active hidden-md hidden-xs hidden-lg" href="#tabRegistro1" aria-controls="tabRegistro1" data-toggle="tab" role="tab" tabindex="-1" style="font-size: 70%">MUERTE E INCAPACIDAD TOTAL PERMANENTE</a>
				              		</li>
				              		<li class="nav-item">
				              			<a class="nav-link hidden-md hidden-xs hidden-lg" href="#tabRegistro2" aria-controls="tabRegistro2" data-toggle="tab" role="tab" tabindex="-1" style="font-size: 70%">INCAPACIDAD PARCIAL PERMANENTE</a>
				              		</li>
				              		<li class="nav-item active" >
				              			<a class="nav-link active hidden-md hidden-sm hidden-lg" href="#tabRegistro1" aria-controls="tabRegistro1" data-toggle="tab" role="tab" tabindex="-1" style="font-size: 75%">MUERTE E ITP</a>
				              		</li>
				              		<li class="nav-item">
				              			<a class="nav-link hidden-md hidden-sm hidden-lg" href="#tabRegistro2" aria-controls="tabRegistro2" data-toggle="tab" role="tab" tabindex="-1" style="font-size: 75%">IPP</a>
				              		</li>
				            	</ul>
				            	<div class="tab-content">
			          				<div role="tabpanel" class="tab-pane active" id="tabRegistro1">
			            				<div class="form">
			            					<br/>
			            					<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-6 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 13px;color:#58595B">1. MUERTE</h9>
								    			</div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
									    		<div class="col-md-2 offset-md-1">
											      	<label for="inputMuerte" style="font-size: 80%;">Muerte</label>
											      	<input type="number" style="font-size: 90%;" autofocus="autofocus" name="inputMuerte" tabindex="1" required="required" min="0" class="form-control" value="{{ $dat[0]->descontado_muerte }}" id="inputMuerte" placeholder="N° Horas">
											    </div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<hr class="col-md-8 offset-md-1" style="margin-top: 0px;margin-bottom: 0px;">
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-8 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 13px;color:#58595B">2. INCAPACIDAD TOTAL PERMANENTE</h9>
								    			</div>
								    		</div>
								    		<div class="form-group row"  style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-8 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 11px;color:#939598">A. Lesiones que incapacitan total o permanentemente al trabajador para efectuar  cualquier clase de trabajo remunerado</h9>
								    			</div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
									    		<div class="form-group col-md-2 offset-md-1">
									    			<label for="inputLesion" style="font-size: 80%;">Lesión Incapacita Total</label>
										      		<input type="number" style="font-size: 90%;" required="required"  tabindex="2" value="{{ $dat[0]->descontado_lesion_permanente }}" min="0" name="inputLesion" class="form-control" id="inputLesion" placeholder="N° Horas">
									    		</div>
									    	</div>
									    	<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-8 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 11px;color:#939598">B. Lesiones que resulten en la pérdida anatómica o la pérdida funcional total de</h9>
								    			</div>
								    		</div>
									    	<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
									    		<div class="form-group col-md-2">
									    			<label for="inputOjos" style="font-size: 80%;">Ambos ojos</label>
										      		<input type="number" style="font-size: 90%;" required="required" value="{{ $dat[0]->descontado_ambos_ojos }}"tabindex="3" min="0" class="form-control" id="inputOjos" name="inputOjos" placeholder="N° Horas">
									    		</div>
									    		<div class="form-group col-md-2">
									    			<label for="inputBrazos" style="font-size: 80%;">Ambos brazos</label>
										      		<input type="number" style="font-size: 90%;" min="0" required="required" value="{{ $dat[0]->descontado_ambos_brazos }}"  tabindex="4" class="form-control" id="inputBrazos" name="inputBrazos" placeholder="N° Horas">
									    		</div>
									    		<div class="form-group col-md-2">
									    			<label for="inputPiernas" style="font-size: 80%;">Ambas piernas</label>
										      		<input type="number" style="font-size: 90%;" min="0" class="form-control" tabindex="5" value="{{ $dat[0]->descontado_ambas_piernas }}" id="inputPiernas" required="required" name="inputPiernas" placeholder="N° Horas">
									    		</div>
									    		<div class="form-group col-md-2">
									    			<label for="inputManos" style="font-size: 80%;">Ambas manos</label>
										      		<input type="number" style="font-size: 90%;" min="0" class="form-control" tabindex="6" value="{{ $dat[0]->descontado_ambas_manos }}" id="inputManos" name="inputManos" required="required" placeholder="N° Horas">
									    		</div>
									    	</div>
									    	<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
									    		<div class="form-group col-md-2">
									    			<label for="inputPies" style="font-size: 80%;">Ambos pies</label>
										      		<input type="number" style="font-size: 90%;" min="0" class="form-control" value="{{ $dat[0]->descontado_ambos_pies }}" id="inputPies" tabindex="7" name="inputPies" required="required" placeholder="N° Horas">
									    		</div>
									    		<div class="form-group col-md-2">
									    			<label for="inputOjoBrazo" style="font-size: 80%;">Un ojo y un brazo</label>
										      		<input type="number" style="font-size: 90%;" min="0" class="form-control" value="{{ $dat[0]->descontado_ojo_brazo }}" id="inputOjoBrazo" tabindex="8" name="inputOjoBrazo" required="required" placeholder="N° Horas">
									    		</div>
									    		<div class="form-group col-md-2">
									    			<label for="inputOjoMano" style="font-size: 80%;">Un ojo y una mano</label>
										      		<input type="number" style="font-size: 90%;" min="0" value="{{ $dat[0]->descontado_ojo_mano }}" class="form-control" id="inputOjoMano" tabindex="9" name="inputOjoMano" required="required" placeholder="N° Horas">
									    		</div>
									    		<div class="form-group col-md-2">
									    			<label for="inputOjoPierna" style="font-size: 80%;">Un ojo y una pierna</label>
										      		<input type="number" style="font-size: 90%;" min="0" class="form-control" value="{{ $dat[0]->descontado_ojo_pierna }}" id="inputOjoPierna" tabindex="10" name="inputOjoPierna" required="required" placeholder="N° Horas">
									    		</div>
									    	</div>
									    	<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
									    		<div class="form-group col-md-2">
									    			<label for="inputOjoPie" style="font-size: 80%;">Un ojo y un pie</label>
										      		<input type="number" min="0" style="font-size: 90%;" value="{{ $dat[0]->descontado_ojo_pie }}" class="form-control" required="required" tabindex="11" id="inputOjoPie" name="inputOjoPie" placeholder="N° Horas">
									    		</div>
									    		<div class="form-group col-md-2">
									    			<label for="inputManoPierna" style="font-size: 80%;">Una mano y una pierna</label>
											      	<input type="number" min="0" style="font-size: 90%;" class="form-control" value="{{ $dat[0]->descontado_mano_pierna }}" id="inputManoPierna" tabindex="12" name="inputManoPierna" placeholder="N° Horas" required="required">
									    		</div>
									    		<div class="form-group col-md-2">
									    			<label for="inputManoPie" style="font-size: 80%;">Una mano y un pie</label>
										      		<input type="number" min="0" style="font-size: 90%;" value="{{ $dat[0]->descontado_mano_pie }}" class="form-control" id="inputManoPie" tabindex="13" required="required" name="inputManoPie" placeholder="N° Horas">
									    		</div>
									    	</div>
									    	<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
									    		<div class="col-md-8 offset-md-1">
									    			<h9 style="font-weight: bold;font-size: 10px;color:#BFBFBF">Siempre que no sea de la misma extremidad</h9>
									    		</div>
									    	</div>
									    	<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
									    		<div class="form-group col-md-2">
									    			<label for="inputBrazoMano" style="font-size: 80%;">Un brazo y una mano</label>
										      		<input type="number" min="0" style="font-size: 90%;" class="form-control" value="{{ $dat[0]->descontado_brazo_mano_dist_ext }}" required="required" tabindex="14" id="inputBrazoMano" name="inputBrazoMano" placeholder="N° Horas">
									    		</div>
									    		<div class="form-group col-md-2">
									    			<label for="inputPiernaPie" style="font-size: 80%;">Una pierna y un pie</label>
										      		<input type="number" min="0" style="font-size: 90%;" class="form-control" value="{{ $dat[0]->descontado_pierna_pie_dist_ext }}" id="inputPiernaPie" tabindex="15" required="required" name="inputPiernaPie" placeholder="N° Horas">
									    		</div>
									    	</div>
								    	</div>
								    </div>
								    <div role="tabpanel" class="tab-pane" id="tabRegistro2" >
			            				<div class="form">
			            					<br/>
			            					<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-6 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 14px;color:#58595B">3. INCAPACIDAD PARCIAL PERMANENTE </h9>
								    			</div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-8 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 12px;color:#939598">A. Lesiones que incapacitan total o permanentemente al trabajador para efectuar  cualquier clase de trabajo remunerado</h9>
								    			</div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-8 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 12px;color:#939598">a) Un brazo</h9>
								    			</div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
									    		<div class="form-group col-md-3">
									    			<label for="inputACodo" style="font-size: 80%;">Cualquier punto arriba del codo</label>
										      		<input type="number" style="font-size: 90%;" required="required" value="{{ $dat[0]->descontado_perdida_codo_hombro }}" min="0" tabindex="17" class="form-control" id="inputACodo" name="inputACodo" placeholder="N° Horas">
									    		</div>
									    		<div class="form-group col-md-3">
									    			<label for="inputAMuñeca" style="font-size: 80%;">Cualquier punto arriba de la muñeca</label>
										      		<input type="number" min="0" style="font-size:90%;" value="{{ $dat[0]->descontado_perdida_muneca_codo }}" required="required" tabindex="18" class="form-control" id="inputAMuñeca" name="inputAMuñeca" placeholder="N° Horas">
									    		</div>
									    	</div>
									    	<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-8 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 12px;color:#939598">b) Una pierna</h9>
								    			</div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: -10px;">
									    		<div class="form-group col-md-3">
									    			<label for="inputARodilla" style="font-size: 80%;">Cualquier punto arriba de la rodilla</label>
										      		<input type="number" min="0" style="font-size: 90%;" required="required" value="{{ $dat[0]->descontado_perdida_pierna_muslo }}" tabindex="19" class="form-control" id="inputARodilla" name="inputARodilla" placeholder="N° Horas">
									    		</div>
									    		<div class="form-group col-md-3">
									    			<label for="inputATobillo" style="font-size: 80%;">Cualquier punto arriba del tobillo</label>
										      		<input type="number" min="0" style="font-size: 90%;"  required="required" value="{{ $dat[0]->descontado_perdida_tobillo_rodilla }}" tabindex="20" class="form-control" id="inputATobillo" name="inputATobillo" placeholder="N° Horas">
									    		</div>
									    	</div>
									    	<div class="col-md-9">
												<div class="box box-solid">
													<div class="box-header with-border">
										              	<div class="col-md-8 offset-md-1">
										              		<h9 style="font-weight: bold;font-size: 12px;color:#939598">c) Mano, dedo pulgar y otros dedos de la mano</h9>
										              	</div>
										              	<div class="col-md-8 offset-md-1">
										              		<h9 style="font-weight: bold;font-size: 10px;color:#939598">Amputación de todo o parte del dedo</h9>
										            	</div>
										            </div>
										            <div class="box-body">
										            	<div class="box-group" id="accordion">
										            		<div class="panel box box-danger" style="border-top-color: #939598">
											    				<div class="box-header with-border" >
											    					<h7 class="box-title">
											    						<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="font-size: 80%;color: #939598"><i class="fa fas fa-chevron-down"></i> Tercer Falange(uña)</a>
											    					</h7>
											    				</div>
										    					<div id="collapseOne" class="panel-collapse collapse" >
										    						<div class="box-body">
										    							<div class="form-group row">
																    		<div class="col-md-2 offset-md-1">
																		      	<label for="input3FPulgar" style="font-size: 80%">Pulgar</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" tabindex="22" value="{{ $dat[0]->descontado_mano_dedos_tercer_falange_pulgar }}" class="form-control" id="input3FPulgar" name="input3FPulgar" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input3FIndice" style="font-size: 80%">Índice</label>
																		      	<input type="number" style="font-size: 90%" min="0" class="form-control" required="required" value="{{ $dat[0]->descontado_mano_dedos_primer_falange_indice }}" id="input3FIndice" name="input3FIndice" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input3FMedio" style="font-size: 80%">Medio</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" value="{{ $dat[0]->descontado_mano_dedos_tercer_falange_medio }}" id="input3FMedio" name="input3FMedio" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input3FAnular" style="font-size: 80%">Anular</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" value="{{ $dat[0]->descontado_mano_dedos_tercer_falange_anular }}" id="input3FAnular" name="input3FAnular" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input3FMeñique" style="font-size: 80%">Meñique</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" value="{{ $dat[0]->descontado_mano_dedos_tercer_falange_menique }}" id="input3FMeñique" name="input3FMeñique" placeholder="N° Dias">
																		    </div>
																		</div>
										    						</div>
										    					</div>
											    			</div>
											    			<div class="panel box box-danger" style="border-top-color: #939598">
											    				<div class="box-header with-border">
											    					<h7 class="box-title">
											    						<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" style="font-size: 80%;color: #939598"><i class="fa fas fa-chevron-down"></i> Segundo Falange(uña)</a>
											    					</h7>
											    				</div>
													    		<div id="collapseTwo" class="panel-collapse collapse"  >
																    <div class="box-body">
																    	<div class="form-group row">
																	    	<div class="col-md-2 offset-md-1">
																		      	<label for="input2FIndice" style="font-size: 80%">Índice</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input2FIndice" value="{{ $dat[0]->descontado_mano_dedos_segundo_falange_indice }}" name="input2FIndice" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input2FMedio" style="font-size: 80%">Medio</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input2FMedio" value="{{ $dat[0]->descontado_mano_dedos_segundo_falange_medio }}" name="input2FMedio" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input2FAnular" style="font-size: 80%">Anular</label>
																		      	<input type="number"  style="font-size: 90%" min="0" required="required" class="form-control" id="input2FAnular" value="{{ $dat[0]->descontado_mano_dedos_segundo_falange_anular }}" name="input2FAnular" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input2FMeñique" style="font-size: 80%">Meñique</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input2FMeñique" value="{{ $dat[0]->descontado_mano_dedos_segundo_falange_menique }}" name="input2FMeñique" placeholder="N° Dias">
																		    </div>
																		</div>
																    </div>
																</div>
												    		</div>
												    		<div class="panel box box-danger" style="border-top-color: #939598">
												    			<div class="box-header with-border">
												    				<h7 class="box-title">
												    					<a data-toggle="collapse" data-parent="#accordion" href="#collapseTres" style="font-size: 80%;color: #939598;"><i class="fa fas fa-chevron-down"></i> Primer Falange(próxima)</a>
												    				</h7>
												    			</div>
												    			<div id="collapseTres" class="panel-collapse collapse">
												    				<div class="box-body">
												    					<div class="form-group row">
																	    	<div class="col-md-2 offset-md-1">
																	    		<label for="input1FPulgar" style="font-size: 80%">Pulgar</label>
													      						<input type="number" min="0" required="required" class="form-control" id="input1FPulgar" style="font-size: 90%" value="{{ $dat[0]->descontado_mano_dedos_primer_falange_pulgar }}" name="input1FPulgar" placeholder="N° Dias">
																	    	</div>
																	    	<div class="col-md-2">
																	    		<label for="input1FIndice" class=>Índice</label>
												      							<input type="number" value="{{ $dat[0]->descontado_mano_dedos_primer_falange_indice }}" min="0" required="required" class="form-control" id="input1FIndice" name="input1FIndice" placeholder="N° Horas">
																	    		
																	    	</div>
																	    	<div class="col-md-2">
																	    		<label for="input1FMedio" style="font-size: 80%">Medio</label>
													      						<input type="number"  style="font-size: 90%" min="0" required="required" class="form-control" id="input1FMedio" value="{{ $dat[0]->descontado_mano_dedos_primer_falange_medio }}" name="input1FMedio" placeholder="N° Dias">
																	    	</div>
																	    	<div class="col-md-2">
																	    		<label for="input1FAnular" style="font-size: 80%">Anular</label>
													      						<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input1FAnular" value="{{ $dat[0]->descontado_mano_dedos_primer_falange_anular }}" name="input1FAnular" placeholder="N° Dias">
																	    	</div>
																	    	<div class="col-md-2">
																	    		<label for="input1FMeñique" style="font-size: 80%">Meñique</label>
													      						<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input1FMeñique" value="{{ $dat[0]->descontado_mano_dedos_primer_falange_menique }}" name="input1FMeñique" placeholder="N° Dias">
																	    	</div>
																	    </div>
												    				</div>
												    			</div>
												    		</div>
												    		<div class="panel box box-danger" style="border-top-color: #939598">
												    			<div class="box-header with-border">
												    				<h7 class="box-title">
												    					<a data-toggle="collapse" data-parent="#accordion" href="#collapseMetacarpo" style="font-size: 80%;color: #939598;"><i class="fa fas fa-chevron-down"></i> Metacarpo</a>
												    				</h7>
												    			</div>
												    			<div id="collapseMetacarpo" class="panel-collapse collapse">
												    				<div class="box-body">
												    					<div class="form-group row">
												    						<div class="col-md-2">
												    							<label for="inputMPulgar" style="font-size: 80%">Pulgar</label>
													      						<input type="number" min="0" required="required" class="form-control" id="inputMPulgar" style="font-size: 90%" value="{{ $dat[0]->descontado_mano_dedos_metacarpo_pulgar }}" name="inputMPulgar" placeholder="N° Dias">
												    						</div>
												    						<div class="col-md-2">
												    							<label for="inputMIndice" style="font-size: 80%">Índice</label>
													      						<input type="number" min="0" required="required" class="form-control" id="inputMIndice" style="font-size: 90%" value="{{ $dat[0]->descontado_mano_dedos_metacarpo_indice }}" name="inputMIndice" placeholder="N° Dias">
												    						</div>
												    						<div class="col-md-2">
												    							<label for="inputMMedio" style="font-size: 80%">Medio</label>
													      						<input type="number" min="0" required="required" class="form-control" id="inputMMedio" style="font-size: 90%" value="{{ $dat[0]->descontado_mano_dedos_metacarpo_medio }}" name="inputMMedio" placeholder="N° Dias">
												    						</div>
												    						<div class="col-md-2">
												    							<label for="inputMAnular" style="font-size: 80%">Anular</label>
													      						<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="inputMAnular" value="{{ $dat[0]->descontado_mano_dedos_metacarpo_anular }}" name="inputMAnular" placeholder="N° Dias">
												    						</div>
												    						<div class="col-md-2">
												    							<label for="inputMMeñique" style="font-size: 80%">Meñique</label>
													      						<input type="number" min="0" required="required" class="form-control" id="inputMMeñique" style="font-size: 90%" value="{{ $dat[0]->descontado_mano_dedos_metacarpo_menique }}" name="inputMMeñique" placeholder="N° Dias">
												    						</div>
												    					</div>
												    				</div>
												    			</div>
												    		</div>
												    		<div class="panel box box-danger" style="border-top-color: #939598">
												    			<div class="box-header with-border">
												    				<h7 class="box-title">
												    					<a data-toggle="collapse" data-parent="#accordion" href="#collapseMano" style="font-size: 80%;color: #939598;"><i class="fa fas fa-chevron-down"></i> Mano hasta la Muñeca</a>
												    				</h7>
												    			</div>
												    			<div id="collapseMano" class="panel-collapse collapse">
												    				<div class="box-body">
												    					<div class="form-group row">
												    						<div class="col-md-2">
												    							<label for="inputManoMuñecaPulgar" style="font-size: 80%" class=>Pulgar</label>
													      						<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="inputManoMuñecaPulgar" value="{{ $dat[0]->descontado_mano_dedos_mano_pulgar }}" name="inputManoMuñecaPulgar" placeholder="N° Dias">
												    						</div>
												    					</div>
												    				</div>
												    			</div>
												    		</div>
										            	</div>
										            </div>
												</div>
											</div>
											<div class="col-md-9">
												<div class="box box-solid">
													<div class="box-header with-border">
														<div class="col-md-8">
															<h9 style="font-weight: bold;font-size: 12px;color: #939598">d) Pie, dedo grande y otros dedos del pie</h9>
														</div>
														<div class="col-md-8">
															<h9 style="font-weight: bold;font-size: 10px;color:#939598">Amputación de todo o parte del hueso</h9>
														</div>
													</div>
													<div class="box-body">
														<div class="box-group" id="accordion1">
															<div class="panel box box-danger" style="border-top-color:#939598">
																<div class="box-header with-border" >
											    					<h7 class="box-title">
											    						<a data-toggle="collapse" data-parent="#accordion1" href="#collapseOne1" style="font-size: 80%;color: #939598"><i class="fa fas fa-chevron-down"></i> Tercer Falange(uña)</a>
											    					</h7>
											    				</div>
											    				<div id="collapseOne1" class="panel-collapse collapse" >
										    						<div class="box-body">
										    							<div class="form-group row">
																    		<div class="col-md-2 offset-md-1">
																    			<label for="input3FPDedoG" style="font-size: 80%">Dedo Grande</label>
													      						<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input3FPDedoG" value="{{ $dat[0]->descontado_pie_dedos_tercer_falange_dedo_grande }}" name="input3FPDedoG" placeholder="N° Dias">
																    		</div>
																    		<div class="col-md-2 offset-md-1">
																    			<label for="input3FPOtroDedo" style="font-size: 80%">C/u Dedos</label>
													      						<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="input3FPOtroDedo" value="{{ $dat[0]->descontado_pie_dedos_tercer_falange_cada_dedo }}" name="input3FPOtroDedo" placeholder="N° Dias">
																    		</div>
																    	</div>
																    </div>
																</div>
															</div>
															<div class="panel box box-danger" style="border-top-color:#939598">
																<div class="box-header with-border" >
											    					<h7 class="box-title">
											    						<a data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo1" style="font-size: 80%;color: #939598"><i class="fa fas fa-chevron-down"></i> Segundo Falange(uña)</a>
											    					</h7>
											    				</div>
											    				<div id="collapseTwo1" class="panel-collapse collapse">
											    					<div class="box-body">
											    						<div class="form-group row">
											    							<div class="col-md-2 col-lg-2">
											    								<label for="input2FPOtroDedo" style="font-size: 80%">C/u Dedos</label>
													      						<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="input2FPOtroDedo" value="{{ $dat[0]->descontado_pie_dedos_segundo_falange_cada_dedo }}" name="input2FPOtroDedo" placeholder="N° Dias">
											    							</div>
											    						</div>
											    					</div>
											    				</div>
															</div>
															<div class="panel box box-danger" style="border-top-color:#939598">
																<div class="box-header with-border" >
											    					<h7 class="box-title">
											    						<a data-toggle="collapse" data-parent="#accordion1" href="#collapseTres1" style="font-size: 80%;color: #939598"><i class="fa fas fa-chevron-down"></i> Primer Falange(uña)</a>
											    					</h7>
											    				</div>
											    				<div id="collapseTres1" class="panel-collapse collapse">
											    					<div class="box-body">
											    						<div class="form-group row">
											    							<div class="col-md-2">
											    								<label for="input1FPDedoG" style="font-size: 80%">Dedo Grande</label>
													      						<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="input1FPDedoG" value="{{ $dat[0]->descontado_pie_dedos_primer_falange_dedo_grande }}"name="input1FPDedoG" placeholder="N° Dias">
											    							</div>
											    							<div class="col-md-2">
											    								<label for="input1FPOtroDedo" style="font-size: 80%">C/u Dedos</label>
													      						<input type="number" min="0" required="required" class="form-control" id="input1FPOtroDedo" style="font-size: 90%" value="{{ $dat[0]->descontado_pie_dedos_primer_falange_cada_dedo }}"  name="input1FPOtroDedo" placeholder="N° Dias">
											    							</div>
											    						</div>
											    					</div>
											    				</div>
															</div>
															<div class="panel box box-danger" style="border-top-color:#939598">
																<div class="box-header with-border">
																	<h7 class="box-title">
																		<a data-toggle="collapse" data-parent="#accordion1" href="#collapseMetatarso" style="font-size: 80%;color: #939598"><i class="fa fas fa-chevron-down"></i> Metatarso</a>
																	</h7>
																</div>
																<div id="collapseMetatarso" class="panel-collapse collapse">
																	<div class="box-body">
																		<div class="form-group row">
																			<div class="col-md-2">
																				<label for="inputMPDedoG" style="font-size: 80%">Dedo Grande</label>
													      						<input type="number" min="0" required="required" class="form-control" id="inputMPDedoG" style="font-size: 90%" value="{{ $dat[0]->descontado_pie_dedos_metatarso_dedo_grande }}"  name="inputMPDedoG" placeholder="N° Dias">
																			</div>
																			<div class="col-md-2">
																				<label for="inputMPOtroDedo" style="font-size: 80%">C/u Dedos</label>
													      						<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="inputMPOtroDedo" value="{{ $dat[0]->descontado_pie_dedos_metatarso_cada_dedo }}"  name="inputMPOtroDedo" placeholder="N° Dias">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="panel box box-danger" style="border-top-color:#939598">
																<div class="box-header with-border">
																	<h7 class="box-title">
																		<a data-toggle="collapse" data-parent="#accordion1" href="#collapsePie" style="font-size: 80%;color: #939598"><i class="fa fas fa-chevron-down"></i> Pie hasta el Tobillo</a>
																	</h7>
																</div>
																<div id="collapsePie" class="panel-collapse collapse">
																	<div class="box-body">
																		<div class="form-group row">
																			<div class="col-md-2">
																				<label for="inputPieTobilloPDedoG" style="font-size: 80%">Dedo Grande</label>
													      						<input type="number" min="0" required="required" class="form-control" id="inputPieTobilloPDedoG" value="{{ $dat[0]->descontado_pie_dedos_pie_dedo_grande }}"  name="inputPieTobilloPDedoG" style="font-size: 90%" placeholder="N° Dias">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-8 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 12px;color:#939598">B. Lesiones que resulten en la pérdidad de funciones fisiológicas</h9>
								    			</div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
									    		<div class="form-group col-md-2 offset-md-1">
											      	<label for="inputOjoPerdiV" style="font-size: 80%">Un ojo Pérdida de la visión</label>
											      	<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="inputOjoPerdiV" value="{{ $dat[0]->descontado_vision_ojo }}"  name="inputOjoPerdiV" placeholder="N° Dias">
											    </div>
											    <div class="form-group col-md-2">
											      	<label for="inputOidoPerdiA" style="font-size: 80%">Un oido Pérdida de la audición</label>
											      	<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="inputOidoPerdiA" value="{{ $dat[0]->descontado_audicion_oido }}"  name="inputOidoPerdiA" placeholder="N° Dias">
											    </div>
											    <div class="form-group col-md-2">
											      	<label for="inputAOidoPerdiA" style="font-size: 80%">Ambos oidos Pérdida de la audición</label>
											      	<input type="number" min="0"  style="font-size: 90%" required="required" class="form-control" id="inputAOidoPerdiA" value="{{ $dat[0]->descontado_ambos_oidos }}"  name="inputAOidoPerdiA" placeholder="N° Dias">
											    </div>
									    		<div class="form-group col-md-2 offset-md-1" style="margin-top: 1%">
											      	<label for="inputHerniaNO" style="font-size: 80%;">Hernia no operada</label>
											      	<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="inputHerniaNO" value="{{ $dat[0]->descontado_hernia_no_operada }}" name="inputHerniaNO" placeholder="N° Dias">
											    </div>
											</div>
											<div class="form-row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
												<div class="col-md-6 offset-md-5">
													<button class="btn btn-primary" style="background-color: #DD4B39;border-color: #DD4B39;"><a href="{{ route('update_dias_descontados',$dat[0]->id_dias_desc) }}" style="color:#ffffff"><i class="far fa-save"></i></a> Actualizar</button>
												</div>
											</div>
								    	</div>
								    </div>
								</div>
				            </div>
				        </div>
				    </div>
			  	</form>
			</div>
		</div>
    </section>
</div>									
@endsection

@section('scripts')
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>   
@endsection
