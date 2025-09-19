<?php

require_once 'config.php';


//METODO GET CON CONDICIONALES 


echo "ingrese el id del administrador: ";

$id_mio = readline();


$consumo = file_get_contents($BASE_URL_USUARIOS);

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
    $estado = readline("Ingrese estado (1 = activo, 0 = inactivo): ");

    $datos = array(
        "nombre" => $nombre,
        "correo" => $correo,
        "contrasena" => $contrasena
        ,"estado" => $estado
    );

    $data_json = json_encode($datos);

    $proceso = curl_init($BASE_URL_USUARIOS);

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


//METODO PUT 

$respuesta_put = readline("¿Desea actualizar un usuario? escribe (s) para SI o escribe (n) para NO: "); 

if ($respuesta_put === "s") {
    $id_actualizar = readline("Ingrese el ID del usuario a actualizar: ");
    $nombre = readline("Ingrese nuevo nombre: ");
    $correo = readline("Ingrese nuevo correo: ");
    $contrasena = readline("Ingrese nueva contraseña: ");
    $estado = readline("Ingrese nuevo estado (1 = activo, 0 = inactivo): ");

    $datos_actualizar = array(
        "nombre" => $nombre,
        "correo" => $correo,
        "contrasena" => $contrasena,
        "estado" => $estado
    );

    $data_json_actualizar = json_encode($datos_actualizar);

    $url_actualizar = $BASE_URL_USUARIOS . "/" . $id_actualizar;

    $proceso_put = curl_init($url_actualizar);

    curl_setopt($proceso_put, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($proceso_put, CURLOPT_POSTFIELDS, $data_json_actualizar);
    curl_setopt($proceso_put, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso_put, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_json_actualizar)
    ));

    $respuestapet_put = curl_exec($proceso_put);

    $http_code_put = curl_getinfo($proceso_put, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso_put)) {
        die("Error en la petición PUT: " . curl_error($proceso_put) . "\n");
    }

    curl_close($proceso_put);

    if ($http_code_put === 200) {
        echo "Usuario actualizado correctamente (200)\n";
        echo "Respuesta del servidor: $respuestapet_put\n";
    } else {
        echo "Error en el servidor. Código de respuesta: $http_code_put\n";
    }
}

//METODO DELETE

$respuesta_delete = readline("¿Desea eliminar un usuario? escribe (s) para SI o escribe (n) para NO: ");
if ($respuesta_delete === "s") {
    $id_eliminar = readline("Ingrese el ID del usuario a eliminar: ");

    $url_eliminar = $BASE_URL_USUARIOS . "/" . $id_eliminar;

    $proceso_delete = curl_init($url_eliminar);

    curl_setopt($proceso_delete, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($proceso_delete, CURLOPT_RETURNTRANSFER, true);

    $respuestapet_delete = curl_exec($proceso_delete);

    $http_code_delete = curl_getinfo($proceso_delete, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso_delete)) {
        die("Error en la petición DELETE: " . curl_error($proceso_delete) . "\n");
    }

    curl_close($proceso_delete);

    if ($http_code_delete === 200) {
        echo "Usuario eliminado correctamente (200)\n";
        echo "Respuesta del servidor: $respuestapet_delete\n";
    } else {
        echo "Error en el servidor. Código de respuesta: $http_code_delete\n";
    }
}

?>