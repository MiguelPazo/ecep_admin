<!DOCTYPE HTML>
<!--[if lt IE 8]>
<html class="no-js lt-ie8"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'/>
    <title>Alena</title>
    <meta name="description" content="Módulo administrativo de Alena."/>
    <meta name="keywords" content="store, tienda, alena"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('/js/libs/material-design-lite/material.min.css') }}"/>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,500,700,300,300italic,500italic|Roboto+Condensed:400,300'
          rel='stylesheet' type='text/css'/>
    <link rel="stylesheet" type="text/css"
          href="https://storage.googleapis.com/code.getmdl.io/1.0.6/material.teal-blue.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}"/>

    <script src="{{ asset('/js/libs/material-design-lite/material.min.js') }}"></script>
</head>
<body>
<!--[if lt IE 9]>
<div class="lt-ie9-bg">
    <p class="browsehappy">Estas usando un navegador <strong>muy antiguo</strong>
        <a href="http://browsehappy.com/">actualizate</a>, vive una mejor experiencia y se feliz :D</p>
</div>
<![endif]-->

<div id="loader-container"></div>
<div class="mdl-layout">
    <main class="mdl-layout__content">
        <div class="mdl-grid">
            <section class="section--center mdl-grid mdl-cell--4-col signin-form">
                <div class="mdl-card mdl-cell--12-col mdl-shadow--6dp">
                    <div class="mdl-card__title mdl-card--expand signin-title">
                        <h1 class="mdl-card__title-text">Alena</h1>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" autocomplete="off">
                            <label class="mdl-textfield__label">Email</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="password" autocomplete="off">
                            <label class="mdl-textfield__label">Contraseña</label>
                        </div>
                    </div>
                    <div class="mdl-card__actions align_right">
                        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                            Ingresar
                        </a>
                    </div>
                </div>
                <div class="additional-info">
                    <a href="#">Registrarse</a>
                    <span class="divider-horizontal"></span>
                    <a href="#">¿Olvidó su contraseña?</a>
                </div>
                <div class="back-squeare">
                </div>

            </section>
        </div>
    </main>
</div>
</body>
</html>