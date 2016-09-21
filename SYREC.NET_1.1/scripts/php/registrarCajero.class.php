<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
include 'conexion.php';

class RegistrarCajero {

    private $id, $nombre, $email, $psw, $telefono, $celular, $entrada, $salida, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $conexion, $Merchant;

    /**
     * Constructor encargado del ingreso de los datos a la base de datos.
     *
     * @param integer $id Identificador del Padre
     * @param string $cajero Nombre del Cajero
     * @param string $correo Correo Electrónico del Cajero
     * @param string $pass Contraseña del Cajero
     * @param string $phone Teléfono particular del Cajero
     * @param string $cel Celular del Cajero
     * @param time $entrada Hora del entrada el cajero
     * @param time $salida Hora del Salida del Cajero
     * @param integer $lu Lunes
     * @param integer $ma Martes
     * @param integer $mi Miércoles
     * @param integer $ju Jueves
     * @param integer $vi Viernes
     * @param integer $sa Sábado
     * @param integer $do Domigno
     * @return string
     */
    public function __construct($id, $cajero, $correo, $pass, $phone, $cel, $entrada, $salida, $lu, $ma, $mi, $ju, $vi, $sa, $do) {
        $this->nombre = $cajero;
        $this->email = $correo;
        $this->telefono = $phone;
        $this->celular = $cel;
        $this->entrada = $entrada;
        $this->salida = $salida;
        $this->id = $id;
        $this->Merchant = $this->MerchantSupperior($this->id);
        $this->psw = $pass;
        $this->conexion = new Conexion;
        $this->conexion->sql_connect();
        $this->domingo = $do;
        $this->lunes = $lu;
        $this->martes = $ma;
        $this->miercoles = $mi;
        $this->jueves = $ju;
        $this->viernes = $vi;
        $this->sabado = $sa;
    }

    /**
     * Método para obtener el ID_MERCHANT del Comercio que da de alta a los Cajeros
     * @param integer $idUser Identificador del usuario padre
     * @return integer
     */
    private function MerchantSupperior($idUser) {
        $db = new Conexion;
        $db->sql_connect();
        $merchant = $db->sql_result($db->sql_query("SELECT ID_MERCHANT from usuarios where idUsuario=" . $idUser), 0);
        if ($merchant == NULL)
            $merchant = 0;
        return $merchant;
    }

    public function registrar() {
        $existe = $this->conexion->sql_num_rows($this->conexion->sql_query("SELECT * FROM usuarios WHERE Usuario = \"" . mysql_real_escape_string($this->email) . "\""));
        if ($existe > 0) {
            return "no";
        } else {
            //echo "INSERT INTO usuarios (Usuario, Contrasena,idPerfil,ID_MERCHANT,Status,intentos) VALUES (\"".mysql_real_escape_string($this->email)."\",\"".mysql_real_escape_string(hash('sha256', md5($this->psw)))."\",4,\"".mysql_real_escape_string($this->Merchant)."\",1,0)<br>";
            $this->conexion->sql_query("INSERT INTO usuarios (Usuario, Contrasena,idPerfil,ID_MERCHANT,Status,intentos) VALUES (\"" . mysql_real_escape_string($this->email) . "\",\"" . mysql_real_escape_string(hash('sha256', md5($this->psw))) . "\",4,\"" . mysql_real_escape_string($this->Merchant) . "\",1,0)");
            //echo "SELECT idUsuario FROM usuarios WHERE Usuario LIKE '$this->email'<br>";
            $idUsr = $this->conexion->sql_result($this->conexion->sql_query("SELECT idUsuario FROM usuarios WHERE Usuario LIKE '$this->email'"), 0);
            //echo "INSERT INTO cajero (idUsuario, nombreCajero,telefono,celular) VALUES (\"".mysql_real_escape_string($idUsr)."\",\"".mysql_real_escape_string($this->nombre)."\",\"".mysql_real_escape_string($this->telefono)."\",\"".mysql_real_escape_string($this->celular)."\")<br>";
            $this->conexion->sql_query("INSERT INTO cajero (idUsuario, nombreCajero,telefono,celular) VALUES (\"" . mysql_real_escape_string($idUsr) . "\",\"" . mysql_real_escape_string($this->nombre) . "\",\"" . mysql_real_escape_string($this->telefono) . "\",\"" . mysql_real_escape_string($this->celular) . "\")");
            //echo "SELECT idCajero FROM cajero WHERE idUsuario = $idUsr <br>";
            $idCajero = $this->conexion->sql_result($this->conexion->sql_query("SELECT idCajero FROM cajero WHERE idUsuario = $idUsr"), 0);
            //echo "INSERT INTO horarioCajero (idCajero, entrada,salida,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado,Domingo)
            //						VALUES (\"".mysql_real_escape_string($idCajero)."\",\"".mysql_real_escape_string($this->entrada)."\",\"".mysql_real_escape_string($this->salida)."\",\"".mysql_real_escape_string($this->lunes)."\",\"".mysql_real_escape_string($this->martes)."\",\"".mysql_real_escape_string($this->miercoles)."\",\"".mysql_real_escape_string($this->jueves)."\",\"".mysql_real_escape_string($this->viernes)."\",\"".mysql_real_escape_string($this->sabado)."\",\"".mysql_real_escape_string($this->domingo)."\")<br>";
            $this->conexion->sql_query("INSERT INTO horarioCajero (idCajero, entrada,salida,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado,Domingo) 
									VALUES (\"" . mysql_real_escape_string($idCajero) . "\",\"" . mysql_real_escape_string($this->entrada) . "\",\"" . mysql_real_escape_string($this->salida) . "\",\"" . mysql_real_escape_string($this->lunes) . "\",\"" . mysql_real_escape_string($this->martes) . "\",\"" . mysql_real_escape_string($this->miercoles) . "\",\"" . mysql_real_escape_string($this->jueves) . "\",\"" . mysql_real_escape_string($this->viernes) . "\",\"" . mysql_real_escape_string($this->sabado) . "\",\"" . mysql_real_escape_string($this->domingo) . "\")");
            //echo "INSERT INTO relaciones (idUsuarioPadre,idUsuarioHijo) VALUES ($this->id,$idUsr)<br>";
            $this->conexion->sql_query("INSERT INTO relaciones (idUsuarioPadre,idUsuarioHijo) VALUES ($this->id,$idUsr)");
            return "si";
        }
    }

}

/* $registrar = new RegistrarCajero(3, 'RAFA AGUILAR', 'kain_raziel_lok@hotmail.com', '8StB4', '4616175681', '4611840960', '00:01', '23:59', 0,0, 0, 0, 0, 0, 1);
  $ingreso = $registrar->registrar();
  echo $ingreso; */
?>
