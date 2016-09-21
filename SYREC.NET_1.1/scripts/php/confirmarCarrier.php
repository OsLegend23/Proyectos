<?php
ini_set('session.save_path', '/home/syrec/tmp_session/');
session_start();
$monto = $_REQUEST['monto'];
$carrier = $_REQUEST['carrier'];
$celular = $_REQUEST['celular'];
$_SESSION['monto'] = $monto;
$_SESSION['carrier'] = $carrier;
$_SESSION['celular'] = $celular;
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            table{
                border:1px solid #800000;
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
                color:#808080;
                text-align:center;
            }
            table, tr, td{
                border:1px solid #800000;
                border-collapse:collapse;
                padding:5px;
                vertical-align:middle;
                font-size:22px;
            }
            th{
                border:1px solid #800000;
                background:url(../../images/style1_bg.gif) #FFF top repeat-x;
            }
        </style>
    </head>
    <body>
        <div align="center">
            <form action="reload.php" method="post">
                <table width="70%" border="0">
                    <thead>
                        <tr>
                            <th>Carrier</th>
                            <th>Celular</th>
                            <th>Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo $carrier; ?>
                            </td>
                            <td>
                                <?php echo $celular; ?>
                            </td>
                            <td>
								$ <?php echo $monto; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" value="Send"><label>Enviar Recarga</label></button>
                <button type="button" value="return" onclick="history.back();"><label>Regresar</label></button>
            </form>
        </div>
    </body>
</html>