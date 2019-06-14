<?php 

namespace Portal_SSOMA\Http\Controllers; 

use Illuminate\Http\Request;
use Portal_SSOMA\Http\Requests;
use GuzzleHttp\Client;
use Portal_SSOMA\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Portal_SSOMA\Models\Dias_Descontados as Dias_Desc;
use Alert;
use DateTime;

class DescontadosController extends Controller{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function dias_descontados()
    {
        if(auth()->user()->rol[0]->id_rol == 6){
            $data = DB::connection('srvdesbdpg')->select('select id_dias_desc,case when regimen=1 then \'CONSTRUCCIÓN\' WHEN regimen=2 THEN \'MINERIA\' END as regimen,case when regimen=1 then \'DIAS DESCONTADOS DEL REGIMEN DE CONSTRUCCIÓN\' WHEN regimen=2 THEN \'DIAS DESCONTADOS DEL REGIMEN DE MINERIA\' END as nombre,descontado_muerte,descontado_lesion_permanente,descontado_ambos_ojos,descontado_ambos_brazos,descontado_ambas_piernas,descontado_ambas_manos,descontado_ambos_pies,descontado_ojo_brazo,descontado_ojo_mano,descontado_ojo_pierna,descontado_ojo_pie,descontado_mano_pierna,descontado_mano_pie,descontado_brazo_mano_dist_ext,descontado_pierna_pie_dist_ext,descontado_perdida_codo_hombro,descontado_perdida_muneca_codo,descontado_perdida_pierna_muslo,descontado_perdida_tobillo_rodilla,descontado_mano_dedos_tercer_falange_pulgar,descontado_mano_dedos_primer_falange_pulgar,descontado_mano_dedos_metacarpo_pulgar,descontado_mano_dedos_mano_pulgar,descontado_mano_dedos_tercer_falange_indice,descontado_mano_dedos_segundo_falange_indice,descontado_mano_dedos_primer_falange_indice,descontado_mano_dedos_metacarpo_indice,descontado_mano_dedos_tercer_falange_medio,descontado_mano_dedos_segundo_falange_medio,descontado_mano_dedos_primer_falange_medio,descontado_mano_dedos_metacarpo_medio,descontado_mano_dedos_tercer_falange_anular,descontado_mano_dedos_segundo_falange_anular,descontado_mano_dedos_primer_falange_anular,descontado_mano_dedos_metacarpo_anular,descontado_mano_dedos_tercer_falange_menique,descontado_mano_dedos_segundo_falange_menique,descontado_mano_dedos_primer_falange_menique,descontado_mano_dedos_metacarpo_menique,descontado_pie_dedos_tercer_falange_dedo_grande,descontado_pie_dedos_primer_falange_dedo_grande,descontado_pie_dedos_metatarso_dedo_grande,descontado_pie_dedos_pie_dedo_grande,descontado_pie_dedos_tercer_falange_cada_dedo,descontado_pie_dedos_segundo_falange_cada_dedo,descontado_pie_dedos_primer_falange_cada_dedo,descontado_pie_dedos_metatarso_cada_dedo,descontado_vision_ojo,descontado_audicion_oido,descontado_ambos_oidos,descontado_hernia_no_operada,usuario_registro,fecha_registro,usuario_modificacion,fecha_modificacion,estado FROM ssoma.tbl_dias_desc WHERE estado = 1');

            $count = DB::connection('srvdesbdpg')->select('select count(*) as contador from ssoma.tbl_dias_desc where (regimen = 1 or regimen = 2) and estado = 1');
            return view("dias_descontados",compact("data","count"));
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

     public function configuracion_proyecto_dias_descontados()
    {
        if(auth()->user()->rol[0]->id_rol == 6){
            return view("dias_descontados_registro");
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function grabarDiasD(Request $request){
        if(auth()->user()->rol[0]->id_rol == 6){
            $dia = new DateTime();
            $dias_desc = new Dias_Desc;
            $dias_desc->regimen = request('selectRegimen');
            $dias_desc->descontado_muerte = request('inputMuerte');
            $dias_desc->descontado_lesion_permanente = request('inputLesion');
            $dias_desc->descontado_ambos_ojos = request('inputOjos');
            $dias_desc->descontado_ambos_brazos = request('inputBrazos');
            $dias_desc->descontado_ambas_piernas = request('inputPiernas');
            $dias_desc->descontado_ambas_manos = request('inputManos');
            $dias_desc->descontado_ambos_pies = request('inputPies');
            $dias_desc->descontado_ojo_brazo = request('inputOjoBrazo');
            $dias_desc->descontado_ojo_mano = request('inputOjoMano');
            $dias_desc->descontado_ojo_pierna = request('inputOjoPierna');
            $dias_desc->descontado_ojo_pie = request('inputOjoPie');
            $dias_desc->descontado_mano_pierna = request('inputManoPierna');
            $dias_desc->descontado_mano_pie = request('inputManoPie');
            $dias_desc->descontado_brazo_mano_dist_ext = request('inputBrazoMano');
            $dias_desc->descontado_pierna_pie_dist_ext = request('inputPiernaPie');
            $dias_desc->descontado_perdida_codo_hombro = request('inputACodo');
            $dias_desc->descontado_perdida_muneca_codo = request('inputAMuñeca');
            $dias_desc->descontado_perdida_pierna_muslo = request('inputARodilla');
            $dias_desc->descontado_perdida_tobillo_rodilla = request('inputATobillo');
            $dias_desc->descontado_mano_dedos_tercer_falange_pulgar = request('input3FPulgar');
            $dias_desc->descontado_mano_dedos_primer_falange_pulgar = request('input1FPulgar');
            $dias_desc->descontado_mano_dedos_metacarpo_pulgar = request('inputMPulgar');
            $dias_desc->descontado_mano_dedos_mano_pulgar = request('inputManoMuñecaPulgar');
            $dias_desc->descontado_mano_dedos_tercer_falange_indice = request('input3FIndice');
            $dias_desc->descontado_mano_dedos_segundo_falange_indice = request('input2FIndice');
            $dias_desc->descontado_mano_dedos_primer_falange_indice = request('input1FIndice');
            $dias_desc->descontado_mano_dedos_metacarpo_indice = request('inputMIndice');
            $dias_desc->descontado_mano_dedos_tercer_falange_medio = request('input3FMedio');
            $dias_desc->descontado_mano_dedos_segundo_falange_medio = request('input2FMedio');
            $dias_desc->descontado_mano_dedos_primer_falange_medio = request('input1FMedio');
            $dias_desc->descontado_mano_dedos_metacarpo_medio = request('inputMMedio');
            $dias_desc->descontado_mano_dedos_tercer_falange_anular = request('input3FAnular');
            $dias_desc->descontado_mano_dedos_segundo_falange_anular = request('input2FAnular');
            $dias_desc->descontado_mano_dedos_primer_falange_anular = request('input1FAnular');
            $dias_desc->descontado_mano_dedos_metacarpo_anular = request('inputMAnular');
            $dias_desc->descontado_mano_dedos_tercer_falange_menique = request('input3FMeñique');
            $dias_desc->descontado_mano_dedos_segundo_falange_menique = request('input2FMeñique');
            $dias_desc->descontado_mano_dedos_primer_falange_menique = request('input1FMeñique');
            $dias_desc->descontado_mano_dedos_metacarpo_menique = request('inputMMeñique');
            $dias_desc->descontado_pie_dedos_tercer_falange_dedo_grande = request('input3FPDedoG');
            $dias_desc->descontado_pie_dedos_primer_falange_dedo_grande = request('input1FPDedoG');
            $dias_desc->descontado_pie_dedos_metatarso_dedo_grande = request('inputMPDedoG');
            $dias_desc->descontado_pie_dedos_pie_dedo_grande = request('inputPieTobilloPDedoG');
            $dias_desc->descontado_pie_dedos_tercer_falange_cada_dedo = request('input3FPOtroDedo');
            $dias_desc->descontado_pie_dedos_segundo_falange_cada_dedo = request('input2FPOtroDedo');
            $dias_desc->descontado_pie_dedos_primer_falange_cada_dedo = request('input1FPOtroDedo');
            $dias_desc->descontado_pie_dedos_metatarso_cada_dedo = request('inputMPOtroDedo');
            $dias_desc->descontado_vision_ojo = request('inputOjoPerdiV');
            $dias_desc->descontado_audicion_oido = request('inputOidoPerdiA');
            $dias_desc->descontado_ambos_oidos = request('inputAOidoPerdiA');
            $dias_desc->descontado_hernia_no_operada = request('inputHerniaNO');
            $dias_desc->usuario_registro = auth()->user()->id_aplicacion_usuario;
            $dias_desc->fecha_registro = $dia->format('d-m-y');
            $dias_desc->estado = '1';
            $data = DB::connection('srvdesbdpg')->select('select count(*) as contador from ssoma.tbl_dias_desc where estado=1 and regimen ='.$dias_desc->regimen);
             if(request('selectRegimen') == -1 ){
                Alert::error('No a seleccionado un Regimen ','Error');
                return redirect('/dias_descontados_registro')->withInput($request->except('selectRegimen'));
            }
            if($data[0]->contador == '1'){
                Alert::error('Ya hay registrado un regimen de Dias Descontados/Debitados','Error');
                return redirect('/dias_descontados_registro')->withInput($request->except('selectRegimen'));
            }else{
                $dias_desc->save();
                Alert::success('El proyecto se guardo correctamente','Guardado');
                return redirect('/dias_descontados');
            }
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }    
        
    }

    public function updateDiasD(Request $request,$id)
    {
        if(auth()->user()->rol[0]->id_rol == 6){
            $dias_desc = DB::connection('srvdesbdpg')->select('select * from ssoma.tbl_dias_desc where estado=1 and id_dias_desc ='.$id);
            $dias_desc[0]->regimen = request('selectRegimen1');
            $dias_desc[0]->descontado_muerte = request('inputMuerte');
            $dias_desc[0]->descontado_lesion_permanente = request('inputLesion');
            $dias_desc[0]->descontado_ambos_ojos = request('inputOjos');
            $dias_desc[0]->descontado_ambos_brazos = request('inputBrazos');
            $dias_desc[0]->descontado_ambas_piernas = request('inputPiernas');
            $dias_desc[0]->descontado_ambas_manos = request('inputManos');
            $dias_desc[0]->descontado_ambos_pies = request('inputPies');
            $dias_desc[0]->descontado_ojo_brazo = request('inputOjoBrazo');
            $dias_desc[0]->descontado_ojo_mano = request('inputOjoMano');
            $dias_desc[0]->descontado_ojo_pierna = request('inputOjoPierna');
            $dias_desc[0]->descontado_ojo_pie = request('inputOjoPie');
            $dias_desc[0]->descontado_mano_pierna = request('inputManoPierna');
            $dias_desc[0]->descontado_mano_pie = request('inputManoPie');
            $dias_desc[0]->descontado_brazo_mano_dist_ext = request('inputBrazoMano');
            $dias_desc[0]->descontado_pierna_pie_dist_ext = request('inputPiernaPie');
            $dias_desc[0]->descontado_perdida_codo_hombro = request('inputACodo');
            $dias_desc[0]->descontado_perdida_muneca_codo = request('inputAMuñeca');
            $dias_desc[0]->descontado_perdida_pierna_muslo = request('inputARodilla');
            $dias_desc[0]->descontado_perdida_tobillo_rodilla = request('inputATobillo');
            $dias_desc[0]->descontado_mano_dedos_tercer_falange_pulgar = request('input3FPulgar');
            $dias_desc[0]->descontado_mano_dedos_primer_falange_pulgar = request('input1FPulgar');
            $dias_desc[0]->descontado_mano_dedos_metacarpo_pulgar = request('inputMPulgar');
            $dias_desc[0]->descontado_mano_dedos_mano_pulgar = request('inputManoMuñecaPulgar');
            $dias_desc[0]->descontado_mano_dedos_tercer_falange_indice = request('input3FIndice');
            $dias_desc[0]->descontado_mano_dedos_segundo_falange_indice = request('input2FIndice');
            $dias_desc[0]->descontado_mano_dedos_primer_falange_indice = request('input1FIndice');
            $dias_desc[0]->descontado_mano_dedos_metacarpo_indice = request('inputMIndice');
            $dias_desc[0]->descontado_mano_dedos_tercer_falange_medio = request('input3FMedio');
            $dias_desc[0]->descontado_mano_dedos_segundo_falange_medio = request('input2FMedio');
            $dias_desc[0]->descontado_mano_dedos_primer_falange_medio = request('input1FMedio');
            $dias_desc[0]->descontado_mano_dedos_metacarpo_medio = request('inputMMedio');
            $dias_desc[0]->descontado_mano_dedos_tercer_falange_anular = request('input3FAnular');
            $dias_desc[0]->descontado_mano_dedos_segundo_falange_anular = request('input2FAnular');
            $dias_desc[0]->descontado_mano_dedos_primer_falange_anular = request('input1FAnular');
            $dias_desc[0]->descontado_mano_dedos_metacarpo_anular = request('inputMAnular');
            $dias_desc[0]->descontado_mano_dedos_tercer_falange_menique = request('input3FMeñique');
            $dias_desc[0]->descontado_mano_dedos_segundo_falange_menique = request('input2FMeñique');
            $dias_desc[0]->descontado_mano_dedos_primer_falange_menique = request('input1FMeñique');
            $dias_desc[0]->descontado_mano_dedos_metacarpo_menique = request('inputMMeñique');
            $dias_desc[0]->descontado_pie_dedos_tercer_falange_dedo_grande = request('input3FPDedoG');
            $dias_desc[0]->descontado_pie_dedos_primer_falange_dedo_grande = request('input1FPDedoG');
            $dias_desc[0]->descontado_pie_dedos_metatarso_dedo_grande = request('inputMPDedoG');
            $dias_desc[0]->descontado_pie_dedos_pie_dedo_grande = request('inputPieTobilloPDedoG');
            $dias_desc[0]->descontado_pie_dedos_tercer_falange_cada_dedo = request('input3FPOtroDedo');
            $dias_desc[0]->descontado_pie_dedos_segundo_falange_cada_dedo = request('input2FPOtroDedo');
            $dias_desc[0]->descontado_pie_dedos_primer_falange_cada_dedo = request('input1FPOtroDedo');
            $dias_desc[0]->descontado_pie_dedos_metatarso_cada_dedo = request('inputMPOtroDedo');
            $dias_desc[0]->descontado_vision_ojo = request('inputOjoPerdiV');
            $dias_desc[0]->descontado_audicion_oido = request('inputOidoPerdiA');
            $dias_desc[0]->descontado_ambos_oidos = request('inputAOidoPerdiA');
            $dias_desc[0]->descontado_hernia_no_operada = request('inputHerniaNO');
            $dias_desc[0]->usuario_modificacion = auth()->user()->id_aplicacion_usuario;
            $dias_desc[0]->fecha_modificacion = 'now()';
            $dias_desc[0]->estado = '1';
            if(request('selectRegimen1') == -1 ){
                Alert::error('No a seleccionado un Regimen ','Error');
                $dat = $dias_desc;
                return view('dias_descontados_edit',compact('dat'));
            }else{
                $update = DB::connection('srvdesbdpg')->update('update ssoma.tbl_dias_desc SET regimen='.$dias_desc[0]->regimen.',descontado_muerte='.$dias_desc[0]->descontado_muerte.' ,descontado_lesion_permanente='.$dias_desc[0]->descontado_lesion_permanente.' ,descontado_ambos_ojos='.$dias_desc[0]->descontado_ambos_ojos.' ,descontado_ambos_brazos='.$dias_desc[0]->descontado_ambos_brazos.' ,descontado_ambas_piernas='.$dias_desc[0]->descontado_ambas_piernas.' ,descontado_ambas_manos='.$dias_desc[0]->descontado_ambas_manos.' ,descontado_ambos_pies='.$dias_desc[0]->descontado_ambos_pies.' ,descontado_ojo_brazo='.$dias_desc[0]->descontado_ojo_brazo.' ,descontado_ojo_mano='.$dias_desc[0]->descontado_ojo_mano.' ,descontado_ojo_pierna='.$dias_desc[0]->descontado_ojo_pierna.' ,descontado_ojo_pie='.$dias_desc[0]->descontado_ojo_pie.' ,descontado_mano_pierna='.$dias_desc[0]->descontado_mano_pierna.' ,descontado_mano_pie='.$dias_desc[0]->descontado_mano_pie.' ,descontado_brazo_mano_dist_ext='.$dias_desc[0]->descontado_brazo_mano_dist_ext.' ,descontado_pierna_pie_dist_ext='.$dias_desc[0]->descontado_pierna_pie_dist_ext.' ,descontado_perdida_codo_hombro='.$dias_desc[0]->descontado_perdida_codo_hombro.' ,descontado_perdida_muneca_codo='.$dias_desc[0]->descontado_perdida_muneca_codo.' ,descontado_perdida_pierna_muslo='.$dias_desc[0]->descontado_perdida_pierna_muslo.' ,descontado_perdida_tobillo_rodilla='.$dias_desc[0]->descontado_perdida_tobillo_rodilla.' ,descontado_mano_dedos_tercer_falange_pulgar='.$dias_desc[0]->descontado_mano_dedos_tercer_falange_pulgar.' ,descontado_mano_dedos_primer_falange_pulgar='.$dias_desc[0]->descontado_mano_dedos_primer_falange_pulgar.' ,descontado_mano_dedos_metacarpo_pulgar='.$dias_desc[0]->descontado_mano_dedos_metacarpo_pulgar.' ,descontado_mano_dedos_mano_pulgar='.$dias_desc[0]->descontado_mano_dedos_mano_pulgar.' ,descontado_mano_dedos_tercer_falange_indice='.$dias_desc[0]->descontado_mano_dedos_tercer_falange_indice.' ,descontado_mano_dedos_segundo_falange_indice='.$dias_desc[0]->descontado_mano_dedos_segundo_falange_indice.' ,descontado_mano_dedos_primer_falange_indice='.$dias_desc[0]->descontado_mano_dedos_primer_falange_indice.' ,descontado_mano_dedos_metacarpo_indice='.$dias_desc[0]->descontado_mano_dedos_metacarpo_indice.' ,descontado_mano_dedos_tercer_falange_medio='.$dias_desc[0]->descontado_mano_dedos_tercer_falange_medio.' ,descontado_mano_dedos_segundo_falange_medio='.$dias_desc[0]->descontado_mano_dedos_segundo_falange_medio.' ,descontado_mano_dedos_primer_falange_medio='.$dias_desc[0]->descontado_mano_dedos_primer_falange_medio.' ,descontado_mano_dedos_metacarpo_medio='.$dias_desc[0]->descontado_mano_dedos_metacarpo_medio.' ,descontado_mano_dedos_tercer_falange_anular='.$dias_desc[0]->descontado_mano_dedos_tercer_falange_anular.' ,descontado_mano_dedos_segundo_falange_anular='.$dias_desc[0]->descontado_mano_dedos_segundo_falange_anular.' ,descontado_mano_dedos_primer_falange_anular='.$dias_desc[0]->descontado_mano_dedos_primer_falange_anular.' ,descontado_mano_dedos_metacarpo_anular='.$dias_desc[0]->descontado_mano_dedos_metacarpo_anular.' ,descontado_mano_dedos_tercer_falange_menique='.$dias_desc[0]->descontado_mano_dedos_tercer_falange_menique.' ,descontado_mano_dedos_segundo_falange_menique='.$dias_desc[0]->descontado_mano_dedos_segundo_falange_menique.' ,descontado_mano_dedos_primer_falange_menique='.$dias_desc[0]->descontado_mano_dedos_primer_falange_menique.' ,descontado_mano_dedos_metacarpo_menique='.$dias_desc[0]->descontado_mano_dedos_metacarpo_menique.' ,descontado_pie_dedos_tercer_falange_dedo_grande='.$dias_desc[0]->descontado_pie_dedos_tercer_falange_dedo_grande.' ,descontado_pie_dedos_primer_falange_dedo_grande='.$dias_desc[0]->descontado_pie_dedos_primer_falange_dedo_grande.' ,descontado_pie_dedos_metatarso_dedo_grande='.$dias_desc[0]->descontado_pie_dedos_metatarso_dedo_grande.' ,descontado_pie_dedos_pie_dedo_grande='.$dias_desc[0]->descontado_pie_dedos_pie_dedo_grande.' ,descontado_pie_dedos_tercer_falange_cada_dedo='.$dias_desc[0]->descontado_pie_dedos_tercer_falange_cada_dedo.' ,descontado_pie_dedos_segundo_falange_cada_dedo='.$dias_desc[0]->descontado_pie_dedos_segundo_falange_cada_dedo.' ,descontado_pie_dedos_primer_falange_cada_dedo='.$dias_desc[0]->descontado_pie_dedos_primer_falange_cada_dedo.' ,descontado_pie_dedos_metatarso_cada_dedo='.$dias_desc[0]->descontado_pie_dedos_metatarso_cada_dedo.' ,descontado_vision_ojo='.$dias_desc[0]->descontado_vision_ojo.' ,descontado_audicion_oido='.$dias_desc[0]->descontado_audicion_oido.' ,descontado_ambos_oidos='.$dias_desc[0]->descontado_ambos_oidos.' ,descontado_hernia_no_operada='.$dias_desc[0]->descontado_hernia_no_operada.' ,usuario_modificacion='.$dias_desc[0]->usuario_modificacion.' ,fecha_modificacion='.$dias_desc[0]->fecha_modificacion.' where id_dias_desc='.$dias_desc[0]->id_dias_desc);
                Alert::success('El proyecto se actualizo correctamente','Actualizado');
                return redirect('/dias_descontados');
            }
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function destroy($id)
    {
    	if(auth()->user()->rol[0]->id_rol == 6){
            $data = DB::connection('srvdesbdpg')->select('select case when regimen=1 then \'DIAS DESCONTADOS DEL REGIMEN DE CONSTRUCCIÓN\' WHEN regimen=2 THEN \'DIAS DESCONTADOS DEL REGIMEN DE MINERIA\' END as nombre FROM ssoma.tbl_dias_desc WHERE estado = 1 and id_dias_desc='.$id);
        	//print(json_encode($data)); 
            $dat = DB::connection('srvdesbdpg')->update('update ssoma.tbl_dias_desc SET estado = 0 WHERE id_dias_desc='.$id);
            Alert::success('El registro ' .$data[0]->nombre. ' fue borrado exitosamente','Borrado');
            return redirect()->route("dias_descontados");
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }

    public function edit($id)
    {
        if(auth()->user()->rol[0]->id_rol == 6){    
            $dat = DB::connection('srvdesbdpg')->select('select id_dias_desc,regimen,descontado_muerte,descontado_lesion_permanente,descontado_ambos_ojos,descontado_ambos_brazos,descontado_ambas_piernas,descontado_ambas_manos,descontado_ambos_pies,descontado_ojo_brazo,descontado_ojo_mano,descontado_ojo_pierna,descontado_ojo_pie,descontado_mano_pierna,descontado_mano_pie,descontado_brazo_mano_dist_ext,descontado_pierna_pie_dist_ext,descontado_perdida_codo_hombro,descontado_perdida_muneca_codo,descontado_perdida_pierna_muslo,descontado_perdida_tobillo_rodilla,descontado_mano_dedos_tercer_falange_pulgar,descontado_mano_dedos_primer_falange_pulgar,descontado_mano_dedos_metacarpo_pulgar,descontado_mano_dedos_mano_pulgar,descontado_mano_dedos_tercer_falange_indice,descontado_mano_dedos_segundo_falange_indice,descontado_mano_dedos_primer_falange_indice,descontado_mano_dedos_metacarpo_indice,descontado_mano_dedos_tercer_falange_medio,descontado_mano_dedos_segundo_falange_medio,descontado_mano_dedos_primer_falange_medio,descontado_mano_dedos_metacarpo_medio,descontado_mano_dedos_tercer_falange_anular,descontado_mano_dedos_segundo_falange_anular,descontado_mano_dedos_primer_falange_anular,descontado_mano_dedos_metacarpo_anular,descontado_mano_dedos_tercer_falange_menique,descontado_mano_dedos_segundo_falange_menique,descontado_mano_dedos_primer_falange_menique,descontado_mano_dedos_metacarpo_menique,descontado_pie_dedos_tercer_falange_dedo_grande,descontado_pie_dedos_primer_falange_dedo_grande,descontado_pie_dedos_metatarso_dedo_grande,descontado_pie_dedos_pie_dedo_grande,descontado_pie_dedos_tercer_falange_cada_dedo,descontado_pie_dedos_segundo_falange_cada_dedo,descontado_pie_dedos_primer_falange_cada_dedo,descontado_pie_dedos_metatarso_cada_dedo,descontado_vision_ojo,descontado_audicion_oido,descontado_ambos_oidos,descontado_hernia_no_operada,usuario_registro,fecha_registro,usuario_modificacion,fecha_modificacion,estado,case when regimen=1 then \'Construcción\' WHEN regimen=2 then \'Mineria\' END as nombre_regimen FROM ssoma.tbl_dias_desc where id_dias_desc='.$id);
            return view('dias_descontados_edit',compact('dat'));
        }elseif(auth()->user()->rol[0]->id_rol == 7){
            Alert::warning('Usted no tiene privlegios para acceder a esta página','Alerta');
            return redirect('/principal');
        }
    }
}