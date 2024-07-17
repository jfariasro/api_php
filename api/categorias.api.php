<?php
header('Content-Type: application/json');

if ($numero_rutas >= 3) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $id = (isset($rutas_filtro[4]) && is_numeric($rutas_filtro[4])) ? $rutas_filtro[4] : -1;
            if ($id !== -1) {
                $categorias = new ControladorCategorias;
                echo $categorias->BuscarCategoria($rutas_filtro[4]);
            } else {
                $categorias = new ControladorCategorias;
                echo $categorias->Index();
            }
            break;
        case 'POST':
            $json = file_get_contents('php://input');
            $datos = json_decode($json, true);
            $categorias = new ControladorCategorias;
            $categorias->RegistroCategoria($datos);
            break;
        case 'PUT':
            $id = (isset($rutas_filtro[4]) && is_numeric($rutas_filtro[4])) ? intval($rutas_filtro[4]) : -1;
            $json = file_get_contents('php://input');
            $datos = json_decode($json, true);
            try {
                $categorias = new ControladorCategorias;
                if ($id !== -1) {
                    $obj = $categorias->BuscarCategoria($id);
                    if (count(json_decode($obj, true)) == 0) {
                        echo json_encode(array(
                            "error" => "La categoría no existe",
                            "codigo" => 404
                        ));
                        return;
                    } else if ($id !== $datos['id']) {
                        echo json_encode(array(
                            "error" => "El Id de categoría no coincide",
                            "codigo" => 409,
                            "id" => $id,
                            "datos" => $datos
                        ));
                        return;
                    }
                    $categorias->ActualizarCategoria($id, $datos);
                } else {
                    echo json_encode(array(
                        "error" => "El Id no es numérico",
                        "codigo" => 500
                    ));

                    return;
                }
            } catch (Exception $ex) {
                echo json_encode(array(
                    "error" => $ex->getMessage(),
                    "codigo" => 500
                ));

                return;
            }
            break;
        case 'DELETE':
            $id = (isset($rutas_filtro[4]) && is_numeric($rutas_filtro[4])) ? intval($rutas_filtro[4]) : -1;
            try {
                $categorias = new ControladorCategorias;
                if ($id !== -1) {
                    $obj = $categorias->BuscarCategoria($id);
                    if (count(json_decode($obj, true)) == 0) {
                        echo json_encode(array(
                            "error" => "La categoría no existe",
                            "codigo" => 404
                        ));
                        return;
                    }
                    $categorias->EliminarCategoria($id);
                } else {
                    echo json_encode(array(
                        "error" => "El Id no es numérico",
                        "codigo" => 500
                    ));

                    return;
                }
            } catch (Exception $ex) {
                echo json_encode(array(
                    "error" => $ex->getMessage(),
                    "codigo" => 500
                ));

                return;
            }
            break;
        default:
            echo json_encode(array(
                "error" => "Error de Peticiones",
                "codigo" => 500
            ));

            return;
            break;
    }
}
