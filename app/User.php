<?php

namespace Portal_SSOMA;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Portal_SSOMA\UserRol;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $connection = 'srvdesbdpg';
    protected $table = 'seguridadapp.aplicacion_usuario';
    protected $primaryKey = 'id_aplicacion_usuario';
    public $timestamps = false;

     protected $fillable = [
        'name', 'username','provider','provider_id','id_aplicacion','fecha_ini','fecha_fin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'remember_token',
    ];

    public function rol(){
        return $this->hasMany(UserRol::class, 'id_aplicacion_usuario');
    }

}
