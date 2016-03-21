<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <style>
        .dialog_permissions {
            background-color: #f4f4f4;
            line-height: 30px;
            margin-top: 125px;
            padding: 0 0 30px;
        }

        .dialog_permissions .logo {
            position: absolute;
            right: -54px;
            top: -74px;
            width: 240px;
        }

        .dialog_permissions h3 {
            background-color: #646464;
            color: #fff;
            margin: 0 0 20px;
            padding: 10px 15px;
        }

        .dialog_permissions .dialog_content {
            margin-bottom: 20px;
        }

        .dialog_permissions .dialog_content div {
            display: inline-block;
            vertical-align: top;
            width: 49%;
        }

        .dialog_permissions .permissions {

        }

        .dialog_permissions .permissions ul {

        }

        .dialog_permissions .permissions li {

        }

        .dialog_permissions .app {
            text-align: center;
        }

        .dialog_permissions .app .text_logo {
            display: block;
            font-size: 60px;
            margin-top: 86px;
        }

        .dialog_permissions .dialog_buttons {
            text-align: center;
        }

        .dialog_permissions .dialog_buttons input {
            margin: 0 15px;
        }

        .btn-lg, .btn-group-lg > .btn {
            height: 52px;
            padding: 10px 28px;
        }

        .btn, .btn-lg, .input-lg {
            border-radius: 3px;
        }

        .btn-success {
            background-color: #2ecc71;
            background-image: none;
            border: 0 none;
            box-shadow: 0 3px 0 rgba(2, 154, 67, 1);
            line-height: 1.8;
        }

        .btn-default {
            background-color: #c9c9c9;
            background-image: none;
            border: 0 none;
            box-shadow: 0 3px 0 rgba(138, 133, 133, 1);
            line-height: 1.8;
        }

    </style>
</head>
<body>
<div class="container-fluid container">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 dialog_permissions">
            <img class="logo" src="{{ asset('/img/logo_reniec.jpg') }}" alt="">
            <h3>Solicitud de Permisos</h3>
            <div class="col-sm-12 dialog_content">
                <div class="permissions">
                    <span>El servicio solicita los siguientes datos:</span>
                    <ul>
                        <li>
                            Nombres y apellidos.
                        </li>
                        <li>
                            DNI
                        </li>
                        <li>
                            Organización que emitió su certificado.
                        </li>
                        <li>
                            Clase de certificado.
                        </li>
                        <li>
                            Número de serial de su certificado.
                        </li>
                    </ul>
                </div>
                <div class="app">
                    <span class="text_logo">ECEP</span>
                </div>
            </div>
            <div class="col-sm-12 dialog_buttons">
                <input class="btn btn-default btn-lg" type="button" value="CANCELAR">
                <input class="btn btn-success btn-lg" type="button" value="ACEPTAR">
            </div>
        </div>
    </div>
</div>
</body>
</html>

