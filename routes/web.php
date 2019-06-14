 <?php

//----------------LOGIN Y CERRAR SESIÓN----------------------------
Route::get('auth/{provider}','Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback','Auth\LoginController@handleProviderCallback');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get("/","Auth\LoginController@index")->name('welcome');

//Rutas propias
Route::get("/principal","ControllerPortal@create")->name('principal');
Route::get("/administracion_usuarios","ControllerPortal@lista_adm_user")->name('administracion_usuarios');
Route::get("/administracion_usuarios/{id}/inactivar","ControllerPortal@cambiar_state_user")->name('states_usuarios');
Route::post("/administracion_usuarios/grabarUsuariosNew","ControllerPortal@grabarUsuarios")->name('grabar_usuarios');

//API ROUTES
Route::get("/configuracion_proyecto_registro/{id}","ProyectoController@getProyectos");
Route::get("/configuracion_proyecto_unidad_negocio","ProyectoController@getUnidades");
Route::get("/configuracion_proyecto_registro/id_proyecto/{id_proyecto}","ProyectoController@getDatos");
///Route::get("/configuracion_proyecto/{id}/sincronizar","ProyectoController@sincronizeDatos");
Route::post("/configuracion_proyecto/{id}/save_sincronizar","ProyectoController@saveSincronize")->name('save_sincronizar');

//ROUTES BD-SEGURIDAD
Route::get("/configuracion_proyecto_registro/id_jefe/{id}","SeguridadController@byJefe");
Route::get("/configuracion_proyecto_registro/verificar_habilitado/{id}","ProyectoController@asignadoJefe");

//--CONFIGURACION PROYECTO
Route::get("/configuracion_proyecto","ProyectoController@configuracion_proyecto")->name('configuracion_proyecto');
Route::get("/configuracion_proyecto_registro", "ProyectoController@configuracion_proyecto_registro")->name('configuracion_proyecto_registro');
Route::post("/configuracion_proyecto_registro/grabarConfiguraciónProyecto","ProyectoController@grabarConfiguracionProyecto")->name('grabar_configurar_proyecto');
Route::post("/configuracion_proyecto/{id}/updateConfiguraciónProyecto","ProyectoController@updateConfiguracionProyecto")->name('update_configurar_proyecto');
Route::get("/configuracion_proyecto/{id_proyecto}/edit","ProyectoController@edit")->name('proyecto.edit');
Route::get("/configuracion_proyecto/{id_proyecto}","ProyectoController@destroy")->name('proyecto.destroy');

//--DIAS DESCONTADOS
Route::get("/dias_descontados","DescontadosController@dias_descontados")->name('dias_descontados');
Route::get("/dias_descontados_registro","DescontadosController@configuracion_proyecto_dias_descontados")->name('dias_descontados_registro');
Route::post("/dias_descontados_registro/grabarDiasDescontados","DescontadosController@grabarDiasD")->name('grabar_dias_descontados');
Route::post("/dias_descontados_registro/updateDiasDescontados/{id}","DescontadosController@updateDiasD")->name('update_dias_descontados');
Route::get("/dias_descontados/{id_dias_desc}/edit","DescontadosController@edit")->name('dias.edit');
Route::get("/dias_descontados/{id_dias_desc}","DescontadosController@destroy")->name('dias.destroy');


//------PROGRAMACION ANUAL
Route::get("/programacion_anual","ProgramacionAnualController@index")->name('programacion_anual');
Route::get("/programacion_anual_general","ProgramacionAnualController@listado")->name('programacion_anual_general');
Route::get("/programacion_anual_registro","ProgramacionAnualController@registro_programacion")->name('programacion_anual_registro');
Route::post("/programacion_anual_registro/import-excel", "ProgramacionAnualController@importProgramacion")->name('importar_excel');
Route::delete("/programacion_anual/{id}/delete","ProgramacionAnualController@destroy")->name('programacion_destroy');
Route::get("/programacion_anual_general/{id}/visualizacion","ProgramacionAnualController@visualizacionProgramacion")->name('visualizacion_programacion');

//ROUTE BD-SSOMA
//Route::get("/configuracion_proyecto/proyecto","ProyectoController@cargarTablaProyecto")->name('configuracion_proyecto_tabla');

//--INDICADORES
Route::get("/indicadores_listado","IndicadoresController@indicadores_l")->name('indicadores_listado');
Route::get("/indicadores_registro","IndicadoresController@indicadores_r")->name('indicadores_registro');
Route::get("/indicadores_registro/{id_indicadores}/editIndicadores","IndicadoresController@editIndicadores")->name('indicadores_edit');
Route::get("/indicadores_registro/{id_indicadores}/sendIndicadores","IndicadoresController@sendIndicadores")->name('indicadores_send');
Route::get("/indicadores_listado_general","IndicadoresController@indicadores_listado_general")->name('indicadores_listado_general');
Route::get("/indicadores/{id_indicadores}/aprobar","IndicadoresController@validacion_observacion")->name('indicadores_aprobacion_observacion');
Route::post("/indicadores_registro/grabar_indicadores" ,"IndicadoresController@grabarIndicadores")->name('indicadores_grabar');
Route::post("/indicadores/aprobar/{id_indicadores}","IndicadoresController@aprobar_indicadores")->name('aprobar_indicadores');
Route::post("/indicadores/{id_indicadores}/update","IndicadoresController@update_indicadores")->name('update_indicadores');

//--DASHBOARD
Route::get("/dashboards","ControllerPortal@dashboard")->name('dashboards');

Route::get("/reportes_estadisticos","ReportesController@reportes_individuales")->name('reportes_individuales');
Route::get("/reportes_indicadores/all","ReportesController@reportes_indicadores")->name('reportes_indicadores');
Route::get("/reportes_consolidados","ReportesController@reportes_consolidados")->name('reportes_consolidados');
Route::get("/reportes_indicadores","ReportesController@reportes_generar")->name('reportes_generar');


//Rutas Login
/*Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');*/
// Rutas de Registro
/*if ($options['register'] ?? true) {
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
}*/
//Rutas para reseteo de Contraseña
/*if ($options['reset'] ?? true) {
    Route::resetPassword();
}*/
// Rutas Verificacion de Correo
/*if ($options['verify'] ?? false) {
    Route::emailVerification();
}*/



