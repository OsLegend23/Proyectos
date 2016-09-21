<?php
/**
 * Clase personal para la conexión con MySQL
 * Creado el 31 de Mayo de 2008
 * @author ISC. Rafael Aguilar
 * @version 1.2
 */
class Conexion {
    var $servidor;
    var $usuario;
    var $pass;
    var $bd;
    var $conectar;
    var $consulta;
    var $Error_en_Str;
    /**
     * Abre o reutiliza una conexión a un servidor MySQL.
     * @param string $serv Nombre del Servidor
     * @param string $user Usuario de la base de datos
     * @param string $contra Password de la base de datos
     * @param string $db Nombre de la base de dato a la cuál se quiere tener acceso
     * @return int Devuelve un identificador de enlace a MySQL en caso de éxito o 0 en caso de error
     */
    function sql_connect($serv="localhost", $user="syrec", $contra="j3h0var3y", $db="syrec_recarga") {
        if($serv!="")$this->servidor= $serv;
        if($user!="")$this->usuario= $user;
        if($contra!="")$this->pass= $contra;
        if($db!="")$this->bd= $db;
        //Se hace la conexión al servidor
        $this->conectar = @mysql_connect($this->servidor, $this->usuario, $this->pass);
        if(!$this->conectar) {
            $this->Error = mysql_error();
            echo $this->Error;
            return 0;
        }
        //Seleccionando la base de datos
        if(!@mysql_select_db($this->bd, $this->conectar)) {
            $this->Error = "No se pudo establecer la conexi&oacute;n con la base de datos ".$this->bd;
            echo $this->Error;
            return 0;
        }
        return $this->conectar;
    }

    /**
     * Envía una única consulta (múltiples consultas no están soportadas) a la base de datos actualmente activa en el servidor.
     * @param string $sql Consulta
     * @return resource|bool Para SELECT, SHOW, DESCRIBE, EXPLAIN y otras sentencias que retornan un recordset, retorna un resource en caso de éxito, o FALSE en caso de error.
     * Para otros tipos de sentencias SQL, tales como INSERT, UPDATE, DELETE, DROP, etc, retorna TRUE en caso de éxito o FALSE en caso de error.
     */
    function sql_query($sql="") {
        if($sql=="") {
            print (' Especifica una consulta');
            return 0;
        }
        //Se ejecuta la consulta
        $this->consulta = @mysql_query($sql, $this->conectar);
        if($this->conectar) {
            return $this->consulta;
        }else {
            echo $this->Error_en_Str = mysql_error();
        }
    }

    /**
     * Recupera el número de filas de un resultset. Este comando es únicamente válido para sentencias como SELECT o SHOW que retornan un resultset real.
     * @param resource $i El resultado de la consulta
     * @return int El número de filas de un resultset en caso de éxito y 0 en caso de error.
     */
    function sql_num_rows($i) {
        $resultado = @mysql_num_rows($i);
        if(!$resultado) {
            $this->Error_en_Str = mysql_error();
            echo $this->Error_en_Str;
        }
        return $resultado;
    }

    /**
     * Recupera el número de campos desde una query.
     * @param resource $i Query a obtener sus campos
     * @return int|bool Devuelve el número de campos en un resultado dado de resource en caso de éxito o FALSE en caso de error.
     */
    function sql_num_fields($i) {
        $resultado = @mysql_num_fields($i);
        if($resultado) {
            return $resultado;
        }else {
            $this->Error_en_Str = mysql_error();
            echo $this->Error_en_Str;
        }
    }

    /**
     * Recupera una fila de resultado como un array asociativo, un array numérico o como ambos
     * @param resource $i Query
     * @return array|bool Devuelve un array de cadenas que corresponde a la fila recuperada, o FALSE si no hay más filas
     */
    function sql_fetch_array($i) {
        $resultado = @mysql_fetch_array($i);
        if($resultado) {
            return $resultado;
        }else {
            $this->Error_en_Str = mysql_error();
            echo $this->Error_en_Str;
        }
    }

    /**
     * Devuelve un array asociativo que corresponde a la fila recuperada y mueve el apuntador de datos interno hacia adelante
     * @param resource $i Query
     * @return array|bool Devuelve un array asociativo de cadenas que corresponde a la fila recuperada, o FALSE si no hay más filas disponibles.
     */
    function sql_fetch_assoc($i) {
        $resultado= @mysql_fetch_assoc($i);
        if($resultado) {
            return $resultado;
        }else {
            echo $this->Error_en_Str = mysql_error();
        }
    }

    /**
     * Recupera el contenido de una celda de un resultset MySQL.
     * @param resource $i Query
     * @param int $j El número de fila del resultset que está siendo recuperado. El número de filas empieza a partir de 0.
     * @return string|bool El contenido de una celda de un resultset MySQL en caso de éxito, o FALSE en caso de fallo.
     */
    function sql_result($i, $j) {
        $resultado = @mysql_result($i, $j);
        if($resultado) {
            return $resultado;
        }else {
            $this->Error_en_Str = mysql_error();
            echo $this->Error_en_Str;
        }
    }

    /**
     * Obtiene el nombre del campo especificado en un resultado.
     * @param resource $i Query
     * @param int $j El número del campo a buscar. El valor de $j comienza en 0
     * @return string|bool El nombre del campo especificado en caso de éxito o FALSE en caso de error.
     */
    function sql_field_name($i, $j) {
        $resultado = @mysql_field_name($i,$j);
        if($resultado) {
            return $resultado;
        }else {
            $this->Error_en_Str = mysql_error();
            echo $this->Error_en_Str;
        }
    }

    /**
     * liberará toda la memoria asociada con el identificador del resultado $result.
     * @param resource $result
     * @return bool Devuelve TRUE en caso de éxito o FALSE en caso de error. 
     */
    function sql_free_result($result){
        $resultado = @mysql_free_result($result);
        if($resultado){
            return $resultado;
        }else{
            $this->Error_en_Str = mysql_error();
            echo $this->Error_en_Str;
        }
    }

    /**
     * Cierra la conexión no continua al servidor de MySQL que es asociada con el identificador de enlace especificado
     * @return bool Devuelve TRUE en caso de éxito o FALSE en caso de error.
     */
    function sql_close() {
        $cerrar = @mysql_close($this->conectar);
        if($cerrar) {
            return $cerrar;
        }else {
            echo "No se ha podido cerrar la conexi&oacute;n.";
        }
    }

    function __call($metodo, $atributos) {
        echo "No existe el m&eacute;todo <i>\"$metodo\"</i> que estas se&ntilde;alando";
    }
}
?>