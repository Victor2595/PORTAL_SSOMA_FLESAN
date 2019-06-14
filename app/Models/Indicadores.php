<?php

namespace Portal_SSOMA\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use GuzzleHttp\Client;

class Indicadores extends Model
{

	protected $connection = 'srvdesbdpg';
    protected $table = 'ssoma.tbl_indicadores';
    protected $primaryKey = 'id_indicadores';
    public $timestamps = false;
    //protected $fillable = ['id_proyecto','id_unidad_negocio','gerente_proyecto','residente_obra','alcance_proyecto','valor_contrato','nombre_proyecto','metas_hombre','regimen','factor_indicador','codigo_proyecto'];

}