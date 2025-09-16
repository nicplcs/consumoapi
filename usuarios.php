<?php


//METODO GET CON CONDICIONALES 

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


// METODO POST

$respuesta = readline("¿Desea agregar un nuevo usuario? escribe (s) para SI o escribe (n) para NO: ");

if ($respuesta === "s") {
    $nombre = readline("Ingrese nombre: ");
    $correo = readline("Ingrese correo: ");
    $contrasena = readline("Ingrese contraseña: ");

    $datos = array(
        "nombre" => $nombre,
        "correo" => $correo,
        "contrasena" => $contrasena
    );

    $data_json = json_encode($datos);

    $proceso = curl_init($url);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_json)
    ));

    $respuestapet = curl_exec($proceso);

    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die("Error en la petición POST: " . curl_error($proceso) . "\n");
    }

    curl_close($proceso);

    if ($http_code === 200) {
        echo "Usuario guardado correctamente (200)\n";
        echo "Respuesta del servidor: $respuestapet\n";
    } else {
        echo "Error en el servidor. Código de respuesta: $http_code\n";
    }
}


?>