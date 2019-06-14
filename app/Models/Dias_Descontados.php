<?php

namespace Portal_SSOMA\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Dias_Descontados extends Model
{
    protected $connection = 'srvdesbdpg';
    protected $table = 'ssoma.tbl_dias_desc';
    public $timestamps = false;
   	//protected $fillable = ['id_aplicacion_usuario','id_rol','empresa','objeto_permitido','fecha_ini','fecha_fin'];


}