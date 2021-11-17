<?php
session_start();
if (isset($_SESSION['logged']) && $_SESSION['logged']) {
    /**
     * Redirigir
     */
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.6.6/jquery.fullPage.css'>
    <link rel="stylesheet" href="styles/basic.css">
    <title>Bienvenidos!</title>


</head>

<body>
    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <header>
        <div class="header-top clearfix">
            <a class="l-right toggle-menu" href="#">
                <i></i>
                <i></i>
                <i></i>
            </a>
        </div>

        <nav class="hide">
            <ul id="menu">
                <li data-menuanchor="firstSection">
                    <a type="button" onclick="showModal()" title="Sign in">Iniciar Sesion</a>
                </li>
                <li data-menuanchor="secondSection">
                    <a type="button" onclick="showModal2()" title="Sign up">Registrarse</a>
                </li>
            </ul>
        </nav>
    </header>
    <div id="fullpage">
        <section class="vertical-scrolling" style="background-image: url('media/imagen3.jpeg'); background-size:cover;">
            <div class="container align-items-center" style="background-color:#516349; color:#F4EFEC; width:60%; margin-left:40%;">
                <h1>PARAMO DE SANTURBAN</h1>
            </div>
            <div class="container align-text-center text-start" style="background-color:#F4EFEC; color:#516349; height: 50%; width:60%; margin-left:40%; padding:2%; padding-right:5%;">
                <h3><strong>El Páramo Santurbán es un macizo montañoso, conocido geográficamente también como "Nudo de Santurbán"</strong>, que contempla una amplia región natural, de ecosistema montano intertropical, con ubicación en los departamentos colombianos de Santander y Norte de Santander.</h3>
                <h3>Santurbán dentro de los páramos del Gran Santander <strong>El páramo se destaca por la diversidad y belleza de su fauna, así como por su importancia ecológica </strong>, en el que nacen varias fuentes hídricas que abastecen de agua a poblaciones y ciudades de la región. </h3>
            </div>
        </section>
        <section class="vertical-scrolling" style="background-image: url('media/imagen4.jpg'); background-size:cover; background-position:0px">
            <div class="container align-items-center" style="background-color:#516349; color:#F4EFEC; width:50%; margin-left:25%;">
                <h1>AMENZAS Y RIESGOS</h1>
            </div>
            <div class="container align-text-center text-start" style="background-color:#F4EFEC; color:#516349; height: 50%; width:65%; margin-left:17.5%;padding-right:5%; padding:2%;">
                <h3><strong> - </strong>Intervención humana por la colonización del páramo (tala de la vegetación, quemas controladas y crecimiento de zonas agrícolas).</h3>
                <br>
                <h3><strong> - </strong>Alteración de la función de regulación hídrica por compactación de los suelos producto de la ganadería.</h3>
                <br>
                <h3><strong> - </strong>La minería a gran escala que quiere implementar la multinacional Minesa de Emiratos Árabes Unidos, amenazando con contaminar la fuente hídrica del páramo que alimenta a más de 4 millones de colombianos.
                    que se puedan presentar amenazando fauna y flora de frailejones.</h3>
            </div>
        </section>
        <section class="vertical-scrolling">
            <video width="100%" autoplay>
                <source src="media/video.mp4" type="video/mp4">
            </video>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            var myModal = new bootstrap.Modal(document.getElementById('Modal1'), {
                keyboard: false
            });

            var myModal2 = new bootstrap.Modal(document.getElementById('Modal2'), {
                keyboard: false
            });

            window.showModal = function() {
                myModal.show();
            }

            window.closeModal = function() {
                myModal.hide()
            }

            window.showModal2 = function() {
                myModal2.show();
            }

            window.closeModal2 = function() {
                myModal2.hide()
            }
        });
    </script>
    <div class="modal" id="Modal1" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center" style="background-color: #516349; color:#F4EFEC;">
                    <h5 class="modal-title text-center">Iniciar Sesion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3" style="background-color: #F4EFEC; color:#516349;">
                    <form id="login">
                        <div class="row">
                            <div class="col">
                                <label for="NombreUsuario">Nombre</label>
                                <input name="nickname" id="NombreU" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="ContraseñaUsuario">Contraseña</label>
                                <input name="clave" id="ContraseñaU" type="password" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Volver</button>
                    <button type="button" id="login-button" class="btn btn-lg btn-primary">Iniciar Sesion</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="Modal2" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #516349; color:#F4EFEC;">
                    <h5 class="modal-title">Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #F4EFEC; color:#516349;">
                    <div class="row">
                        <div class="col">
                            <label for="NombreRegistro">Nombre</label>
                            <input name="NombreRegistro" id="NombreR" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="ContraseñaRegistro">Contraseña</label>
                            <input name="ContraseñaRegistro" id="ContraseñaR" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="TelefonoRegistro">Telefono</label>
                            <input name="TelefonoRegistro" id="TelefonoR" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="CorreoRegistro">Correo Electronico </label>
                            <input name="CorreoRegistro" id="CorreoR" type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal" onclick="closeModal2()">Volver</button>
                    <button type="button" class="btn btn-lg btn-primary">Registrarse</button>
                </div>
            </div>
        </div>
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.6.6/jquery.fullPage.min.js'></script>
    <script src="scripts/function.js"></script>
    <script>
        $(document).ready(function() {
            $("#login-button").click(function() {
                var inputs = $("#login :input");
                values = {};
                inputs.each(function() {
                    values[this.name] = $(this).val();
                }) 
                let params = {user : values}
                console.log(params);
                var BACK = 'http://127.0.0.1:8000/api/';
                $.post(BACK + 'loginUser', params, function(data){
                    console.log(data);
                });
            })
        })
    </script>
</body>

</html>