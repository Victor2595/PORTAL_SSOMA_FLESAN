<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Portal SSOMAC</title>
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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
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
                <div class="row" style="margin:auto;">
                    <div class="col-sm-12 text-center">
                        <img src="{{ asset('img/login-icono.png') }}" class="brand_logo" alt="Logo"  style="z-index: 7;position: inherit;">
                        <div class="d-flex justify-content-center  login_container" style="height: 200px;">
                            <!--<button type="submit" value="Entrar" name="button" class="btn login_btn" >{{ __('Iniciar Sesión') }}</button>-->
                            <!--<a href="javascript:nuevaventana('{{ url('auth/google') }}')"  target="_parent" class="btn_google"><img src="{{ asset('img/logo_google.jpg') }}" class="btn_g"> Signed in with Google</a>-->
                            <div class="col-lg-6 col-md-8">
                                <div class="user_card" style="top: -60px;">
                                    <div class="text-center">
                                        <br><br>
                                        <a href="{{ url('auth/google') }}" class="btn btn-primary" style="font-family: Open Sans Light,Open Sans,arial;">
                                            <i class="fab fa-google text-danger" style="background: white;padding: 5px; border-radius: 3px;"></i> Sign in with Google
                                        </a>
                                        <div style="margin: auto; margin-top:5px; font-size: 12px; border-radius: 10px;" class="col-lg-6 p-3 mb-2 bg-secondary text-white"><i class="fab fa-chrome"></i> Sistema optimizado para navegador Google Chrome.</div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <div class="col-sm-12 text-center" style="top: -60px;">
                        <img src="{{ asset('img/logo_blanco_flesan_grupo.png') }}" class="logo_grupo_flesan" alt="grupo_flesan">
                    </div>
                    <div class="col-sm-12 text-center" style="top: -60px;">
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
