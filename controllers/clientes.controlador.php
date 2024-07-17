<?php

class ControladorClientes
{
    private $clientes;

    public function __construct(){
        $this->clientes = new ModeloClientes();
    }

    //GET CURSOS
    public function Index()
    {
        return $this->clientes->getClientes();
    }

    //POST CURSOS
    public function RegistroCliente($datos)
    {
        $this->clientes->postClientes($datos);

        return;
    }

    public function ActualizarCliente($id, $datos)
    {
        $this->clientes->putClientes($id, $datos);

        return;
    }

    public function EliminarCliente($id)
    {
        $this->clientes->deleteClientes($id);

        return;
    }

    public function BuscarCliente($id)
    {
        return $this->clientes->searchClientes($id);
    }
}
