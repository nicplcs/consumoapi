<?php

    require_once 'config.php';

    $consumo = file_get_contents($url_get);

    if($consumo === false){
    $error = error_get_last();
    die("Error al consumir el servicio: " . $error['message']);
    }

    $movimientos = json_decode($consumo);

    echo "Seleccione una opción:\n";
    echo "0. Buscar por ID\n";
    echo "1. Ver todos los movimientos\n";
    echo "2. Agregar un nuevo movimiento\n"; 
    echo "3. Actualizar un movimiento\n";
    echo "4. Eliminar un movimiento\n";
    $opcion = readline("Digite 0, 1, 2, 3 o 4: ");

    if ($opcion == 0) {
    $idBuscado = readline("Digite el ID del movimiento: ");
    $encontrado = false;

    foreach ($movimientos as $m) {
        if ($m->id_movimiento == $idBuscado) {
            echo "Movimiento encontrado\n";
            echo "ID:$m->id_movimiento\n";
            echo "Tipo:$m->tipo\n";
            echo "Descripción:$m->descripcion\n";
            echo "Cantidad:$m->cantidad\n";
            echo "Fecha:$m->fecha\n";
            echo "Usuario:$m->usuario_responsable\n";
            echo "Acción:$m->accion\n";
            echo "Producto:$m->id_producto\n";
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        echo "No existe ningún movimiento con el ID $idBuscado.\n";
    }
    }

    elseif ($opcion == 1){
    foreach ($movimientos as $m){
        printf( "ID: %s - Tipo: %s - Descripcion: %s - Cantidad: %s - Fecha: %s - Usuario_responsable: %s - Accion: %s - ID_producto: %s \n",
        $m->id_movimiento,
        $m->tipo,
        $m->descripcion,
        $m->cantidad,
        $m->fecha,
        $m->usuario_responsable,
        $m->accion,
        $m->id_producto
        );
    }
    } 
    
    //post

    elseif ($opcion == 2) {
    $tipo = readline("Digite el tipo de movimiento: ");
    $descripcion = readline("Digite la descripción: ");
    $cantidad = readline("Digite la cantidad: ");
    $fecha = readline("Digite la fecha: ");
    $usuario = readline("Digite el usuario responsable: ");
    $accion = readline("Digite la acción: ");
    $id_producto = readline("Digite el ID del producto: ");

    $data = array(
        "tipo" => $tipo,
        "descripcion" => $descripcion,
        "cantidad" => $cantidad,
        "fecha" => $fecha,
        "usuario_responsable" => $usuario,
        "accion" => $accion,
        "id_producto" => $id_producto
    );

    $data_json = json_encode($data);

    $proceso = curl_init($url_post);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Content-Length: ' . strlen($data_json)
    ));

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die('Error en la petición POST: ' . curl_error($proceso) . "\n");
    }

    curl_close($proceso);

    if ($http_code === 200) {
        echo "Movimiento agregado exitosamente.\n";
    } else {
        echo "Error al agregar el movimiento. Código HTTP: $http_code\n";
        echo "Respuesta del servidor: $respuesta\n";
    }
    }

    //put

    elseif ($opcion == 3) {
    echo "Movimientos disponibles: \n";
    foreach ($movimientos as $m){
        echo "ID: $m->id_movimiento- Tipo: $m->tipo- Descripcion: $m->descripcion\n";
    }

    $id_movimiento = readline("Digite el ID del movimiento que desea actualizar:");

    $existe = false;
    $movimientoActual = null;
    foreach ($movimientos as $m) {
    if ($m->id_movimiento == $id_movimiento) {
        $existe = true;
        $movimientoActual = $m;
        break;
        }
    }

    if (!$existe) {
        echo "No existe un movimiento con el ID $id_movimiento\n";
    }else {

    echo "Datos actuales del movimiento:\n";
    echo "Tipo actual: $movimientoActual->tipo\n";
    echo "Descripción actual: $movimientoActual->descripcion\n";
    echo "Cantidad actual: $movimientoActual->cantidad\n";
    echo "Fecha actual: $movimientoActual->fecha\n";
    echo "Usuario actual: $movimientoActual->usuario_responsable\n";
    echo "Acción actual: $movimientoActual->accion\n";
    echo "ID Producto actual: $movimientoActual->id_producto\n";
    echo "Digite los nuevos valores (deje en blanco para mantener el valor actual):\n";

    $tipo = readline("Nuevo tipo (actual: $movimientoActual->tipo): ");
    if (empty($tipo)) $tipo = $movimientoActual->tipo;
            
    $descripcion = readline("Nueva descripción (actual: $movimientoActual->descripcion): ");
    if (empty($descripcion)) $descripcion = $movimientoActual->descripcion;
            
    $cantidad = readline("Nueva cantidad (actual: $movimientoActual->cantidad): ");
    if (empty($cantidad)) $cantidad = $movimientoActual->cantidad;
            
    $fecha = readline("Nueva fecha (actual: $movimientoActual->fecha): ");
    if (empty($fecha)) $fecha = $movimientoActual->fecha;
            
    $usuario = readline("Nuevo usuario (actual: $movimientoActual->usuario_responsable): ");
    if (empty($usuario)) $usuario = $movimientoActual->usuario_responsable;
            
    $accion = readline("Nueva acción (actual: $movimientoActual->accion): ");
    if (empty($accion)) $accion = $movimientoActual->accion;
            
    $id_producto = readline("Nuevo ID producto (actual: $movimientoActual->id_producto): ");
    if (empty($id_producto)) $id_producto = $movimientoActual->id_producto;

    $data = array(
    "id_movimiento" => $id_movimiento,
    "tipo" => $tipo,
    "descripcion" => $descripcion,
    "cantidad" => $cantidad,
    "fecha" => $fecha,
    "usuario_responsable" => $usuario,
    "accion" => $accion,
    "id_producto" => $id_producto
    );

    $data_json = json_encode($data);

    $proceso = curl_init($url_put);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_json)
    ));

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if (curl_errno($proceso)) {
        die('Error en la petición PUT: ' . curl_error($proceso) . "\n");
    }

    curl_close($proceso);

    if ($http_code === 200) {
        echo "Movimiento actualizado exitosamente.\n";
        echo "Respuesta del servidor $respuesta .\n";
    } else {
        echo "Error al actualizar el movimiento. Código HTTP: $http_code\n";
        echo "Respuesta del servidor: $respuesta\n";
    }
    }
    }
    
    //delete

    elseif($opcion == 4){
    $id_movimiento = readline("Digite el ID de movimiento que desee eliminar\n");

    $data = array(
        "id_movimiento" => $id_movimiento
    );

    $data_json = json_encode($data);

    if (!function_exists('curl_init')) {
    die('ERROR: cURL no está disponible');
    }
    echo "cURL está disponible\n";

    $proceso = curl_init($url_delete);

    curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($proceso, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_json)
    ));

    $respuesta = curl_exec($proceso);
    $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

    if(curl_errno($proceso)){
        die('Eror en la peticion DELETE:'. curl_errno($proceso) .\n);
    }

    curl_close($proceso);

        if ($http_code === 200) {
        echo "Movimiento eliminado exitosamente.\n";
    } else {
        echo "Error al eliminar el movimiento. Código HTTP: $http_code\n";
    }
    }
?>
//C:\xampp\php\php.exe consumo_movimientos.php
