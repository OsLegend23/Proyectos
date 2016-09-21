<?php
class Conexion {
    var $servidor;
    var $usuario;
    var $pass;
    var $bd;
    var $conectar;
    var $consulta;
    var $Error_en_Str;
    // $user="pweb_alumno", $contra="pweb_0801", $db="pweb"
    //Se hace la conexion con el servidor
    function sql_connect($serv="localhost", $user="syrec", $contra="librabep", $db="syrec_recarga") {
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

    //Fución para realizar las consultas
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

    //Número de registros de la consulta
    function sql_num_rows($i) {
        $resultado = mysql_num_rows($i);
        if(!$resultado) {
            $this->Error_en_Str = mysql_error();
            echo $this->Error_en_Str;
        }
        return $resultado;
    }

    //Numero de campos de una consulta
    function sql_num_fields($i) {
        $resultado = @mysql_num_fields($i);
        if($resultado) {
            return $resultado;
        }else {
            $this->Error_en_Str = mysql_error();
            echo $this->Error_en_Str;
        }
    }

    //Arreglo de la consulta
    function sql_fetch_array($i) {
        $resultado = @mysql_fetch_array($i);
        if($resultado) {
            return $resultado;
        }else {
            $this->Error_en_Str = mysql_error();
            echo $this->Error_en_Str;
        }
    }

    //Arreglo asociativo de la consulta
    function sql_fetch_assoc($i) {
        $resultado= @mysql_fetch_assoc($i);
        if($resultado) {
            return $resultado;
        }else {
            echo $this->Error_en_Str = mysql_error();
        }
    }

    //Datos de un resultado en una fila
    function sql_result($i, $j) {
        $resultado = @mysql_result($i, $j);
        if($resultado) {
            return $resultado;
        }else {
            $this->Error_en_Str = mysql_error();
            echo $this->Error_en_Str;
        }
    }

    //Nombre de los campos
    function sql_field_name($i, $j) {
        $resultado = @mysql_field_name($i,$j);
        if($resultado) {
            return $resultado;
        }else {
            $this->Error_en_Str = mysql_error();
            echo $this->Error_en_Str;
        }
    }

    //Cerrar la conexión
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