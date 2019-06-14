<?php

namespace Portal_SSOMA\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class GmailVerificarUser extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombre)
    { 
        
        $this->name = $nombre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ssoma.grupoflesan@gmail.com','Oficina Corporativa Seguridad, Salud Ocupacional y Medio Ambiente')
            ->subject('Verificación Usuario')
            ->markdown('mail.verificacionUser')
            ->with([
                'name' => $this->name,
                'link' => 'https://192.168.25.26.xip.io:8000',
               // 'proyecto' => $this->nombre_proyecto,
            ]);
    }
}
