<?php

namespace Portal_SSOMA\Imports;

use Portal_SSOMA\Models\Programacion_Anual_Det;
use Portal_SSOMA\Models\Programacion_Anual;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToArray;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use DateTime;

use Alert;

class UsersImport implements ToCollection,WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     use Importable;

     public function collection(Collection $rows)
    {


        $codproy = auth()->user()->rol[0]->objeto_permitido;
        $dia = new DateTime();
        $key = count($rows);
        $file[] = $rows;
        $devol = null;
        $arrayn = null;
        $borrarFila1 = null;
        $borrarFila2 = null;
        $borrarFila3 = null;
        $borrarFila4 = null;
        $count = 0;
        foreach ($file as $row) 
        {  
            $fecha = ($row[11][3]-25569)*86400;
            $fecha_format = gmdate("d-m-y",$fecha);
            $fecha_formatx = gmdate("d-m-y",$fecha);

            for($k=0;$k<17;$k++){
                unset($row[$k]);
            }
            for($i=17;$i<$key-1;$i++){
                for($j=0;$j<21;$j++){
                    unset($row[$i][0]);   
                    unset($row[$borrarFila1]);
                    unset($row[$borrarFila2]);
                    unset($row[$borrarFila3]);
                    unset($row[$borrarFila4]);
                }

                if($row[$i][1] == 'TOTAL DE PROGRAMADO Y EJECUTADO:'){
                    $devol = $i;
                } 
                if($row[$i][1] == 'JEFES DE AREA'){
                    $borrarFila1 = $i;
                }else if($row[$i][1] == 'ASISTENTES DE AREAS'){
                    $borrarFila2 = $i;
                }else if($row[$i][1] == 'CAPATACES'){
                    $borrarFila3 = $i;
                }else if($row[$i][1] == 'SSOMA'){
                    $borrarFila4 = $i;
                }
                if($row[$i] == null){
                    unset($row[$i]);
                }
                $c = count($row[$i]);
            }
            for($r=$devol+1;$r<$key;$r++){
                unset($row[$r]);
            }

            $rowx = $row[$devol];

            $idproy = DB::connection('srvdesbdpg')->select('select id_proyecto from ssoma.tbl_proyecto where estado = 1 and codigo_proyecto=\''.$codproy.'\' limit 1');
            
            $buscPro = DB::connection('srvdesbdpg')->select('select ls.id_liderazgo_ssoma,p.codigo_proyecto,ls.id_proyecto,CONCAT(EXTRACT(MONTH from ls.periodo),\'-\',0,EXTRACT(DAY from ls.periodo),\'-\', Right(Cast(EXTRACT(YEAR from ls.periodo) As Char(4)),2)) as periodo,CONCAT(EXTRACT(MONTH from ls.periodo),\'-\', Right(Cast(EXTRACT(YEAR from ls.periodo)As Char(4)),2)) as periodox,ls.estado from ssoma.tbl_liderazgo_ssoma ls inner join ssoma.tbl_proyecto p on p.id_proyecto = ls.id_proyecto where  p.codigo_proyecto=\''.$codproy.'\' and ls.estado=1');
            $progra = new Programacion_Anual();
            $progra->id_proyecto = $idproy[0]->id_proyecto;
            $progra->periodo = $fecha_format;
            $progra->tpe_insp_plani_progr = $row[$devol][2];
            $progra->tpe_insp_plani_ejec = $row[$devol][3];
            $progra->tpe_insp_plani_porce = $row[$devol][4];
            $progra->tpe_capac_entre_progr = $row[$devol][5];
            $progra->tpe_capac_entre_ejec = $row[$devol][6];
            $progra->tpe_capac_entre_porce = $row[$devol][7];
            $progra->tpe_investi_accide_progr = $row[$devol][8];
            $progra->tpe_investi_accide_ejec = $row[$devol][9];
            $progra->tpe_investi_accide_porce = $row[$devol][10];
            $progra->tpe_observ_tare_progr = $row[$devol][11];
            $progra->tpe_observ_tare_ejec = $row[$devol][12];
            $progra->tpe_observ_tare_porce = $row[$devol][13];
            $progra->tpe_reun_progra_ssoma_progr = $row[$devol][14];
            $progra->tpe_reun_progra_ssoma_ejec = $row[$devol][15];
            $progra->tpe_reun_progra_ssoma_porce = $row[$devol][16];
            $progra->tpe_comi_tecn_sst_progr = $row[$devol][17];
            $progra->tpe_comi_tecn_sst_ejec = $row[$devol][18];
            $progra->tpe_comi_tecn_sst_porce = $row[$devol][19];
            $progra->tpe_plv = $row[$devol][20];
            $progra->usuario_registro = auth()->user()->id_aplicacion_usuario; 
            $progra->fecha_registro = $dia->format('y-m-d');
            $progra->estado = '1';
            $progra->save();


            $idliderazgo = DB::connection('srvdesbdpg')->select('select  * from ssoma.tbl_liderazgo_ssoma order by id_liderazgo_ssoma desc limit 1');

            for($contenido=17;$contenido<$devol;$contenido++){
                if($contenido != $borrarFila1 && $contenido != $borrarFila2 && $contenido != $borrarFila3 && $contenido != $borrarFila4){
                    if($contenido != $devol){
                        $progra_det = new Programacion_Anual_Det();
                        $progra_det->id_liderazgo_ssoma = $idliderazgo[0]->id_liderazgo_ssoma;
                        $progra_det->participante_cargo = $row[$contenido][1];
                        if($row[$contenido][2] == null){
                            $progra_det->inspecciones_planificadas_programadas = '0';
                        }else{
                            $progra_det->inspecciones_planificadas_programadas = $row[$contenido][2];
                        }
                        if($row[$contenido][3] == null){
                            $progra_det->inspecciones_planificadas_ejecutadas = '0';
                        }else{
                            $progra_det->inspecciones_planificadas_ejecutadas = $row[$contenido][3];
                        }
                        if($row[$contenido][4] == null){
                            $progra_det->inspecciones_planificadas_porcentaje = '0';
                        }else{
                            $progra_det->inspecciones_planificadas_porcentaje = $row[$contenido][4];
                        }
                        if($row[$contenido][5] == null){
                            $progra_det->capacitacion_entrenamiento_programadas = '0';
                        }else{
                            $progra_det->capacitacion_entrenamiento_programadas = $row[$contenido][5];
                        }
                        if($row[$contenido][6] == null){
                            $progra_det->capacitacion_entrenamiento_ejecutadas = '0';
                        }else{
                            $progra_det->capacitacion_entrenamiento_ejecutadas = $row[$contenido][6];
                        }
                        if($row[$contenido][7] == null){
                            $progra_det->capacitacion_entrenamiento_porcentaje = '0';
                        }else{
                            $progra_det->capacitacion_entrenamiento_porcentaje = $row[$contenido][7];
                        }
                        if($row[$contenido][8] == null){
                            $progra_det->investigacion_accidentes_programadas = '0';
                        }else{
                            $progra_det->investigacion_accidentes_programadas = $row[$contenido][8];
                        }
                        if($row[$contenido][9] == null){
                            $progra_det->investigacion_accidentes_ejecutadas = '0';
                        }else{
                            $progra_det->investigacion_accidentes_ejecutadas = $row[$contenido][9];
                        }
                        if($row[$contenido][10] == null){
                             $progra_det->investigacion_accidentes_porcentaje = '0';
                        }else{
                            $progra_det->investigacion_accidentes_porcentaje = $row[$contenido][10];
                        }
                        if($row[$contenido][11] == null){
                            $progra_det->observacion_tareas_programadas = '0';
                        }else{
                            $progra_det->observacion_tareas_programadas = $row[$contenido][11];
                        }
                        if($row[$contenido][12] == null){
                            $progra_det->observacion_tareas_ejecutadas = '0';
                        }else{
                            $progra_det->observacion_tareas_ejecutadas = $row[$contenido][12];
                        }
                        if($row[$contenido][13] == null){
                            $progra_det->observacion_tareas_porcentaje = '0';
                        }else{
                            $progra_det->observacion_tareas_porcentaje = $row[$contenido][13];
                        }
                        if($row[$contenido][14] == null){
                            $progra_det->reuniones_programadas_programadas = '0';
                        }else{
                            $progra_det->reuniones_programadas_programadas = $row[$contenido][14];
                        }
                        if($row[$contenido][15] == null){
                            $progra_det->reuniones_programadas_ejecutadas = '0';
                        }else{
                            $progra_det->reuniones_programadas_ejecutadas = $row[$contenido][15];
                        }
                        if($row[$contenido][16] == null){
                            $progra_det->reuniones_programadas_porcentaje = '0';
                        }else{
                            $progra_det->reuniones_programadas_porcentaje = $row[$contenido][16];
                        }
                        if($row[$contenido][17] == null){
                            $progra_det->comite_tecnico_programadas = '0';
                        }else{
                            $progra_det->comite_tecnico_programadas = $row[$contenido][17];
                        }
                        if($row[$contenido][18] == null){
                            $progra_det->comite_tecnico_ejecutadas = '0';
                        }else{
                            $progra_det->comite_tecnico_ejecutadas = $row[$contenido][18];
                        }
                        if($row[$contenido][19] == null){
                            $progra_det->comite_tecnico_porcentaje = '0';
                        }else{
                            $progra_det->comite_tecnico_porcentaje = $row[$contenido][19];
                        }
                        if($row[$contenido][20] == null){
                            $progra_det->plv_porcentaje = '0';
                        }else{
                            $progra_det->plv_porcentaje = $row[$contenido][20];
                        }
                        $progra_det->usuario_registro = auth()->user()->id_aplicacion_usuario;
                        $progra_det->fecha_registro = $dia->format('y-m-d');
                        $progra_det->estado = $idliderazgo[0]->estado;
                        $progra_det->save();
                    }              
                }
            }
        }
    }


    
}
