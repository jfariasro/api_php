<?php

require_once 'config/conexion.php';

class ModeloProductos
{
    private $conexion;
    private $pdo;
    public function __construct()
    {
        $this->pdo = new Conexion();
    }

    public function getProductos()
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT p.*, c.nombre AS categoria FROM productos p JOIN categorias c");
        $consulta->execute();
        $filas = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $this->conexion = null;

        return json_encode($filas);
    }

    public function searchProductos($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT p.*, c.nombre as categoria
        FROM productos p JOIN categorias c WHERE p.id = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $fila = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $this->conexion = null;

        return json_encode($fila) ?? null;
    }

    public function postProductos($datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("INSERT INTO productos (nombre, idcategoria, descripcion, cantidad, precio)
        VALUES (:nombre, :idcategoria, :descripcion, :cantidad, :precio)");
        $sql->bindParam(':nombre', $datos['nombre']);
        $sql->bindParam(':idcategoria', $datos['idcategoria']);
        $sql->bindParam(':descripcion', $datos['descripcion']);
        $sql->bindParam(':cantidad', $datos['cantidad']);
        $sql->bindParam(':precio', $datos['precio']);
        $resultado = $sql->execute();

        if (!$resultado) {
            echo json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Registrar Producto",
            ));
        } else {
            echo json_encode(array(
                "codigo" => 200,
                "mensaje" => "Producto Registrado",
            ));
        }

        $this->conexion = null;
    }

    public function putProductos($id, $datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("UPDATE productos SET nombre = :nombre,
        idcategoria = :idcategoria, descripcion = :descripcion, cantidad = :cantidad, precio = :precio 
        WHERE id = :id");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':nombre', $datos['nombre']);
        $sql->bindParam(':idcategoria', $datos['idcategoria']);
        $sql->bindParam(':descripcion', $datos['descripcion']);
        $sql->bindParam(':cantidad', $datos['cantidad']);
        $sql->bindParam(':precio', $datos['precio']);
        $resultado = $sql->execute();

        if (!$resultado) {
            echo json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Actualizar Producto",
            ));
        } else {
            echo json_encode(array(
                "codigo" => 200,
                "mensaje" => "Producto Actualizado",
            ));
        }

        $this->conexion = null;
    }

    public function deleteProductos($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("DELETE FROM productos WHERE id = :id");
        $sql->bindParam(':id', $id);
        $resultado = $sql->execute();

        if (!$resultado) {
            echo json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Eliminar Producto",
            ));
        } else {
            echo json_encode(array(
                "codigo" => 200,
                "mensaje" => "Producto Eliminado",
            ));
        }

        $this->conexion = null;
    }

}
