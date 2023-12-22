<?php

function conexion(){
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "desis";

    $conn = mysqli_connect($host, $user, $password, $database);

    if (!$conn) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }
    return $conn;
}
?>
