<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Votación</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 90%;
            padding: 10px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-check-input {
            margin-right: 10px;
        }

        .btn {
            padding: 10px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .error {
            color: red;
            border: 1px solid red;
            padding: 10px;
            margin-bottom: 10px;
        }
        .error-message{
            color:red;
        }
       

    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Votación</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>
    <div class="container">
        <h1>Formulario de Votación</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="nombre">Nombre y Apellido:</label>
                <input type="text" name="nombre" id="nombre" class="form-control">
                <div>
                    <span class="error-message"></span>
                </div>

            </div>
            <div class="form-group">
                <label for="alias">Alias:</label>
                <input type="text" name="alias" id="alias" class="form-control">
                <div>
                    <span class="error-message"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="rut">RUT:</label>
                <input type="text" name="rut" id="rut" class="form-control">
                <div>
                    <span class="error-message"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control">
                <div>
                    <span class="error-message"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="region">Región:</label>
                <div>
                    <span class="error-message"></span>
                </div>
                <select name="region" id="region" class="form-control">
                    <option value="">Seleccione una región</option>
                </select>
                
            </div>
            <div class="form-group">
                <label for="comuna">Comuna:</label>
                <div>
                    <span class="error-message"></span>
                </div>
                <select name="comuna" id="comuna" class="form-control">
                    <option value="">Seleccione una comuna</option>
                </select>
            </div>
            <div class="form-group">
                <label for="candidato">Candidato:</label>
                <div>
                    <span class="error-message"></span>
                </div>
                <select name="candidato" id="candidato" class="form-control">
                    <option value="">Seleccione un candidato</option>
                </select>
            </div>
            <br>
            Como se entero de Nosotros
            <br>
            <div class="form-group">
                <input type="checkbox" name="medio[]" value="web" class="form-check-input"> Web
                <input type="checkbox" name="medio[]" value="tv" class="form-check-input"> Tv
                <input type="checkbox" name="medio[]" value="redes" class="form-check-input"> Redes Sociales
                <input type="checkbox" name="medio[]" value="correo" class="form-check-input"> Correo
                <div>
                    <span class="error-message"></span>
                </div>
            </div>
            <br>
            <br>
            <button type="button" id="votar" class="btn btn-primary">Votar</button>
        </form>
    </div>
</body>
</html>

</body>
</html>
<script>
$(document).ready(function() {
   
    //llenar data de select regiones
    $.ajax({
        url: "funciones.php",
        method: "GET",
        data: {
            action: "obtener_regiones"
        },
        success: function(response) {
            let regiones = JSON.parse(response);

            $.each(regiones, function(index, region) {
                $("#region").append("<option value='" + region.id + "'>" + region.nombre + "</option>");
            });
        }
    });

    //llenar data de select comuna, segun la region que escojan
    $("#region").change(function() {
        let id_region = $(this).val();
        $.ajax({
            url: "funciones.php",
            method: "GET",
            data: {
                action: "obtener_comunas",
                id_region: id_region
            },
            success: function(response) {
                let comunas = JSON.parse(response);
                $("#comuna").empty();
                $("#comuna").append("<option value=''>Seleccione una comuna</option>");
                $.each(comunas, function(index, comuna) {
                    $("#comuna").append("<option value='" + comuna.id + "'>" + comuna.nombre + "</option>");
                });
            }
        });
    });

    //llenar data de select candidato
    $.ajax({
        url: "funciones.php",
        method: "GET",
        data: {
            action: "obtener_candidatos"
        },
        success: function(response) {
            let candidatos = JSON.parse(response);;
            $.each(candidatos, function(index, candidato) {
                $("#candidato").append("<option value='" + candidato.id + "'>" + candidato.nombres + " " + candidato.apellidos + "</option>");
            });
        }
    });


    /*** Validaciones Campos ***/
    $("#nombre").on("blur", function() {
        if ($("#nombre").val()=='') {
            event.preventDefault();
            $("#nombre").addClass("error");
            $("#nombre").parent().find(".error-message").text("El nombre y apellido es obligatorio");
        } else {
            $("#nombre").removeClass("error");
            $("#nombre").parent().find(".error-message").text("");
        }
    });

     // Validar alias
     $("#alias").on("blur", function() {
        if (!$(this).val()) {
            $(this).addClass("error");
            $(this).parent().find(".error-message").text("El alias es obligatorio");
        } else if ($(this).val().length < 5) {
            $(this).addClass("error");
            $(this).parent().find(".error-message").text("El alias debe tener al menos 5 caracteres");
        } else if (!/^[a-zA-Z0-9]+$/.test($(this).val())) {
            $(this).addClass("error");
            $(this).parent().find(".error-message").text("El alias solo puede contener letras y números");
        } else {
            $(this).removeClass("error");
            $(this).parent().find(".error-message").text("");
        }
    });
    
    // Validar RUT
    $("#rut").on("blur", function() {
        if (!$(this).val()) {
            $(this).addClass("error");
            $(this).parent().find(".error-message").text("El RUT es obligatorio");
        } else if (!/^[0-9]{7,8}-[0-kK]{1}$/.test($(this).val())) {
            $(this).addClass("error");
            $(this).parent().find(".error-message").text("El RUT no es válido");
        } else {
            $(this).removeClass("error");
            $(this).parent().find(".error-message").text("");
        }
    });

    //Validar email
    $("#email").on("blur", function() {
        if (!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test($(this).val())) {
            $(this).addClass("error");
            $(this).parent().find(".error-message").text("El email no es válido");
        } else {
            $(this).removeClass("error");
            $(this).parent().find(".error-message").text("");
        }
    });

    //Validar select no vacio
    function validarSelect(select) {
        if (!select.val()) {
            select.addClass("error");
            select.parent().find(".error-message").text("Este campo es obligatorio");
            return false;
        } else {
            select.removeClass("error");
            select.parent().find(".error-message").text("");
            return true;
        }
    }

    $("#region").on("change", function() {
        validarSelect($(this));
    });

    $("#comuna").on("change", function() {
        validarSelect($(this));
    });

    $("#candidato").on("change", function() {
        validarSelect($(this));
    });

    //Validar medio
    $("#medio").find(":checkbox").on("blur", function() {
        let seleccionados = $("#medio").find(":checked").length;
        if (seleccionados < 2) {
            $("#medio").addClass("error");
            $("#medio").parent().find(".error-message").text("Debe elegir al menos dos opciones");
        } else {
            $("#medio").removeClass("error");
            $("#medio").parent().find(".error-message").text("");
        }
    });

    //Boton Votar
    $("#votar").on("click", function(event) {
        // Validar que no haya errores en los campos
        let elementosInvalidos = $(".error").not("input, select, checkbox");

        if (elementosInvalidos.length > 0) {
            event.preventDefault();
            return;
        }
        
        //Validar que no haya voto duplicado para un rut
        $.ajax({
            url: "funciones.php",
            method: "GET",
            data: {
                action: "buscar_duplicado",
                rut: $("#rut").val()
            },
            success: function(response) {

                if(parseInt(response) > 0){
                    alert("El usuario ya realizo un voto")
                    return false;
                }else{
                    //Guardar el registro 
                    guardar_voto()
                }
            }
        });
    });

    function guardar_voto(){
        let mediosSeleccionados = $(".form-group input[name='medio[]']:checked").map(function() {
            eturn $(this).val();
        }).get();

        $.ajax({
            url: "funciones.php",
            method: "POST",
            data: {
                action:"guardar_registro",
                nombre: $("#nombre").val(),
                alias: $("#alias").val(),
                rut: $("#rut").val(),
                email: $("#email").val(),
                id_region: $("#region").val(),
                id_comuna: $("#comuna").val(),
                id_candidato: $("#candidato").val(),
                medio: mediosSeleccionados.join(","),
            },
            success: function(response) {
                console.log(response)
                if (parseInt(response) === 1) {
                    alert("Voto guardado correctamente.");
                    window.location.reload();
                } else {
                    alert("Ha ocurrido un error al guardar el voto.");
                }
            },
            error: function(error) {
                console.log(error);
                alert("Ha ocurrido un error inesperado. Inténtelo de nuevo más tarde.");
            },
        });
    }

});  

</script>
