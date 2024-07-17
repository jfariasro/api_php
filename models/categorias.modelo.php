<?php

require_once 'config/conexion.php';

class ModeloCategorias
{
    private $conexion;
    private $pdo;
    public function __construct()
    {
        $this->pdo = new Conexion();
    }

    public function getCategorias()
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT * FROM categorias");
        $consulta->execute();
        $filas = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $this->conexion = null;

        return json_encode($filas);
    }

    public function searchCategorias($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT * FROM categorias WHERE id = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $fila = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $this->conexion = null;

        return json_encode($fila) ?? null;
    }

    public function postCategorias($datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("INSERT INTO categorias (nombre, descripcion)
        VALUES (:nombre, :descripcion)");
        $sql->bindParam(':nombre', $datos['nombre']);
        $sql->bindParam(':descripcion', $datos['descripcion']);
        $resultado = $sql->execute();

        if (!$resultado) {
            echo json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Registrar Categorias",
            ));
        } else {
            echo json_encode(array(
                "codigo" => 200,
                "mensaje" => "Categoría Registrada",
            ));
        }

        $this->conexion = null;
    }

    public function putCategorias($id, $datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("UPDATE categorias SET nombre = :nombre,
        descripcion = :descripcion WHERE id = :id");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':nombre', $datos['nombre']);
        $sql->bindParam(':descripcion', $datos['descripcion']);
        $resultado = $sql->execute();

        if (!$resultado) {
            echo json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Actualizar Categoría",
            ));
        } else {
            echo json_encode(array(
                "codigo" => 200,
                "mensaje" => "Categoría Actualizada",
            ));
        }

        $this->conexion = null;
    }

    public function deleteCategorias($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("DELETE FROM categorias WHERE id = :id");
        $sql->bindParam(':id', $id);
        $resultado = $sql->execute();

        if (!$resultado) {
            echo json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Eliminar Categoría",
            ));
        } else {
            echo json_encode(array(
                "codigo" => 200,
                "mensaje" => "Categoría Eliminada",
            ));
        }

        $this->conexion = null;
    }

}
