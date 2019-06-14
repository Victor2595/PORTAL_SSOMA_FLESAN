<?php

namespace Portal_SSOMA\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class GmailNotificacionJefeModificacion extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre_proyecto_ant,$name_ant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre_proyecto_ant,$name_ant)
    {
        $this->nombre_proyecto = $nombre_proyecto_ant;
        $this->name = $name_ant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ssoma.grupoflesan@gmail.com','Oficina Corporativa Seguridad, Salud Ocupacional y Medio Ambiente')
            ->subject('Designación Jefe SSOMA')
            ->markdown('mail.designacionJefeAnt')
            ->with([
                'name' => $this->name,
                //'link' => 'http://www.bryceandy.com',
                'proyecto' => $this->nombre_proyecto,
            ]);
    }
}
