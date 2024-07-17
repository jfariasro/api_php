<?php
header('Content-Type: application/json');

if ($numero_rutas >= 3) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $id = (isset($rutas_filtro[4]) && is_numeric($rutas_filtro[4])) ? $rutas_filtro[4] : -1;
            if ($id !== -1) {
                $productos = new ControladorProductos;
                echo $productos->BuscarProducto($rutas_filtro[4]);
            } else {
                $productos = new ControladorProductos;
                echo $productos->Index();
            }
            break;
        case 'POST':
            $json = file_get_contents('php://input');
            $datos = json_decode($json, true);
            $productos = new ControladorProductos;
            $productos->RegistroProducto($datos);
            break;
        case 'PUT':
            $id = (isset($rutas_filtro[4]) && is_numeric($rutas_filtro[4])) ? intval($rutas_filtro[4]) : -1;
            $json = file_get_contents('php://input');
            $datos = json_decode($json, true);
            try {
                $productos = new ControladorProductos;
                if ($id !== -1) {
                    $obj = $productos->BuscarProducto($id);
                    if (count(json_decode($obj, true)) == 0) {
                        echo json_encode(array(
                            "error" => "El producto no existe",
                            "codigo" => 404
                        ));
                        return;
                    } else if ($id !== intval($datos['id'])) {
                        echo json_encode(array(
                            "error" => "El Id de producto no coincide",
                            "codigo" => 409,
                            "id" => $id,
                            "datos" => $datos
                        ));
                        return;
                    }
                    $productos->ActualizarProducto($id, $datos);
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
                $productos = new ControladorProductos;
                if ($id !== -1) {
                    $obj = $productos->BuscarProducto($id);
                    if (count(json_decode($obj, true)) == 0) {
                        echo json_encode(array(
                            "error" => "El producto no existe",
                            "codigo" => 404
                        ));
                        return;
                    }
                    $productos->EliminarProducto($id);
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
