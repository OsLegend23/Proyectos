<?php

set_time_limit(0);
set_include_path('./lib/classes');
require_once 'configuration.php';

function __autoload($class) {
    if (file_exists('./lib/classes/' . $class . '.class.php')) {
        require_once $class . '.class.php';
    }
}

require_once "lib/nusoap/nusoap.php";

$collect_info = new collect_info;

$trademark = explode("@", $_GET['marca']);
$sub_trademark = explode("@", $_GET['subMarca']);
$state = explode("@", $_GET['idMpo']);

if ($_GET['getMarca'] == 1)
    $collect_info->get_trademarks($_GET['year']);
else if ($_GET['getSubMarca'] == 1)
    $collect_info->get_sub_trademarks($_GET['year'], $trademark[0]);
else if ($_GET['getVersion'] == 1)
    $collect_info->get_versions($_GET['year'], $trademark[0], $sub_trademark[0]);
else if ($_GET['getMpo'] == 1)
    $collect_info->get_Mpo($state[0]);
else if ($_GET['getSubMarcaGNP'] == 1)
    $collect_info->getSerieGNP($trademark[1], $_GET['year']);

class collect_info {

    private static $url = 'http://www.anaseguros.com.mx/cotizar-seguros-de-autos/consultas.aspx';
    private static $ws = 'http://gnpventamasiva.com.mx/WsAutos/CotizadorGNP.asmx?WSDL';

    public function get_all($format = 'php') {
        $start = microtime(true);
        $counter = 0;
        $data = array();
        $years = $this->get_years();

        foreach ($years as $key => $year) {
            $trademarks = $this->get_trademarks(year);

            foreach ($trademarks as $trademark_code => $trademark_name) {
                $sub_trademarks = $this->get_sub_trademarks($year, $trademark_code);
                $data[$year][$trademark_code]['name'] = $trademark_name;

                foreach ($sub_trademarks as $sub_trademark_code => $sub_trademark_name) {
                    $versions = $this->get_versions($year, $trademark_code, $sub_trademark_code);
                    $data[$year][$trademark_code][$sub_trademark_code]['name'] = $sub_trademark_name;
                    $data[$year][$trademark_code][$sub_trademark_code]['data'] = $versions;
                    ++$counter;
                }
            }
        }

        $stop = microtime(true);
        echo 'Finished in: ' . ($stop - $start) . ' with ' . $counter;
        print_r($data);
    }

    public function get_years() {
        return range(1998, date('Y') + 1);
    }

    public function get_trademarks($year) {
        $data = array();
        $params = array('GetMarca' => $year);

        $trademarks = $this->parse_data(curl_class::send(self::$url, GET, $params));
        echo "<option value='-111'>SELECCIONA UNA OPCION</option>";
        foreach ($trademarks as $trademark_code => $trademark_name) {
            echo "<option value='" . $trademark_code . "@" . $trademark_name . "'>" . $trademark_name . "</option>";
        }
    }

    public function get_sub_trademarks($year, $trademark_code) {
        $data = array();
        $params = array('GetSubMarca' => $trademark_code . '|' . $year);
        $sub_trademarks = $this->parse_data(curl_class::send(self::$url, GET, $params));
        echo "<option value='-111'>SELECCIONA UNA OPCION</option>";
        foreach ($sub_trademarks as $sub_trademarks_code => $sub_trademarks_name) {
            echo "<option value='" . $sub_trademarks_code . "@" . $sub_trademarks_name . "'>" . $sub_trademarks_name . "</option>";
        }
    }

    public function get_versions($year, $trademark_code, $sub_trademark_code) {
        $data = array();
        $params = array('GetVehiculo' => $trademark_code . '|' . $year . '|' . $sub_trademark_code);
        $versions = $this->parse_data(curl_class::send(self::$url, GET, $params));
        echo "<option value='-111'>SELECCIONA UNA OPCION</option>";
        foreach ($versions as $versions_code => $versions_name) {
            echo "<option value='" . $versions_code . "@" . $versions_name . "'>" . $versions_name . "</option>";
        }
    }

    public function get_Mpo($state, $format = 'php') {
        $data = array();
        $params = array('GetMpo' => $state);

        $Municipio = $this->parse_data(curl_class::send(self::$url, GET, $params));
        echo "<option value='-111'>SELECCIONA UNA OPCION</option>";
        if ($state == 25 ){
            echo "<option value=6>CULIACAN</option>";
        }
        foreach ($Municipio as $Mpo_code => $Mpo_name) {
            echo "<option value=" . $Mpo_code . ">" . $Mpo_name . "</option>";
        }
    }

    public function getResults($transac, $extras, $deducible) {
        $param = array('transac' => $transac . '&extras=' . $extras . '&deducible=' . $deducible);
        $avaluo = curl_class::send(self::$url, GET, $param);
        print_r($avaluo);
    }

    private function parse_data($html) {
        $data = array();
        if (strlen(trim($html)) <= 0) {
            return $data;
        }
        $dom = new DOMDocument;
        $dom->loadHTML($html);
        foreach ($dom->getElementsByTagName('option') as $key => $option) {
            if ($option->getAttribute('value') == -111) {
                continue;
            }

            $data[$option->getAttribute('value')] = $option->nodeValue;
        }

        return $data;
    }

