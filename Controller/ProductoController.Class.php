<?php


include_once (dirname(__FILE__) .'/../DAO/ProductoDAO.Class.php');
include_once (dirname(__FILE__) .'/../DTO/ProductoDTO.Class.php');

class ProductoController{

    public function __construct() {
        
    }

    public function select($ProductosDTO) {
        $ProductosDAO = new ProductoDAO(); 
            return $ProductosDAO->selectProducto($ProductosDTO); 
    }

    public function update($ProductosDTO) {
        $ProductosDAO = new ProductoDAO();
        return $ProductosDAO->updateProductos($ProductosDTO);
    }

    public function insert($ProductosDTO) {
        $ProductosDAO = new ProductoDAO();
        return $ProductosDAO->InsertProducto($ProductosDTO);
    }

    public function delete($ProductosDTO) {
        $ProductosDAO = new ProductoDAO();
        return $ProductosDAO->deleteProductos($ProductosDTO);
    }

}

$bandera = false;

//$action = "";
//$CodigoProducto = "";
//$Nombre = "";
//$Presentacion = "";
//$precioUnitario = "";
//$activo = "";

//if (isset($_POST['action'])) {
//    $action = $_POST['action'];
//}
//if (isset($_POST['cdoProducto'])) {
//    $CodigoProducto = $_POST['cdoProducto'];
//    $bandera = true;
//}
//if (isset($_POST['Nombre'])) {
//    $Nombre = $_POST['Nombre'];
//    $bandera = true;
//}
//if (isset($_POST['Presentacion'])) {
//    $Presentacion = $_POST['Presentacion']; 
//    $bandera = true;
//}
//if (isset($_POST['precioUnitario'])) {
//    $precioUnitario = $_POST['precioUnitario']; 
//    $bandera = true;
//}
//if (isset($_POST['activo'])) {
//    $activo = $_POST['activo']; 
//    $bandera = true;
//}
///////////////////////////////////////////debug/////////////////////////
$action = "insert";
$CodigoProducto = '10';
$Nombre = 'Ganzito';
$Presentacion = '300 gr';
$PrecioUnitario = '16.00';
$activo = 'S'; 
/////////////////////////////debug/////////////////////////////////

$ProductoController = new ProductoController();
//$ProductosDTO = new ProductoDTO();

//if ($bandera == true) {
    $ProductosDTO = new ProductoDTO(); 
    $ProductosDTO->setCdoProducto($CodigoProducto);
    $ProductosDTO->setNombre($Nombre);
    $ProductosDTO->setPresentacion($Presentacion);
    $ProductosDTO->setPrecioUnitario($PrecioUnitario); 
    $ProductosDTO->setActivo($activo);
//}





