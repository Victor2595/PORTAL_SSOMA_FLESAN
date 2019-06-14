<?php

namespace Portal_SSOMA;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Portal_SSOMA\Models\Proyecto;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserRol extends Authenticatable
{
    //use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'srvdesbdpg';
    protected $table = 'seguridadapp.usuario_rol';
    protected $primaryKey = 'id_usuario_rol';
    public $timestamps = false;

     protected $fillable = [
        'id_aplicacion_usuario', 'id_rol','id_empresa','objeto_permitido','fecha_ini','fecha_fin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function user(){
        return $this->belongsTo(User::class, 'id_aplicacion_usuario');
    }

    public function proyecto(){
        return $this->hasMany(Proyecto::class, 'objeto_permitido');
    }

}
