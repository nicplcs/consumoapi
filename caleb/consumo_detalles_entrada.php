<?php

    $url = "http://localhost:8080/detalles_entrada";

    $consumo = file_get_contents($url);

    if($consumo === false){
    die("Error al consumir el servicio");
    }

    $detalles_entrada = json_decode($consumo);

        echo "Seleccione una opción:\n";
        echo "0. Buscar por ID\n";
        echo "1. Ver todos los detalles_entrada\n";
        $opcion = readline("Digite 0 o 1: ");

    if ($opcion == "0") {
    $idBuscado = readline("Digite el ID del detalle_entrada: ");
    $encontrado = false;

    foreach ($detalles_entrada as $de) {
        if ($de->id_detalle_entrada == $idBuscado) {
            echo "Detalle_entrada encontrado:\n";
            echo "ID:$de->id_detalle_entrada\n";
            echo "Cantidad:$de->cantidad \n";
            echo "ID_orden_entrada:$de->id_orden_entrada\n";
            echo "ID_producto:$de->id_producto \n";
            $encontrado = true;
            break;
        }
    }

    if (!$encontrado) {
        echo "No existe ningún detalle_entrada con el ID $idBuscado.\n";
    }
    }



    elseif ($opcion == "1"){

    printf("%-12s | %-10s | %-30s | %-8s \n",
    "ID_DETALLE_ENTRADA", "CANTIDAD", "ID_ORDEN_ENTRADA", "ID_PRODUCTO");
    echo str_repeat("-", 140) . "\n";

    foreach ($detalles_entrada as $de){
    printf("%-12s | %-10s | %-30s | %-8s\n",
        $de->id_detalle_entrada,
        $de->cantidad,
        $de->id_orden_entrada,
        $de->id_producto
        );
    }
    }
?>