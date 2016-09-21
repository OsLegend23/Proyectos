<?php
//ini_set('session.save_path', '/home/syrec/tmp_session/');
session_start();
date_default_timezone_set('America/Mexico_City');
include 'scripts/php/conexion.php';
if (empty($_SESSION['l_usr'])) {
    header("Location: index.php");
} else {
    $db = new Conexion;
    $db->sql_connect();
    $id = $_SESSION['l_usr'];
    $perfil = $db->sql_result($db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = $id"), 0);
    if ($perfil == 1) {
        header("Location: administracion.php");
    } elseif ($perfil == 3) {
        header("Location: comercio.php");
    } elseif ($perfil == 4) {
        header("Location: cajero.php");
    } else {
        $hoy = date('Y-m-d');
        $sql = $db->sql_query("SELECT aviso FROM avisos ORDER BY fechaPublicacion DESC LIMIT 3");
        /* $saldo_inicial = $db->sql_result($db->sql_query("SELECT saldo_inicial FROM usuarios WHERE idUsuario = $id"), 0);
          $compras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras WHERE idUsuario = $id AND DATE(fecha)<='$hoy'"), 0);
          $ventas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE relaciones.idUsuarioHijo = ventas.idUsuario AND relaciones.idUsuarioPadre = $id AND DATE(fecha)<='$hoy'"), 0);
          $comisiones = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE idUsuario = $id AND DATE(fecha)<='$hoy'"), 0);
          $cargos = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM cargos WHERE cargos.idUsuario = $id AND DATE(fecha)<='$hoy'"), 0);
          $saldo_actual = ($compras+$comisiones)-($ventas+$cagos);
          $db->sql_query("UPDATE saldos SET saldoActual = $saldo_actual, fecha = NOW() WHERE idUsuario = $id"); */
?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <link rel="shortcut icon" href="images/favicon.ico" />
                <title>.::SYREC-ADMIN::.</title>
                <!--Estilos-->
                <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
                <link type="text/css" rel="stylesheet" media="screen" href="css/smoothness/jquery-ui-1.8.1.custom.css" />
                <link type="text/css" rel="stylesheet" media="screen" href="css/ui.jqgrid.css"/>
                <link type="text/css" rel="stylesheet" href="css/contact.css" />
                <!--Scripts-->
                <script type="text/javascript" src="scripts/js/jquery-1.4.1.min.js">
                </script>
                <script type="text/javascript" language="JavaScript" src="scripts/js/jquery-1.4.2.min.js">
                </script>
                <script type="text/javascript" language="JavaScript" src="scripts/js/i18n/grid.locale-sp.js">
                </script>
                <script type="text/javascript" language="JavaScript" src="scripts/js/jquery.jqGrid.min.js">
                </script>
                <script type="text/javascript" language="JavaScript" src="scripts/js/jquery-ui-1.8.1.custom.min.js">
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
                <script type="text/javascript" src="scripts/js/nicEdit.js">
                </script>
            </head>
            <body>
                <div id="pack">
                    <div id="head">
                        <div id="text">
                            <h1><em><?php echo utf8_encode($_SESSION['l_nombre']); ?></em></h1>
                            <h2>Bienvenido</h2>
                        </div>
                        <div id="avisos">
                            <div align="center">
                                <h2 style="color:#f16839;">AVISOS</h2>
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
                            <p>
                                <hr style="width: 100%; height: 2px; margin:5px 0 5px 0;"/>
                    <?php echo $db->sql_result($sql, $i); ?>
                            </p>
<?php
                        }
                    }
?>
                </div><img alt="head" src="images/logo_syrec.png" />
            </div>
            <div id="nav">
                <div id="a-menu">
                    <a href="scripts/php/saldos.php">Saldos</a>
                    <a href="scripts/php/clientes.php">Directorio Comercios</a>
                    <a href="scripts/php/clientesDeshabilitados.php">Comercios Deshabilitados</a>
                    <a href="scripts/php/saldosClientes.php">Saldos Comercios</a>
                    <a href="scripts/php/depositos.php">Depósitos</a>
                    <a href="scripts/php/reportes.php">Reportes</a>
                    <a href="scripts/php/avisos.php">Anuncios</a>
                </div>
                <a href="scripts/php/logout.php" style="float:right; font-size:18px; color:#000;">Salir</a>
            </div>
            <div id="body">
                <div id="left">
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
                        <li><u>Transferencias, NO EFECTIVO</u>, a la cuenta: <strong>Servicios y Recargas Electrónicas S de RL</strong></li>
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
                </div>
                <div id="right">
                    <div id="contenedor" align="center">
                        <table id="saldos">
                        </table>
                        <div id="pager">
                        </div>
                        <h1>Bienvenido</h1>
                        <p>
                            Este es el sistema administrativo para el control de saldos y venta de tu red, desde este sitio puedes realizar transferencias a tu red, dar de alta un usuario y consultar el estado y ganancias de tu red
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
        <?php $db->sql_close(); ?>
    </body>
</html>
<?php
                }
            }
?>
