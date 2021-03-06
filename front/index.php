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
                <h3><strong>El P??ramo Santurb??n es un macizo monta??oso, conocido geogr??ficamente tambi??n como "Nudo de Santurb??n"</strong>, que contempla una amplia regi??n natural, de ecosistema montano intertropical, con ubicaci??n en los departamentos colombianos de Santander y Norte de Santander.</h3>
                <h3>Santurb??n dentro de los p??ramos del Gran Santander <strong>El p??ramo se destaca por la diversidad y belleza de su fauna, as?? como por su importancia ecol??gica </strong>, en el que nacen varias fuentes h??dricas que abastecen de agua a poblaciones y ciudades de la regi??n. </h3>
            </div>
        </section>
        <section class="vertical-scrolling" style="background-image: url('media/imagen4.jpg'); background-size:cover; background-position:0px">
            <div class="container align-items-center" style="background-color:#516349; color:#F4EFEC; width:60%; margin-left:17.5%;">
                <h1>AMENZAS Y RIESGOS</h1>
            </div>
            <div class="container align-text-center text-start" style="background-color:#F4EFEC; color:#516349; height: 50%; width:65%; margin-left:17.5%; padding:2%;">
                <h3><strong> - </strong>Intervenci??n humana por la colonizaci??n del p??ramo (tala de la vegetaci??n, quemas controladas y crecimiento de zonas agr??colas).</h3>
                <br>
                <h3><strong> - </strong>Alteraci??n de la funci??n de regulaci??n h??drica por compactaci??n de los suelos producto de la ganader??a.</h3>
                <br>
                <h3><strong> - </strong>La miner??a a gran escala que quiere implementar la multinacional Minesa de Emiratos ??rabes Unidos, amenazando con contaminar la fuente h??drica del p??ramo que alimenta a m??s de 4 millones de colombianos.
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

            var myModal3 = new bootstrap.Modal(document.getElementById('ModalAlert'), {
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

            window.showModal3 = function(title, icon, color) {
                document.getElementById('tituloModal').innerHTML = title;
                icono = document.getElementById('iconoModal');
                icono.nameClass = icon;
                icono.style.color = color
                myModal3.show();
            }

            window.closeModal3 = function() {
                myModal3.hide()
            }
            

        });
    </script>
    <div class="modal" id="Modal1" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 25px;">
                <div class="modal-header text-center" style="background-color: #516349; color:#F4EFEC; border-top-left-radius:25px; border-top-right-radius:25px">
                    <h3 class="modal-title text-center">Iniciar Sesion</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #F4EFEC; color:#516349;">
                    <div class="container">
                        <form id="login">
                            <div class="row">
                                <div class="col">
                                    <label for="NombreUsuario">Nickname</label>
                                    <input name="nickname" id="NombreU" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="Contrase??aUsuario">Contrase??a</label>
                                    <input name="clave" id="Contrase??aU" type="password" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
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
            <div class="modal-content" style="border-radius: 25px;">
                <div class="modal-header" style="background-color: #516349; color:#F4EFEC; border-top-left-radius:25px; border-top-right-radius:25px">
                    <h3 class="modal-title">Registro</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #F4EFEC; color:#516349;">
                    <div class="container">
                        <form id="register">
                            <div class="row">
                                <div class="col">
                                    <label for="NombreCompletoRegistro">Nombre Completo</label>
                                    <input name="nombre_completo" id="NombreCompletoR" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="NombreRegistro">Nickname</label>
                                    <input name="nickname" id="NombreR" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="Contrase??aRegistro">Contrase??a</label>
                                    <input name="clave" id="Contrase??aR" type="password" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal" onclick="closeModal2()">Volver</button>
                    <button type="button" id="register-button" class="btn btn-lg btn-primary">Registrarse</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="ModalAlert" tabindex="-1">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content" style="border-radius: 25px;">
                <div class="modal-body" style="border-top-left-radius:25px; border-top-right-radius:25px">
                    <div class="container-fluid mb-3 mt-3">
                        <div class="row justify-content-center">
                            <div class="col-3 text-center">
                                <i class="bi bi-exclamation-triangle" id="iconoModal" style="font-size:70px;"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <h4 class="modal-title" id="tituloModal" style="color: black">Modal title</h5>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-10 text-center">
                                <p id="contenidoModal hidden">

                                </p>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-3 text-center">
                                <button type="button" class="btn btn-primary" onclick="closeModal3()">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.6.6/jquery.fullPage.min.js'></script>
    <script src="scripts/function.js"></script>
    <script>
        $(document).ready(function() {
            var BACK = 'http://127.0.0.1:8000/api/';
            $("#login-button").click(function() {
                var inputs = $("#login :input");
                values = {};
                inputs.each(function() {
                    values[this.name] = $(this).val();
                })
                let params = {
                    user: values
                }
                console.log(params);
                $.post(BACK + 'loginUser', params, function(data) {
                    if (data['status'] == false) {
                        showModal3('Usuario no registrado', 'bi bi-exclamation-triangle', 'red')
                    } else {
                        showModal3('Incio de sesion satisfactorio', 'bi bi-exclamation-triangle', 'green')
                        localStorage.setItem("nickname", data.data['nickname']);
                        localStorage.setItem("clave", data.data['clave']);
                        localStorage.setItem("id_usuario", data.data['id_usuario']);
                        window.location.href = 'admin/login.php';
                    }
                });
            })

            $("#register-button").click(function() {
                var inputs = $("#register :input");
                values = {};
                inputs.each(function() {
                    values[this.name] = $(this).val();
                })
                let params = {
                    user: values
                }
                if (values['nickname'] == "" || values['nombre_completo'] == "" || values['clave'] == "") {
                    showModal3('Debe llenar todos los campos', 'bi bi-exclamation-triangle', 'red')
                } else {
                    console.log(params)
                    $.post(BACK + 'createUser', params, function(data) {
                        showModal3('Usuario creado satisfactoriamente', 'bi bi-exclamation-triangle', 'green')
                        console.log(data);
                    });
                }
            })
        })
    </script>
</body>

</html>