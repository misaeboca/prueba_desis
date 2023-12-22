<?php
include_once "conexion.php";

/**Get datos de la tabla candidato */
function obtener_candidatos() {
    $conn = conexion();
    $sql = "SELECT id, nombres, apellidos FROM candidato";
    $result = mysqli_query($conn, $sql);
    $candidatos = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $candidatos[] = $row;
    }

    echo json_encode($candidatos);
}

/**Get datos de la tabla region */
function obtener_regiones() {
    $conn = conexion();
    $sql = "SELECT id, nombre FROM region";
    $result = mysqli_query($conn, $sql);
    $regiones = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $regiones[] = $row;
    }
    echo json_encode($regiones);
}

/**Get datos de la tabla comuna */
function obtener_comunas($id_region) {
    $conn = conexion();
    $sql = sprintf("SELECT id, nombre FROM comuna WHERE id_region = %d", $id_region);
    $result = mysqli_query($conn, $sql);
    $comunas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $comunas[] = $row;
    }
    mysqli_close($conn);
    echo json_encode($comunas);
}

/**Buscar si un rut ya realizo una votacion*/
function buscar_duplicado($rut) {
    $conn = conexion();
    $sql = sprintf("SELECT COUNT(*) AS cantidad FROM votacion WHERE rut = '%s'", $rut);
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $cantidad = $row['cantidad'];
    mysqli_close($conn);
    if($cantidad>0)
        echo  json_encode(1);
    else
        echo  json_encode(0);
}

/**Guardar el registro*/
function guardar_registro($nombre, $alias, $rut, $email, $id_region, $id_comuna, $id_candidato, $medio) {
    $conn = conexion();
    $sql = sprintf(
        "INSERT INTO votacion (nombres, alias, rut, email, id_region, id_comuna, id_candidato, medio)
        VALUES ('%s', '%s', '%s', '%s', %d, %d, %d, '%s')",
        $nombre,
        $alias,
        $rut,
        $email,
        $id_region,
        $id_comuna,
        $id_candidato,
        $medio
    );
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    if($result)
        echo  json_encode(1);
    else
        echo  json_encode(0);

}

//Controlador de peticiones ajax
switch ($_REQUEST["action"]) {
    case "obtener_regiones":
        obtener_regiones();
        break;

    case "obtener_candidatos":
        obtener_candidatos();
        break;
    
    case "obtener_comunas":
        $id_region = $_GET["id_region"];
        obtener_comunas($id_region);
            break;

    case "buscar_duplicado":
        $rut = $_GET["rut"];
        buscar_duplicado($rut);
            break;
    
    case "guardar_registro":
        $nombre = $_POST["nombre"];
        $alias = $_POST["alias"];
        $rut = $_POST["rut"];
        $email = $_POST["email"];
        $id_region = $_POST["id_region"];
        $id_comuna = $_POST["id_comuna"];
        $id_candidato = $_POST["id_candidato"];
        $medio = $_POST["medio"];

        guardar_registro($nombre, $alias, $rut, $email, $id_region, $id_comuna, $id_candidato, $medio);
            break;
}
?>
