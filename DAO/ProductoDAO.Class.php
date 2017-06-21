<?php
 include_once(dirname(__FILE__).'/../DTO/ProductoDTO.Class.php');
/* include_once (dirname(__FILE__) . '/../../classDTO/fondospropios/fondospropiosDTO.php');*/
 include_once('../tribunal/connect/Proveedor.Class.php');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductoDAO
 *
 * @author ISC. Erik Eduardo Jimenez Diaz
 */
class ProductoDAO {
     private $proveedor;

    public function __construct($proveedor = null) {
        if ($proveedor === null) {
            $this->proveedor = new Proveedor("mysql", "puntoventa" );
        } else {
            $this->proveedor = proveedor ;
        }
    }

    public function InsertProducto($ProductosDTO) {
        
        $this->proveedor->connect();
        $tmp = "";
        $sql = "insert into tblProductos(CodigoProducto, Nombre, Presentacion, precioUnitario, activo) values (" . 
                $ProductosDTO->getCdoProducto(). ", '" .$ProductosDTO->getNombre().
               "', '" . $ProductosDTO->getPresentacion() . "', '" . $ProductosDTO->getPrecioUnitario()."','S');";
        echo $sql;
        $this->proveedor->execute($sql);
        if (!$this->proveedor->error()) {
            $tmp = new ProductoDTO();
            $tmp->setCdoProducto($this->proveedor->lastID());
            $tmp = $this->selectProducto($tmp);
        }
        return $tmp;
        $this->proveedor->close();
        $this->proveedor->stmt = $this->proveedor->free_result($this->proveedor->stmt);
    }

    public function selectProducto($ProductosDTO) {
        $this->proveedor->connect();
        $tmp = "";
        $sql = "select * from tblProductos";
        if ($ProductosDTO != "") {
            if ($ProductosDTO->getCdoProducto()!= "" || $ProductosDTO->getNombre() != "" ||
                $ProductosDTO->getPresentacion()!="" || $ProductosDTO->getPrecioUnitario() != "") {
                $sql.=" where ";

                if ($ProductosDTO->getCdoProducto()!= "") {
                    $sql.= "CodigoProducto =" . $fondospropiosDTO->getCveCuenta() . " and ";
                }
                if ($ProductosDTO->getNombre() != "" ) {
                    $sql.= "Nombre=" . $fondospropiosDTO->getIdNivelCuenta() . " and ";
                }
                if ($ProductosDTO->getPresentacion()!="") {
                    $sql.= "Presentacion =" . $fondospropiosDTO->getCuenta() . " and ";
                }
                if ($ProductosDTO->getPrecioUnitario() != "") {
                    $sql.= "precioUnitario=" . $fondospropiosDTO->getSCuenta1() . " and ";
                }
                if ($ProductosDTO->getActivo() != "") {
                    $sql.= "activo=" . $fondospropiosDTO->getActivo() . " and ";
                }
                $sql = trim($sql, "and ");
            }
        }
        $count = 0;
        $this->proveedor->execute($sql);
        try {
            if (!$this->proveedor->error()) {
                if ($this->proveedor->rows($this->proveedor->stmt) > 0) {
                    $tmp = array();
                    while ($ProductosDTO = $this->proveedor->fetch_array($this->proveedor->stmt, 0)) {
                        $tmp[$count] = new ProductoDTO();
                        $tmp[$count]->setCdoProducto($ProductosDTO['CodigoProducto']);
                        $tmp[$count]->setNombre($ProductosDTO['Nombre']);
                        $tmp[$count]->setPresentacion($ProductosDTO['Presentacion']);
                        $tmp[$count]->setPrecioUnitario($ProductosDTO['precioUnitario']);
                        $tmp[$count]->setActivo($ProductosDTO['Activo']);
                        $count++;
                    }
                    return $tmp;
                } else {
                    return $tmp;
                }
            } else {
                return $tmp;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        $this->proveedor->close();
        $this->proveedor->stmt = $this->proveedor->free_result($this->proveedor->stmt);
    }

    public function updateProductos($ProductosDTO) {
        $this->proveedor->connect();
        $tmp = "";
    $sql = "update tblProductos set Nombre=" . $ProductosDTO->getNombre() .
            ", Presentacion=" . $ProductosDTO->getNombre() .
            ", precioUnitario=" . $ProductosDTO->getPrecioUnitario(). 
            " Activo='S' where CodigoProducto=" . $ProductosDTO->getCdoProducto() . ";";
        $this->proveedor->execute($sql);
        if (!$this->proveedor->error()) {
            $tmp = new fondospropiosDTO();
            $tmp->setCdoProducto($ProductosDTO->getCdoProducto());
            $tmp = $this->selectProducto($tmp);
        }

        $this->proveedor->close();
        $this->proveedor->stmt = $this->proveedor->free_result($this->proveedor->stmt);
        return $tmp;
    }

    public function deleteProductos($ProductosDTO) {
        $this->proveedor->connect();
        $tmp = "";
        $sql = "update tblProductos set  Activo= 'N' where CodigoProducto=" . $ProductosDTO->getCdoProducto() . ";";
        $this->proveedor->execute($sql);
        if (!$this->proveedor->error()) {
            $tmp = new fondospropiosDTO();
            $tmp->setCdoProducto($ProductosDTO->getCdoProducto());
            $tmp = $this->selectProducto($tmp);
        }
        return $tmp;
        $this->proveedor->close();
        $this->proveedor->stmt = $this->proveedor->free_result($this->proveedor->stmt);
    }
}
