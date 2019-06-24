<?php

namespace Portal_SSOMA\Http\Controllers;


use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Portal_SSOMA\Models\Proyecto;
use Portal_SSOMA\Models\Aplicacion_Usuario;
use Portal_SSOMA\Models\Usuario_Rol;
use Portal_SSOMA\Mail\GmailVerificarUser;
use Illuminate\Support\Facades\Mail;
use Alert;
use DateTime;

class ControllerPortal extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('principal');
        /*if(is_array(request()->session()->get('avatar'))){
            print('es');
        }else{
            print('no');
        }*/
        
    }

     public function dashboard()
    {
        return view("dashboards");
    }
    
    public function lista_adm_user(){
        if(auth()->user()->rol[0]->id_rol == 6){
            $app = DB::select('select * from ssoma.v_administracion_usuarios_ssoma');
            $perfil = DB::select('select id_rol,upper(nombre) as nombre from seguridadapp.rol_aplicacion where id_aplicacion = 2');
            $client = new CLient([
            'base_uri' => 'http://192.168.25.26:1337/datos_maestros/',
            'timeout' => 2.0,
            ]);
            $response2 = $client->request('GET','empresa');
            $unidades = json_decode($response2->getBody( )->getContents());
            return view('administracion_usuarios',compact('app','unidades','perfil'));
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function cambiar_state_user($id){
        if(auth()->user()->rol[0]->id_rol == 6){    
            $usuario_state = Aplicacion_Usuario::where('id_aplicacion_usuario',$id)->first();
            if($usuario_state->estado_sesion == 1){
                $inactivar = DB::select('update seguridadapp.aplicacion_usuario set estado_sesion = 0 where id_aplicacion_usuario ='.$id);
                Alert::success('El usuario fue desactivado exitosamente','INACTIVADO');
                return redirect()->route("administracion_usuarios");
            }elseif($usuario_state->estado_sesion == 0){
                $activar = DB::select('update seguridadapp.aplicacion_usuario set estado_sesion = 1 where id_aplicacion_usuario ='.$id);
                Alert::success('El usuario fue activado exitosamente','ACTIVADO');
                return redirect()->route("administracion_usuarios");
            }
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function grabarUsuarios(Request $request){
        if(auth()->user()->rol[0]->id_rol == 6){  
            if($request->selectPerfil != -1){
                $empresa = $request->idEmpresa;
                $rol = $request->selectPerfil;
                $correo = $request->inputEmail;
                
                $val = str_contains($correo,'@flesan.com.pe');
                $value = str_contains($correo,'@dvc.com.pe');
                $valid_email =str_contains($correo,'@');

                $no_duplicate = Aplicacion_Usuario::where('username',$correo)->where('id_aplicacion',2)->get();
                if(count($no_duplicate) == 0){
                    if($valid_email == true){
                        if($val == true || $value == true){
                            $dia = new DateTime();
                            $tipo = $request->inputTipoDni;
                            $dni = $request->inputDni;
                            $nombres = $request->inputNombres;
                            $apellidos = $request->inputApellidos;
                            $nombre = $apellidos.' '.$nombres;

                            $aplicacion_usuario = new Aplicacion_Usuario();
                            $aplicacion_usuario->id_aplicacion = 2;
                            $aplicacion_usuario->username = $correo;
                            $aplicacion_usuario->fecha_ini = $dia->format('d-m-y');
                            $aplicacion_usuario->estado_sesion = 1;
                            $aplicacion_usuario->estado_validacion = 0;
                            $aplicacion_usuario->nombres = $nombres;
                            $aplicacion_usuario->apellidos = $apellidos;
                            $aplicacion_usuario->tipo_documento = $tipo;
                            if($tipo == 1){
                                $aplicacion_usuario->dni = $dni;
                            }else if($tipo == 2){
                                $aplicacion_usuario->pasaporte = $pasaporte;
                            }
                            $aplicacion_usuario->save();

                            $usuario_rol = new Usuario_Rol();
                            $usuario_rol->id_aplicacion_usuario = $aplicacion_usuario->id_aplicacion_usuario;
                            $usuario_rol->id_rol = $rol;
                            $usuario_rol->id_empresa = $empresa;
                            $usuario_rol->fecha_ini = $aplicacion_usuario->fecha_ini;
                            $usuario_rol->save();
                            Mail::to($correo)->send(new GmailVerificarUser($nombre));
                            Alert::success('El usuario se guardo correctamente','Guardado');
                            return redirect('/administracion_usuarios');
                        }else if($val == false || $value == false){
                            Alert::error('La cuenta de correo no es una cuenta corporativa','Error');
                            return redirect('/administracion_usuarios');
                        }
                    }else{
                        Alert::error('El e-mail ingresado no es un cuenta de correo','Error');
                        return redirect('/administracion_usuarios');
                    }
                }else{
                    Alert::error('Este Usuario ya se encuentra registrado','Error');
                    return redirect('/administracion_usuarios');
                }
            }else{
                Alert::error('Usted no selecciono Perfil','Error');
                return redirect('/administracion_usuarios');
            }
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function cargaUser($email){
       $client = new CLient([
            'base_uri' => 'http://192.168.25.26:1337/datos_maestros/',
            //'timeout' => 4.0,
            ]);

        $response2 = $client->request('GET','directorio?userPrincipalName='.$email);
        $usuario = json_decode($response2->getBody( )->getContents());
        return response()->json($usuario);
    }

    public function cargaEmpresa(){
        $client = new CLient([
            'base_uri' => 'http://192.168.25.26:1337/datos_maestros/',
            //'timeout' => 2.0,
        ]);
        $response2 = $client->request('GET','empresa');
        $empresa = json_decode($response2->getBody( )->getContents());
        return response()->json($empresa);
    }

    public function cargaPerfil(){
        $perfil = DB::select('select id_rol,upper(nombre) as nombre from seguridadapp.rol_aplicacion where id_aplicacion = 2');
        return response()->json($perfil);
    }

    public function updateUser($id){
        /*$user = DB::select('select * from seguridadapp.edit_user('.$id.')');
        print(json_encode($user));
        $app = DB::select('select * from ssoma.v_administracion_usuarios_ssoma');
            $perfil = DB::select('select id_rol,upper(nombre) as nombre from seguridadapp.rol_aplicacion where id_aplicacion = 2');
            $client = new CLient([
            'base_uri' => 'http://192.168.25.26:1337/datos_maestros/',
            'timeout' => 2.0,
            ]);
            $response2 = $client->request('GET','empresa');
            $unidades = json_decode($response2->getBody( )->getContents());
            return view('administracion_usuarios',compact('app','unidades','perfil','user'));*/
    }
}
