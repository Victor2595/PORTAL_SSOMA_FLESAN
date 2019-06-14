<?php

namespace Portal_SSOMA\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Portal_SSOMA\Http\Controllers\Controller;
//use Portal_SSOMA\Models\Aplicacion_Usuario;
use Portal_SSOMA\Models\Usuario_Rol;

class SeguridadController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

	public function byJefe($id){
		return DB::connection('srvdesbdpg')->select('select * from seguridadapp.v_jefe_ssomac where id_empresa = \''.$id.'\'');
	}
    
}
