<?php
$serv = "localhost";
$usu = "root";
$contra = "";
$bd = "mecanica_flores";

$conectar = mysqli_connect($serv, $usu, $contra, $bd);

if (!$conectar) {
    die("Error de conexión: " . mysqli_connect_error());
} else {
    echo "Conexión exitosa";
}
?>
