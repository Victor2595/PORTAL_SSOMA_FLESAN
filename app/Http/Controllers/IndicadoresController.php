<?php

namespace Portal_SSOMA\Http\Controllers; 

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Portal_SSOMA\Models\Proyecto;
use Portal_SSOMA\Models\Indicadores;
use Portal_SSOMA\Models\Auditoria_Validacion;
use Illuminate\Support\Facades\DB;
use Portal_SSOMA\Mail\GmailNotificacionJefe;
use Portal_SSOMA\Mail\GmailNotificacionJefeModificacion;
use Alert;
use DateTime;
use Carbon\Carbon;

use Portal_SSOMA\Charts\seguimientoJefe;

class IndicadoresController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function indicadores_l()
    {
        if(auth()->user()->rol[0]->id_rol == 7){    
            $codigo_proyecto = auth()->user()->rol[0]->objeto_permitido;
            if($codigo_proyecto != ""){
                $nombPro = Proyecto::where('codigo_proyecto',$codigo_proyecto)->get();
                $contador = DB::connection('srvdesbdpg')->select('select i.id_indicadores from ssoma.tbl_indicadores i left join ssoma.tbl_auditoria_validacion av on av.id_indicadores = i.id_indicadores and av.estado_validacion = i.estado_validacion where i.estado = 1 and av.estado_validacion = 4 and i.id_proyecto = '.$nombPro[0]->id_proyecto.' and 
                            CONCAT(EXTRACT(MONTH FROM av.fecha_ejecuta_accion) || \'/\' || EXTRACT(YEAR FROM av.fecha_ejecuta_accion))= CONCAT(EXTRACT(MONTH FROM now()) || \'/\' || EXTRACT(YEAR FROM now()))');
                $tablalistado = DB::connection('srvdesbdpg')->select('select DISTINCT i.id_indicadores,CONCAT(CASE WHEN extract(month from i.fecha_registro)=1 then \'ENERO\' WHEN extract(month from i.fecha_registro)=2 then \'FEBRERO\' WHEN extract(month from i.fecha_registro)=3 then \'MARZO\' WHEN extract(month from i.fecha_registro)=4 then \'ABRIL\' WHEN extract(month from i.fecha_registro)=5 then \'MAYO\' WHEN extract(month from i.fecha_registro)=6 then \'JUNIO\' WHEN extract(month from i.fecha_registro)=7 then \'JULIO\' WHEN extract(month from i.fecha_registro)=8 then \'AGOSTO\' WHEN extract(month from i.fecha_registro)=9 then \'SETIEMBRE\' WHEN extract(month from i.fecha_registro)=10 then \'OCTUBRE\' WHEN extract(month from i.fecha_registro)=11 then \'NOVIEMBRE\' WHEN extract(month from i.fecha_registro)=12 then \'DICIEMBRE\' END ,\'-\',extract(YEAR from i.fecha_registro)) as mes,MAX(cast(av.fecha_ejecuta_accion as date)) as fecha,CASE WHEN i.estado_validacion=1 THEN \'EN REDACCION\' WHEN i.estado_validacion=2 THEN \'ENTREGADO A SSOMA\' WHEN i.estado_validacion=3 THEN \'OBSERVADO\' WHEN i.estado_validacion=4 THEN \'APROBADO\' END as estado_vali,i.estado_validacion,av.descripcion FROM ssoma.TBL_INDICADORES i inner join ssoma.tbl_auditoria_validacion av on av.id_indicadores = i.id_indicadores and i.estado_validacion = av.estado_validacion WHERE i.estado=1 and i.id_proyecto='.$nombPro[0]->id_proyecto.' group by i.id_indicadores,i.fecha_registro,i.estado_validacion,av.descripcion,fecha_ejecuta_accion having av.fecha_ejecuta_accion = (select MAX(fecha_ejecuta_accion) from ssoma.tbl_auditoria_validacion where id_indicadores = i.id_indicadores and estado_validacion = i.estado_validacion) ');
                $mensaje = array();
            }else{
                $nombPro = array();
                $contador= array();
                $tablalistado = array();
                $mensaje = array('mensaje'=>'Usted no esta asignado a ningún Proyecto por el momento, comuniquese con la Oficina Corporativa SSOMA para mayor Información.');
            }
            //print(count($contador));
            return view("indicadores_listado",compact('nombPro','tablalistado','mensaje','contador'));
        }elseif(auth()->user()->rol[0]->id_rol == 6){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function indicadores_r()
    {
        if(auth()->user()->rol[0]->id_rol == 7){  
            $codigo_proyecto = auth()->user()->rol[0]->objeto_permitido;
            if($codigo_proyecto != null){
                $proyecto = Proyecto::where('codigo_proyecto',$codigo_proyecto)->where('estado',1)->first();
                return view("indicadores_registro",compact('proyecto'));    
            }else{
                Alert::warning('Usted no esta asignado a ningún Proyecto por el momento','Alerta');
                return redirect('/indicadores_listado');
            }
        }elseif(auth()->user()->rol[0]->id_rol == 6){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }  
        
    }  

    public function grabarIndicadores(Request $request){
        if(auth()->user()->rol[0]->id_rol == 7){  
            $codigo_proyecto = auth()->user()->rol[0]->objeto_permitido;
            $nombPro = Proyecto::where('codigo_proyecto',$codigo_proyecto)->first();
        	$dia = new DateTime();
        	$indicador = new Indicadores();
        	$indicador->id_proyecto = $nombPro->id_proyecto;
        	$indicador->cantidad_trabajadores = $request->cantidadTrabajadores;
        	$indicador->hht = $request->hombresHoraEx;
        	$indicador->inc = $request->incidentesINC;
        	$indicador->iap = $request->incidentesAP;
        	$indicador->aam = $request->AAM;
        	$indicador->asp = $request->ASP;
        	$indicador->accidentecp = $request->ACP;
        	$indicador->af = $request->AF;
        	$indicador->dias_perdidos = $request->diasPerdidos;
        	$indicador->dias_transportados = $request->diasTransportados;
        	$indicador->dias_desconectados = $request->diasDesconectados;
        	$indicador->cant_trabj_emi = $request->cantidadTrabEMI;
        	$indicador->cant_trabj_emr = $request->cantidadTrabEMS;
        	$indicador->num_trabj_detec_enferm_ocup = $request->numeroTrabajEnfOcu;
        	$indicador->cant_trabaj_expuestos_agent_enferm_ocupacional = $request->numeroTrabExpOcEnferOcup;
        	$indicador->num_trabj_detec_cancer_profesional =$request->numeroTrabajadCanceOcup;
        	$indicador->cant_dias_ause_enferm_noprofes =$request->numeroDiasAuseEnfNP;
        	$indicador->cant_certif_recibidos =$request->certificadosRecibidos;
        	$indicador->cant_certif_validados =$request->certificadosValilados;
        	$indicador->cantidad_colaboradores =$request->cantidadColaboradoresS;
        	$indicador->hhts =$request->hombresHoraExSub;
        	$indicador->incs =$request->incidentesINCSub;
        	$indicador->iaps =$request->incidentesAPSub;
        	$indicador->aams =$request->AAMSub;
        	$indicador->asps =$request->ASPSub;
        	$indicador->accidentecps =$request->ACPSub;
        	$indicador->afs =$request->AFSub;
        	$indicador->dias_perdidoss =$request->diasPerdidosSub;
        	$indicador->dias_transportadoss = $request->diasTransportadosSub;
        	$indicador->dias_desconectadoss = $request->diasDesconectadosSub;
            $indicador->numero_horas_entrenam =$request->numeroHorasEntrenaDVC;
        	$indicador->numero_horas_entrenams = $request->numeroHorasEntrenaSub;
            $indicador->evaluacion_cliente = $request->evaluacionCliente;
        	$indicador->acciones_sustentables_cambios_climaticos = $request->accionesSustCambClimat;
        	$indicador->descripc_acciones_susten_camb_clim = $request->descripcionSustCambiClima;
        	$indicador->total_nhe = $request->totalNHEObra;
        	$indicador->fecha_recepcion_infor_auditoria = $request->fechaRecepcionInforme;
        	$indicador->cant_total_nc_obs_audit = $request->totalNCOBS;
        	$indicador->gestion_ambiental = $request->gestionAmbiental;
        	$indicador->gestion_seguridad_salud_ocup = $request->gestionSeguridadSalud;
        	$indicador->evaluac_cumpl_legal = $request->evaluacionCumplimientoLegal;
        	$indicador->interac_partic_practicas_ssoma = $request->interaccionPartPractSSOMA;
        	$indicador->descrip_inter_parti_practicas_ssoma = $request->descripcionInteraccionParticionPracticas;
        	$indicador->reuniones_ssoma_obre = $request->reunionesSSOMAObra;
        	$indicador->generacion_resid_obras_edificac = $request->generacionResiduosObrasEdif;
        	$indicador->cantidad_residuos_dispuestos = $request->cantidadResiduosDispuestos;
        	$indicador->consumo_agua_obras_edif = $request->consumoAguaObrEdif;
        	$indicador->consumo_energia_obras_edif = $request->consumoEnergObrEdif;
            $indicador->tasa_entrenamiento = ($indicador->total_nhe/($indicador->hht + $indicador->hhts))*100;
            $indicador->tasa_frecuencia_c_tp = (($indicador->accidentecp + $indicador->accidentecps)*$nombPro->factor_indicador_especifico_obra)/($indicador->hht + $indicador->hhts);
            $indicador->tasa_frecuencia_s_tp = (($indicador->asp + $indicador->asps)*$nombPro->factor_indicador_especifico_obra)/($indicador->hht + $indicador->hhts);
            $indicador->tasa_gravedad = (($indicador->dias_perdidos + $indicador->dias_perdidoss)*$nombPro->factor_indicador_especifico_obra)/($indicador->hht + $indicador->hhts);
            $indicador->tasa_accidentabilidad = ($indicador->tasa_gravedad + $indicador->tasa_frecuencia_s_tp)/200;
        	$indicador->estado_validacion = '1';
        	$indicador->usuario_registro = auth()->user()->id_aplicacion_usuario;
        	$indicador->fecha_registro = $dia->format('d-m-y');
        	$indicador->estado = '1';
        	$indicador->save();

            $auditoria = new Auditoria_Validacion();
            $auditoria->id_indicadores = $indicador->id_indicadores;
            $auditoria->usuario_ejecuta_accion = auth()->user()->id_aplicacion_usuario;
            $auditoria->fecha_ejecuta_accion = $dia->format('d-m-y h:i:s');
            $auditoria->descripcion = 'El indicador aun se encuentra en redacción';
            $auditoria->estado_validacion = $indicador->estado_validacion;
            $auditoria->save();
            //print(json_encode($indicador));
            Alert::success('El indicador se guardo correctamente','Guardado');
            return redirect('/indicadores_listado');
        }elseif(auth()->user()->rol[0]->id_rol == 6){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }  
    }

    public function indicadores_listado_general(){
        if(auth()->user()->rol[0]->id_rol == 6){
            $tablalistado = DB::connection('srvdesbdpg')->select('select i.id_indicadores,i.id_proyecto,p.nombre_proyecto,CONCAT(CASE WHEN extract(month from i.fecha_registro)=1 then \'ENERO\' WHEN extract(month from i.fecha_registro)=2 then \'FEBRERO\' WHEN extract(month from i.fecha_registro)=3 then \'MARZO\' WHEN extract(month from i.fecha_registro)=4 then \'ABRIL\' WHEN extract(month from i.fecha_registro)=5 then \'MAYO\' WHEN extract(month from i.fecha_registro)=6 then \'JUNIO\' WHEN extract(month from i.fecha_registro)=7 then \'JULIO\' WHEN extract(month from i.fecha_registro)=8 then \'AGOSTO\' WHEN extract(month from i.fecha_registro)=9 then \'SETIEMBRE\' WHEN extract(month from i.fecha_registro)=10 then \'OCTUBRE\' WHEN extract(month from i.fecha_registro)=11 then \'NOVIEMBRE\' WHEN extract(month from i.fecha_registro)=12 then \'DICIEMBRE\' END ,\'-\',extract(YEAR from i.fecha_registro)) as mes,i.fecha_registro,CASE WHEN i.estado_validacion=1 THEN \'EN REDACCION\' WHEN i.estado_validacion=2 THEN \'ENTREGADO A SSOMA\' WHEN i.estado_validacion=3 THEN \'OBSERVADO\' WHEN estado_validacion=4 THEN \'APROBADO\' END as estado_vali,i.estado_validacion,case when i.estado_validacion =1  then \'El indicador fue enviado\' when i.estado_validacion = 2 then \'\' when i.estado_validacion=3 then \'El indicador fue validado\' end as descripci_observacion FROM ssoma.TBL_INDICADORES i left join ssoma.tbl_proyecto p on p.id_proyecto = i.id_proyecto WHERE i.estado=1 and i.estado_validacion = 2 or i.estado_validacion = 4');   
            $proyectos = DB::connection('srvdesbdpg')->select('select * from ssoma.tbl_proyecto p where p.estado = 1 and p.fecha_inicio between cast(date_trunc(\'month\',current_date - interval \'4 month\') as date) and cast(date_trunc(\'month\',current_date) as date) or p.fecha_fin between cast(date_trunc(\'month\',current_date - interval \'4 month\') as date) and cast(date_trunc(\'month\',current_date) as date) or p.fecha_fin > cast(date_trunc(\'month\',current_date) as date) order by p.id_proyecto');
            $fecha_proyecto = DB::connection('srvdesbdpg')->select('select ml.id_proyecto,ml.nombre_proyecto,MAX(ml.mes1)mes1,MAX(ml.mes2)mes2,MAX(ml.mes3)mes3,MAX(ml.mes4)mes4,MAX(ml.mes5)mes5 from ssoma.tbl_proyecto p left join ssoma.tbl_indicadores i on i.id_proyecto = p.id_proyecto left join ssoma.tbl_auditoria_validacion av on av.id_indicadores = i.id_indicadores and av.estado_validacion = i.estado_validacion,(select p.id_proyecto,p.nombre_proyecto,av.estado_validacion,av.fecha_ejecuta_accion,primero.fecha,segundo.fecha,tercero.fecha,cuarto.fecha,quinto.fecha,case when cast(av.fecha_ejecuta_accion as date) = primero.fecha then primero.estado_validacion else 0 end as mes1,case when cast(av.fecha_ejecuta_accion as date) = segundo.fecha then segundo.estado_validacion else 0 end as mes2,case when cast(av.fecha_ejecuta_accion as date) = tercero.fecha then tercero.estado_validacion else 0 end as mes3,case when cast(av.fecha_ejecuta_accion as date) = cuarto.fecha then cuarto.estado_validacion else 0 end as mes4,case when cast(av.fecha_ejecuta_accion as date) = quinto.fecha then quinto.estado_validacion else 0 end as mes5 from ssoma.tbl_proyecto p left join ssoma.tbl_indicadores i on i.id_proyecto = p.id_proyecto left join ssoma.tbl_auditoria_validacion av on av.id_indicadores = i.id_indicadores and av.estado_validacion = i.estado_validacion,(select i.id_indicadores,p.id_proyecto,av.estado_validacion, case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'4 month\' as date) else cast(av.fecha_ejecuta_accion as date) end as fecha from ssoma.tbl_proyecto p left join ssoma.tbl_indicadores i on p.id_proyecto = i.id_proyecto left join ssoma.tbl_auditoria_validacion av on av.id_indicadores = i.id_indicadores and av.estado_validacion = i.estado_validacion where p.estado = 1  and (concat(extract(year from case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'4 month\' as date) else cast(av.fecha_ejecuta_accion as date)end),\'-\',extract(month from case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'4 month\' as date) else cast(av.fecha_ejecuta_accion as date)end))) = concat(extract(year from cast(current_date - interval \'4 month\' as date)),\'-\',concat(extract(month from cast(current_date - interval \'4 month\' as date)))))as primero,(select i.id_indicadores,p.id_proyecto,av.estado_validacion, case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'3 month\' as date) else cast(av.fecha_ejecuta_accion as date) end as fecha from ssoma.tbl_proyecto p left join ssoma.tbl_indicadores i on p.id_proyecto = i.id_proyecto left join ssoma.tbl_auditoria_validacion av on av.id_indicadores = i.id_indicadores and av.estado_validacion = i.estado_validacion where p.estado = 1  and (concat(extract(year from case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'3 month\' as date) else cast(av.fecha_ejecuta_accion as date)end),\'-\',extract(month from case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'3 month\' as date) else cast(av.fecha_ejecuta_accion as date)end))) = concat(extract(year from cast(current_date - interval \'3 month\' as date)),\'-\',concat(extract(month from cast(current_date - interval \'3 month\' as date)))))as segundo,(select i.id_indicadores,p.id_proyecto,av.estado_validacion, case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'2 month\' as date) else cast(av.fecha_ejecuta_accion as date) end as fecha from ssoma.tbl_proyecto p left join ssoma.tbl_indicadores i on p.id_proyecto = i.id_proyecto left join ssoma.tbl_auditoria_validacion av on av.id_indicadores = i.id_indicadores and av.estado_validacion = i.estado_validacion where p.estado = 1  and (concat(extract(year from case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'2 month\' as date) else cast(av.fecha_ejecuta_accion as date)end),\'-\',extract(month from case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'2 month\' as date) else cast(av.fecha_ejecuta_accion as date)end))) = concat(extract(year from cast(current_date - interval \'2 month\' as date)),\'-\',concat(extract(month from cast(current_date - interval \'2 month\' as date)))))as tercero,(select i.id_indicadores,p.id_proyecto,av.estado_validacion, case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'1 month\' as date) else cast(av.fecha_ejecuta_accion as date) end as fecha from ssoma.tbl_proyecto p left join ssoma.tbl_indicadores i on p.id_proyecto = i.id_proyecto left join ssoma.tbl_auditoria_validacion av on av.id_indicadores = i.id_indicadores and av.estado_validacion = i.estado_validacion where p.estado = 1  and (concat(extract(year from case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'1 month\' as date) else cast(av.fecha_ejecuta_accion as date)end),\'-\',extract(month from case when av.fecha_ejecuta_accion is null then cast(current_date - interval \'1 month\' as date) else cast(av.fecha_ejecuta_accion as date)end))) = concat(extract(year from cast(current_date - interval \'1 month\' as date)),\'-\',concat(extract(month from cast(current_date - interval \'1 month\' as date)))))as cuarto,(select i.id_indicadores,p.id_proyecto,av.estado_validacion, case when av.fecha_ejecuta_accion is null then cast(current_date as date) else cast(av.fecha_ejecuta_accion as date) end as fecha from ssoma.tbl_proyecto p left join ssoma.tbl_indicadores i on p.id_proyecto = i.id_proyecto left join ssoma.tbl_auditoria_validacion av on av.id_indicadores = i.id_indicadores and av.estado_validacion = i.estado_validacion where p.estado = 1  and (concat(extract(year from case when av.fecha_ejecuta_accion is null then cast(current_date as date) else cast(av.fecha_ejecuta_accion as date)end),\'-\',extract(month from case when av.fecha_ejecuta_accion is null then cast(current_date as date) else cast(av.fecha_ejecuta_accion as date)end))) = concat(extract(year from cast(current_date  as date)),\'-\',concat(extract(month from cast(current_date as date)))))as quinto where p.estado=1 and p.fecha_inicio between cast(date_trunc(\'month\',current_date - interval \'4 month\') as date) and cast(date_trunc(\'month\',current_date) as date) or p.fecha_fin between cast(date_trunc(\'month\',current_date - interval \'4 month\') as date) and cast(date_trunc(\'month\',current_date) as date) or p.fecha_fin > cast(date_trunc(\'month\',current_date) as date)) as ml where p.estado = 1 and p.fecha_inicio between cast(date_trunc(\'month\',current_date - interval \'4 month\') as date) and  cast(date_trunc(\'month\',current_date) as date) or p.fecha_fin between cast(date_trunc(\'month\',current_date - interval \'4 month\') as date) and cast(date_trunc(\'month\',current_date) as date) or p.fecha_fin > cast(date_trunc(\'month\',current_date) as date) group by ml.id_proyecto,ml.nombre_proyecto');
            $meses = DB::connection('srvdesbdpg')->select('select TO_CHAR(cast(current_date - interval \'4 month\' as date), \'TMMonth\')mes1,TO_CHAR(cast(current_date - interval \'3 month\' as date), \'TMMonth\')mes2,TO_CHAR(cast(current_date - interval \'2 month\' as date), \'TMMonth\')mes3,TO_CHAR(cast(current_date - interval \'1 month\' as date), \'TMMonth\')mes4,TO_CHAR(cast(current_date as date), \'TMMonth\')mes5');
                   
            $list = array();
            for($i=0;$i<count($fecha_proyecto);$i++){
                $x = 0;
                $y = $i;
                $dat[] =array($x, $y, (int)$fecha_proyecto[$i]->mes1);
                $list =  $dat;
            }
            for($i=0;$i<count($fecha_proyecto);$i++){
                $x = 1;
                $y = $i;
                $dat[] =array($x, $y, (int)$fecha_proyecto[$i]->mes2);
                $list =  $dat;
            }
            for($i=0;$i<count($fecha_proyecto);$i++){
                $x = 2;
                $y = $i;
                $dat[] =array($x, $y, (int)$fecha_proyecto[$i]->mes3);
                $list =  $dat;
            }
            for($i=0;$i<count($fecha_proyecto);$i++){
                $x = 3;
                $y = $i;
                $dat[] =array($x, $y, (int)$fecha_proyecto[$i]->mes4);
                $list =  $dat;
            }
            for($i=0;$i<count($fecha_proyecto);$i++){
                $x = 4;
                $y = $i;
                $dat[] =array($x, $y, (int)$fecha_proyecto[$i]->mes5);
                $list =  $dat;
            }
            //print(json_encode($proyectos));
            return view("indicadores_listado_general",compact('tablalistado','fecha_proyecto','meses','proyectos','list'));
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function validacion_observacion($id){
        $indicador_validacion = Indicadores::where('id_indicadores',$id)->get();
        return view('indicadores_visualizacion',compact('indicador_validacion'));
    }

    public function aprobar_indicadores(Request $request){
        if(auth()->user()->rol[0]->id_rol == 6){
            $codigo_proyecto = auth()->user()->rol[0]->objeto_permitido;
            $dia = new DateTime();
            if($request->estadoRadio == 1){
                Indicadores::where('id_indicadores',$request->id_indicadores)->update(['estado_validacion'=>4]);
                $auditoria = new Auditoria_Validacion();
                $auditoria->id_indicadores = $request->id_indicadores;
                $auditoria->usuario_ejecuta_accion = auth()->user()->id_aplicacion_usuario;
                $auditoria->fecha_ejecuta_accion = $dia->format('d-m-y h:i:s');
                $auditoria->descripcion = 'El indicador fue aprobado';
                $auditoria->estado_validacion = 4;
                $auditoria->save();
                Alert::success('El indicador se aprobo correctamente','Aprobado');
                return redirect('/indicadores_listado_general');
            }else if($request->estadoRadio == 2){
                Indicadores::where('id_indicadores',$request->id_indicadores)->update(['estado_validacion'=>3]);
                $auditoria = new Auditoria_Validacion();
                $auditoria->id_indicadores = $request->id_indicadores;
                $auditoria->usuario_ejecuta_accion = auth()->user()->id_aplicacion_usuario;
                $auditoria->fecha_ejecuta_accion = $dia->format('d-m-y h:i:s');
                $auditoria->descripcion = $request->descripcionObservacion;
                $auditoria->estado_validacion = 3;
                $auditoria->save();
                Alert::info('El indicador se devolvio al jefe SSOMA para su respectiva modificación','Observado');
                return redirect('/indicadores_listado_general');
            }
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function editIndicadores($id){
        if(auth()->user()->rol[0]->id_rol == 7){    
            $query = Indicadores::where('id_indicadores',$id)->get();
            $proyecto = DB::connection('srvdesbdpg')->select('select CONCAT(to_char(i.fecha_registro, \'TMMONTH\'),\'-\',EXTRACT(YEAR from i.fecha_registro)) as fecha from ssoma.tbl_indicadores i where i.id_indicadores ='.$id);
            $auditoria = Auditoria_Validacion::where('id_indicadores',$id)->where('estado_validacion',$query[0]->estado_validacion)->get();
            return view('/indicadores_edit',compact('query','proyecto','auditoria'));
        }elseif(auth()->user()->rol[0]->id_rol == 6){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function sendIndicadores($id){
        if(auth()->user()->rol[0]->id_rol == 7){
            Indicadores::where('id_indicadores',$id)->update(['estado_validacion'=>2]);
            $dia = new DateTime();
            $auditoria = new Auditoria_Validacion();
            $auditoria->id_indicadores = $id;
            $auditoria->usuario_ejecuta_accion = auth()->user()->id_aplicacion_usuario;
            $auditoria->fecha_ejecuta_accion = $dia->format('d-m-y h:i:s');
            $auditoria->descripcion = 'El indicador fue enviado a los Asistentes Corporativos SSOMA';
            $auditoria->estado_validacion = 2;
            $auditoria->save();
            Alert::success('El indicador se envio correctamente','Enviado');
            return redirect('/indicadores_listado');
        }elseif(auth()->user()->rol[0]->id_rol == 6){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function update_indicadores(Request $request,$id){
        if(auth()->user()->rol[0]->id_rol == 7){    
            $dia = new DateTime();
            $estadoIndicador = Indicadores::where('id_indicadores',$id)->get();
            $indicador = Indicadores::find($id);
            $auditoria = new Auditoria_Validacion();
            if($estadoIndicador[0]->estado_validacion == 1){
                $indicador->cantidad_trabajadores = $request->cantidadTrabajadores; 
                $indicador->hht = $request->hombresHoraEx;
                $indicador->inc = $request->incidentesINC;
                $indicador->iap = $request->incidentesAP;
                $indicador->aam = $request->AAM;
                $indicador->asp = $request->ASP;
                $indicador->accidentecp = $request->ACP;
                $indicador->af = $request->AF;
                $indicador->dias_perdidos = $request->diasPerdidos;
                $indicador->dias_transportados = $request->diasTransportados;
                $indicador->dias_desconectados = $request->diasDesconectados;
                $indicador->cant_trabj_emi = $request->cantidadTrabEMI;
                $indicador->cant_trabj_emr = $request->cantidadTrabEMS;
                $indicador->num_trabj_detec_enferm_ocup = $request->numeroTrabajEnfOcu;
                $indicador->cant_trabaj_expuestos_agent_enferm_ocupacional = $request->numeroTrabExpOcEnferOcup;
                $indicador->num_trabj_detec_cancer_profesional = $request->numeroTrabajadCanceOcup;
                $indicador->cant_dias_ause_enferm_noprofes = $request->numeroDiasAuseEnfNP;
                $indicador->cant_certif_recibidos = $request->certificadosRecibidos;
                $indicador->cant_certif_validados = $request->certificadosValilados;
                $indicador->numero_horas_entrenam = $request->numeroHorasEntrenaDVC;
                $indicador->cantidad_colaboradores = $request->cantidadColaboradoresS;
                $indicador->hhts = $request->hombresHoraExSub;
                $indicador->incs = $request->incidentesINCSub;
                $indicador->iaps = $request->incidentesAPSub;
                $indicador->aams = $request->AAMSub;
                $indicador->asps = $request->ASPSub;
                $indicador->accidentecps = $request->ACPSub;
                $indicador->afs = $request->AFSub;
                $indicador->dias_perdidoss = $request->diasPerdidosSub;
                $indicador->dias_transportadoss = $request->diasTransportadosSub;
                $indicador->dias_desconectadoss = $request->diasDesconectadosSub;
                $indicador->numero_horas_entrenams = $request->numeroHorasEntrenaSub;
                $indicador->total_nhe = $request->totalNHEObra;
                $indicador->evaluacion_cliente = $request->evaluacionCliente;
                $indicador->acciones_sustentables_cambios_climaticos = $request->accionesSustCambClimat;
                $indicador->descripc_acciones_susten_camb_clim = $request->descripcionSustCambiClima;
                $indicador->fecha_recepcion_infor_auditoria = $request->fechaRecepcionInforme;
                $indicador->cant_total_nc_obs_audit = $request->totalNCOBS;
                $indicador->gestion_ambiental = $request->gestionAmbiental;
                $indicador->gestion_seguridad_salud_ocup = $request->gestionSeguridadSalud;
                $indicador->evaluac_cumpl_legal = $request->evaluacionCumplimientoLegal;
                $indicador->interac_partic_practicas_ssoma = $request->interaccionPartPractSSOMA;
                $indicador->descrip_inter_parti_practicas_ssoma = $request->descripcionInteraccionParticionPracticas;
                $indicador->reuniones_ssoma_obre = $request->reunionesSSOMAObra;
                $indicador->generacion_resid_obras_edificac = $request->generacionResiduosObrasEdif;
                $indicador->cantidad_residuos_dispuestos = $request->cantidadResiduosDispuestos;
                $indicador->consumo_agua_obras_edif = $request->consumoAguaObrEdif;
                $indicador->consumo_energia_obras_edif = $request->consumoEnergObrEdif;
                $indicador->tasa_entrenamiento = ($indicador->total_nhe/($indicador->hht + $indicador->hhts))*100;
                $indicador->tasa_frecuencia_c_tp = (($indicador->accidentecp + $indicador->accidentecps)*$nombPro->factor_indicador_especifico_obra)/($indicador->hht + $indicador->hhts);
                $indicador->tasa_frecuencia_s_tp = (($indicador->asp + $indicador->asps)*$nombPro->factor_indicador_especifico_obra)/($indicador->hht + $indicador->hhts);
                $indicador->tasa_gravedad = (($indicador->dias_perdidos + $indicador->dias_perdidoss)*$nombPro->factor_indicador_especifico_obra)/($indicador->hht + $indicador->hhts);
                $indicador->tasa_accidentabilidad = ($indicador->tasa_gravedad + $indicador->tasa_frecuencia_s_tp)/200;
                $indicador->estado_validacion = 1;
                $indicador->usuario_modificacion = auth()->user()->id_aplicacion_usuario;
                $indicador->fecha_modificacion = $dia->format('d-m-y');
                $indicador->save();

                $auditoria->id_indicadores = $request->id_indicadores;
                $auditoria->usuario_ejecuta_accion = auth()->user()->id_aplicacion_usuario;
                $auditoria->fecha_ejecuta_accion = $dia->format('d-m-y h:i:s');
                $auditoria->descripcion = 'El indicador  en redacción fue modificado';
                $auditoria->estado_validacion = 1;
                $auditoria->save();
                Alert::success('El indicador se modificó correctamente','Modificado');

            }else if($estadoIndicador[0]->estado_validacion == 3){
                $indicador->cantidad_trabajadores = $request->cantidadTrabajadores; 
                $indicador->hht = $request->hombresHoraEx;
                $indicador->inc = $request->incidentesINC;
                $indicador->iap = $request->incidentesAP;
                $indicador->aam = $request->AAM;
                $indicador->asp = $request->ASP;
                $indicador->accidentecp = $request->ACP;
                $indicador->af = $request->AF;
                $indicador->dias_perdidos = $request->diasPerdidos;
                $indicador->dias_transportados = $request->diasTransportados;
                $indicador->dias_desconectados = $request->diasDesconectados;
                $indicador->cant_trabj_emi = $request->cantidadTrabEMI;
                $indicador->cant_trabj_emr = $request->cantidadTrabEMS;
                $indicador->num_trabj_detec_enferm_ocup = $request->numeroTrabajEnfOcu;
                $indicador->cant_trabaj_expuestos_agent_enferm_ocupacional = $request->numeroTrabExpOcEnferOcup;
                $indicador->num_trabj_detec_cancer_profesional = $request->numeroTrabajadCanceOcup;
                $indicador->cant_dias_ause_enferm_noprofes = $request->numeroDiasAuseEnfNP;
                $indicador->cant_certif_recibidos = $request->certificadosRecibidos;
                $indicador->cant_certif_validados = $request->certificadosValilados;
                $indicador->numero_horas_entrenam = $request->numeroHorasEntrenaDVC;
                $indicador->cantidad_colaboradores = $request->cantidadColaboradoresS;
                $indicador->hhts = $request->hombresHoraExSub;
                $indicador->incs = $request->incidentesINCSub;
                $indicador->iaps = $request->incidentesAPSub;
                $indicador->aams = $request->AAMSub;
                $indicador->asps = $request->ASPSub;
                $indicador->accidentecps = $request->ACPSub;
                $indicador->afS = $request->AFSub;
                $indicador->dias_perdidoss = $request->diasPerdidosSub;
                $indicador->dias_transportadoss = $request->diasTransportadosSub;
                $indicador->dias_desconectadoss = $request->diasDesconectadosSub;
                $indicador->numero_horas_entrenams = $request->numeroHorasEntrenaSub;
                $indicador->total_nhe = $request->totalNHEObra;
                $indicador->evaluacion_cliente = $request->evaluacionCliente;
                $indicador->acciones_sustentables_cambios_climaticos = $request->accionesSustCambClimat;
                $indicador->descripc_acciones_susten_camb_clim = $request->descripcionSustCambiClima;
                $indicador->fecha_recepcion_infor_auditoria = $request->fechaRecepcionInforme;
                $indicador->cant_total_nc_obs_audit = $request->totalNCOBS;
                $indicador->gestion_ambiental = $request->gestionAmbiental;
                $indicador->gestion_seguridad_salud_ocup = $request->gestionSeguridadSalud;
                $indicador->evaluac_cumpl_legal = $request->evaluacionCumplimientoLegal;
                $indicador->interac_partic_practicas_ssoma = $request->interaccionPartPractSSOMA;
                $indicador->descrip_inter_parti_practicas_ssoma = $request->descripcionInteraccionParticionPracticas;
                $indicador->reuniones_ssoma_obre = $request->reunionesSSOMAObra;
                $indicador->generacion_resid_obras_edificac = $request->generacionResiduosObrasEdif;
                $indicador->cantidad_residuos_dispuestos = $request->cantidadResiduosDispuestos;
                $indicador->consumo_agua_obras_edif = $request->consumoAguaObrEdif;
                $indicador->consumo_energia_obras_edif = $request->consumoEnergObrEdif;
                $indicador->tasa_entrenamiento = ($indicador->total_nhe/(($indicador->hht + $indicador->hhts)*100));
                $indicador->tasa_frecuencia_c_tp = (($indicador->accidentecp + $indicador->accidentecps)*$nombPro->factor_indicador_especifico_obra)/($indicador->hht + $indicador->hhts);
                $indicador->tasa_frecuencia_s_tp = (($indicador->asp + $indicador->asps)*$nombPro->factor_indicador_especifico_obra)/($indicador->hht + $indicador->hhts);
                $indicador->tasa_gravedad = (($indicador->dias_perdidos + $indicador->dias_perdidoss)*$nombPro->factor_indicador_especifico_obra)/($indicador->hht + $indicador->hhts);
                $indicador->tasa_accidentabilidad = ($indicador->tasa_gravedad + $indicador->tasa_frecuencia_s_tp)/200;
                $indicador->estado_validacion = 2;
                $indicador->usuario_modificacion = auth()->user()->id_aplicacion_usuario;
                $indicador->fecha_modificacion = $dia->format('d-m-y');
                $indicador->save();

                $auditoria->id_indicadores = $id;
                $auditoria->usuario_ejecuta_accion = auth()->user()->id_aplicacion_usuario;
                $auditoria->fecha_ejecuta_accion = $dia->format('d-m-y h:i:s');
                $auditoria->descripcion = 'El indicador observado fue enviado a los Asistentes Corporativos SSOMA';
                $auditoria->estado_validacion = 2;
                $auditoria->save();
                Alert::success('El indicador se envio correctamente','Enviado');
            }
            return redirect('/indicadores_listado');
        }elseif(auth()->user()->rol[0]->id_rol == 6){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

}