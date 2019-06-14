<?php

namespace Portal_SSOMA\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;

class Auditoria_Validacion extends Model
{
    protected $connection = 'srvdesbdpg';
    protected $table = 'ssoma.tbl_auditoria_validacion';
    protected $primaryKey = 'id_auditoria_validacion';
    public $timestamps = false;
   	protected $fillable = ['id_indicadores','usuario_ejecuta_accion','fecha_ejecuta_accion','descripcion','estado_validacion'];


}