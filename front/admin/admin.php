<?php

require 'header.php';

?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<header>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color:#516349;">
        <a class="navbar-brand" href="#" style="padding-left:5%;color:#F4EFEC;">SANTURBAN STATS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav" style="color:#F4EFEC;">
            <ul class="navbar-nav" style="padding-right: 5%;">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" style="color:#F4EFEC;">Cerrar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="showModal2()" style="color:#F4EFEC;">Historial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="showModal()" style="color:#F4EFEC;">Editar Usuario</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<div id="containerPrincipal" style="width:100%; height:50vh; padding:5%; padding-top:1%; padding-bottom:0;"></div>
<div class="row" style="width:100%; padding-top:1%; padding-bottom:0;">
    <div class="col">
        <div id="container" style="width:100%; height:40vh; padding:2%;"></div>
    </div>
    <div class="col">
        <div id="container1" style="width:100%; height:40vh; padding:2%;"></div>
    </div>
    <div class="col">
        <div id="container2" style="width:100%; height:40vh; padding:2%;"></div>
    </div>
</div>




<script>
    var nickname = localStorage.getItem("nickname")
    var clave = localStorage.getItem("clave")
    var id_usuario = localStorage.getItem("id_usuario")

    var histori = [];
    var BACK = 'http://127.0.0.1:8000/api/';
    $(document).prop('title', 'Santurwan');
    $(document).ready(function() {
        var user = {
            "nickname": nickname,
            "clave": clave,
        }
        let params = {
            user: user
        }
        $.post(BACK + 'traerLecturas', params, function(data) {
            histori = data.data;
            var temperatura = [];
            var id = [];
            var uv = [];
            var humedad = [];
            for (let i = 0; i < data.data.length; i++) {
                temperatura[i] = Number(data.data[i].temperatura);
                id[i] = Number(data.data[i].id_sensores);
                uv[i] = Number(data.data[i].uv);
                humedad[i] = Number(data.data[i].humedad);
            }
            draw(temperatura, humedad, uv, id)
            draw1(temperatura, id);
            draw2(uv, id);
            draw3(humedad, id);
        });
    })

    function draw(temperatura, humedad, uv, id) {
        const chart4 = Highcharts.chart('containerPrincipal', {

            title: {
                text: 'LECTURAS POR SENSOR'
            },

            yAxis: {
                title: {
                    text: 'SENSORES'
                }
            },

            xAxis: {
                categories: id
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            series: [{
                name: 'Temperatura',
                data: temperatura,
            }, {
                name: 'Humedad',
                data: humedad,
            }, {
                name: 'UV',
                data: uv,
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    }

    function draw1(temperatura, id) {
        const chart4 = Highcharts.chart('container', {

            title: {
                text: 'LECTURAS DE TEMPERATURA'
            },

            yAxis: {
                title: {
                    text: 'SENSORES'
                }
            },

            xAxis: {
                categories: id
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            series: [{
                name: 'Temperatura',
                data: temperatura,
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    }

    function draw2(uv, id) {
        const chart4 = Highcharts.chart('container1', {

            title: {
                text: 'LECTURAS DE UV'
            },

            yAxis: {
                title: {
                    text: 'SENSORES'
                }
            },

            xAxis: {
                categories: id
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            series: [{
                name: 'UV',
                data: uv,
                color: '#008000',
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    }

    function draw3(humedad, id) {
        const chart4 = Highcharts.chart('container2', {

            title: {
                text: 'LECTURAS DE HUMEDAD'
            },

            yAxis: {
                title: {
                    text: 'SENSORES'
                }
            },

            xAxis: {
                categories: id
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            series: [{
                name: 'Humedad',
                data: humedad,
                color: '#000000',
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });
    }
</script>
<script>
    function historial() {
        var tabla = $("#history-body");
        var html = '';
        histori.map((dato) => {
            html += '<tr><td>';
            html += dato.id_sensores + '</td>';
            html += '<td>' + dato.temperatura + '</td>';
            html += '<td>' + dato.humedad + '</td>';
            html += '<td>' + dato.uv + '</td>';
            html += '<td>' + dato.fecha_creacion + '</td>';
            html += '<td>' + dato.fecha_ult_modif + '</td>';
            html += '<td class="text-center"><button class="btn bg-trasnparent btn-sm" onclick = "showModal4(' + dato.id_sensores + ',' + dato.temperatura + ',' + dato.humedad + ',' + dato.uv + ');"> <i class="bi bi-pencil-square"></i></button>';
            html += '</td></tr>';
        });
        tabla.html(html);
    }
    $(document).ready(function() {
        var myModal = new bootstrap.Modal(document.getElementById('Modal1'), {
            keyboard: false
        });
        var myModal2 = new bootstrap.Modal(document.getElementById('ModalHistory'), {
            keyboard: false
        });
        var myModal3 = new bootstrap.Modal(document.getElementById('ModalAlert'), {
            keyboard: false
        });
        var myModal4 = new bootstrap.Modal(document.getElementById('ModalEditar'), {
            keyboard: false
        });

        window.showModal = function() {
            $("#NombreU").val(nickname)
            $("#Contrase??aU").val(clave)
            myModal.show();
        }

        window.closeModal = function() {
            myModal.hide()
        }

        updateHistory = function(){
            $("#history-body").html("")
            var user = {
                "nickname": nickname,
                "clave": clave,
            }
            let params = {
                user: user
            }
            $.post(BACK + 'traerLecturas', params, function(data) {
                histori = data.data;
            });
            historial();
        }
        window.showModal2 = function() {
            updateHistory();
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

        window.showModal4 = function(id_sensor, temperatura, humedad, uv) {
            $("#Temperatura").val(temperatura)
            $("#Humedad").val(humedad)
            $("#UV").val(uv)
            $("#Id_sensores").val(id_sensor)
            myModal2.hide();
            myModal4.show();
        }

        window.closeModal4 = function() {
            updateHistory();
            myModal4.hide()
        }

        $("#saveU-button").click(function() {

            $("#idU").val(id_usuario)
            var inputs = $("#editUser :input");
            values = {};
            inputs.each(function() {
                values[this.name] = $(this).val();
            })
            let params = {
                user: values
            }
            if (values['nickname'] == "" || values['clave'] == "") {
                showModal3('Debe llenar todos los campos', 'bi bi-exclamation-triangle', 'red')
            } else {
                $.post(BACK + 'editarUser', params, function(data) {
                    showModal3('Usuario actualizado satisfactoriamente', 'bi bi-exclamation-triangle', 'green')
                    nickname = values["nickname"];
                    clave = values["clave"];
                });
            }
        })
        $("#save-button").click(function() {
            var inputs = $("#editLectura :input");
            values = {};
            inputs.each(function() {
                values[this.name] = $(this).val();
            })
            let params = {
                lectura: values
            }
            console.log(params)
            if (values['temperatura'] == "" || values['humedad'] == "" || values['uv'] == "") {
                showModal3('Debe llenar todos los campos', 'bi bi-exclamation-triangle', 'red')
            } else {
                $.post(BACK + 'editarLectura', params, function(data) {
                    showModal3('Lectura actualizado satisfactoriamente', 'bi bi-exclamation-triangle', 'green')
                    $("#history-body").html("")
                    historial()
                    console.log(data);
                });
            }
        })
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
                    <form id="editUser">
                        <div class="row">
                            <div class="col">
                                <label for="NombreUsuario">Nickname</label>
                                <input name="nickname" id="NombreU" type="text" class="form-control">
                                <input name="id_usuario" id="idU" type="text" class="form-control" hidden>
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
                <button type="button" id="saveU-button" class="btn btn-lg btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ModalEditar" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 25px;">
            <div class="modal-header text-center" style="background-color: #516349; color:#F4EFEC; border-top-left-radius:25px; border-top-right-radius:25px">
                <h3 class="modal-title text-center">Editar lectura</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #F4EFEC; color:#516349;">
                <div class="container">
                    <form id="editLectura">
                        <div class="row">
                            <div class="col">
                                <label for="Temperatura">Temperatura</label>
                                <input name="temperatura" id="Temperatura" type="number" class="form-control">
                                <input name="id_sensores" id="Id_sensores" type="text" class="form-control" hidden>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="Humedad">Humedad</label>
                                <input name="humedad" id="Humedad" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="UV">UV</label>
                                <input name="uv" id="UV" type="number" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal" onclick="closeModal4()">Volver</button>
                <button type="button" id="save-button" class="btn btn-lg btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ModalHistory" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 25px;">
            <div class="modal-header text-center" style="background-color: #516349; color:#F4EFEC; border-top-left-radius:25px; border-top-right-radius:25px">
                <h3 class="modal-title text-center">Historial de datos</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #F4EFEC; color:#516349;">
                <div class="table-responsive" id="table-ordered3">
                    <table id="table_list3" class="table table-bordered table-hover datatable" style="width:99%;">
                        <thead>
                            <tr style="background-color: #516349;">
                                <th class="text-center" style="color:#F4EFEC;"> # </th>
                                <th class="text-center" style="color:#F4EFEC;"> Temperatura </th>
                                <th class="text-center" style="color:#F4EFEC;"> Humedad</th>
                                <th class="text-center" style="color:#F4EFEC;"> UV</th>
                                <th class="text-center" style="color:#F4EFEC;"> Fecha de creacion </th>
                                <th class="text-center" style="color:#F4EFEC;"> Fecha de modificacion </th>
                                <th class="text-center" style="color:#F4EFEC;"> Editar </th>
                            </tr>
                        </thead>
                        <tbody id="history-body">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Volver</button>
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

<?php
require 'footer.php';
?>