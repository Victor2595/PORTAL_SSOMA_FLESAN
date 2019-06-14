<?php

namespace Portal_SSOMA\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\UserRol;

class Proyecto extends Model
{
    protected $connection = 'srvdesbdpg';
    protected $table = 'ssoma.tbl_proyecto';
    protected $primaryKey = 'id_proyecto';
    public $timestamps = false;
    //protected $fillable = ['id_proyecto','id_unidad_negocio','gerente_proyecto','residente_obra','alcance_proyecto','valor_contrato','nombre_proyecto','metas_hombre','regimen','factor_indicador','codigo_proyecto'];


    public static function proyectos($id){
    	return Proyecto::where('id_unidad_negocio','=',$id)->get();
    }	

    public function usuariorol(){
        return $this->belongsTo(UserRol::class, 'codigo_proyecto');
    }
}
