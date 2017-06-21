<?php 
/**
 * Description of ProductoDAO
 *
 * @author ISC. Erik Eduardo Jimenez Diaz
 */
class ProductoDTO {
    private $CodigoProducto;
    private $Nombre;
    private $Presentacion;
    private $precioUnitario;
    private $activo;

    function getCdoProducto() {
        return $this->CodigoProducto;
    }

    function getNombre() {
        return $this->Nombre;
    }

    function getPresentacion() {
        return $this->Presentacion;
    }

    function getPrecioUnitario() {
        return $this->precioUnitario;
    }
    function getActivo() {
        return $this->activo;
    }

    function setActivo($activo) {
        $this->activo = $activo;
    }

    function setCdoProducto($CodigoProducto) {
        $this->CodigoProducto = $CodigoProducto;
    }

    function setNombre($Nombre) {
        $this->Nombre = $Nombre;
    }

    function setPresentacion($Presentacion) {
        $this->Presentacion = $Presentacion;
    }

    function setPrecioUnitario($precioUnitario) {
        $this->precioUnitario = $precioUnitario;
    }
    
}
