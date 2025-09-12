<?php

$url = "http://localhost:8080/productos";
$consumo = file_get_contents($url);

if ($consumo === false) {
    die("Error al consumir el servicio web.");
}

$productos = json_decode($consumo);

echo "¿Qué productos desea ver? (1 = con stock, 0 = sin stock): ";
$opcion = (readline());

echo "-------------------------PRODUCTOS------------------------\n";

foreach ($productos as $producto) {
    if ($opcion == 1 && $producto->stock > 0) {
        echo $producto->idProducto . " | " . $producto->nombre . " | Stock: " . $producto->stock . " | DISPONIBLE\n";
    } elseif ($opcion == 0 && $producto->stock == 0) {
        echo $producto->idProducto . " | " . $producto->nombre . " | Stock: " . $producto->stock . " | AGOTADO\n";
    }
}

?>
