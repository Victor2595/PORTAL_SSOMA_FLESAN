<?php 

namespace Portal_SSOMA\Http\Controllers; 

use Illuminate\Http\Request;
use Portal_SSOMA\Http\Requests;
//use GuzzleHttp\Client;
use Portal_SSOMA\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Portal_SSOMA\Models\Programacion_Anual as Programacion;
use Portal_SSOMA\Models\Programacion_Anual_Det as Programacion_det;
use Portal_SSOMA\Imports\UsersImport;
use Portal_SSOMA\Models\Proyecto as Proyecto;
use Maatwebsite\Excel\Facades\Excel;
use Alert;
use DateTime;

class ProgramacionAnualController extends Controller{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	if(auth()->user()->rol[0]->id_rol == 7){    
            $codproy = auth()->user()->rol[0]->objeto_permitido;
            if($codproy != ""){
        	       $datosTablaProgramacion = DB::connection('srvdesbdpg')->select('select ls.id_liderazgo_ssoma,ls.id_proyecto,p.nombre_proyecto, CONCAT(case when EXTRACT(MONTH from ls.periodo)=1 then \'ENE\' when EXTRACT(MONTH from ls.periodo)=2 then \'FEB\' when EXTRACT(MONTH from ls.periodo)=3 then \'MAR\' when EXTRACT(MONTH from ls.periodo)=4 then \'ABR\' when EXTRACT(MONTH from ls.periodo)=5 then \'MAY\' when EXTRACT(MONTH from ls.periodo)=6 then \'JUN\' when EXTRACT(MONTH from ls.periodo)=7 then \'JUL\' when EXTRACT(MONTH from ls.periodo)=8 then \'AGO\' when EXTRACT(MONTH from ls.periodo)=9 then \'SET\' when EXTRACT(MONTH from ls.periodo)=10 then \'OCT\' when EXTRACT(MONTH from ls.periodo)=11 then \'NOV\' when EXTRACT(MONTH from ls.periodo)=12 then \'DIC\' end,\'-\', EXTRACT(YEAR from ls.periodo)) as fecha_periodo,round(CAst(ls.tpe_plv as decimal(5,1)),1) as tpe_plv FROM ssoma.tbl_liderazgo_ssoma_det lsd inner join ssoma.tbl_liderazgo_ssoma ls on ls.id_liderazgo_ssoma = lsd.id_liderazgo_ssoma inner join ssoma.tbl_proyecto p on ls.id_proyecto = p.id_proyecto where p.codigo_proyecto=\''.$codproy.'\' and ls.estado = 1 group by ls.id_liderazgo_ssoma,ls.id_proyecto,p.nombre_proyecto,ls.periodo,ls.tpe_plv');
        	       $proyec = DB::connection('srvdesbdpg')->select('select nombre_proyecto from ssoma.tbl_proyecto where  codigo_proyecto=\''.$codproy.'\' and estado = 1 limit 1');
            }else{
                $datosTablaProgramacion = array();
                $proyec = array();
            }
            //print(json_encode($proyec[0]->nombre_proyecto));
        	return view("programacion_anual",compact('datosTablaProgramacion','proyec'));
        }elseif(auth()->user()->rol[0]->id_rol == 6){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }    
    }

    public function listado()
    {
        if(auth()->user()->rol[0]->id_rol == 6){	
            $codproy = auth()->user()->rol[0]->objeto_permitido;
        	$datosTablaProgramacion = DB::connection('srvdesbdpg')->select('select ls.id_liderazgo_ssoma,ls.id_proyecto,p.id_usuario,au.name,p.nombre_proyecto, CONCAT(case when EXTRACT(MONTH from ls.periodo)=1 then \'ENE\' when EXTRACT(MONTH from ls.periodo)=2 then \'FEB\' when EXTRACT(MONTH from ls.periodo)=3 then \'MAR\' when EXTRACT(MONTH from ls.periodo)=4 then \'ABR\' when EXTRACT(MONTH from ls.periodo)=5 then \'MAY\' when EXTRACT(MONTH from ls.periodo)=6 then \'JUN\' when EXTRACT(MONTH from ls.periodo)=7 then \'JUL\' when EXTRACT(MONTH from ls.periodo)=8 then \'AGO\' when EXTRACT(MONTH from ls.periodo)=9 then \'SET\' when EXTRACT(MONTH from ls.periodo)=10 then \'OCT\' when EXTRACT(MONTH from ls.periodo)=11 then \'NOV\' when EXTRACT(MONTH from ls.periodo)=12 then \'DIC\' end,\'-\', EXTRACT(YEAR from ls.periodo)) as fecha_periodo,round(CAst(ls.tpe_plv as decimal(5,1)),1) as tpe_plv FROM ssoma.tbl_liderazgo_ssoma_det lsd inner join ssoma.tbl_liderazgo_ssoma ls on ls.id_liderazgo_ssoma = lsd.id_liderazgo_ssoma inner join ssoma.tbl_proyecto p on ls.id_proyecto = p.id_proyecto inner join seguridadapp.aplicacion_usuario au on au.id_aplicacion_usuario = p.id_usuario where ls.estado = 1 group by ls.id_liderazgo_ssoma,ls.id_proyecto,p.id_usuario,p.nombre_proyecto,ls.periodo,ls.tpe_plv,au.name');
        	return view("programacion_anual_general",compact('datosTablaProgramacion'));
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function registro_programacion()
    {
        if(auth()->user()->rol[0]->id_rol == 7){	
            $datosProyecto =  Proyecto::where('id_usuario','=',auth()->user()->id_aplicacion_usuario)->first();
            if($datosProyecto != null){
                $mensaje = array();
                return view("programacion_anual_registro",compact('datosProyecto','mensaje'));
            }else{
                $mensaje = array('mensaje'=>'Usted no esta asignado a ningún Proyecto por el momento, comuniquese con la Oficina Corporativa SSOMA para mayor Información.');
                Alert::warning('Usted no esta asignado a ningún Proyecto por el momento','Alerta');
                return redirect('/programacion_anual');
            }
        }elseif(auth()->user()->rol[0]->id_rol == 6){
    	    Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    
    public function importProgramacion()
	{	
		if(auth()->user()->rol[0]->id_rol == 7){  
            $dat = Excel::import(new UsersImport,request()->file('excel'));
    		Alert::success('La programación se guardo correctamente','Guardado');
            return redirect('/programacion_anual');
        }elseif(auth()->user()->rol[0]->id_rol == 6){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }   
	}

	public function destroy($id)
	{
		if(auth()->user()->rol[0]->id_rol == 7){
            $liderazgo = DB::connection('srvdesbdpg')->select('select ls.id_liderazgo_ssoma,ls.id_proyecto,p.nombre_proyecto, CONCAT(case when EXTRACT(MONTH from ls.periodo)=1 then \'ENE\' when EXTRACT(MONTH from ls.periodo)=2 then \'FEB\' when EXTRACT(MONTH from ls.periodo)=3 then \'MAR\' when EXTRACT(MONTH from ls.periodo)=4 then \'ABR\' when EXTRACT(MONTH from ls.periodo)=5 then \'MAY\' when EXTRACT(MONTH from ls.periodo)=6 then \'JUN\' when EXTRACT(MONTH from ls.periodo)=7 then \'JUL\' when EXTRACT(MONTH from ls.periodo)=8 then \'AGO\' when EXTRACT(MONTH from ls.periodo)=9 then \'SET\' when EXTRACT(MONTH from ls.periodo)=10 then \'OCT\' when EXTRACT(MONTH from ls.periodo)=11 then \'NOV\' when EXTRACT(MONTH from ls.periodo)=12 then \'DIC\' end,\'-\', EXTRACT(YEAR from ls.periodo)) as fecha_periodo,round(CAst(ls.tpe_plv as decimal(5,1)),1) as tpe_plv FROM ssoma.tbl_liderazgo_ssoma_det lsd inner join ssoma.tbl_liderazgo_ssoma ls on ls.id_liderazgo_ssoma = lsd.id_liderazgo_ssoma inner join ssoma.tbl_proyecto p on ls.id_proyecto = p.id_proyecto where ls.estado = 1 and ls.id_liderazgo_ssoma='.$id.' group by ls.id_liderazgo_ssoma,ls.id_proyecto,p.nombre_proyecto,ls.periodo,ls.tpe_plv');

        	$deleteCabecera = DB::connection('srvdesbdpg')->update('update ssoma.tbl_liderazgo_ssoma SET estado = 0 WHERE id_liderazgo_ssoma='.$id);
        	$deleteDetalle = DB::connection('srvdesbdpg')->update('update ssoma.tbl_liderazgo_ssoma_det SET estado = 0 WHERE id_liderazgo_ssoma='.$id);
        	Alert::success('El programa '.$liderazgo[0]->fecha_periodo.' del proyecto' .$liderazgo[0]->nombre_proyecto. ' fue borrado exitosamente','Borrado');
            return redirect()->route("programacion_anual");
        }elseif(auth()->user()->rol[0]->id_rol == 6){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
	}

    public function visualizacionProgramacion($id){
        if(auth()->user()->rol[0]->id_rol == 6){
            $progra = Programacion::where('id_liderazgo_ssoma',$id)->where('estado',1)->get();
            $programa = Programacion_det::where('id_liderazgo_ssoma',$id)->where('estado',1)->get();

            $proyecx = $progra[0]->id_proyecto;
            $proyec = Proyecto::where('id_proyecto',$proyecx)->get();
            $mes = DB::connection('srvdesbdpg')->select('select CONCAT(case when EXTRACT(MONTH from ls.periodo)=1 then \'ENE\' when EXTRACT(MONTH from ls.periodo)=2 then \'FEB\' when EXTRACT(MONTH from ls.periodo)=3 then \'MAR\' when EXTRACT(MONTH from ls.periodo)=4 then \'ABR\' when EXTRACT(MONTH from ls.periodo)=5 then \'MAY\' when EXTRACT(MONTH from ls.periodo)=6 then \'JUN\' when EXTRACT(MONTH from ls.periodo)=7 then \'JUL\' when EXTRACT(MONTH from ls.periodo)=8 then \'AGO\' when EXTRACT(MONTH from ls.periodo)=9 then \'SET\' when EXTRACT(MONTH from ls.periodo)=10 then \'OCT\' when EXTRACT(MONTH from ls.periodo)=11 then \'NOV\' when EXTRACT(MONTH from ls.periodo)=12 then \'DIC\' end,\'-\', EXTRACT(YEAR from ls.periodo)) as fecha_periodo FROM ssoma.tbl_liderazgo_ssoma ls where id_liderazgo_ssoma ='.$id);
            return view('/programacion_anual_visualizacion',compact('programa','progra','proyec','mes'));
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }
}