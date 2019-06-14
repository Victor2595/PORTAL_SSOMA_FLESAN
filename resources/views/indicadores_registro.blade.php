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
          <li  class="active"><a href="{{ route('indicadores_listado') }}"><i class="far fa-circle"></i> Listado</a></li>
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
    <section class="content">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ route('principal') }}">SSOMA</a>
        </li>
        <li class="breadcrumb-item active">
          <a href="{{ route('indicadores_listado') }}">Indicadores SSOMA</a>
        </li>
        <li class="breadcrumb-item active">Registro de Datos</li>
      </ol>
      <div class="box box-danger">
        <div class="box-header with-border" >
          <h3 class="box-title"><i class="glyphicon glyphicon-signal"></i>  Registro de Indicadores - {{ $proyecto->nombre_proyecto }}</h3>
        </div>
        <div class="box-body">
          <form method="POST" action="/indicadores_registro/grabar_indicadores" enctype="multipart/form-data">
          @csrf
            <!--<div class="row">
              <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div class="progress progress-md">
                  <div class="progress-bar progress-bar-danger progress-bar-striped progress-bar-animated" role="progressbar" id="bar" name="bar" style="width: 0%" aria-valuenow="30%" aria-valuemin="0" aria-valuemax="100">
                  </div>
                </div>
              </div>
            </div>-->
            <div class="row">
              <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                <div role="tabpanel">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item active"><a class="nav-link active" href="#tabRegistro1" aria-controls="tabRegistro1" data-toggle="tab" role="tab">Tasas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabRegistro2" aria-controls="tabRegistro2" data-toggle="tab" role="tab">Salud Ocupacional y Ausentabilidad</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabRegistro3" aria-controls="tabRegistro3" data-toggle="tab" role="tab">Acciones Sustentables y Entrenamientos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabRegistro4" aria-controls="tabRegistro4" data-toggle="tab" role="tab">Conformidad de Procesos y Productos</a>
                    </li>
                  </ul>
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tabRegistro1">
                      <div class="form">
                        <br/>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-6">
                            <h9 style="color:#939598;font-size: 13px;">Tasas(Dvc / Flesan)</h9>
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-2">
                            <label for="cantidadTrabajadores" style="font-size: 80%" title="Cantidad de Trabajadores">N° de Trabajadores</label>
                            <input type="number" id="cantidadTrabajadores" style="font-size: 85%;" name="cantidadTrabajadores" min="0" placeholder="Cantidad de Trabajadores" class="form-control" title="Cantidad de Trabajadores" required autofocus="autofocus">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="hombresHoraEx" style="font-size: 80%"><element title="Hombres Hora Exposición al riesgo">HHT</element></label>
                            <input type="number" id="hombresHoraEx" style="font-size: 85%;" title="Hombres Hora Exposición al riesgo" name="hombresHoraEx" step="any" min="0" placeholder="HHT" class="form-control" required>
                          </div>
                          <div class="form-group col-md-2">
                            <label for="incidentesINC" style="font-size: 80%;"><element title="(Solo requirio de Primeros Auxilios)">Incidentes</element></label>
                            <input type="number" id="incidentesINC" name="incidentesINC" style="font-size: 85%;" title="(Solo requirio de Primeros Auxilios)" min="0" placeholder="INC" class="form-control" required>
                          </div>
                          <div class="form-group col-md-2">
                            <label for="incidentesAP" style="font-size: 80%;"><element title="Incidentes Alto Potencial">IAP</element></label>
                            <input type="number" id="incidentesAP" title="Incidentes Alto Potencial" style="font-size: 85%;" name="incidentesAP" min="0" placeholder="IAP" class="form-control" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="AAM" style="font-size: 80%;"><element title="Accidente Ambiental">AAM</element></label>
                            <input type="number" id="AAM" name="AAM" title="Accidente Ambiental" min="0" style="font-size: 85%;" placeholder="AAM" class="form-control" required>
                          </div>
                          <div class="form-group col-md-2">
                            <label for="ASP"><element title="Accidente sin Tiempo Perdido" style="font-size: 80%;">ASP</element></label>
                            <input type="number" id="ASP" title="Accidente sin Tiempo Perdido" style="font-size: 85%;" name="ASP" min="0" placeholder="ASP" class="form-control" required="required">
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-2">
                            <label for="ACP" style="font-size: 80%;"><element title="Accidente con Tiempo Perdido">ACP</element></label>
                            <input type="number" id="ACP" name="ACP" style="font-size: 85%;" title="Accidente con Tiempo Perdido" min="0" placeholder="ACP" class="form-control" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="AF" style="font-size: 80%;"><element title="Accidentes Fatales">AF</element></label>
                            <input type="number" id="AF" name="AF" min="0" style="font-size: 85%;" title="Accidentes Fatales" placeholder="AF" class="form-control" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="diasPerdidos" style="font-size: 80%;"><element title="Dias Pérdidos">Dias Pérdidos</element></label>
                            <input type="number" id="diasPerdidos" name="diasPerdidos" min="0" title="Dias Pérdidos" style="font-size: 85%;" placeholder="Dias Pérdidos" class="form-control" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="diasTransportados" style="font-size: 80%;"><element title="Dias Transportados">Dias Transportados</element></label>
                            <input type="number" id="diasTransportados" name="diasTransportados" style="font-size: 85%;" min="0" title="Dias Transportados" placeholder="Dias Transportados" class="form-control" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="diasDesconectados" style="font-size: 80%;"><element title="Dias Desconectados">Dias Desconectados</label>
                          <input type="number" id="diasDesconectados" name="diasDesconectados" style="font-size: 85%;" title="Dias Desconectados" min="0" placeholder="Dias Desconectados" class="form-control" required="required">
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <hr>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-6">
                            <h9 style="color:#939598;font-size: 13px;">Tasas Subcontratistas</h9>
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-2">
                            <label for="cantidadColaboradoresS" style="font-size: 80%;" title="Cantidad de Colaboradores Subcontratistas">N° de Colaboradores</label>
                            <input type="number" id="cantidadColaboradoresS" name="cantidadColaboradoresS" style="font-size: 85%;" min="0" placeholder="Cantidad de Colaboradores" class="form-control" title="Cantidad de Colaboradores Subcontratistas" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="hombresHoraExSub" style="font-size: 80%;"><element title="Hombres Hora Exposición al riesgo Subcontratistas">HHT</element></label>
                            <input type="number" id="hombresHoraExSub" style="font-size: 85%;" name="hombresHoraExSub" step="any" min="0" placeholder="HHT" class="form-control" required title="Hombres Hora Exposición al riesgo Subcontratistas" >
                          </div>
                          <div class="form-group col-md-2">
                            <label for="incidentesINCSub" style="font-size: 80%;"><element title="(Solo requirio de Primeros Auxilios) Subcontratistas">Incidentes</element></label>
                            <input type="number" id="incidentesINCSub" style="font-size: 85%;" title="(Solo requirio de Primeros Auxilios) Subcontratistas" name="incidentesINCSub" min="0" placeholder="INC" class="form-control" required>
                          </div>
                          <div class="form-group col-md-2">
                            <label for="incidentesAPSub" style="font-size: 80%;"><element title="Incidentes Alto Potencial Subcontratistas">IAP</element></label>
                            <input type="number" id="incidentesAPSub" style="font-size: 85%;" name="incidentesAPSub" min="0" title="Incidentes Alto Potencial Subcontratistas" placeholder="IAP" class="form-control" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="AAMSub" style="font-size: 80%;"><element title="Accidente Ambiental Subcontratistas">AAM</element></label>
                            <input type="number" id="AAMSub" min="0"  style="font-size: 85%;" name="AAMSub" title="Accidente Ambiental Subcontratistas" placeholder="INC" class="form-control" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="ASPSub" style="font-size: 80%;"><element title="Accidente sin Tiempo Perdido Subcontratistas">ASP</element></label>
                            <input type="number" id="ASPSub" min="0" style="font-size: 85%;" name="ASPSub" title="Accidente sin Tiempo Perdido Subcontratistas" placeholder="ASP" class="form-control" required="required">
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-2">
                            <label for="ACPSub"><element title="Accidente con Tiempo Perdido Subcontratistas">ACP</element></label>
                            <input type="number" id="ACPSub" min="0" name="ACPSub" placeholder="ACP" class="form-control" required="required" >
                          </div>
                          <div class="form-group col-md-2">
                            <label for="AFSub" style="font-size: 80%;"><element title="Accidentes Fatales Subcontratistas">AF</element></label>
                            <input type="number" id="AFSub" min="0" style="font-size: 85%;" name="AFSub" placeholder="AF" class="form-control" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="diasPerdidosSub" style="font-size: 80%;"><element title="Dias Pérdidos Subcontratistas">Dias Pérdidos</element></label>
                            <input type="number" id="diasPerdidosSub" style="font-size: 85%;" title="Dias Pérdidos Subcontratistas" name="diasPerdidosSub" min="0" placeholder="Dias Pérdidos" class="form-control" required="required" autofocus="autofocus">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="diasTransportadosSub" style="font-size: 80%;"><element title="Dias Transportados Subcontratistas">Dias Transportados</element></label>
                            <input type="number" id="diasTransportadosSub" style="font-size: 85%;" title="Dias Transportados Subcontratistas" name="diasTransportadosSub" min="0" placeholder="Dias Transportados" class="form-control" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="diasDesconectadosSub" style="font-size: 80%;"><element title="Dias Desconectados Subcontratistas">Dias Desconectados</element></label>
                            <input type="number" id="diasDesconectadosSub" style="font-size: 85%;" title="Dias Desconectados Subcontratistas" name="diasDesconectadosSub" min="0" placeholder="Dias Desconectados" class="form-control" required="required">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tabRegistro2">
                      <div class="form">
                        <br/>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-3">
                            <label for="cantidadTrabEMI" style="font-size: 80%;"><element title="Cantidad de Trbjadores con Exámen Medico de Ingreso">Cantidad de Trbjs. con Exámen Médico de Ingreso(Acumulado)</element></label>
                            <input type="number" id="cantidadTrabEMI" style="font-size: 85%;" title="Cantidad de Trbjadores con Exámen Medico de Ingreso" name="cantidadTrabEMI" min="0" placeholder="N° Tbjrs. con Exámen Medico de Ingreso" class="form-control" required="required">
                          </div>
                          <div class="form-group col-md-3">
                            <label for="cantidadTrabEMS" style="font-size: 80%;"><element title="Cantidad de Trabajadores con Exámen Medico de Salida">Cantidad de Tbjrs. con Exámen Médico de Salida(Acumulado)</element></label>
                            <input type="number" id="cantidadTrabEMS" name="cantidadTrabEMS" min="0" style="font-size: 85%;" title="Cantidad de Trabajadores con Exámen Medico de Salida" placeholder="N° Tbjrs. con Exámen Medico de Salida" class="form-control" required="required">
                          </div>
                          <div class="form-group col-md-3">
                            <label for="numeroTrabajEnfOcu" style="font-size: 80%;"><element title="Número de Trabajadores. detectados con Enfermedad Ocupacional">Número de Trbjs. detectados con Enfermedad Ocupacional</element></label>
                            <input type="number" id="numeroTrabajEnfOcu" name="numeroTrabajEnfOcu" style="font-size: 85%;" title="Número de Trabajadores. detectados con Enfermedad Ocupacional" min="0" placeholder="N° Tbjrs. con Enfermedad Ocupacional" class="form-control" required="required" autofocus="autofocus">
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-3">
                            <label for="numeroTrabExpOcEnferOcup" style="font-size: 80%;"><element title="Cantidad de Trabjadores expuestos al agente que ocasionó la Enfermedad Ocupacional">Cantidad de Trbjs. expuestos al agente que ocasionó la Enfermedad Ocupacional</element></label>
                            <input type="number" id="numeroTrabExpOcEnferOcup" style="font-size: 85%;" name="numeroTrabExpOcEnferOcup" min="0" placeholder="N° Trbjs. expuestos ocasionó Enfermedad Ocupacional" class="form-control" title="Cantidad de Trabjadores expuestos al agente que ocasionó la Enfermedad Ocupacional" required="required" autofocus="autofocus">
                          </div>
                          <div class="form-group col-md-3" style="padding-top: 1.5%">
                            <label for="numeroTrabajadCanceOcup" style="font-size: 80%;"><element title="Número de Trbjs. con Cáncer Profesional">Número de Trbjs. con Cáncer Profesional</element></label>
                            <input type="number" id="numeroTrabajadCanceOcup" name="numeroTrabajadCanceOcup" min="0" placeholder="N° Trbjs. Cáncer Ocupacional" class="form-control" required="required" style="font-size: 85%;" autofocus="autofocus">
                          </div>
                          <div class="form-group col-md-3" style="padding-top: 1.5%">
                            <label for="numeroDiasAuseEnfNP" style="font-size: 80%;"><element title="Cantidad de días de ausencia por Enfermedad no Profesional">Cantidad de días de ausencia por Enfermedad no Profesional</element></label>
                            <input type="number" id="numeroDiasAuseEnfNP" name="numeroDiasAuseEnfNP" min="0" title="Cantidad de días de ausencia por Enfermedad no Profesional" style="font-size: 85%;" placeholder="N° Dias Ausencia Enfermedad no Profesional" class="form-control" required="required" autofocus="autofocus">
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;">
                          <hr>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-6">
                            <h9 style="color:#939598;font-size: 13px;">Certificados Médicos</h9>
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-3">
                            <label for="certificadosRecibidos" style="font-size: 80%;"><element title="Cantidad de Certificados Recibidos">Cantidad de Certificados Recibidos</element></label>
                            <input type="number" id="certificadosRecibidos" min="0" style="font-size: 85%;" title="Cantidad de Certificados Recibidos" name="certificadosRecibidos" placeholder="N° Certificados Recibidos" class="form-control" required="required" autofocus="autofocus">
                          </div>
                          <div class="form-group col-md-3">
                            <label for="certificadosValilados" style="font-size: 80%;"><element title="Cantidad de Certificados Validados">Cantidad de Certificados Validados</element></label>
                            <input type="number" id="certificadosValilados" min="0" style="font-size: 85%;" title="Cantidad de Certificados Validados" name="certificadosValilados" placeholder="N° Certificados Validados" class="form-control" required="required" autofocus="autofocus">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tabRegistro3">
                      <div class="form">
                        <br/>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-6">
                            <h9 style="color:#939598;font-size: 13px;">Acciones Sustentables</h9>
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-3">
                            <label for="accionesSustCambClimat" style="font-size: 80%;"><element title="Acciones Sustentables en Cambios Climáticos">Acciones Sustentables en Cambios Climáticos</element></label>
                            <input type="number" id="accionesSustCambClimat" min="0" style="font-size: 85%;" name="accionesSustCambClimat" title="Acciones Sustentables en Cambios Climáticos" placeholder="Acciones Sustentables en Cambios Climáticos" class="form-control" required="required" autofocus="autofocus">
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-12">
                            <label for="descripcionSustCambiClima" style="font-size: 80%;"><element title="Descripción de la Acciones Sustentables en Cambios Climáticos">Descripción de la Acciones Sustentables en Cambios Climáticos</element></label>
                            <textarea id="descripcionSustCambiClima" class="md-text-area form-control" title="Descripción de la Acciones Sustentables en Cambios Climáticos" autofocus="autofocus" rows="4" maxlength="350" style="font-size: 85%;" name="descripcionSustCambiClima" placeholder="Escriba aquí la descripcion de las Acciones Sustentables en Cambios Climáticos..."></textarea>
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;">
                          <hr>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-6">
                            <h9 style="color:#939598;font-size: 13px;">Entrenamientos</h9>
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-3">
                            <label for="numeroHorasEntrenaDVC" style="font-size: 80%;"><element title="Número de horas de entrenamiento Dvc-Flesan">NHE - Número de horas de entrenamiento</element></label>
                            <input type="number" id="numeroHorasEntrenaDVC" style="font-size: 85%;" title="Número de horas de entrenamiento Dvc-Flesan" name="numeroHorasEntrenaDVC" min="0" placeholder="NHE (Flesan - DVC)" class="form-control" required="required" autofocus="autofocus" onkeyup="sumar();">
                          </div>
                          <div class="form-group col-md-3">
                            <label for="numeroHorasEntrenaSub" style="font-size: 80%;"><element title="Número de horas de entrenamiento Subcontratistas">NHE - Número de horas de entrenamiento</element></label>
                            <input type="number" id="numeroHorasEntrenaSub" style="font-size: 85%;" title="Número de horas de entrenamiento Subcontratistas" name="numeroHorasEntrenaSub" min="0"  placeholder="NHE (Subcontratistas)" class="form-control" required="required" autofocus="autofocus" onkeyup="sumar();">
                          </div>
                          <div class="form-group col-md-3" style="padding-top: 1%">
                            <label for="totalNHEObra" style="font-size: 80%;"><element title="Total de Número de horas de entrenamiento por Obra">Total de NHE por Obra</element></label>
                            <input type="number" id="totalNHEObra" style="font-size: 85%;" name="totalNHEObra" min="0" title="Total de Número de horas de entrenamiento por Obra" class="form-control" readonly="true">
                          </div>
                          <div class="form-group col-md-3" style="padding-top: 1%">
                            <label for="evaluacionCliente" style="font-size: 80%;"><element title="Evaluación Cliente">Evaluación Cliente</element></label>
                            <input type="number" id="evaluacionCliente" style="font-size: 85%;" name="evaluacionCliente" title="Evaluación Cliente" min="0" placeholder="Evaluación Cliente" class="form-control" required="required" autofocus="autofocus">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tabRegistro4">
                      <div class="form">
                        <br/>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-6">
                            <h9 style="color:#939598;font-size: 13px;">Conformidad de Procesos y Productos (AUDITORIAS)</h9>
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-2">
                            <label for="fechaRecepcionInforme" style="font-size: 80%;">Fecha Recepción Informe Auditoria</label>
                            <input type="date"  id="fechaRecepcionInforme"  style="font-size: 85%;" name="fechaRecepcionInforme" min="0" class="form-control" autofocus="autofocus">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="totalNCOBS" style="font-size: 80%;">Cantidad total NC, y OBS de la auditoría</label>
                            <input type="number" min="0" id="totalNCOBS" style="font-size: 85%;"  name="totalNCOBS" placeholder="Total NC, y OBS" min="0" class="form-control" autofocus="autofocus">
                          </div>
                          <div class="form-group col-md-2" style="padding-top: 1%">
                            <label for="gestionAmbiental" style="font-size: 80%;">Gestión Ambiental</label>
                            <input type="number" min="0" id="gestionAmbiental" style="font-size: 85%;" name="gestionAmbiental" placeholder="% Gestión Ambiental" min="0" max="100" class="form-control" autofocus="autofocus" step="any" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="gestionSeguridadSalud" style="font-size: 80%;">Gestión de Seguridad y Salud Ocupacional</label>
                            <input type="number" min="0" id="gestionSeguridadSalud" style="font-size: 85%;" name="gestionSeguridadSalud" placeholder="% Gestión Seguridad y Salud Ocupacional" min="0" class="form-control" autofocus="autofocus" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="evaluacionCumplimientoLegal" style="font-size: 80%;">Evaluación del Cumplimiento Legal</label>
                            <input type="number" min="0" id="evaluacionCumplimientoLegal" style="font-size: 85%;" name="evaluacionCumplimientoLegal" placeholder="% Evaluación del Cumplimiento" min="0"  class="form-control" step="any" autofocus="autofocus" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="interaccionPartPractSSOMA" style="font-size: 80%;">Interacción y partición de prácticas de SSOMA</label>
                            <input type="number" min="0" id="interaccionPartPractSSOMA" style="font-size: 85%;" name="interaccionPartPractSSOMA" placeholder="Interacción y partición de prácticas de SSOMA" min="0"  class="form-control" autofocus="autofocus" required="required">
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-12">
                            <label for="descripcionInteraccionParticionPracticas" style="font-size: 80%;">Descripción de la Interacción y partición de prácticas de SSOMA</label>
                            <textarea id="descripcionInteraccionParticionPracticas" style="font-size: 85%;" class="md-text-area form-control" autofocus="autofocus" rows="4" maxlength="350" name="descripcionInteraccionParticionPracticas" placeholder="Escriba aquí la descripción de la Interacción y partición de Practicás de SSOMA..."></textarea>
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-2" style="padding-top: 1.5%">
                            <label for="reunionesSSOMAObra" style="font-size: 80%;">Reuniones de SSOMA en Obra</label>
                            <input type="number" min="0" style="font-size: 85%;" id="reunionesSSOMAObra" name="reunionesSSOMAObra" placeholder="Reuniones de SSOMA en Obra" min="0"  class="form-control" autofocus="autofocus" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="generacionResiduosObrasEdif" style="font-size: 80%;">Generación de Residuos en las Obras de Edificaciones</label>
                            <input type="number" min="0" id="generacionResiduosObrasEdif" name="generacionResiduosObrasEdif" placeholder="Generación residuos Obras Edificaciones" min="0" style="font-size: 85%;" class="form-control" autofocus="autofocus" required="required">
                            <h9 style="color: #BFBFBF;font-size: 68%;">*Cant. de energia en m3/mes</h9>
                          </div>
                          <div class="form-group col-md-2">
                            <label for="cantidadResiduosDispuestos" style="font-size: 80%;">Cantidad de Residuos Dispuestos en una EPS-RS/EC-RS</label>
                            <input type="number" min="0" id="cantidadResiduosDispuestos" name="cantidadResiduosDispuestos" placeholder="Cantidad Residuos Dispuestos" min="0"  style="font-size: 85%;" class="form-control" autofocus="autofocus" required="required">
                            <h9 style="color: #BFBFBF;font-size: 68%;">*Cant. de energia en m3/mes</h9>
                          </div>
                          <div class="form-group col-md-2">
                            <label for="consumoAguaObrEdif" style="font-size: 80%;">Consumo de Agua en las Obras de Edificaciones</label>
                            <input type="number" min="0" id="consumoAguaObrEdif" name="consumoAguaObrEdif" placeholder="Consumo de Agua en la Obra" min="0"  class="form-control" autofocus="autofocus" style="font-size: 85%;" required="required">
                          </div>
                          <div class="form-group col-md-2">
                            <label for="consumoEnergObrEdif" style="font-size: 80%;">Consumo de Energia Elétrica en las Obras de Edificaciones</label>
                            <input type="number" min="0" id="consumoEnergObrEdif" name="consumoEnergObrEdif" placeholder="Consumo de Energia Elétrica en la obra" min="0"  class="form-control" style="font-size: 85%;" autofocus="autofocus" required="required">
                            <h9 style="color: #BFBFBF;font-size: 68%;">*Cant. de energia en kWh/mes</h9>
                          </div>
                        </div>
                        <div class="form-group row" style="margin-left: 0;margin-right: 0;margin-bottom: 10px;">
                          <div class="form-group col-md-3">
                            <button type="submit" class="btn btn-danger"><i class="far fa-save"></i> Registrar</button>
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
    <script type="text/javascript" src="{{ asset('js-proyect/admin/proyectos/indicadores_registro.js') }}"></script>
    <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
@endsection