switch ($action) {
    case "insert":  
        $rs = $ProductoController->Insert($ProductosDTO);
        $json = "";

        if ($rs !== "") {
            $json .= '{"estatus":"ok",';
            $total = count($rs);
            $json .= '"totalCount":"' . $total . '"';
            $json .= ',"resultado":[';
            foreach ($rs as $ProductosDTO) {
                $json .= '{';
                $json .= '"cdoProducto":' . json_decode($ProductosDTO->getCdoProducto());
                $json .= ',"Nombre":' . json_encode($ProductosDTO->getNombre());
                $json .= ',"Presentacion":' . json_encode($ProductosDTO->getPresentacion());
                $json .= ',"precioUnitario":' . json_encode($ProductosDTO->getPrecioUnitario()); 
                $json .= ',"activo":' . json_encode($ProductosDTO->getActivo());
                $json .= '},';
            }
            $json = substr(trim($json), 0, -1);

            $json .= ']';
            $json .='}';
        } else {
            $json .= '{"estatus":"Empty","Mensaje:"No Pudo Registrarse"}';
        }
        echo $json;
        break;
    case'select':
        if ($ProductosDTO->getCdoProducto() == "") {
            $ProductosDTO->setCdoProducto("null");
        }
        if ($ProductosDTO->getNombre() == "") {
            $ProductosDTO->setNombre("");
        }
        if ($ProductosDTO->getPresentacion() == "") {
            $ProductosDTO->setPresentacion("");
        }
        if ($ProductosDTO->getPrecioUnitario() == "") {
            $ProductosDTO->setPrecioUnitario("0");
        }
        $rs = $ProductoController->select($ProductosDTO);
        $json = "";

        if ($rs !== "") {
            $json .= '{"estatus":"ok",';
            $total = count($rs);
            $json .= '"totalCount":"' . $total . '"';
            $json .= ',"resultado":[';
            foreach ($rs as $fondospropiosDTO) {
                $json .= '{';
                $json .= '"cdoProducto":' . json_decode($ProductosDTO->getCdoProducto());
                $json .= ',"Nombre":' . json_encode($ProductosDTO->getNombre());
                $json .= ',"Presentacion":' . json_encode($ProductosDTO->getPresentacion());
                $json .= ',"precioUnitario":' . json_encode($ProductosDTO->getPrecioUnitario()); 
                $json .= ',"activo":' . json_encode($ProductosDTO->getActivo());
                $json .= '},';
            }
            $json = substr(trim($json), 0, -1);

            $json .= ']';
            $json .='}';
        } else {
            $json .= '{"estatus":"Empty","Mensaje:"No se encontro"}';
        }
        echo $json;
        break;
    case 'update':
        if ($ProductosDTO->getCdoProducto() == "") {
            $ProductosDTO->setCdoProducto("null");
        }
        if ($ProductosDTO->getNombre() == "") {
            $ProductosDTO->setNombre("");
        }
        if ($ProductosDTO->getPresentacion() == "") {
            $ProductosDTO->setPresentacion("");
        }
        if ($ProductosDTO->getPrecioUnitario() == "") {
            $ProductosDTO->setPrecioUnitario("0");
        }
        $rs = $ProductoController->update($ProductosDTO);
        $json = "";
        if ($rs !== "") {
            $json .= '{"estatus":"ok",';
            $total = count($rs);
            $json .= '"totalCount":"' . $total . '"';
            $json .= ',"resultado":[';
            foreach ($rs as $ProductosDTO) {
                $json .= '{';
                $json .= '"cdoProducto":' . json_decode($ProductosDTO->getCdoProducto());
                $json .= ',"Nombre":' . json_encode($ProductosDTO->getNombre());
                $json .= ',"Presentacion":' . json_encode($ProductosDTO->getPresentacion());
                $json .= ',"precioUnitario":' . json_encode($ProductosDTO->getPrecioUnitario()); 
                $json .= ',"activo":' . json_encode($ProductosDTO->getActivo());
                $json .= '},';
            }
            $json = substr(trim($json), 0, -1);

            $json .= ']';
            $json .='}';
        } else {
            $json .= '{"estatus":"Empty","Mensaje:"No Pudo Actualizar"}';
        }
        echo $json;
        break;
        
    case 'delete':
        $rs = $ProductoController->delete($ProductosDTO);
        $json = "";
        if ($rs !== "") {
            $json .= '{"estatus":"ok",';
            $total = count($rs);
            $json .= '"totalCount":"' . $total . '"';
            $json .= ',"resultado":[';
            foreach ($rs as $ProductosDTO) {
                $json .= '{';
                $json .= '"cdoProducto":' . json_decode($ProductosDTO->getCdoProducto());
                $json .= ',"Nombre":' . json_encode($ProductosDTO->getNombre());
                $json .= ',"Presentacion":' . json_encode($ProductosDTO->getPresentacion());
                $json .= ',"precioUnitario":' . json_encode($ProductosDTO->getPrecioUnitario()); 
                $json .= ',"activo":' . json_encode($ProductosDTO->getActivo());
                $json .= '},';
            }
            $json = substr(trim($json), 0, -1);
            $json .= ']';
            $json .='}';
        } else {
            $json .= '{"estatus":"Empty","Mensaje:"No Pudo Eliminar"}';
        }
        echo $json;
        break;
}