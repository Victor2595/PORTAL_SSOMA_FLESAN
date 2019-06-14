<?php

namespace Portal_SSOMA\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class GmailNotificacionJefe extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre_proyecto,$name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre_proyecto,$name)
    {
        $this->nombre_proyecto = $nombre_proyecto;
        $this->name = $name;
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
            ->markdown('mail.designacionJefe')
            ->with([
                'name' => $this->name,
                //'link' => 'http://www.bryceandy.com',
                'proyecto' => $this->nombre_proyecto,
            ]);
    }
}
