<?php

class ControladorProductos
{
    private $productos;

    public function __construct(){
        $this->productos = new ModeloProductos();
    }

    //GET CURSOS
    public function Index()
    {
        return $this->productos->getProductos();
    }

    //POST CURSOS
    public function RegistroProducto($datos)
    {
        $this->productos->postProductos($datos);

        return;
    }

    public function ActualizarProducto($id, $datos)
    {
        $this->productos->putProductos($id, $datos);

        return;
    }

    public function EliminarProducto($id)
    {
        $this->productos->deleteProductos($id);

        return;
    }

    public function BuscarProducto($id)
    {
        return $this->productos->searchProductos($id);
    }
}
