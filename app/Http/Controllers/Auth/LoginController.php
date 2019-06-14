<?php

namespace Portal_SSOMA\Http\Controllers\Auth;

use Portal_SSOMA\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Session;
use Socialite;
use Auth;
use Portal_SSOMA\User;
use Alert;
use DateTime;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/principal';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     public function index()
    {
        return view("welcome");
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $val = str_contains($user->email,'@flesan.com.pe');
        $value = str_contains($user->email,'@dvc.com.pe');
        if($val != false || $value != false){
            $correo = User::where('username',$user->email)
            ->where('id_aplicacion','=','2')->get();
            if(count($correo) != 0){
                $authApp = DB::connection('srvdesbdpg')->select('select id_aplicacion from seguridadapp.aplicacion_usuario where username =\''.$user->email.'\' and id_aplicacion=2 and estado_sesion=0 and (provider_id is null)');
                if(count($authApp) == 0){
                    $authUser = User::where('provider_id',$user->id)
                    ->where('id_aplicacion','=','2')
                    ->first();
                }elseif(count($authApp) == 1){
                    $authUser = $this->findOrCreateUser($user,$provider);
                }
                request()->session()->push('avatar',$user->avatar);
                Auth::login($authUser,true);
                return redirect($this->redirectTo);
            }else if(count($correo) == 0){
                Alert::error('Este usuario '.$user->email.' no se encuentra registrado en el sistema','Error');
                return redirect('/');
            }

        }else{
           Alert::error('Este usuario '.$user->email.' no es corporativo del Grupo Flesan','Error');
           return redirect('/');
        }


            /*$authUser = $this->findOrCreateUser($user,$provider);
            print(json_encode(count($authUser)));
            request()->session()->push('avatar',$user->avatar);
            if(sizeof($authApp) !=0 ) {
                Auth::login($authUser,true);
                return redirect($this->redirectTo);
            }else{
                Alert::error('Este usuario '.$user->email.' no se encuentra validado en el sistema, verifique su correo para continuar o comuniquese con la Oficina Central SSOMA','Error');
                return redirect('/');
            }*/
        /*}else{
           Alert::error('Este usuario '.$user->email.' no es corporativo del Grupo Flesan','Error');
           return redirect('/');
        }*/

    }

    public function findOrCreateUser($user, $provider){

        $dia = new DateTime();
        $authUser = User::where('username',$user->email)
        ->where('id_aplicacion','=','2')
        ->where('estado_sesion','=','0')
        ->first();
        $authUser->name = $user->name;
        $authUser->fecha_validacion = $dia->format('d-m-y');
        $authUser->provider = strtoupper($provider);
        $authUser->provider_id = $user->id;
        $authUser->estado_sesion = 1;
        $authUser->save();

        if($authUser){
            return $authUser;
        }

        /*return User::create([
            'name'       => $user->name,
            'username'   => $user->email,
            'provider'   => strtoupper($provider),
            'provider_id'=> $user->id,
            'id_aplicacion' => '2',
            'estado_sesion' => 0,
            'fecha_ini' => $dia->format('y-m-d')
        ]);*/
    }

    public function sendFailedLogin($user){
        $errors = [$this->$user->email => trans('auth.failed')];
        if($user->expectsJson()){
            return response()->json($errors,422);
        }

        return redirect()->back()
            ->withInput($user->only($this->username(),'remember'))
            ->withErrors($errors);
    }
}