    public function get_data_table($modelo, $marca, $serie, $version, $estado, $mpo, $marca2, $serie2, $estado2) {

//        $params = array('transac' => $modelo . "|" . $marca . "|" . $serie . "|" . $version . "|" . $estado . "|" . $mpo . "|1|S|5&extras=" . $modelo . ",%27" . $marca2 . "%27,%27" . $serie2 . "%27,%27" . $estado2 . "%27&deducible=5");
        $urldef = "http://anaseguros.com.mx/cotizar-seguros-de-autos/consultas.aspx?transac=" . $modelo . "|" . $marca . "|" . $serie . "|" . $version . "|" . $estado . "|" . $mpo . "|1|T|5&extras=" . $modelo . ",%27" . $marca2 . "%27,%27" . $serie2 . "%27,%27" . $estado2 . "%27&deducible=5";
        $sub_trademarks = $this->parser_table(curl_class::send($urldef, GET));

        return $sub_trademarks;
    }

    private function parser_table($html) {
        $data = array();
        if (strlen(trim($html)) <= 0) {
            return $data;
        }
        $dom = new DOMDocument;
        @$dom->loadHTML($html);
        foreach ($dom->getElementsByTagName('td') as $element) {
            $data[$element->nodeValue] = $element->nodeValue . "<br>";
        }
        $data = array_chunk($data, 4);

        return $data;
    }

    public function getIdCarGNP($marca, $modelo, $serie) {
        $xml = simplexml_load_file('catalogoAut.xml');
        $idCar = array();
        foreach ($xml->Elemento as $auto) {
            if ($auto->Valor == "$marca" & $auto->Clave1 == "$modelo" & $auto->Clave2 == "$serie") {
                $idCar = $auto->Clave3;
            }
        }
        if (count($idCar) > 0) {
            return (string) $idCar[0];
        } else {
            return 0;
        }
    }
    
    public function getSerieGNP($marca, $modelo) {
        $xml = simplexml_load_file('catalogoAut.xml');
        echo "<option value='-111'>SELECCIONA UNA OPCION</option>";
        foreach ($xml->Elemento as $auto) {
            if ($auto->Valor == "$marca" & $auto->Clave1 == "$modelo") {
                echo "<option value='" . $auto->Clave3 . "'>" . $auto->Clave4 ."</option>";
            }
        }
    }

    public function getGNP($EstadoCirculacion, $claveMarca, $Marca, $Modelo, $Paquete) {
        $client = new nusoap_client(self::$ws, true);
        
        $sError = $client->getError();
        if ($sError)
            print_r($sError);
        
        $inicioVig = date('d/m/Y');
        $finVig = date('d/m/Y', strtotime('+1 year'));
        if ($EstadoCirculacion < 10) {
            $EstadoCirculacion = '0' . $EstadoCirculacion;
        }
        $getRC = "<Solicitud>
                    <General>
                            <Usuario>MI_AGENTE</Usuario>
                            <Password>MIAGENTEWsPer</Password>
                            <CodigoPromocion>MIAGENTE_LN</CodigoPromocion>
                            <Tienda>0</Tienda>
                            <OpcionesAContratar>Limitada y RC LN MIAGENTE</OpcionesAContratar>
                            <Paquete>$Paquete</Paquete>
                            <FormaPago>Mensual</FormaPago>
                            <MetodoPago>I</MetodoPago>
                            <InicioVig>$inicioVig</InicioVig>
                            <FinVig>$finVig</FinVig>
                            <Accion>C</Accion>
                            <Cotizacion/>
                            <descuentoGC>0</descuentoGC>
                            <cesioncomision>0</cesioncomision>
                            <primerrecibo>IN</primerrecibo>
                            <recibosubsecuente>IN</recibosubsecuente>
                            <CodigoIntermediario>0067807001</CodigoIntermediario>
                            <CodigoCliente></CodigoCliente>
                            <TipoPago/>
                            <ValVehi>0</ValVehi>
                            <PrimaTotal>0</PrimaTotal>
                    </General>
                    <Autos>
                            <Auto>
                                    <EstadoCirculacion>$EstadoCirculacion</EstadoCirculacion>
                                    <Uso></Uso>
                                    <ClaveMarca>$claveMarca</ClaveMarca>
                                    <Marca>$Marca</Marca>
                                    <Modelo>$Modelo</Modelo>
                                    <Descripcion></Descripcion>
                                    <Motor></Motor>
                                    <Serie></Serie>
                                    <Placas></Placas>
                                    <FormaIndemnizacion>Valor Convenido</FormaIndemnizacion>
                                    <ValorConvenido></ValorConvenido>
                            </Auto>
                    </Autos>
            </Solicitud>";

        $getResponse = $client->call("Cotizar", array('mixml' => $getRC));
        if ($client->fault) {
            print_r($client->fault);
        } else {
            $sError = $client->getError();
        }

        if (count($getResponse) > 0) {
            return $getResponse;
        } else {
            return 0;
        }

        //print_r($getResponse['ObtenerCatalogoResult']['Catalogo']['Elemento']);
    }

}

//http://anaseguros.com.mx/cotizar-seguros-de-autos/consultas.aspx?transac=2012|BW|464|P0100047|2|2|1|S|5&extras=2012,%27BMW%27,%27BMW%20X1%27,%27BAJA%20CALIFORNIA%27&deducible=5