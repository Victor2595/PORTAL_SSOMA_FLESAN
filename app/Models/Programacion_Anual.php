<?php

namespace Portal_SSOMA\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use GuzzleHttp\Client;

class Programacion_Anual extends Model
{

	protected $connection = 'srvdesbdpg';
    protected $table = 'ssoma.tbl_liderazgo_ssoma';
    protected $primaryKey = 'id_liderazgo_ssoma';
    public $timestamps = false;

     protected $fillable = [
        'id_proyecto', 'periodo','tpe_insp_plani_progr','tpe_insp_plani_ejec','tpe_insp_plani_porce','tpe_capac_entre_progr','tpe_capac_entre_ejec','tpe_capac_entre_porce','tpe_investi_accide_progr','tpe_investi_accide_ejec','tpe_investi_accide_porce','tpe_observ_tare_progr','tpe_observ_tare_ejec','tpe_observ_tare_porce','tpe_reun_progra_ssoma_progr','tpe_reun_progra_ssoma_ejec','tpe_reun_progra_ssoma_porce','tpe_comi_tecn_sst_progr','tpe_comi_tecn_sst_ejec','tpe_comi_tecn_sst_porce','tpe_plv'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    

}