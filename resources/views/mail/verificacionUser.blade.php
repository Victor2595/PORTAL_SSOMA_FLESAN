@component('mail::message')

Buen dia <b>{{$name}}</b>,

Usted a sido registrado al Portal de <b>"Seguridad, Salud Ocupacional </b>


<b>y Medio Ambiente"</b> del <b style="color: #d31a2b">GRUPO FLESAN</b>.
 
Para continuar con el último paso de su registro presione el 

botón que se muestra a continuación.

@component('mail::button', ['url' =>  $link , 'color' => 'red'])
<b> Verificar Cuenta</b>
@endcomponent

Saludos,<br />
Oficina de Seguridad, Salud Ocupacional y Medio Ambiente.

<b style="font-size: 8%">Abstenganse responder a este correo porque es un proceso automático.</b>
@endcomponent