<?php 

namespace Portal_SSOMA\Http\Controllers; 

use Illuminate\Http\Request;
use Portal_SSOMA\Http\Requests;
use GuzzleHttp\Client;
use Portal_SSOMA\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Portal_SSOMA\Models\Proyecto as Proyect;
use Portal_SSOMA\Models\Dias_Descontados as Dias_Desc;
use Portal_SSOMA\Mail\GmailNotificacionJefe;
use Portal_SSOMA\Mail\GmailNotificacionJefeModificacion;
use Illuminate\Support\Facades\Mail;
use Alert;
use DateTime;

class ProyectoController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function configuracion_proyecto_registro()
    {   
        if(auth()->user()->rol[0]->id_rol == 6){
            $client = new CLient([
            'base_uri' => 'http://192.168.25.26:1337/datos_maestros/',
            'timeout' => 4.0,
            ]);

            $response2 = $client->request('GET','empresa');
            $unidades = json_decode($response2->getBody( )->getContents());

            return view("configuracion_proyecto_registro",compact("unidades"));
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function getProyectos($id){
       $client = new CLient([
        'base_uri' => 'http://192.168.25.26:1337/datos_maestros/'//,
        //'timeout' => 4.2,
        ]);
        $response = $client->request('GET','proyectos?estado=A&cod_empresa='.$id);
        $response2 = $client->request('GET','unidades_negocio');
        
        $unidades = json_decode($response2->getBody( )->getContents());
        $project =  json_decode($response->getBody( )->getContents());
        return response()->json($project);
    }

    public function getUnidades(){
       $client = new CLient([
        'base_uri' => 'http://192.168.25.26:1337/datos_maestros/',
        'timeout' => 2.0,
        ]);
        $response2 = $client->request('GET','unidades_negocio');
        
        $unidades = json_decode($response2->getBody( )->getContents());
        return response()->json($unidades);
    }

    public function getDatos($id_proyecto){
       $client = new CLient([
        'base_uri' => 'http://192.168.25.26:1337/datos_maestros/'//,
        //'timeout' => 3.0,
        ]);
        $response = $client->request('GET','proyectos?id_proyecto='.$id_proyecto);
        $datos =  json_decode($response->getBody( )->getContents());
        return response()->json($datos);
    }

    public function asignadoJefe($id){
        return DB::connection('srvdesbdpg')->select('select count(*) as contador from tbl_proyecto where estado = 1 and id_usuario ='.$config_proyecto->id_usuario);
    }

    public function grabarConfiguracionProyecto(Request $request){
        if(auth()->user()->rol[0]->id_rol == 6){    
            $dia = new DateTime();
            $dat = Dias_Desc::where('regimen',request('selectRegimen'))->where('estado',1)->get(); 
            $config_proyecto = new Proyect;
            $config_proyecto->id_unidad_negocio = request('selectUN');
            $config_proyecto->codigo_proyecto = request('selectProy');
            $config_proyecto->tipo_proyecto = request('inputTipoP');
            $config_proyecto->gerente_proyecto = request('inputGerente');
            $config_proyecto->residente_obra = request('inputResidente');
            $config_proyecto->alcance_proyecto = request('areaAlcance');
            $config_proyecto->cliente = request('inputCliente');
            $config_proyecto->valor_contrato = request('inputValor');
            $config_proyecto->fecha_inicio = request('inputFechaI');
            $config_proyecto->fecha_fin = request('inputFechaF');
            $config_proyecto->estado_proyecto = 'A';
            $config_proyecto->nombre_proyecto = request('nombreProy');
            $config_proyecto->metas_hombre = request('inputMetasH');
            $config_proyecto->regimen =request('selectRegimen');
            $config_proyecto->factor_indicador_especifico_obra =request('inputFactor');
            $config_proyecto->id_dias_desc = $dat[0]->id_dias_desc ;
            $config_proyecto->id_usuario = request('selectJef');
            $config_proyecto->usuario_registro = auth()->user()->id_aplicacion_usuario ;
            $config_proyecto->fecha_registro = $dia->format('d-m-y');
            $config_proyecto->fecha_sincronize = $dia->format('d-m-y h:i:s');
            $config_proyecto->estado = '1';
            if(request('selectRegimen') == '-1'){
                Alert::error('No se a seleccionado un Regimen','Error');
                $client = new CLient([
                    'base_uri' => 'http://192.168.25.26:1337/datos_maestros/'//,
                    //'timeout' => 3.0,
                ]);
                $response2 = $client->request('GET','empresa');
                $response = $client->request('GET','proyectos');
                $unidad_n = $client->request('GET','empresa?cod_empresa='.$config_proyecto->id_unidad_negocio);
                $datos =  json_decode($response->getBody( )->getContents());
                $unidades = json_decode($response2->getBody( )->getContents());
                $unidad = json_decode($unidad_n->getBody()->getContents());
                return view("/configuracion_proyecto_registro")->withInput();
            }
            $data = DB::connection('srvdesbdpg')->select('select count(*) as contador from ssoma.tbl_proyecto where estado = 1 and id_usuario ='.$config_proyecto->id_usuario);
            if($data[0]->contador == '1'){
                Alert::error('El jefe de SSOMA ya esta asignado en otro proyecto','Error');
                return redirect('/configuracion_proyecto_registro')->withInput($request->except('selectJef'));
            }
            if(request('selectUN') == -1 ){
                Alert::error('No a seleccionado una unidad de Negocio','Error');
                return redirect('/configuracion_proyecto_registro')->withInput();
            }
            if(request('selectProy') == -1 ){
                //request('inputMetasH') == '' || request('selectRegimen') == '-1'
                Alert::error('No a seleccionado un proyecto','Error');
                return redirect('/configuracion_proyecto_registro')->withInput();
            }
            if(request('selectJefe') == -1){
                Alert::error('No a seleccionado un Jefe de SSOMA','Error');
                return redirect('/configuracion_proyecto_registro')->withInput();
            }else{
                if($config_proyecto->save()){
                    $insertarObjPermitido = DB::connection('srvdesbdpg')->update('update seguridadapp.usuario_rol set objeto_permitido =\''.$config_proyecto->codigo_proyecto.'\' where id_aplicacion_usuario='.$config_proyecto->id_usuario);

                    $informacionJefe = DB::connection('srvdesbdpg')->select('select * from seguridadapp.aplicacion_usuario where id_aplicacion_usuario='.$config_proyecto->id_usuario);

                    Mail::to($informacionJefe[0]->username)->send(new GmailNotificacionJefe($config_proyecto->nombre_proyecto,$informacionJefe[0]->name));
                    Alert::success('El proyecto se guardo correctamente','Guardado');
                    return redirect('/configuracion_proyecto');
                }
            }
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function saveSincronize(Request $request,$id){
        if(auth()->user()->rol[0]->id_rol == 6){
            $dia = new DateTime();
            $proyecto = Proyect::find($id);
            $client = new CLient([
            'base_uri' => 'http://192.168.25.26:1337/datos_maestros/'//,
            //'timeout' => 3.0,
            ]);
            $response = $client->request('GET','proyectos?id_proyecto='.$proyecto->codigo_proyecto);
            $proyectos = json_decode($response->getBody( )->getContents());
            $proyecto->gerente_proyecto = $proyectos[0]->gerente_de_proyecto;
            $proyecto->tipo_proyecto = $proyectos[0]->tipo_proyecto;
            $proyecto->residente_obra = $proyectos[0]->residente_obra;
            $proyecto->alcance_proyecto = $proyectos[0]->alcance;
            $proyecto->cliente = $proyectos[0]->cliente;
            $proyecto->valor_contrato = $proyectos[0]->valor_contrato;
            $proyecto->fecha_inicio = $proyectos[0]->fecha_inicio;
            $proyecto->fecha_fin = $proyectos[0]->fecha_fin;
            $proyecto->nombre_proyecto = $proyectos[0]->nombre_proyecto;
            $proyecto->fecha_sincronize = $dia->format('d-m-y h:i:s');
            $proyecto->save(); 
            $config_proyecto = Proyect::find($id);
            $jefe = DB::connection('srvdesbdpg')->select('select p.id_usuario,case when a.name is null then a.username else a.name end username from seguridadapp.aplicacion_usuario a inner join seguridadapp.usuario_rol u on u.id_aplicacion_usuario = a.id_aplicacion_usuario inner join ssoma.tbl_proyecto p on p.id_usuario = a.id_aplicacion_usuario where u.id_rol = 7 and p.id_proyecto ='.$config_proyecto->id_proyecto);
            $jefes = DB::connection('srvdesbdpg')->select('select * from seguridadapp.v_jefe_ssomac where id_empresa = \''.$config_proyecto->id_unidad_negocio.'\'');
            $client = new CLient([
            'base_uri' => 'http://192.168.25.26:1337/datos_maestros/'//,
            //'timeout' => 3.8,
            ]);
            $response1 = $client->request('GET','empresa');
            $response2 = $client->request('GET','empresa?cod_empresa='.$config_proyecto->id_unidad_negocio);
            $response3 = $client->request('GET','proyectos?estado=A&cod_empresa='.$config_proyecto->id_unidad_negocio);
            $response4 = $client->request('GET','proyectos?id_proyecto='.$config_proyecto->codigo_proyecto);
            $unidades = json_decode($response1->getBody()->getContents());
            $unidadesf = json_decode($response2->getBody()->getContents());
            $proyectos = json_decode($response3->getBody()->getContents());
            $proyectosf = json_decode($response4->getBody()->getContents());
            $selectJef1h = null;//al cargar por primera vez el formaulario agrego este parametro como null
            return view('configuracion_proyecto_edit',compact('unidades','unidadesf','proyectos','proyectosf','config_proyecto','jefe','jefes', 'selectJef1h'));
        }elseif (auth()->user()->rol[0]->id_rol == 7) {
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

     public function configuracion_proyecto()
    {
        if(auth()->user()->rol[0]->id_rol == 6){
            $client = new CLient([
            'base_uri' => 'http://192.168.25.26:1337/datos_maestros/',
            'timeout' => 3.0,
            ]);
            $response = $client->request('GET','empresa');
            $unidades = json_decode($response->getBody( )->getContents());

            $query = DB::connection('srvdesbdpg')->select('select * from ssoma.v_configuracion_proyecto');
            
            $data = Array();
            foreach ($query as $val) {
                $id_proyecto = $val->id_proyecto;
                $id_unidad_negocio = $val->id_unidad_negocio;
                $nombre_proyecto = $val->nombre_proyecto;
                $metas_hombre = $val->metas_hombre;
                $estado_proyecto = $val->estado_proyecto;
                $id_usuario = $val->id_usuario;
                $username = $val->username;
                for($i=0;$i<count($unidades);$i++){
                    if($unidades[$i]->COD_EMPRESA == $id_unidad_negocio){
                        $empresa = $unidades[$i]->NOMBRE_EMPRESA;
                    }
                }
                $arreglo = array('id_proyecto' => $id_proyecto,'id_unidad_negocio'=>$id_unidad_negocio,'empresa'=>$empresa,'nombre_proyecto'=>$nombre_proyecto,'metas_hombre'=>$metas_hombre,'estado_proyecto'=>$estado_proyecto,'id_usuario'=>$id_usuario,'username'=>$username);
                $data[]= $arreglo;
            }
            return view("configuracion_proyecto")->withData($data);
        }elseif (auth()->user()->rol[0]->id_rol == 7) {
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }  

   
    public function edit($id)
    {
        if(auth()->user()->rol[0]->id_rol == 6){
            $config_proyecto = Proyect::find($id);
            $jefe = DB::connection('srvdesbdpg')->select('select p.id_usuario,case when a.name is null then a.username else a.name end username from seguridadapp.aplicacion_usuario a inner join seguridadapp.usuario_rol u on u.id_aplicacion_usuario = a.id_aplicacion_usuario inner join ssoma.tbl_proyecto p on p.id_usuario = a.id_aplicacion_usuario where u.id_rol = 7 and p.id_proyecto ='.$config_proyecto->id_proyecto);
            $jefes = DB::connection('srvdesbdpg')->select('select * from seguridadapp.v_jefe_ssomac where id_empresa = \''.$config_proyecto->id_unidad_negocio.'\'');
            $client = new CLient([
            'base_uri' => 'http://192.168.25.26:1337/datos_maestros/'//,
            //'timeout' => 3.8,
            ]);
            $response1 = $client->request('GET','empresa');
            $response2 = $client->request('GET','empresa?cod_empresa='.$config_proyecto->id_unidad_negocio);
            $response3 = $client->request('GET','proyectos?estado=A&cod_empresa='.$config_proyecto->id_unidad_negocio);
            $response4 = $client->request('GET','proyectos?id_proyecto='.$config_proyecto->codigo_proyecto);
            $unidades = json_decode($response1->getBody()->getContents());
            $unidadesf = json_decode($response2->getBody()->getContents());
            $proyectos = json_decode($response3->getBody()->getContents());
            $proyectosf = json_decode($response4->getBody()->getContents());
            $selectJef1h = null;
            /*foreach ($proyectos as $proy) {
                foreach ($proyectosf as $proyf) {
                    /*if($proy->id_proyecto == $proyf->id_proyecto){
                        print('x');
                    }*/
                    /*print(json_encode($proy->id_proyecto));
                }
            }*/
            return view('configuracion_proyecto_edit',compact('unidades','unidadesf','proyectos','proyectosf','config_proyecto','jefe','jefes', 'selectJef1h'));
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }
    
    public function updateConfiguracionProyecto(Request $request,$id)
    {
        if(auth()->user()->rol[0]->id_rol == 6){
            $dia = new DateTime();
            $config_proyecto = Proyect::find($id);
            $dias_desc = Dias_Desc::where('regimen',request('selectRegimen1'))->where('estado',1)->get();
            $jefes = DB::connection('srvdesbdpg')->select('select a.id_aplicacion_usuario,a.id_aplicacion,case when a.name is null then a.username else a.name end username,a.fecha_ini,a.fecha_fin,a.provider,a.provider_id,a.remember_token from seguridadapp.aplicacion_usuario a inner join seguridadapp.usuario_rol u on u.id_aplicacion_usuario = a.id_aplicacion_usuario where a.id_aplicacion = 2 and u.id_rol = 7 and u.id_empresa = \''.$config_proyecto->id_unidad_negocio.'\'');
            $jefe = DB::connection('srvdesbdpg')->select('select p.id_usuario,case when a.name is null then a.username else a.name end username from seguridadapp.aplicacion_usuario a inner join seguridadapp.usuario_rol u on u.id_aplicacion_usuario = a.id_aplicacion_usuario inner join ssoma.tbl_proyecto p on p.id_usuario = a.id_aplicacion_usuario where u.id_rol = 7 and p.id_proyecto =\''.$config_proyecto->id_proyecto.'\'');
            $dat_proyecto = Proyect::where('codigo_proyecto',request('selectProy1'))->where('estado',1)->get();
            $selectJef1h = null;        
            $client = new CLient([
            'base_uri' => 'http://192.168.25.26:1337/datos_maestros/'//,
            //'timeout' => 4.3,
            ]);
            $selectJef1h = null;
            $response = $client->request('GET','empresa');
            $response2 = $client->request('GET','empresa?cod_empresa='.$config_proyecto->id_unidad_negocio);
            $response3 = $client->request('GET','proyectos?estado=A&cod_empresa='.$config_proyecto->id_unidad_negocio);
            $response4 = $client->request('GET','proyectos?id_proyecto='.$config_proyecto->codigo_proyecto);
            $unidades = json_decode($response->getBody()->getContents());
            $unidadesf = json_decode($response2->getBody()->getContents());
            $proyectos = json_decode($response3->getBody()->getContents());
            $proyectosf = json_decode($response4->getBody()->getContents());

            if(request('selectUN1') == -1){
                $selectJef1h = request('selectJef1');     
                $response = $client->request('GET','empresa');
                $response2 = $client->request('GET','empresa?cod_empresa='.request('selectUN1'));
                $response3 = $client->request('GET','proyectos?estado=A&cod_empresa='.request('selectUN1'));
                $response4 = $client->request('GET','proyectos?id_proyecto='.request('selectProy1'));
                $unidades = json_decode($response->getBody()->getContents());
                $unidadesf = json_decode($response2->getBody()->getContents());
                $proyectos = json_decode($response3->getBody()->getContents());
                $proyectosf = json_decode($response4->getBody()->getContents());

                Alert::error('No a seleccionado una unidad de Negocio','Error');
                return view('configuracion_proyecto_edit',compact('unidades','unidadesf','proyectos','proyectosf','config_proyecto','jefe','jefes','selectJef1h'));
            }else if(request('selectRegimen1') == -1){
                $selectJef1h = request('selectJef1');     
                $response = $client->request('GET','empresa');
                $response2 = $client->request('GET','empresa?cod_empresa='.request('selectUN1'));
                $response3 = $client->request('GET','proyectos?estado=A&cod_empresa='.request('selectUN1'));
                $response4 = $client->request('GET','proyectos?id_proyecto='.request('selectProy1'));
                $unidades = json_decode($response->getBody()->getContents());
                $unidadesf = json_decode($response2->getBody()->getContents());
                $proyectos = json_decode($response3->getBody()->getContents());
                $proyectosf = json_decode($response4->getBody()->getContents());
                
                Alert::error('No a seleccionado un Regimen','Error');
                //print(request('selectProy1'));
                return view('configuracion_proyecto_edit',compact('unidades','unidadesf','proyectos','proyectosf','config_proyecto','jefe','jefes', 'selectJef1h'))->withInput($request->except('selectRegimen1'));
            }else if(request('selectProy1') == -1){
                $selectJef1h = request('selectJef1');     
                $response = $client->request('GET','empresa');
                $response2 = $client->request('GET','empresa?cod_empresa='.request('selectUN1'));
                $response3 = $client->request('GET','proyectos?estado=A&cod_empres='.request('selectUN1'));
                $response4 = $client->request('GET','proyectos?id_proyecto='.request('selectProy1'));
                $unidades = json_decode($response->getBody()->getContents());
                $unidadesf = json_decode($response2->getBody()->getContents());
                $proyectos = json_decode($response3->getBody()->getContents());
                $proyectosf = json_decode($response4->getBody()->getContents());
                Alert::error('No a seleccionado un Proyecto','Error');
                return view('configuracion_proyecto_edit',compact('unidades','unidadesf','proyectos','proyectosf','config_proyecto','jefe','jefes', 'selectJef1h'));
            }else if(request('selectJef1') == -1){
                $selectJef1h = -1;
                Alert::error('No a seleccionado un Jefe SSOMA','Error');
                return view('configuracion_proyecto_edit',compact('unidades','unidadesf','proyectos','proyectosf','config_proyecto','jefe','jefes', 'selectJef1h'));
            }else if($config_proyecto->codigo_proyecto != request('selectProy1')){
                //print(json_encode($dat_proyecto));
                if(count($dat_proyecto) == 0 ){
                    if($config_proyecto->id_usuario != request('selectJef1')){
                        $jefeOP = Proyect::where('id_usuario',request('selectJef1'))->where('estado',1)->get();
                        if(count($jefeOP) == 1){
                            $selectJef1h = request('selectJef1');  
                            $response = $client->request('GET','empresa');
                            $response2 = $client->request('GET','empresa?cod_empresa='.request('selectUN1'));
                            $response3 = $client->request('GET','proyectos?estado=A&cod_empresa='.request('selectUN1'));
                            $response4 = $client->request('GET','proyectos?id_proyecto='.request('selectProy1'));
                            $unidades = json_decode($response->getBody()->getContents());
                            $unidadesf = json_decode($response2->getBody()->getContents());
                            $proyectos = json_decode($response3->getBody()->getContents());
                            $proyectosf = json_decode($response4->getBody()->getContents());
                            Alert::error('El jefe de SSOMA ya esta asignado en otro proyecto','Error');
                            return view('configuracion_proyecto_edit',compact('unidades','unidadesf','proyectos','proyectosf','config_proyecto','jefe','jefes', 'selectJef1h'));
                        }else{
                            $config_proyecto->id_unidad_negocio = request('selectUN1');
                            $config_proyecto->codigo_proyecto = request('selectProy1');
                            $config_proyecto->gerente_proyecto = request('inputGerente1');
                            $config_proyecto->residente_obra = request('inputResidente1');
                            $config_proyecto->alcance_proyecto = request('areaAlcance1');
                            $config_proyecto->cliente = request('inputCliente1');
                            $config_proyecto->valor_contrato = request('inputValor1');
                            $config_proyecto->fecha_inicio = request('inputFechaI1');
                            $config_proyecto->fecha_fin = request('inputFechaF1');
                            $config_proyecto->estado_proyecto = 'A';
                            $config_proyecto->nombre_proyecto = request('nombreProy1');
                            $config_proyecto->metas_hombre = request('inputMetasH1');
                            $config_proyecto->regimen =request('selectRegimen1');
                            $config_proyecto->factor_indicador_especifico_obra =request('inputFactor1');
                            $config_proyecto->id_dias_desc = $dias_desc[0]->id_dias_desc ;
                            $config_proyecto->id_usuario = request('selectJef1');
                            $config_proyecto->usuario_modificacion = auth()->user()->id_aplicacion_usuario;
                            $config_proyecto->fecha_modificacion = $dia->format('d-m-y');;
                            $config_proyecto->estado = '1';

                            $Proyecto_Ant = Proyect::find($id);
                            $informacionJefeAnt = DB::connection('srvdesbdpg')->select('select * from seguridadapp.aplicacion_usuario where id_aplicacion_usuario='.$Proyecto_Ant->id_usuario);
                            //$eliminarObjPermitido = DB::connection('srvdesbdpg')->update('update seguridadapp.usuario_rol set objeto_permitido =\'\' where id_aplicacion_usuario='.$Proyecto_Ant->id_usuario);
                            Mail::to($informacionJefeAnt[0]->username)->send(new GmailNotificacionJefeModificacion($Proyecto_Ant->nombre_proyecto,$informacionJefeAnt[0]->name));

                            $config_proyecto->save();
                            $informacionJefe = DB::connection('srvdesbdpg')->select('select * from seguridadapp.aplicacion_usuario where id_aplicacion_usuario='.$config_proyecto->id_usuario);
                            Mail::to($informacionJefe[0]->username)->send(new GmailNotificacionJefe($config_proyecto->nombre_proyecto,$informacionJefe[0]->name));

                            //$insertarObjPermitido = DB::connection('srvdesbdpg')->update('update seguridadapp.usuario_rol set objeto_permitido =\'\''.$config_proyecto->codigo_proyecto.'\' where id_aplicacion_usuario='.$config_proyecto->id_usuario);

                            Alert::success('El proyecto se actualizo correctamente','Actualizado');
                            return redirect('/configuracion_proyecto');
                        }
                    }
                }else{
                    Alert::error('El Proyecto ya esta asignado a otro jefe SSOMA','Error');
                    return view('configuracion_proyecto_edit',compact('unidades','unidadesf','proyectos','proyectosf','config_proyecto','jefe','jefes', 'selectJef1h'));
                }
            }else{
                $config_proyecto->id_unidad_negocio = request('selectUN1');
                $config_proyecto->codigo_proyecto = request('selectProy1');
                $config_proyecto->gerente_proyecto = request('inputGerente1');
                $config_proyecto->residente_obra = request('inputResidente1');
                $config_proyecto->alcance_proyecto = request('areaAlcance1');
                $config_proyecto->cliente = request('inputCliente1');
                $config_proyecto->valor_contrato = request('inputValor1');
                $config_proyecto->fecha_inicio = request('inputFechaI1');
                $config_proyecto->fecha_fin = request('inputFechaF1');
                $config_proyecto->estado_proyecto = 'A';
                $config_proyecto->nombre_proyecto = request('nombreProy1');
                $config_proyecto->metas_hombre = request('inputMetasH1');
                $config_proyecto->regimen =request('selectRegimen1');
                $config_proyecto->factor_indicador_especifico_obra =request('inputFactor1');
                $config_proyecto->id_dias_desc = $dias_desc[0]->id_dias_desc ;
                $config_proyecto->id_usuario = request('selectJef1');
                $config_proyecto->usuario_modificacion = auth()->user()->id_aplicacion_usuario;
                $config_proyecto->fecha_modificacion = $dia->format('d-m-y');;
                $config_proyecto->estado = '1';

                $Proyecto_Ant = Proyect::find($id);
                $informacionJefeAnt = DB::connection('srvdesbdpg')->select('select * from seguridadapp.aplicacion_usuario where id_aplicacion_usuario='.$Proyecto_Ant->id_usuario);
                $eliminarObjPermitido = DB::connection('srvdesbdpg')->update('update seguridadapp.usuario_rol set objeto_permitido =\'\' where id_aplicacion_usuario='.$Proyecto_Ant->id_usuario);
                Mail::to($informacionJefeAnt[0]->username)->send(new GmailNotificacionJefeModificacion($Proyecto_Ant->nombre_proyecto,$informacionJefeAnt[0]->name));

                $config_proyecto->save();

                $informacionJefe = DB::connection('srvdesbdpg')->select('select * from seguridadapp.aplicacion_usuario where id_aplicacion_usuario='.$config_proyecto->id_usuario);
                Mail::to($informacionJefe[0]->username)->send(new GmailNotificacionJefe($config_proyecto->nombre_proyecto,$informacionJefe[0]->name));
                $insertarObjPermitido = DB::connection('srvdesbdpg')->update('update seguridadapp.usuario_rol set objeto_permitido =\''.$config_proyecto->codigo_proyecto.'\' where id_aplicacion_usuario='.$config_proyecto->id_usuario);

                Alert::success('El proyecto se actualizo correctamente','Actualizado');
                return redirect('/configuracion_proyecto');
            }
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function destroy($id)
    {
        if(auth()->user()->rol[0]->id_rol == 6){
            $dat = DB::connection('srvdesbdpg')->update('update ssoma.tbl_proyecto SET estado = 0 WHERE id_proyecto='.$id);
            Alert::success('El proyecto fue borrado exitosamente','Borrado');
            return redirect()->route("configuracion_proyecto");
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }

    }
}