<?php

class ControladorCategorias
{
    private $categorias;

    public function __construct(){
        $this->categorias = new ModeloCategorias();
    }

    //GET CURSOS
    public function Index()
    {
        return $this->categorias->getCategorias();
    }

    //POST CURSOS
    public function RegistroCategoria($datos)
    {
        $this->categorias->postCategorias($datos);

        return;
    }

    public function ActualizarCategoria($id, $datos)
    {
        $this->categorias->putCategorias($id, $datos);

        return;
    }

    public function EliminarCategoria($id)
    {
        $this->categorias->deleteCategorias($id);

        return;
    }

    public function BuscarCategoria($id)
    {
        return $this->categorias->searchCategorias($id);
    }
}
