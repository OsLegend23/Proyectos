<?php

$xml = simplexml_load_file('catalogoAut.xml');
/* echo "<pre>";
  print_r($xml);
  echo "</pre>"; */

echo date('d/m/Y',strtotime('+1 year'))."<br>";

$modelo = $_REQUEST['modelo'];
$marca = explode('@', $_REQUEST['marca']);
$marca2 = str_replace(" ", '%20', $marca[1]);
$serie = explode('@', $_REQUEST['serie']);
$serie2 = str_replace(" ", '%20', $serie[1]);
$version = explode('@', $_REQUEST['version']);
//$version2 = str_replace(" ", '%20', $version[1]);
$estado = explode('@', $_REQUEST['sel_estado']);
$estado2 = str_replace(" ", '%20', $estado[1]);
$mpo = $_REQUEST['Mpo'];

$idCar = array();
foreach ($xml->Elemento as $auto) {
    if ($auto->Valor == "$marca[1]" & $auto->Clave1 == "$modelo" & $auto->Clave2 == "$serie[1]") {
        $idCar = $auto->Clave3;
    }
}
if (count($idCar) > 0) {
    echo (string)$idCar[0];
}else{
    echo "PARA CONOCER DISPONIBILIDAD CONSULTE DIRECTAMENTE CON LA ASEGURADORA";
}

?>
