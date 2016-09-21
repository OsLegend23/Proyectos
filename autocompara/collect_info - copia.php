<?php

set_time_limit(0);
set_include_path('./lib/classes');
require_once 'configuration.php';

function __autoload($class) {
    if (file_exists('./lib/classes/' . $class . '.class.php')) {
        require_once $class . '.class.php';
    }
}

$collect_info = new collect_info;
$collect_info->get_trademarks($_GET['GetMarca']);
$collect_info->get_Mpo($_GET['idMpo']);

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

        // return $this->parse_data( curl_class::send(self::$url, GET, $params) );
        $trademarks = $this->parse_data(curl_class::send(self::$url, GET, $params));
        foreach ($trademarks as $trademark_code => $trademark_name) {
            //$data[$trademark_code]['name'] = $trademark_name;
            echo "<option value=" . $trademark_code . ">" . $trademark_name . "</option>";
        }
    }

    public function get_sub_trademarks($year, $trademark_code) {
        $data = array();
        $params = array('GetSubMarca' => $trademark_code . '|' . $year);
        $sub_trademarks = $this->parse_data(curl_class::send(self::$url, GET, $params));
        //return $this->parse_data(curl_class::send(self::$url, GET, $params));
        foreach ($sub_trademarks as $sub_trademarks_code => $sub_trademarks_name){
            $data[$sub_trademarks_code]['name'] = $sub_trademarks_name;
        }
    }

    public function get_versions($year, $trademark_code, $sub_trademark_code) {
        $data = array();
        $params = array('GetVehiculo' => $trademark_code . '|' . $year . '|' . $sub_trademark_code);
        $versions = $this->parse_data(curl_class::send(self::$url, GET, $params));
        //return $this->parse_data(curl_class::send(self::$url, GET, $params));
        foreach ($versions as $versions_code => $versions_name ){
            $data[$versions_code]['name'] = $versions_name;
        }
    }

    public function get_Mpo($state, $format = 'php') {
        $data = array();
        $params = array('GetMpo' => $state);

        // return $this->parse_data( curl_class::send(self::$url, GET, $params) );
        $Municipio = $this->parse_data(curl_class::send(self::$url, GET, $params));
        // echo "<select>";
        echo "<option value='-111'>SELECCIONA UNA OPCION</option>";
        foreach ($Municipio as $Mpo_code => $Mpo_name) {
            // $data[$Mpo_code]['name'] = $Mpo_name;

            echo "<option value=" . $Mpo_code . ">" . $Mpo_name . "</option>";
        }
        // echo "</select>";
        // print_r($data);
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

}
