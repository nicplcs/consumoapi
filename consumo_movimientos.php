<?php

    $url = "http://localhost:8080/movimientos";
    $url_post = "http://localhost:8080/anadirMovimiento";

    $consumo = file_get_contents($url);

    if($consumo === false){
    $error = error_get_last();
    die("Error al consumir el servicio: " . $error['message']);
    }

    $movimientos = json_decode($consumo);

    echo "Seleccione una opción:\n";
    echo "0. Buscar por ID\n";
    echo "1. Ver todos los movimientos\n";
    echo "2. Agregar un nuevo movimiento\n"; 
    $opcion = readline("Digite 0, 1 o 2: ");

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
        printf(
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
    else {
    echo "Opción no válida.\n";
    }
?>
