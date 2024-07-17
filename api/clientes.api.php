<?php
header('Content-Type: application/json');

if ($numero_rutas >= 3) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $id = (isset($rutas_filtro[4]) && is_numeric($rutas_filtro[4])) ? $rutas_filtro[4] : -1;
            if ($id !== -1) {
                $clientes = new ControladorClientes;
                echo $clientes->BuscarCliente($rutas_filtro[4]);
            } else {
                $clientes = new ControladorClientes;
                echo $clientes->Index();
            }
            break;
        case 'POST':
            $json = file_get_contents('php://input');
            $datos = json_decode($json, true);
            $clientes = new ControladorClientes;
            $clientes->RegistroCliente($datos);
            break;
        case 'PUT':
            $id = (isset($rutas_filtro[4]) && is_numeric($rutas_filtro[4])) ? intval($rutas_filtro[4]) : -1;
            $json = file_get_contents('php://input');
            $datos = json_decode($json, true);
            try {
                $clientes = new ControladorClientes;
                if ($id !== -1) {
                    $obj = $clientes->BuscarCliente($id);
                    if (count(json_decode($obj, true)) == 0) {
                        echo json_encode(array(
                            "error" => "El cliente no existe",
                            "codigo" => 404
                        ));
                        return;
                    } else if ($id !== intval($datos['id'])) {
                        echo json_encode(array(
                            "error" => "El Id de cliente no coincide",
                            "codigo" => 409,
                            "id" => $id,
                            "datos" => $datos
                        ));
                        return;
                    }
                    $clientes->ActualizarCliente($id, $datos);
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
                $clientes = new ControladorClientes;
                if ($id !== -1) {
                    $obj = $clientes->BuscarCliente($id);
                    if (count(json_decode($obj, true)) == 0) {
                        echo json_encode(array(
                            "error" => "El cliente no existe",
                            "codigo" => 404
                        ));
                        return;
                    }
                    $clientes->EliminarCliente($id);
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
