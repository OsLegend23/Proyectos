<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
include 'conexion.php';
$db = new Conexion;
$db->sql_connect();

$idAviso = $_GET['idAviso'];
$aviso = $db->sql_result($db->sql_query("SELECT aviso FROM avisos WHERE idAviso = $idAviso"), 0);

if (isset($_POST['aviso'])) {
    $actualiza = $db->sql_query("UPDATE avisos SET aviso='" . trim($_POST[aviso]) . "' WHERE idAviso = $idAviso");
    if ($actualiza) {
        echo "<script type='text/javascript'>
				alert('Aviso Actualizado con Éxito');
				window.parent.location.href = '../../administracion.php';
			</script>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="../../images/favicon.ico" />
        <title>.::SYREC-ADMIN::.</title>
        <script type="text/javascript" src="../js/nicEdit.js">
        </script>
        <script type="text/javascript">
            bkLib.onDomLoaded(function(){
                new nicEditor({
                    fullPanel: true,
                    iconsPath: '../../images/nicEditorIcons.gif'
                }).panelInstance('aviso', {
                    hasPanel: true
                });
            });
        </script>
    </head>
    <body>
        <div style="width:652px; height:256px; background:#FFF;">
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" accept-charset="utf-8">
                <textarea name="aviso" id="aviso" style="width:650px; height:200px; ">
                    <?php echo $aviso; ?>
                </textarea>
                <button type="submit" value="Enviar">
                    <label>
                        Enviar
                    </label>
                </button>
            </form>
        </div>
    </body>
</html>
