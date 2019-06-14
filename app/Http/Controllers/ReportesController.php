<?php 

namespace Portal_SSOMA\Http\Controllers; 

use Illuminate\Http\Request; 
use Portal_SSOMA\Http\Requests;
use GuzzleHttp\Client;
use Portal_SSOMA\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Portal_SSOMA\Models\Proyecto;
use Portal_SSOMA\Models\Dias_Descontados;
use Portal_SSOMA\Mail\GmailNotificacionJefe;
use Illuminate\Support\Facades\Mail;
use Alert;
use DateTime;

class ReportesController extends Controller{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function reportes_individuales(){
        if(auth()->user()->rol[0]->id_rol == 7){
            $id_p = auth()->user()->rol[0]->objeto_permitido;
            $proyecto = Proyecto::where('id_usuario',auth()->user()->id_aplicacion_usuario)->where('estado',1)->get();
            $indicadores = DB::select('select * from ssoma.tbl_indicadores i left join ssoma.tbl_proyecto p on i.id_proyecto = p.id_proyecto left join ssoma.tbl_auditoria_validacion av on av.id_indicadores = i.id_indicadores and av.estado_validacion = i.estado_validacion where p.codigo_proyecto = \''.$id_p.'\' and i.estado_validacion = 4');
            if(count($proyecto) != 0){
                $meses = DB::select('select * from ssoma.v_meses');
                $valoresTE = DB::select('select * from ssoma.reporte_tasa_entrenamiento_individual('.$proyecto[0]->id_proyecto.')');
                $valoresTFCA = DB::select('select * from ssoma.reporte_tasa_frecuencia_ctp_individual('.$proyecto[0]->id_proyecto.')');
                $valoresTFSA = DB::select('select * from ssoma.reporte_tasa_frecuencia_stp_individual('.$proyecto[0]->id_proyecto.')');
                $valoresGravedad = DB::select('select * from ssoma.reporte_tasa_gravedad_individual('.$proyecto[0]->id_proyecto.')');
                $valoresAccidentabilidad = DB::select('select * from ssoma.reporte_tasa_accidentabilidad_individual('.$proyecto[0]->id_proyecto.')');
                $mensaje = array();
            }else{
                $meses = array();
               $valoresTE = array();
                $valoresTFCA = array();
                $valoresTFSA = array();
                $valoresGravedad = array();
                $mensaje = array('mensaje'=>'Usted no esta asignado a ningún Proyecto por el momento, comuniquese con la Oficina Corporativa SSOMA para mayor Información.');
            }
            return view("reportes_individuales",compact('meses','valoresTE','proyecto','valoresTFCA','valoresTFSA','valoresGravedad','mensaje','indicadores'));
        }elseif(auth()->user()->rol[0]->id_rol == 6){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function reportes_consolidados(){
        if(auth()->user()->rol[0]->id_rol == 6){
            return view("reportes_consolidados");
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function reportes_indicadores(){
        if(auth()->user()->rol[0]->id_rol == 6){
            $client = new CLient([
                'base_uri' => 'http://192.168.25.26:1337/datos_maestros/'//,
               // 'timeout' => 2.0,
            ]);
            $response2 = $client->request('GET','empresa');
            $unidades = json_decode($response2->getBody( )->getContents());
            $meses = DB::select('select * from ssoma.v_meses');
            $valoresTE = DB::select('select * from ssoma.v_tasa_entrenamiento_reportes_gen');
            $valoresTFCA = DB::select('select * from ssoma.v_tasa_frecuencia_ctp_reportes_gen');
            $valoresTFSA = DB::select('select * from ssoma.v_tasa_frecuencia_stp_reportes_gen');
            $valoresGravedad = DB::select('select * from ssoma.v_tasa_gravedad_reportes_gen');
            $valoresAccidentabilidad = DB::select('select * from ssoma.v_tasa_accidentabilidad_reportes_gen');
            return view("reportes_indicadores",compact("unidades","meses","valoresTE","valoresTFCA","valoresTFSA","valoresGravedad","valoresAccidentabilidad"));
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function reportes_generar(Request $request){
        if(auth()->user()->rol[0]->id_rol == 6){
            $id_empresa = $request->selectUN;
            $id_proyecto = $request->selectProy;
            if($id_empresa != -1){
                $query1 = ' and id_unidad_negocio = \''.$id_empresa.'\'';
                $query3 = ' where p.id_unidad_negocio =\''.$id_empresa.'\'';
                $client = new CLient([
                    'base_uri' => 'http://192.168.25.26:1337/datos_maestros/'
                ]);
                $response = $client->request('GET','empresa');
                $response2 = $client->request('GET','proyectos?estado=A&cod_empresa='.$id_empresa);
                $unidades = json_decode($response->getBody( )->getContents());
                $proyectos = json_decode($response2->getBody( )->getContents());
                $meses = DB::select('select * from ssoma.v_meses');
                if($id_proyecto == -1 || $id_proyecto == null){
                    $proyecto_seleccionado = array();
                    $valoresTE = DB::select('select * from ssoma.reporte_tasa_entrenamiento_promedio(\''.$id_empresa.'\')');
                    $valoresTFCA = DB::select('select * from ssoma.reporte_tasa_frecuencia_ctp_promedio(\''.$id_empresa.'\')');
                    $valoresTFSA = DB::select('select * from ssoma.reporte_tasa_frecuencia_stp_promedio(\''.$id_empresa.'\')');
                    $valoresGravedad = DB::select('select * from ssoma.reporte_tasa_gravedad_promedio(\''.$id_empresa.'\')');
                    $valoresAccidentabilidad = DB::select('select * from ssoma.reporte_tasa_accidentabilidad_promedio(\''.$id_empresa.'\')');
                }else{
                    $response3 = $client->request('GET','proyectos?id_proyecto='.$id_proyecto);
                    $proyecto_seleccionado = json_decode($response3->getBody( )->getContents());

                    $valoresTE = DB::select('select * from ssoma.reporte_tasa_entrenamiento_search(\''.$id_empresa.'\',\''.$id_proyecto.'\')');
                    $valoresTFCA = DB::select('select * from ssoma.reporte_tasa_frecuencia_ctp_search(\''.$id_empresa.'\',\''.$id_proyecto.'\')');
                    $valoresTFSA = DB::select('select * from ssoma.reporte_tasa_frecuencia_stp_search(\''.$id_empresa.'\',\''.$id_proyecto.'\')');
                    $valoresGravedad = DB::select('select * from ssoma.reporte_tasa_gravedad_search(\''.$id_empresa.'\',\''.$id_proyecto.'\')');
                    $valoresAccidentabilidad = DB::select('select * from ssoma.reporte_tasa_accidentabilidad_search(\''.$id_empresa.'\',\''.$id_proyecto.'\')');
                }
            }else{
                return redirect('reportes_indicadores/all');
            }   
            //print(json_encode(count($proyecto_seleccionado)));
            return view("reportes_indicadores_busqueda",compact("unidades","meses","valoresTE","valoresTFCA","valoresTFSA","valoresGravedad","valoresAccidentabilidad","id_empresa","proyectos","proyecto_seleccionado"));
        }elseif(auth()->user()->rol[0]->id_rol == 7){
                Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
                return redirect('/principal');
        }
    }
}