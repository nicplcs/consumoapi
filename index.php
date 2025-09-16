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

//metodo post//
$respuesta = readline("¿Deseas agregar una nueva categoría? escoge 1 para si o  0 para no: ");

    if($respuesta === "1") {
        $Nombre = readline(" Escribe el nombre de la categoría: ");
        $Descripcion = readline(" Escribe la descripción de la categoría: ");
    
        $data = array(
            'nombreCategoria' => $Nombre,
            'descripcion' => $Descripcion
        );
        $data_categorias = json_encode($data);    

        $proceso = curl_init($urlCategorias);


        curl_setopt($proceso, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($proceso, CURLOPT_POSTFIELDS, $data_categorias);    
        curl_setopt($proceso, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($proceso, CURLOPT_HTTPHEADER, array(                                    
            'Content-Type: application/json',                                          
            'Content-Length: ' . strlen($data_categorias))                                 
        );
        
        $respuestapet = curl_exec($proceso);

        $http_code = curl_getinfo($proceso, CURLINFO_HTTP_CODE);

        if (curl_errno($proceso)){

            die('Error en la petición post : ' . curl_error($proceso) . "\n");
        }

        curl_close($proceso);

        if ($http_code === 200) {
            echo "Categoría agregada exitosamente.\n";
        } else {
            echo "Error al agregar la categoría. ERROR: $http_code\n";
        }
    }
?>

