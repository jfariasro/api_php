<?php

$rutas = explode('/', $_SERVER['REQUEST_URI']);

$rutas_filtro = array_filter($rutas);

$numero_rutas = count($rutas_filtro);

if ($numero_rutas == 2) {
    echo json_encode(array(
        "detalle" => "Detalle No Encontrado",
    ));

    return;
} else {
    if (
        $rutas_filtro[3] == 'cursos'
        || $rutas_filtro[3] == 'clientes'
        || $rutas_filtro[3] == 'categorias'
        || $rutas_filtro[3] == 'productos'
    ) {
        require_once 'api/' . $rutas_filtro[3] . '.api.php';
    } else {
        echo json_encode(array(
            "error" => "Detalle No Encontrado",
            "codigo" => 404
        ));

        return;
    }
}
