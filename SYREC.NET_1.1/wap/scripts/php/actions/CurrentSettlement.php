<?php 
require_once ('dbconnector.php');
$dbase=opendatabase();
//what is my profile?
switch($_SESSION["Role"])
{
    case "Cajero":
        $idpa=mysql_result(mysql_query("select idUsuarioPadre from relaciones where idUsuarioHijo=$_SESSION[UserID]"),0);
        $querystr="SELECT saldo, fechahora FROM operaciones WHERE idUsuario=$idpa ORDER BY idOperaciones DESC LIMIT 1";
        $myquery=mysql_query($querystr);
        $row=mysql_fetch_array($myquery);
        if($row)
        {
            $fecha=date("d M y",strtotime($row[fechahora]));
            $hora=date("h:i:s a",strtotime($row['fechahora']));
            echo "Saldo $".number_format($row[saldo],2);
        }        
        break;        
    default:
        $querystr="SELECT saldo, fechahora FROM operaciones WHERE idUsuario=$_SESSION[UserID] ORDER BY idOperaciones DESC LIMIT 1";
        $myquery=mysql_query($querystr);
        $row=mysql_fetch_array($myquery);
        if($row)
        {
            $fecha=date("d M y",strtotime($row[fechahora]));
            $hora=date("h:i:s a",strtotime($row['fechahora']));
            echo "Saldo $".number_format($row[saldo],2);
        }        
        break;
}
?>
