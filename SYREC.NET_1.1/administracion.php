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
    if ($perfil == 2) {
        header("Location: franquiciatario.php");
    } elseif ($perfil == 3) {
        header("Location: comercio.php");
    } elseif ($perfil == 4) {
        header("Location: cajero.php");
    } else {
        $sql = $db->sql_query("SELECT idAviso, aviso FROM avisos ORDER BY fechaPublicacion DESC LIMIT 3");
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
                <link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
                <!-- IE 6 "fixes" -->
                <!--[if lt IE 7]>
                    <link type='text/css' href='css/basic_ie.css' rel='stylesheet' media='screen' />
                <![endif]--><!--Scripts-->
                <script type="text/javascript" language="JavaScript" src="scripts/js/jquery-1.4.2.min.js"></script>
                <script type="text/javascript" language="JavaScript" src="scripts/js/i18n/grid.locale-sp.js"></script>
                <script type="text/javascript" language="JavaScript" src="scripts/js/jquery.jqGrid.min.js"></script>
                <script type="text/javascript" language="JavaScript" src="scripts/js/jquery-ui-1.8.1.custom.min.js"></script>
                <script type="text/javascript" language="JavaScript" src="scripts/js/jquery.simplemodal.js"></script>
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
                <script type="text/javascript">
                    jQuery(function($){
                        $('.autogrow .editar').click(function(e){
                            var idAviso = $(this).attr('id');
                            $.modal('<iframe src="scripts/php/editaAviso.php?idAviso=' + idAviso + '" height="300" width="655" scrolling="no" style="border:0">', {
                                containerCss: {
                                    height: 305,
                                    padding: 5,
                                    width: 662

                                }
                            });
                            return false;
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
                                while ($row = $db->sql_fetch_array($sql)) {
                            ?>
                            <div class="autogrow">
                                <hr style="width: 100%; height: 2px; margin:5px 0 5px 0;"/><a href="" id="<?php echo $row[idAviso]; ?>" class="editar" style="float:right; font-size:x-small; top:10px;">Editar</a>
                                <?php echo $row[aviso]; ?>
                            </div>
                            <?php
                                }
                            }
                            ?>
                </div>
                <img alt="head" src="images/logo_syrec.png" />
            </div>
            <div id="nav">
                <div id="a-menu">
                    <a href="scripts/php/saldos.php">Saldos</a>
                    <a href="scripts/php/clientes.php">Directorio Franquicias</a>
                    <a href="scripts/php/clientesDeshabilitados.php">Franquicias Deshabilitadas</a>
                    <a href="scripts/php/saldosClientes.php">Saldos Franquicias</a>
                    <a href="scripts/php/depositos.php">Depósitos</a>
                    <a href="scripts/php/reportes.php">Reportes</a>
                    <a href="scripts/php/avisos.php">Avisos</a>
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
