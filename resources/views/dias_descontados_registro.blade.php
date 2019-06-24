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
	      		<a tabindex="-1" href="{{ route('principal') }}">SSOMAC</a>
	    	</li>
	    	<li class="breadcrumb-item">
	    		<a tabindex="-1" href="{{ route('dias_descontados') }}">Dias Descontados</a>
	    	</li>
	    	<li class="breadcrumb-item active">Registro Días Descontados</li>
	  	</ol>
	  	<div class="box box-danger">
	  		<div class="box-header with-border" >
	  			<h3 class="box-title"><i class="glyphicon glyphicon-calendar"></i>  Días Descontados/Debitados</h3>
	  		</div>
	  		<div class="box-body">
	  			<form method="post" action="/dias_descontados_registro/grabarDiasDescontados">
	  				@csrf
	  				<div class="row">
			  			<div class="col-lg-3 col-md-3">
			  				<label for="selectJef" style="font-size: 80%;">Regimen</label>
					      	<div class="row">
						      	<div class="col-md-9 col-sm-9">	
							      	<select id="selectRegimen" autofocus="autofocus" name="selectRegimen" required="true" class="form-control" tabindex="1">
							        	<option value="-1" style="font-size: 90%;" {{ old('selectRegimen')== -1 ? 'selected' : '' }} selected>--Seleccione--</option>
								        	<option value="1" style="font-size: 90%;" {{ old('selectRegimen')== 1 ? 'selected' : '' }}>Construcción</option>
								        	<option value="2" style="font-size: 90%;" {{ old('selectRegimen')== 2 ? 'selected' : '' }}>Minería</option>
							      	</select>
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
											      	<input type="number" style="font-size: 90%;" autofocus="autofocus" name="inputMuerte" value="{{ old('inputMuerte') }}" tabindex="2" required="required" min="0" class="form-control" id="inputMuerte" placeholder="N° Dias">
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
											      	<input type="number" style="font-size: 90%;" required="required" min="0" value="{{ old('inputLesion') }}" name="inputLesion" class="form-control" id="inputLesion" placeholder="N° Dias" tabindex="3">
											     </div>
											</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-8 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 11px;color:#939598">B. Lesiones que resulten en la pérdida anatómica o la pérdida funcional total de</h9>
								    			</div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
									    		<div class="form-group col-md-2 offset-md-1">
											      	<label for="inputOjos" style="font-size: 80%;">Ambos ojos</label>
											      	<input type="number" style="font-size: 90%;" required="required" min="0" value="{{ old('inputOjos') }}" class="form-control" id="inputOjos" name="inputOjos" placeholder="N° Dias" tabindex="4">
											    </div>
											    <div class="form-group col-md-2">
											      	<label for="inputBrazos" style="font-size: 80%;">Ambos brazos</label>
											      	<input type="number" min="0" style="font-size: 90%;" required="required" value="{{ old('inputBrazos') }}" class="form-control" id="inputBrazos" name="inputBrazos" placeholder="N° Dias" tabindex="5">
											    </div>
											    <div class="form-group col-md-2">
											      	<label for="inputPiernas" style="font-size: 80%;">Ambas piernas</label>
											      	<input type="number" min="0" style="font-size: 90%;" class="form-control" value="{{ old('inputPiernas') }}" id="inputPiernas" required="required" name="inputPiernas" placeholder="N° Dias" tabindex="6">
											    </div>
											    <div class="form-group col-md-2 offset-md-1">
											      	<label for="inputManos" style="font-size: 80%;">Ambas manos</label>
											      	<input type="number" style="font-size: 90%;" min="0" class="form-control" tabindex="6" id="inputManos" value="{{ old('inputManos') }}" name="inputManos" required="required" placeholder="N° Dias" tabindex="7">
											    </div>
											</div>
											<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
											    <div class="form-group col-md-2">
											      	<label for="inputPies" style="font-size: 80%;">Ambos pies</label>
											      	<input type="number" min="0" style="font-size: 90%;" class="form-control" id="inputPies" value="{{ old('inputPies') }}" name="inputPies" required="required" placeholder="N° Dias" tabindex="8">
											    </div>
											    <div class="form-group col-md-2">
											      	<label for="inputOjoBrazo" style="font-size: 80%;">Un ojo y un brazo</label>
											      	<input type="number" min="0" style="font-size: 90%;" class="form-control" id="inputOjoBrazo" value="{{ old('inputOjoBrazo') }}" name="inputOjoBrazo" required="required" placeholder="N° Dias" tabindex="9">
											    </div>
											    <div class="form-group col-md-2 offset-md-1">
											      	<label for="inputOjoMano" class=>Un ojo y una mano</label>
											      	<input type="number" min="0" class="form-control" id="inputOjoMano" tabindex="10"  value="{{ old('inputOjoMano') }}" name="inputOjoMano" required="required" placeholder="N° Dias">
											    </div>
											    <div class="form-group col-md-2">
											      	<label for="inputOjoPierna" class=>Un ojo y una pierna</label>
											      	<input type="number" min="0" class="form-control" id="inputOjoPierna" tabindex="11" value="{{ old('inputOjoPierna') }}" name="inputOjoPierna" required="required" placeholder="N° Dias">
											    </div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
											    <div class="form-group col-md-2">
											      	<label for="inputOjoPie" style="font-size: 80%;">Un ojo y un pie</label>
											      	<input type="number" min="0" style="font-size: 90%;" class="form-control" required="required" tabindex="12" id="inputOjoPie" value="{{ old('inputOjoPie') }}" name="inputOjoPie" placeholder="N° Dias">
											    </div>
											    <div class="form-group col-md-2 offset-md-1">
											      	<label for="inputManoPierna" style="font-size: 80%;">Una mano y una pierna</label>
											      	<input type="number" min="0" style="font-size: 90%;" class="form-control" id="inputManoPierna" tabindex="13" value="{{ old('inputManoPierna') }}" name="inputManoPierna" placeholder="N° Dias" required="required">
											    </div>
											    <div class="form-group col-md-2">
											      	<label for="inputManoPie" style="font-size: 80%">Una mano y un pie</label>
											      	<input type="number" min="0" style="font-size: 90%;" class="form-control" id="inputManoPie" tabindex="14" value="{{ old('inputManoPie') }}" required="required" name="inputManoPie" placeholder="N° Dias">
											    </div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-8 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 11px;color:#BFBFBF">Siempre que no sea de la misma extremidad</h9>
								    			</div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
											    <div class="form-group col-md-2  offset-md-1">
											      	<label for="inputBrazoMano" style="font-size: 80%;">Un brazo y una mano</label>
											      	<input type="number" min="0" style="font-size: 90%;" class="form-control" required="required" tabindex="15" id="inputBrazoMano" name="inputBrazoMano" placeholder="N° Dias" value="{{ old('inputBrazoMano') }}">
											    </div>
											    <div class="form-group col-md-2">
											      	<label for="inputPiernaPie" style="font-size: 80%;">Una pierna y un pie</label>
											      	<input type="number" min="0" style="font-size: 90%;" class="form-control" id="inputPiernaPie" value="{{ old('inputPiernaPie') }}" tabindex="15" required="required" name="inputPiernaPie" placeholder="N° Dias" tabindex="16">
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
									    		<div class="form-group col-md-3 offset-md-1">
											      	<label for="inputACodo" style="font-size: 80%">Cualquier punto arriba del codo</label>
											      	<input type="number" style="font-size: 90%" required="required" min="0" tabindex="17" value="{{ old('inputACodo') }}" class="form-control" id="inputACodo" name="inputACodo" placeholder="N° Dias">
											     </div>
											     <div class="form-group col-md-3">
											      	<label for="inputAMuñeca" style="font-size: 80%">Cualquier punto arriba de la muñeca</label>
											      	<input type="number" min="0" style="font-size: 90%" required="required" tabindex="18" class="form-control" value="{{ old('inputAMuñeca') }}" id="inputAMuñeca" name="inputAMuñeca" placeholder="N° Dias">
											     </div>
											</div>
											<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
								    			<div class="col-md-8 offset-md-1">
								    				<h9 style="font-weight: bold;font-size: 12px;color:#939598">b) Una pierna</h9>
								    			</div>
								    		</div>
								    		<div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: -10px;">
									    		<div class="form-group col-md-3 offset-md-1">
											      	<label for="inputARodilla" style="font-size: 80%">Cualquier punto arriba de la rodilla</label>
											      	<input type="number" min="0" style="font-size: 90%" required="required" tabindex="19" value="{{ old('inputARodilla') }}" class="form-control" id="inputARodilla" name="inputARodilla" placeholder="N° Dias">
											     </div>
											     <div class="form-group col-md-3">
											      	<label for="inputATobillo" style="font-size: 80%">Cualquier punto arriba del tobillo</label>
											      	<input type="number" min="0" style="font-size: 90%" required="required" tabindex="20" class="form-control" value="{{ old('inputATobillo') }}" id="inputATobillo" name="inputATobillo" placeholder="N° Dias">
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
																		      	<input type="number" style="font-size: 90%" min="0" required="required" tabindex="22" value="{{ old('input3FPulgar') }}" class="form-control" id="input3FPulgar" name="input3FPulgar" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input3FIndice" style="font-size: 80%">Índice</label>
																		      	<input type="number" style="font-size: 90%" min="0" class="form-control" required="required" value="{{ old('input3FIndice') }}" id="input3FIndice" name="input3FIndice" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input3FMedio" style="font-size: 80%">Medio</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" value="{{ old('input3FMedio') }}" id="input3FMedio" name="input3FMedio" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input3FAnular" style="font-size: 80%">Anular</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" value="{{ old('input3FAnular') }}" id="input3FAnular" name="input3FAnular" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input3FMeñique" style="font-size: 80%">Meñique</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" value="{{ old('input3FMeñique') }}" id="input3FMeñique" name="input3FMeñique" placeholder="N° Dias">
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
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input2FIndice" value="{{ old('input2FIndice') }}" name="input2FIndice" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input2FMedio" style="font-size: 80%">Medio</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input2FMedio" value="{{ old('input2FMedio') }}" name="input2FMedio" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input2FAnular" style="font-size: 80%">Anular</label>
																		      	<input type="number"  style="font-size: 90%" min="0" required="required" class="form-control" id="input2FAnular" value="{{ old('input2FAnular') }}" name="input2FAnular" placeholder="N° Dias">
																		    </div>
																		    <div class="col-md-2">
																		      	<label for="input2FMeñique" style="font-size: 80%">Meñique</label>
																		      	<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input2FMeñique" value="{{ old('input2FMeñique') }}" name="input2FMeñique" placeholder="N° Dias">
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
													      						<input type="number" min="0" required="required" class="form-control" id="input1FPulgar" style="font-size: 90%" value="{{ old('input1FPulgar') }}" name="input1FPulgar" placeholder="N° Dias">
																	    	</div>
																	    	<div class="col-md-2">
																	    		<label for="input1FIndice" class=>Índice</label>
												      							<input type="number" value="{{ old('input1FIndice') }}" min="0" required="required" class="form-control" id="input1FIndice" name="input1FIndice" placeholder="N° Dias">
																	    		
																	    	</div>
																	    	<div class="col-md-2">
																	    		<label for="input1FMedio" style="font-size: 80%">Medio</label>
													      						<input type="number"  style="font-size: 90%" min="0" required="required" class="form-control" id="input1FMedio" value="{{ old('input1FMedio') }}" name="input1FMedio" placeholder="N° Dias">
																	    	</div>
																	    	<div class="col-md-2">
																	    		<label for="input1FAnular" style="font-size: 80%">Anular</label>
													      						<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input1FAnular" value="{{ old('input1FAnular') }}" name="input1FAnular" placeholder="N° Dias">
																	    	</div>
																	    	<div class="col-md-2">
																	    		<label for="input1FMeñique" style="font-size: 80%">Meñique</label>
													      						<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input1FMeñique" value="{{ old('input1FMeñique') }}" name="input1FMeñique" placeholder="N° Dias">
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
													      						<input type="number" min="0" required="required" class="form-control" id="inputMPulgar" style="font-size: 90%" value="{{ old('inputMPulgar') }}" name="inputMPulgar" placeholder="N° Dias">
												    						</div>
												    						<div class="col-md-2">
												    							<label for="inputMIndice" style="font-size: 80%">Índice</label>
													      						<input type="number" min="0" required="required" class="form-control" id="inputMIndice" style="font-size: 90%" value="{{ old('inputMIndice') }}" name="inputMIndice" placeholder="N° Dias">
												    						</div>
												    						<div class="col-md-2">
												    							<label for="inputMMedio" style="font-size: 80%">Medio</label>
													      						<input type="number" min="0" required="required" class="form-control" id="inputMMedio" style="font-size: 90%" value="{{ old('inputMMedio') }}" name="inputMMedio" placeholder="N° Dias">
												    						</div>
												    						<div class="col-md-2">
												    							<label for="inputMAnular" style="font-size: 80%">Anular</label>
													      						<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="inputMAnular" value="{{ old('inputMAnular') }}" name="inputMAnular" placeholder="N° Dias">
												    						</div>
												    						<div class="col-md-2">
												    							<label for="inputMMeñique" style="font-size: 80%">Meñique</label>
													      						<input type="number" min="0" required="required" class="form-control" id="inputMMeñique" style="font-size: 90%" value="{{ old('inputMMeñique') }}" name="inputMMeñique" placeholder="N° Dias">
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
													      						<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="inputManoMuñecaPulgar" value="{{ old('inputManoMuñecaPulgar') }}" name="inputManoMuñecaPulgar" placeholder="N° Dias">
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
													      						<input type="number" style="font-size: 90%" min="0" required="required" class="form-control" id="input3FPDedoG" value="{{ old('input3FPDedoG') }}" name="input3FPDedoG" placeholder="N° Dias">
																    		</div>
																    		<div class="col-md-2 offset-md-1">
																    			<label for="input3FPOtroDedo" style="font-size: 80%">C/u Dedos</label>
													      						<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="input3FPOtroDedo" value="{{ old('input3FPOtroDedo') }}" name="input3FPOtroDedo" placeholder="N° Dias">
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
											    								<label for="input2FPOtroDedo" style="font-size: 80%">Cada Uno de los Dedos</label>
													      						<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="input2FPOtroDedo" value="{{ old('input2FPOtroDedo') }}" name="input2FPOtroDedo" placeholder="N° Dias">
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
													      						<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="input1FPDedoG" value="{{ old('input1FPDedoG') }}" name="input1FPDedoG" placeholder="N° Dias">
											    							</div>
											    							<div class="col-md-2">
											    								<label for="input1FPOtroDedo" style="font-size: 80%">C/u Dedos</label>
													      						<input type="number" min="0" required="required" class="form-control" id="input1FPOtroDedo" style="font-size: 90%" value="{{ old('input1FPOtroDedo') }}" name="input1FPOtroDedo" placeholder="N° Dias">
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
													      						<input type="number" min="0" required="required" class="form-control" id="inputMPDedoG" style="font-size: 90%" value="{{ old('inputMPDedoG') }}"  name="inputMPDedoG" placeholder="N° Dias">
																			</div>
																			<div class="col-md-2">
																				<label for="inputMPOtroDedo" style="font-size: 80%">C/u Dedos</label>
													      						<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="inputMPOtroDedo" value="{{ old('inputMPOtroDedo') }}"  name="inputMPOtroDedo" placeholder="N° Dias">
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
													      						<input type="number" min="0" required="required" class="form-control" id="inputPieTobilloPDedoG" value="{{ old('inputPieTobilloPDedoG') }}"  name="inputPieTobilloPDedoG" style="font-size: 90%" placeholder="N° Dias">
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
											      	<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="inputOjoPerdiV" value="{{ old('inputOjoPerdiV') }}"  name="inputOjoPerdiV" placeholder="N° Dias">
											    </div>
											    <div class="form-group col-md-2">
											      	<label for="inputOidoPerdiA" style="font-size: 80%">Un oido Pérdida de la audición</label>
											      	<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="inputOidoPerdiA" value="{{ old('inputOidoPerdiA') }}"  name="inputOidoPerdiA" placeholder="N° Dias">
											    </div>
											    <div class="form-group col-md-2">
											      	<label for="inputAOidoPerdiA" style="font-size: 80%">Ambos oidos Pérdida de la audición</label>
											      	<input type="number" min="0"  style="font-size: 90%" required="required" class="form-control" id="inputAOidoPerdiA" value="{{ old('inputAOidoPerdiA') }}"  name="inputAOidoPerdiA" placeholder="N° Dias">
											    </div>
									    		<div class="form-group col-md-2 offset-md-1" style="margin-top: 1%">
											      	<label for="inputHerniaNO" style="font-size: 80%;">Hernia no operada</label>
											      	<input type="number" min="0" style="font-size: 90%" required="required" class="form-control" id="inputHerniaNO"  value="{{ old('inputHerniaNO') }}" name="inputHerniaNO" placeholder="N° Dias">
											    </div>
											</div>
								    		
								    		
			            					<div class="form-row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
												<div class="col-md-6 offset-md-5">
								  					<button class="btn btn-primary" style="background-color: #DD4B39;border-color: #DD4B39;"><a href="{{ route('grabar_dias_descontados') }}" style="color:#ffffff;"><i class="far fa-save"></i></a> Grabar</button>
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
		<br/>
	</section>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection
