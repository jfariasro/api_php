<?php

require_once 'config/conexion.php';

class ModeloClientes
{
    private $conexion;
    private $pdo;
    public function __construct()
    {
        $this->pdo = new Conexion();
    }

    public function getClientes()
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT * FROM clientes");
        $consulta->execute();
        $filas = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $this->conexion = null;

        return json_encode($filas);
    }

    public function searchClientes($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $consulta = $this->conexion->prepare("SELECT * FROM clientes WHERE id = :id");
        $consulta->bindParam(':id', $id);
        $consulta->execute();
        $fila = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $this->conexion = null;

        return json_encode($fila) ?? null;
    }

    public function postClientes($datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("INSERT INTO clientes (nombre, apellido, edad, correo)
        VALUES (:nombre, :apellido, :edad, :correo)");
        $sql->bindParam(':nombre', $datos['nombre']);
        $sql->bindParam(':apellido', $datos['apellido']);
        $sql->bindParam(':edad', $datos['edad']);
        $sql->bindParam(':correo', $datos['correo']);
        $resultado = $sql->execute();

        if (!$resultado) {
            echo json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Registrar Cliente",
            ));
        } else {
            echo json_encode(array(
                "codigo" => 200,
                "mensaje" => "Cliente Registrado",
            ));
        }

        $this->conexion = null;
    }

    public function putClientes($id, $datos)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("UPDATE clientes SET nombre = :nombre,
        apellido = :apellido, edad = :edad, correo = :correo WHERE id = :id");
        $sql->bindParam(':id', $id);
        $sql->bindParam(':nombre', $datos['nombre']);
        $sql->bindParam(':apellido', $datos['apellido']);
        $sql->bindParam(':edad', $datos['edad']);
        $sql->bindParam(':correo', $datos['correo']);
        $resultado = $sql->execute();

        if (!$resultado) {
            echo json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Actualizar Cliente",
            ));
        } else {
            echo json_encode(array(
                "codigo" => 200,
                "mensaje" => "Cliente Actualizado",
            ));
        }

        $this->conexion = null;
    }

    public function deleteClientes($id)
    {
        $this->conexion = $this->pdo->getPdo();

        $sql = $this->conexion->prepare("DELETE FROM clientes WHERE id = :id");
        $sql->bindParam(':id', $id);
        $resultado = $sql->execute();

        if (!$resultado) {
            echo json_encode(array(
                "codigo" => 500,
                "mensaje" => "Error al Eliminar Cliente",
            ));
        } else {
            echo json_encode(array(
                "codigo" => 200,
                "mensaje" => "Cliente Eliminado",
            ));
        }

        $this->conexion = null;
    }

}
