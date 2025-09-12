<?php

    $url = "http://localhost:8080/movimientos";

    $consumo = file_get_contents($url);

    if($consumo === false){
    die("Error al consumir el servicio");
    }

    $movimientos = json_decode($consumo);

    echo "Seleccione una opción:\n";
    echo "0. Buscar por ID\n";
    echo "1. Ver todos los movimientos\n";
    $opcion = readline("Digite 0 o 1: ");

    if ($opcion == "0") {
    $idBuscado = readline("Digite el ID del movimiento: ");
    $encontrado = false;

    foreach ($movimientos as $m) {
        if ($m->id_movimiento == $idBuscado) {
            echo "Movimiento encontrado:\n";
            echo "ID:$m->id_movimiento\n";
            echo "Tipo:$m->tipo \n";
            echo "Descripción:$m->descripcion\n";
            echo "Cantidad:$m->cantidad \n";
            echo "Fecha:$m->fecha \n";
            echo "Usuario:$m->usuario_responsable \n";
            echo "Acción:$m->accion \n";
            echo "Producto:$m->id_producto\n";
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        echo "No existe ningún movimiento con el ID $idBuscado.\n";
    }
    }

    elseif ($opcion == "1"){

    printf("%-12s | %-10s | %-30s | %-8s | %-20s | %-20s | %-10s | %-10s\n",
    "ID_MOVIMIENTO", "TIPO", "DESCRIPCION", "CANTIDAD", "FECHA", "USUARIO_RESPONSABLE", "ACCION", "ID_PRODUCTO");
    echo str_repeat("-", 140) . "\n";

    foreach ($movimientos as $m){
        printf("%-12s | %-10s | %-30s | %-8s | %-20s | %-20s | %-10s | %-10s\n",
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
?>
