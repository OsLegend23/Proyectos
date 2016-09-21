<?php
//ini_set('session.save_path', '/home/syrec/tmp_session/');
session_start();
date_default_timezone_set('America/Mexico_City');
include 'scripts/php/conexion.php';
if (empty($_SESSION['l_usr'])) {//Primero reviso si hay una sesión activa, si no lo hay, regresa a la página de inicio
    header("Location: index.php");
} else {//Si está activa, checo hago la conexión a la BD
    $db = new Conexion;
    $db->sql_connect();
    $id = $_SESSION['l_usr'];
    //Ahora verifico el perfil de usuario para evitar que un usuario autentificado ingrese a un área que no es propia de su perfil y redireccionarlo a la que le corresponde
    $perfil = $db->sql_result($db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = $id"), 0);
    if ($perfil == 1) {
        header("Location: administracion.php");
    } elseif ($perfil == 2) {
        header("Location: franquiciatario.php");
    } elseif ($perfil == 4) {
        header("Location: cajero.php");
    } else {//Si el perfil es el correcto, carga los datos de su portal
        $hoy = date('Y-m-d');
        $sql = $db->sql_query("SELECT aviso FROM avisos ORDER BY fechaPublicacion DESC LIMIT 3");
        $ayer = date('Y-m-d', strtotime('-1 days')); //Fecha del día anterior
        /* OBTENER LOS SALDOS DEL DÍA ANTERIOR */
        $comprasA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE depositos.idUsuario = $id AND DATE(fechaAut)<='$ayer' AND estatus = 1"), 0);
        $ventasA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)<='$ayer'"), 0);
        $comisionesA = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)<='2011-01-25'"), 0);
        $comisionesI = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha) > '2011-02-28' AND DATE(fecha)<='$ayer'"), 0);
        $sInicial = ($comprasA + $comisionesA + $comisionesI) - $ventasA - 0.5;
        //SE ACTUALIZA EL SALDO INICIAL
        $db->sql_query("UPDATE usuarios SET saldo_Inicial=$sInicial WHERE idUsuario = $id");
        $saldoInicial = $db->sql_result($db->sql_query("SELECT saldo_Inicial FROM usuarios WHERE idUsuario = $id"), 0);
        $compras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE depositos.idUsuario = $id AND DATE(fechaAut)='$hoy' AND estatus = 1"), 0);
        $ventas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)='$hoy'"), 0);
        $comisiones = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)='$hoy'"), 0);
        $saldoActual = ($saldoInicial + $compras + $comisiones) - $ventas;
        //SE ACTUALIZA EL SALDO ACTUAL
        $db->sql_query("UPDATE saldos SET saldoActual = $saldoActual, fecha = NOW() WHERE idUsuario = $id");
?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <link rel="shortcut icon" href="images/favicon.ico" />
                <title>.::SYREC-COMERCIO::.</title>
                <!--Estilos-->
                <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
                <link type="text/css" rel="stylesheet" media="screen" href="css/smoothness/jquery-ui-1.8.1.custom.css" />
                <link type="text/css" rel="stylesheet" media="screen" href="css/ui.jqgrid.css"/>
                <link type="text/css" rel="stylesheet" href="css/contact.css" />
                <!--Scripts-->
                <script type="text/javascript" language="JavaScript" src="scripts/js/jquery-1.4.2.min.js">
                </script>
                <script type="text/javascript" language="JavaScript" src="scripts/js/i18n/grid.locale-sp.js">
                </script>
                <script type="text/javascript" language="JavaScript" src="scripts/js/jquery.jqGrid.min.js">
                </script>
                <script type="text/javascript" language="JavaScript" src="scripts/js/jquery-ui-1.8.1.custom.min.js">
                </script>
                <script type="text/javascript">
                    function recarga(){
                        location.href=location.href;
                    }
                    setInterval('recarga()',3600000);
                </script>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#a-menu a").each(function(){
                            var href = $(this).attr("href");
                            $(this).click(function(){
                                $("#contenedor").html('<div align="center"><img alt="carga" src="images/loading.gif" style="float:none; padding:30px;"/></div>');
                                $("#contenedor").hide().load(href).fadeIn("slow"); //Le damos efecto
                                return false;
                            });
                        });
                    });
                </script>
            </head>
            <body>
                <div id="pack">
                    <div id="head">
                        <img alt="head" src="images/logo_syrec.png" />
                        <div id="text">
                            <h1><em><?php echo utf8_encode($_SESSION['l_nombre']); ?></em></h1>
                            <h2>Bienvenido</h2>
                        </div>
                        <div id="avisos">
                            <div align="center">
                                <h2 style="color:red;">AVISOS</h2>
                            </div>
