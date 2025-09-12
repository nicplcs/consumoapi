<?php

$admin_id = 1;

echo "ingrese el id del administrador: ";
$id_mio = readline();

$url = "http://localhost:8080/usuarios";

$consumo = file_get_contents($url);

if ($consumo === false) {
    die("Error al consumir el servicio web.");
}

$usuarios = json_decode($consumo);

if ((int)$id_mio !== $admin_id) {
    die("Acceso denegado. Solo el administrador puede ver la lista de usuarios.");
}

echo "-------------------------USUARIOS------------------------\n";


foreach ($usuarios as $usuario) {

if ((string)$usuario->estado === "1") {


    echo $usuario->id . "\n";
    echo $usuario->nombre . "\n";
    echo $usuario->correo . "\n";
    echo $usuario->contrasena . "\n";
    echo $usuario->estado . "\n";
    echo "ACTIVO\n";

} else {
    echo $usuario->id . "\n";
    echo $usuario->nombre . "\n";
    echo $usuario->correo . "\n";
    echo $usuario->contrasena . "\n";
    echo $usuario->estado . "\n";
    echo "INACTIVO\n";
}
    echo "---------------------------------------------------------\n";
}

?>