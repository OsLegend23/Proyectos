<?php 

$subject = "Bienvenido a SYREC";
$message = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bienvenida</title>
</head>

<body>
<p>Bienvenid@<br>
  Gracias por hacer de SYREC tu portal de recargas. Ahora podr&aacute;s vender&nbsp; recargas de Telcel, Movistar, Iusacell y Unef&oacute;n desde cualquier ciudad a cualquier destino y monto, desde una PC con internet o desde un celular Telcel. <br>
  Para poder empezar entra en <a href="http://www.syrec.net">http://www.syrec.net </a>con tu usuario y contrase&ntilde;a y al portal wap <a href="http://wap.syrec.net">http://wap.syrec.net</a> con su contrase&ntilde;a:
</p>
<ul>
  <li><strong>Usuario: '.$_REQUEST['Email'].'</strong></li>
  <li><strong>Contrase&ntilde;a: '.$pass.'</strong></li>
  <li><strong>Usuario Movil: '.$userMovil.'</strong></li>
  <li><strong>Contrase&ntilde;a Movil: '.$passmovil.'</strong></li>
</ul>
<p>Es importante no dar a conocer a nadie esos datos, porque son el medio de acceso a tu saldo. </p>
<strong>Gracias nuevamente por permitirnos ser tus socios de negocios</strong>
</body>
</html>';
$to = $_POST['Email'];
$subject = "Bienvenido";
$headers = "MIME-Version: 1.0\r \n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r \n"; 
$headers .= "Reply-To: \"Abonocel\" <kain_raziel_lok@hotmail.com>\r \n"; 
$headers .= "X-Priority: 3\r \n"; 
$headers .= "X-MSMail-Priority: High\r \n"; 
$headers .= "X-Mailer:  Abonocel";
mail($to,$subject,$message,$headers);
?>