<?php
        $nrows = $db->sql_num_rows($sql);
        if ($nrows == 0) {
?>
                    <p>
                    <?php echo "Sin Avisos"; ?>
                    </p>
                        <?php
                    } else {
                        for ($i = 0; $i < $nrows; $i++) {
                        ?>
                            <div class="autogrow" id="avis">
                                <hr style="width: 100%; height: 2px; margin:5px 0 5px 0;" />
                    <?php echo $db->sql_result($sql, $i); ?>
                            </div>
<?php
                        }
                    }
?>
                </div>
            </div>
            <div id="nav">
                <div id="a-menu">
                    <a href="scripts/php/saldos.php">Saldo</a>
                    <a href="scripts/php/recargas.php">Recarga Electrónica</a>
                    <a href="scripts/php/depositos.php">Compras</a>
                    <a href="scripts/php/ventasComercio.php">Ventas</a>
                    <!--<a href="scripts/php/comisionComercio.php">Comisiones</a>-->
                    <a href="scripts/php/agentes.php">Mi Red</a>
                    <a href="scripts/php/cajeros.php">Cajeros</a>
                    <a href="scripts/php/perfil.php">Perfil</a>
                </div>
                <a href="scripts/php/logout.php" style="float:right; font-size:18px; color:#000;">Salir</a>
            </div>
            <div id="body">
                <div id="left">
                    <ul>
                        <li>
                            Reporta problemas del funcionamiento del portal en:
                        </li>
                        <li>
                            <a href="mailto:soporte@syrec.com.mx" target="_blank">soporte@syrec.com.mx</a>
                        </li>
                    </ul>
                    <h1>Bancos</h1>
                    <ul>
                        <li><u>Depósitos en efectivo</u> a nombre de: <strong>Servicios Eficientes de Administración Electrónica SA de CV :</strong></li>
                    </ul>
                    <h2>BANCOMER BBVA:</h2>
                    <ul>
                        <li>
                            <strong>CTA: </strong>0178547882
                        </li>
                    </ul>
                    <h2>HSBC:</h2>
                    <ul>
                        <li>
                            <strong>CTA: </strong>4050215722
                        </li>
                    </ul>
                    <hr/>
                    <ul>
                        <li><u>Transferencias, <label style="color:red; font-weight: bold;">NO EFECTIVO</label></u>, a la cuenta: <strong>Servicios y Recargas Electrónicas S de RL</strong></li>
                    </ul>
                    <h2>HSBC:</h2>
                    <ul>
                        <li><strong>CTA: </strong> 4046971396</li>
                        <li><strong>CLABE: </strong> 021680040469713960</li>
                    </ul>
                    <h1>Horario</h1>
                    <h2>Sus depósitos serán aplicados en el siguiente horario:</h2>
                    <ul>
                        <li>
                            Lun-Vie
                        </li>
                        <li>
                            09:00-18:00 HRS
                        </li>
                        <li>
                            Sábado
                        </li>
                        <li>
                            09:00-12:45 HRS
                        </li>
                    </ul>
                    <h1>
                        Manuales
                    </h1>
                    <ul>
                        <li>
                            <a href="ManualComercios.pdf" target="_blank">Manual PC</a>
                        </li>
                        <li>
                            <a href="Manualderecargascelular.pdf" target="_blank">Manual Celular</a>
                        </li>
                    </ul>
                    <h2>NOTA</h2>
                    <ul>
                        <li>
                            Guarda el archivo en tu computadora
                        </li>
                        <li>
                            Necesitas AcrobarReader u otro similar para visualizar el archivo
                        </li>
                    </ul>
                </div>
                <div id="right">
                    <div id="contenedor" align="center">
                        <table id="saldos">
                        </table>
                        <div id="pager">
                        </div>
                        <h1>Bienvenido</h1>
                        <p>
                            Este es el sistema de ventas, desde este sitio podrás realizar ventas de TELCEL, MOVISTAR, IUSACELL o UNEFON y consultar el estado de tu saldo y tus ganancias
                        </p>
                    </div>
                </div>
                <div id="down">
                    <p>
                        <strong>Servicios y Recargas Electrónicas S. de R.L.</strong>
                        <br/>
                        <br/>
                        Luis Vega y Monroy 703-5, Plazas del Sol Querétaro, Qro; TEL (442)-22-35-620
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
                }
            }
?>
