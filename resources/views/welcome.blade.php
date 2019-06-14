<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Portal SSOMA</title>
        <link  rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="img/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="img/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="img/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="img/faviconapple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="img/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="img/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff"> 

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link href="css/login.css" rel="stylesheet">
        <!--<script language=javascript>
            var signinWin;
            function nuevaventana(URL){
               window.open(URL,"ventana1","width=600,height=600,scrollbars=NO,resizable=0");
            }
        </script> -->
        
    </head>
    <body>
        <div class="container h-100">
            <div class="d-flex justify-content-center h-100">
                <div class="user_card">
                    <div class="d-flex justify-content-center">
                        <div class="brand_logo_container">
                            <img src="{{ asset('img/login-icono.png') }}" class="brand_logo" alt="Logo">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <!--<button type="submit" value="Entrar" name="button" class="btn login_btn" >{{ __('Iniciar Sesión') }}</button>-->
                               


                                 <!--<a href="javascript:nuevaventana('{{ url('auth/google') }}')"  target="_parent" class="btn_google"><img src="{{ asset('img/logo_google.jpg') }}" class="btn_g"> Signed in with Google</a>-->
                                 <a href="{{ url('auth/google') }}"  target="_parent" class="btn_google"><img src="{{ asset('img/logo_google.jpg') }}" class="btn_g"><span> Signed in with Google</span></a>

                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="logo_grupo_flesan_container">
                        <img src="{{ asset('img/logo_blanco_flesan_grupo.png') }}" class="logo_grupo_flesan" alt="grupo_flesan">
                    </div>   
                    <div class="brand_logo_container3">
                        <img   class="rounded mx-auto d-block" src="{{ asset('img/logos_fdvc.png') }}" >
                    </div>                
                </div>
            </div>
         </div>
        <!-- Bootstrap core JavaScript-->


        <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
        <script src="{{ asset('sweetalert/dist/sweetalert.min.js') }}" type="text/javascript"></script>
        @include('sweet::alert')
    </body>
</html>
