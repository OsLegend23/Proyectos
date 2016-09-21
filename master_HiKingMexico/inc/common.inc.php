<?php
include('globals.inc.php');

class Common
{
    private $root = '';
    private $lang = '';
    private $localization = '';

    public function __construct()
    {
        include('globals.inc.php');

        $domain = explode($GLOBAL['root'], $_SERVER['SCRIPT_FILENAME']);
        $rootCount = count(explode('/', $domain[1])) - $GLOBAL['root-jumps'];

        for ($i = 0; $i < $rootCount; $i++)
            $this->root .= '../';

        $this->lang = 'es';
        $this->localization = $this->root . 'lang/' . $this->lang . '.php';

        if (strcmp($GLOBAL['show_error_reporting'], 'true') == 0) {
            error_reporting(E_ALL ^ E_NOTICE);
            ini_set('display_errors', 1);
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 0);
        }
    }

    public function getUcwords($string)
    {
        return ucwords(strtolower($string));
    }

    public function betweenDates($initialperiod, $periodended, $date = null)
    {
        if (!isset($date)) {
            $date = Date('Y-m-d');
        }
        return ($date >= $initialperiod && $date <= $periodended);
    }

    public function getCaptcha()
    {
        return $_SESSION['captchahikingmexico'];
    }

    public function fillArrayCollection($arrayName, $array, $fields, $firstOption = Null, $isQueryResult = false)
    {
        if (isset($firstOption)) {
            echo "$arrayName.addItem(new Array(";

            foreach ($firstOption as $key => $value) {
                $comma = ",";
                if ($key == 0) {
                    $comma = "";
                }
                echo $comma . "'" . $value . "'";
            }
            echo "));\n";
        }

        if ($isQueryResult) {
            while ($row = $array->fetch()) {
                echo "$arrayName.addItem(new Array(";
                foreach ($fields as $key => $value) {
                    $comma = ",";
                    if ($key == 0) {
                        $comma = "";
                    }
                    echo $comma . "'" . $row[$value] . "'";
                }
                echo "));\n";
            }
        } else {
            foreach ($array as $key => $value) {
                echo "$arrayName.addItem(new Array(";
                if (isset($fields)) {
                    foreach ($fields as $fKey => $fValue) {
                        $comma = ",";
                        if ($key == 0) {
                            $comma = "";
                        }
                        echo $comma . "'" . $value[$fValue] . "'";
                    }
                } else {
                    echo "'$key', '$value' ";
                }
                echo "));\n";
            }
        }
    }

    public function getEscapeString($string)
    {
        return str_replace("'", "", $string);
    }

    public function getRoot()
    {
        return $this->root;
    }

    //Agrega librerias encontradas en la carpeta lib
    public function getLib($lib)
    {
        echo '<script type="text/javascript" src="' . $this->root . 'inc/lib/' . $lib . '"></script>' . "\n";
    }

    //Modifica el Theme de la pagina
    public function getMedia($media, $file)
    {
        return $this->root . 'media/' . $media . '/' . $file;
    }

    //Agrega archivos CSS
    public function getLocalizationFile($fileLang)
    {
        return $this->root . 'lang/' . $this->getLang() . '-' . $fileLang . '.php';
    }

    //Agrega las herramientas encontradas en la carpeta tool
    public function getLang()
    {
        return $this->lang;
    }

    //Agrega archivos javascript
    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    /*
      $media: Tipo de archivo
      $file: archivo con extrencion
     */
    public function getHeaderPage()
    {
        return $this->root . 'header.php';
    }

    //Toma el lenguaje actual
    public function getFooterPage()
    {
        return $this->root . 'footer.php';
    }

    //Modifica el archivo de lenguaje a usar
    public function getGenForm()
    {
        return $this->root . 'inc/lib/genform.php';
    }

    //Determina que archivo de lenguaje usar
    public function getMySQL()
    {
        return $this->root . 'inc/mysql.class.inc.php';
    }

    // incluye un archivo localizado
    public function getQuery()
    {
        return $this->root . 'inc/query.class.inc.php';
    }

    public function getBossSecurity()
    {
        return $this->root . 'inc/boss.security.inc.php';
    }

    public function getArrayYears($oldYear, $strSelectYear = null)
    {
        $years = array();
        if (isset($strSelectYear)) {
            $years['-1'] = $strSelectYear;
        }
        for ($i = date('Y'); $i > (date('Y') - $oldYear); $i--) {
            $years[$i] = $i;
        }
        return $years;
    }

    public function getYearsAgoRange($minYear, $maxYear, $label = null)
    {
        $yearsRange = array();

        if (isset($label)) {
            foreach ($label as $key => $value) {
                $yearsRange[$key] = $value;
            }
        }

        for ($i = $minYear; $i < $maxYear; $i++) {
            $yearsRange[$i] = $i;
        }
        return $yearsRange;
    }

    public function findPhoto($image, $location, $root = Null)
    {
        include('globals.inc.php');

        $root = isset($root) ? $root : $this->root;

        foreach ($GLOBAL['photoTypes'] as $key => $ext) {
            $existfile = $this->root . $location . '/' . $image . '.' . $ext;
            if (file_exists($existfile)) {
                return $root . $location . '/' . $image . '.' . $ext;
                break;
            }
        }
        return false;
    }

    public function findFile($file, $location, $root = Null)
    {
        $root = isset($root) ? $root : $this->root;
        $existfile = $root . $location . '/' . $file;

        if (file_exists($existfile)) {
            return $root . $location . '/' . $file;
        }
        return false;
    }

    public function isFileExist($file, $location, $root = Null)
    {
        include('globals.inc.php');

        $root = isset($root) ? $root : $this->root;
        return file_exists($root . $location . '/' . $file);
    }

    public function getExtension($str)
    {
        if (!isset($str)) {
            return null;
        }
        $i = strrpos($str, '.');
        if (!$i) {
            return null;
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    public function getDateFormat($mDate)
    {
        include('globals.inc.php');
        include($this->getLocalization());

        $dt_registry = date('j-n-Y', strtotime($mDate));
        $dt_registry = explode('-', $dt_registry);
        $dt_registry_day = $dt_registry[0];
        $dt_registry_month = $monthFull[$dt_registry[1]];
        $dt_registry_year = $dt_registry[2];
        $dateFormat = $dt_registry_day . ' ' . $STR['From'] . ' ' . $dt_registry_month . ' ' . $STR['From'] . ' ' . $dt_registry_year;

        return $dateFormat;
    }

    public function getLocalization()
    {
        $this->localization = $this->root . 'lang/' . $this->getLang() . '.php';
        return $this->localization;
    }

    public function getBirthDayFormat($mDate)
    {
        include('globals.inc.php');
        include($this->getLocalization());

        $dt_registry = date('j-n-Y', strtotime($mDate));
        $dt_registry = explode('-', $dt_registry);
        $dt_registry_day = $dt_registry[0];
        $dt_registry_month = $monthFull[$dt_registry[1]];
        $dt_registry_year = $dt_registry[2];
        $dateFormat = $dt_registry_day . ' ' . $STR['From'] . ' ' . $dt_registry_month . ' ' . $STR['From'] . ' ' . $dt_registry_year . ', (' . $this->getYearAgo($mDate) . ') ' . $STR['Years'];

        return $dateFormat;
    }

    public function getYearAgo($date)
    {
        $dia = date('j');
        $mes = date('n');
        $anno = date('Y');
        $dia_nac = substr($date, 8, 2);
        $mes_nac = substr($date, 5, 2);
        $anno_nac = substr($date, 0, 4);
        if ($mes_nac > $mes) {
            $calc_edad = $anno - $anno_nac - 1;
        } else {
            if ($mes == $mes_nac && $dia_nac > $dia) {
                $calc_edad = $anno - $anno_nac - 1;
            } else {
                $calc_edad = $anno - $anno_nac;
            }
        }
        return $calc_edad;
    }

    public function getDaysBetweenDates($mDate1, $mDate2)
    {
        $datediff = strtotime($mDate2) - strtotime($mDate1);
        return floor($datediff / (60 * 60 * 24));
    }

    public function sendMail($sendTo, $bodyMessage, $params)
    {
        if (isset($params)) {
            $bodyMessage = $this->str_replace($bodyMessage, $params);
        }
        $from = $sendTo['from'];
        $to = $sendTo['to'];
        $subject = $sendTo['subject'];
        $charset = $sendTo['charset'];
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=' . $charset . "\r\n";
        $headers .= 'From: ' . $GLOBAL['site-min'] . ' <' . $from . '>' . "\r\n";
        $mail_sent = @mail($to, $subject, $bodyMessage, $headers);
    }

    public function str_replace($string, $params)
    {
        if (isset($params)) {
            foreach ($params as $key => $value) {
                $string = str_replace($key, $value, $string);
            }
        }
        return $string;
    }

    public function check_email_address($email)
    {
        // First, we check that there's one @ symbol, 
        // and that the lengths are right.
        if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
            // Email invalid because wrong number of characters 
            // in one section or wrong number of @ symbols.
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if
            (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
			↪'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])
            ) {
                return false;
            }
        }
        // Check if domain is IP. If not, 
        // it should be valid domain name
        if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if
                (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
			↪([A-Za-z0-9]+))$", $domain_array[$i])
                ) {
                    return false;
                }
            }
        }
        return true;
    }

    public function addCommonsCSS()
    {
        include('globals.inc.php');
        //CSS
        $this->getTheme($GLOBAL['theme']);
        //$this->getTool('css', 'validator/css/validationEngine.jquery.css');
        $this->getCSS('style');
    }

    public function addCommonsJS()
    {
        include('globals.inc.php');
        //JavaScript
        $this->getTool('js', $GLOBAL['jquery']);
        //$this->getTool('js', 'validator/jquery.validationEngine.js');
        //$this->getTool('js', 'validator/jquery.validationEngine-es.js');

        //$this->getJs($GLOBAL['jquery-ui'] . '/jquery.ui.core.min');
        //$this->getJs($GLOBAL['jquery-ui'] . '/jquery.ui.widget.min');
        //$this->getJs($GLOBAL['jquery-ui'] . '/jquery.ui.button.min');

        //$this->getCSS('hikingmexico.style');
        //$this->getTool('js', 'modal/js/jquery.simplemodal.js');
    }

    public function getTheme($theme)
    {
        echo '<link type="text/css" href="' . $this->root . 'theme/' . $theme . '/css/' . $theme . '.css" rel="stylesheet" media="screen,projection" />';
    }

    public function getTool($type, $tool)
    {
        switch ($type) {
            case 'css':
                echo '<link rel="stylesheet" href="' . $this->root . 'inc/tool/' . $tool . '" />' . "\n";
                break;
            case 'js':
                echo '<script type="text/javascript" src="' . $this->root . 'inc/tool/' . $tool . '"></script>' . "\n";
                break;
            default:
                echo $this->root . 'inc/tool/' . $tool . "\n";
                break;
        }
    }

    public function getCSS($css)
    {
        echo '<link type="text/css" href="' . $this->root . 'inc/css/' . $css . '.css" rel="stylesheet" media="screen,projection" />' . "\n";
        echo '<link type="text/css" href="' . $this->root . 'inc/js/Trumbowyg/ui/trumbowyg.min.css" rel="stylesheet" media="screen,projection" />';
    }

    public function getJs($js)
    {
        echo '<script type="text/javascript" src="' . $this->root . 'inc/js/' . $js . '.js"></script>' . "\n";
    }

    //Destructor de la clase Common
    public function __destruct()
    {
    }
}

//End Common
$COMMON = new Common();
include($COMMON->getLocalization());
