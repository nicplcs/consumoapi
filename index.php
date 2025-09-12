<?php

$opcion = readline("Escribe 1 para ver CATEGORÍAS o 0 para ver DEVOLUCIONES: ");

if ($opcion == "1") {
    $urlCategorias = "http://localhost:8080/categorias";  
    $consumoCategorias = file_get_contents($urlCategorias);

    if ($consumoCategorias === FALSE) {
        die("Error al consumir el servicio de categorías.");
    }

    $categorias = json_decode($consumoCategorias, true);

    echo "\n---- CATEGORÍAS ----\n";
    foreach ($categorias as $categoria) {
        echo "ID Categoría: " . $categoria['idCategoria'] . "\n";
        echo "Nombre: " . $categoria['nombreCategoria'] . "\n";
        echo "Descripción: " . $categoria['descripcion'] . "\n\n";
    }
}


elseif ($opcion == "0") {
    $urlDevoluciones = "http://localhost:8080/devoluciones";  
    $consumoDevoluciones = file_get_contents($urlDevoluciones);

    if ($consumoDevoluciones === FALSE) {
        die("Error al consumir el servicio de devoluciones.");
    }

    $devoluciones = json_decode($consumoDevoluciones, true);

    echo "\n---- DEVOLUCIONES ---- \n";
    foreach ($devoluciones as $devolucion) {
        echo "ID Devolución: " . $devolucion['idDevolucion'] . "\n";
        echo "Cantidad: " . $devolucion['cantidad'] . "\n";
        echo "Motivo: " . $devolucion['motivo'] . "\n";
        echo "Fecha Devolución: " . $devolucion['fechaDevolucion'] . "\n";
        echo "ID Orden Salida: " . $devolucion['idOrdenSalida'] . "\n";
        echo "ID Producto: " . $devolucion['idProducto'] . "\n\n";
    }
}

?>
