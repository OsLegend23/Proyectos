<?php
date_default_timezone_set('America/Mexico_City');
include 'conexion.php';

$page = $_REQUEST['page'];
$limit = $_REQUEST['rows'];
$sidx = $_REQUEST['sidx'];
$sord = $_REQUEST['sord'];
//Campo de búsqueda
$searchField = $_REQUEST['searchField'];
//Cadena a buscar
$searchString = utf8_decode($_REQUEST['searchString']);
//Arreglo para los valores de búsqueda
$operadores = array('cn' => "LIKE '%$searchString%'", 'bw' => "LIKE '$searchString%'", 'ew' => "LIKE '%$searchString'", 'lt' => "< '$searchString'", 'le' => "<= '$searchString'", 'gt' => "> '$searchString'", 'ge' => ">= '$searchString'");
//Operador de búsqueda
$searchOper = $operadores[$_REQUEST['searchOper']];
//Datos a editar
$oper = $_POST['oper'];
$id = $_REQUEST['idUsr'];
$estatus = $_POST['estatus'];
$fecha = date('Y-m-d H:i:s');
// if we not pass at first time index use the first column for the index or what you want
if (!$sidx)
    $sidx = 1;
// connect to the MySQL database server
$db = new Conexion;
$db->sql_connect();

$tipo = $db->sql_result($db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = $id"), 0);

if ($tipo == 3) {
    // calculate the number of rows for the query. We need this for paging the result
    $result = $db->sql_query("SELECT COUNT(*) AS count FROM depositos WHERE depositos.idUsuario = '$id'");
    $row = $db->sql_fetch_array($result);
    $count = $row['count'];
// calculate the total pages for the query
    if ($count > 0 && $limit > 0) {
        $total_pages = ceil($count / $limit);
    } else {
        $total_pages = 0;
    }
// if for some reasons the requested page is greater than the total
// set the requested page to total page
    if ($page > $total_pages)
        $page = $total_pages;
// calculate the starting position of the rows
    $start = $limit * $page - $limit;
// if for some reasons start position is negative set it to 0
// typical case is that the user type 0 for the requested page
    if ($start < 0)
        $start = 0;
// the actual query for the grid data

    $SQL = "SELECT depositos.id_deposito, depositos.idUsuario, depositos.cliente, depositos.monto, depositos.banco, depositos.referencia, depositos.fecha, depositos.fechaAut, depositos.estatus, depositos.comentario
FROM depositos
WHERE depositos.idUsuario = $id ORDER BY depositos.$sidx $sord LIMIT $start , $limit";
    $result = $db->sql_query($SQL);
    // we should set the appropriate header information. Do not forget this.
    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    $s .= "<records>".$count."</records>";
    // be sure to put text data in CDATA
    while ($row = $db->sql_fetch_array($result)) {
        $s .= "<row id='" . $row[id_deposito] . "'>";
        $s .= "<cell><![CDATA[" . $row[fecha] . "]]></cell>";
        $s .= "<cell><![CDATA[" . $row[fechaAut] . "]]></cell>";
        $s .= "<cell>" . $row[monto] . "</cell>";
        $s .= "<cell><![CDATA[" . $row[banco] . "]]></cell>";
        $s .= "<cell><![CDATA[" . $row[referencia] . "]]></cell>";
        if ($row[estatus] == 1) {
            $s .= "<cell><![CDATA[ACEPTADO]]></cell>";
        }
        if ($row[estatus] == 2) {
            $s .= "<cell><![CDATA[EN ESPERA]]></cell>";
        }
        if ($row[estatus] == 0) {
            $s .= "<cell><![CDATA[RECHAZADO]]></cell>";
        }
        $s .= "<cell><![CDATA[" . $row[comentario] . "]]></cell>";
        $s .= "</row>";
    }
    $s .= "</rows>";
    echo $s;

} else {

    // calculate the number of rows for the query. We need this for paging the result
    $result = $db->sql_query("SELECT COUNT(*) AS count FROM depositos,relaciones WHERE depositos.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = '$id' AND depositos.estatus = 2 ");
    $row = $db->sql_fetch_array($result);
    $count = $row['count'];
// calculate the total pages for the query
    if ($count > 0 && $limit > 0) {
        $total_pages = ceil($count / $limit);
    } else {
        $total_pages = 0;
    }
// if for some reasons the requested page is greater than the total
// set the requested page to total page
    if ($page > $total_pages)
        $page = $total_pages;
// calculate the starting position of the rows
    $start = $limit * $page - $limit;
// if for some reasons start position is negative set it to 0
// typical case is that the user type 0 for the requested page
    if ($start < 0)
        $start = 0;
// the actual query for the grid data

    $SQL = "SELECT depositos.id_deposito, depositos.idUsuario, depositos.cliente, depositos.monto, depositos.banco, depositos.referencia, depositos.fecha, depositos.estatus, depositos.comentario
FROM depositos, relaciones
WHERE depositos.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = '$id' AND depositos.estatus = 2 ORDER BY depositos.$sidx $sord LIMIT $start , $limit";
    if ($_REQUEST['oper'] == "edit") {
        //$fechaAut = date('Y-m-d H:i:s', strtotime("-1 HOUR"));
        if ($_REQUEST["estatus"] == 1) {
            //SE obtiene el saldo Actual del superior
            $saldo = $db->sql_result($db->sql_query("SELECT saldoActual FROM saldos WHERE idUsuario = $id"), 0);
            //Se obtiene el monto del solicitante
            $solicitado = $db->sql_result($db->sql_query("SELECT monto FROM depositos WHERE id_deposito = $_REQUEST[id]"), 0);
            if ($solicitado > $saldo) {
                $estatus = "NO";
                $mensaje = "No tienes suficiente saldo para traspasar";
                /* header("Content-type: text/xml;charset=iso-8859-1");
                  $s = "<?xml version='1.0' encoding='iso-8859-1'?>"; */
            } else {
                $db->sql_query("UPDATE depositos SET estatus = '$_REQUEST[estatus]', comentario = '$_REQUEST[note]', monto = '$_REQUEST[monto]', fechaAut = '$fecha' WHERE id_deposito = $_REQUEST[id]");
                $row = $db->sql_fetch_array($db->sql_query("SELECT idUsuario,monto,banco,referencia,fecha FROM depositos WHERE id_deposito = $_REQUEST[id]"));
                $monto = $row[monto];
                $db->sql_query("INSERT INTO compras (idUsuario, monto, fecha)
            VALUES ($row[idUsuario],$monto,NOW() - INTERVAL 1 HOUR)");
                return false;
            }
        } else {
            $db->sql_query("UPDATE depositos SET estatus = '$_REQUEST[estatus]', comentario = '$_REQUEST[note]', fechaAut = '$fecha' WHERE id_deposito = $_REQUEST[id]");
            return false;
        }
    }
    $result = $db->sql_query($SQL);
    // we should set the appropriate header information. Do not forget this.
    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    $s .= "<records>" . $count . "</records>";
    // be sure to put text data in CDATA
    while ($row = $db->sql_fetch_array($result)) {
        $s .= "<row id='" . $row[id_deposito] . "'>";
        $s .= "<cell><![CDATA[" . date('d-m-Y H:i:s', strtotime($row[fecha])) . "]]></cell>";
        $s .= "<cell>" . $row[idUsuario] . "</cell>";
        $s .= "<cell><![CDATA[" . $row[cliente] . "]]></cell>";
        $s .= "<cell>" . $row[monto] . "</cell>";
        $s .= "<cell><![CDATA[" . $row[banco] . "]]></cell>";
        $s .= "<cell><![CDATA[" . $row[referencia] . "]]></cell>";
        $s .= "<cell><![CDATA[EN ESPERA]]></cell>";
        $s .= "<cell><![CDATA[" . $row[comentario] . "]]></cell>";
        $s .= "</row>";
    }
    $s .= "</rows>";
    echo $s;
}
?>
