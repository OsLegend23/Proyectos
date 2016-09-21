<?php

set_time_limit(0);
set_include_path('./lib/classes');
require_once 'configuration.php';

function __autoload($class) {
    if (file_exists('./lib/classes/' . $class . '.class.php')) {
        require_once $class . '.class.php';
    }
}

$price = array();
$collect_info = new collect_info;
$price = $collect_info->get_data_table();

$precio = "12,245.59";
$precio = explode(',', $precio);
$precio1 = $precio[0];
$precio2 = $precio[1];
$precio = $precio1.$precio2;
echo (double)$precio+  rand(50, 200);
/*
print_r($price);
print_r($price[0][2]);
print_r($price[0][3]);
print_r($price[1][0]);
print_r($price[1][1]);
print_r($price[1][2]);

print_r($price[1][3]);
print_r($price[2][0]);
print_r($price[2][1]);
print_r($price[2][2]);
print_r($price[2][3]);

print_r($price[3][0]);
print_r($price[3][1]);
print_r($price[3][2]);
print_r($price[3][3]);
print_r($price[4][0]);*/

// $trademark = explode("@", $_GET['marca']);
// $sub_trademark = explode("@", $_GET['subMarca']);
// $state = explode("@", $_GET['idMpo']);

// if ($_GET['getMarca'] == 1)
//     $collect_info->get_trademarks($_GET['year']);
// else if ($_GET['getSubMarca'] == 1)
//     $collect_info->get_sub_trademarks($_GET['year'], $trademark[0]);
// else if ($_GET['getVersion'] == 1)
//     $collect_info->get_versions($_GET['year'], $trademark[0], $sub_trademark[0]);
// else if ($_GET['getMpo'] == 1)
//     $collect_info->get_Mpo($state[0]);
// else {
//     $modelo = $_REQUEST['modelo'];
//     $marca = explode('@', $_REQUEST['marca']);
//     $marca2 = str_replace(" ", '%20', $marca[1]);
//     $serie = explode('@', $_REQUEST['serie']);
//     $serie2 = str_replace(" ", '%20', $serie[1]);
//     $version = $_REQUEST['version'];
//     $estado = explode('@', $_REQUEST['sel_estado']);
//     $estado2 = str_replace(" ", '%20', $estado[1]);
//     $mpo = $_REQUEST['Mpo'];

//     /*$url = "http://anaseguros.com.mx/cotizar-seguros-de-autos/consultas.aspx?transac=" . $modelo . "|" . $marca[0] . "|" . $serie[0] . "|" . $version . "|" . $estado[0] . "|" . $mpo . "|1|T|5&extras=" . $modelo . ",%27" . $marca2 . "%27,%27" . $serie2 . "%27,%27" . $estado2 . "%27&deducible=5";
//     $handler = curl_init($url);
//     $response = curl_exec($handler);
//     //$img = imagecreatefromstring($response);
//     curl_close($handler);
//     echo $response;*/
    
//     $collect_info->get_data_table($modelo, $marca[0], $serie[0], $version, $estado[0], $mpo, $marca2, $serie2, $estado2);
//     print_r($collect_info);
// //    echo $url;
// }

class collect_info {

    private static $url = 'http://www.anaseguros.com.mx/cotizar-seguros-de-autos/consultas.aspx';

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
            echo "<option value=" . $versions_code . ">" . $versions_name . "</option>";
        }
    }

    public function get_Mpo($state, $format = 'php') {
        $data = array();
        $params = array('GetMpo' => $state);

        $Municipio = $this->parse_data(curl_class::send(self::$url, GET, $params));
        echo "<option value='-111'>SELECCIONA UNA OPCION</option>";
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
    
    
    public function get_data_table() {
        $data = array();
        $urldef = "http://www.anaseguros.com.mx/cotizar-seguros-de-autos/consultas.aspx?transac=2013|CR|268|C0230048|19|21|1|T|5&extras=2013,%27CHRYSLER%27,%27CHARGER%27,%27NUEVO%20LEON%27&deducible=5";
        //$params = array('transac' => $modelo . "|" . $marca . "|" . $serie . "|" . $version . "|" . $estado . "|" . $mpo . "|1|S|5&extras=" . $modelo . ",%27" . $marca2 . "%27,%27" . $serie2 . "%27,%27" . $estado2 . "%27&deducible=5");
        $sub_trademarks = $this->parser_table(curl_class::send($urldef, GET));
        
        return $sub_trademarks;
        //return $this->parse_data(curl_class::send(self::$url, GET, $params));
//        foreach ($sub_trademarks as $sub_trademarks_code => $sub_trademarks_name){
//            $data[$sub_trademarks_code]['name'] = $sub_trademarks_name;
//        }
    }
    
    
    public function parser_table($html){
        $data = array();
        if (strlen(trim($html)) <= 0) {
            return $data;
        }
        $dom = new DOMDocument;
        @$dom->loadHTML($html);
        // echo $dom->saveHTML();
        foreach ($dom->getElementsByTagName('td') as $element) 
        {
            $data[$element->nodeValue] =  $element->nodeValue."<br>";
        }
        //print_r(array_chunk($data, 4));
        $data = array_chunk($data, 4);

        return $data;
    }

}

//http://anaseguros.com.mx/cotizar-seguros-de-autos/consultas.aspx?transac=2012|BW|464|P0100047|2|2|1|S|5&extras=2012,%27BMW%27,%27BMW%20X1%27,%27BAJA%20CALIFORNIA%27&deducible=5