<?php

namespace Portal_SSOMA\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use GuzzleHttp\Client;

class Programacion_Anual_Det extends Model{
	protected $connection = 'srvdesbdpg';
	protected $table = 'ssoma.tbl_liderazgo_ssoma_det';
	protected $primaryKey = 'id_liderazgo_det';
    public $timestamps = false;

     protected $fillable = [
        'id_liderazgo_ssoma','participante_cargo','inspecciones_planificadas_programadas','inspecciones_planificadas_ejecutadas','inspecciones_planificadas_porcentaje','capacitacion_entrenamiento_programadas','capacitacion_entrenamiento_ejecutadas','capacitacion_entrenamiento_porcentaje','investigacion_accidentes_programadas','investigacion_accidentes_ejecutadas','investigacion_accidentes_porcentaje','observacion_tareas_programadas','observacion_tareas_ejecutadas','observacion_tareas_porcentaje','reuniones_programadas_programadas','reuniones_programadas_ejecutadas','reuniones_programadas_porcentaje','comite_tecnico_programadas','comite_tecnico_ejecutadas','comite_tecnico_porcentaje','plv_porcentaje','usuario_registro','fecha_registro'
    ];

}














