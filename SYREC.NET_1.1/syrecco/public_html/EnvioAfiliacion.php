<?php
header("Content-type: text/html;charset=utf-8");
include 'scripts/php/FPDF/fpdf.php';
require("scripts/php/PHPMailer_v5.1/class.phpmailer.php");

$NombreComercial = utf8_decode($_REQUEST['name']);
$Responsabel = utf8_decode($_REQUEST['responsable']);
$Mail = $_REQUEST['mail'];
$Phone = $_REQUEST['phone'];
$Cellphone = $_REQUEST['cellphone'];
$Address = utf8_decode($_REQUEST['address']);
$Colony = utf8_decode($_REQUEST['colony']);
$City = utf8_decode($_REQUEST['city']);
$State = utf8_decode($_REQUEST['state']);
$ZipCode = $_REQUEST['zipcode'];
$RFC = $_REQUEST['rfc'];
$Giro = utf8_decode($_REQUEST['giro']);
$Agent = utf8_decode($_REQUEST['Agent']);
$Card = $_FILES['Card']['name'];
$TCard = $_FILES['Card']['tmp_name'];
$Comprobante = $_FILES['comprobante']['name'];
$TComprobante = $_FILES['comprobante']['tmp_name'];

$pdf = new FPDF();
$pdf->AddPage('P', 'A4');
$pdf->Image('images/AfiliacionTira.jpg', null, 10, 30, 275);
$pdf->Image('images/TiraDatos.jpg', 45, 15, 155);
$pdf->Image('images/TiraInstrucciones.jpg', 45, 170, 155);
$pdf->Image('images/Tarjeta.jpg', 120, 240, '80%');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 50, 'Nombre Comercial: ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 50, "$NombreComercial", 0, 0, 'L');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 60, 'Responsable: ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 60, "$Responsabel");
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 70, 'Email: ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 70, "$Mail");
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 80, utf8_decode('Teléfono Fijo: '), 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 80, "$Phone");
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 90, utf8_decode('Teléfono Móvil: '), 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 90, "$Cellphone");
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 100, utf8_decode('Dirección: '), 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 100, "$Address");
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 110, 'Colonia: ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 110, "$Colony");
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 120, 'Ciudad: ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 120, "$City");
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 130, 'Estado: ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 130, "$State");
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 140, utf8_decode('Código Postal: '), 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 140, "$ZipCode");
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 150, 'RFC: ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 150, "$RFC");
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 160, 'Giro: ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 160, "$Giro");
$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90);
$pdf->Cell(10, 170, 'Agente: ', 0, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 170, "$Agent");
$pdf->Ln(115);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(34);
$pdf->MultiCell(0, 5, utf8_decode("Envía este formato adjuntando identificación y comprobante de domicilio a ventas@syrec.com.mx\nEn un máximo de 3 horas hábiles el comercio recibirá vía mail sus claves para ingresar al portal donde podrá descargar los manuales de uso (PC o Celular) y ver de manera permanente las cuentas bancarias corporativas para realizar sus compras de saldo."));

$mail = new PHPMailer();
$doc = $pdf->Output('', 'S');
$mail->Host = "syrec.net";
$mail->From = $Mail;
$mail->FromName = utf8_decode("Formato de Afiliación");
$mail->Subject = utf8_decode("Afiliación");
$mail->AddAddress("ventas@syrec.com.mx");
$mail->AddStringAttachment($doc, 'Afiliacion.pdf', 'base64', 'application/pdf');
$mail->AddAttachment($TCard, $Card);
$mail->AddAttachment($TComprobante, $Comprobante);

$body = "<strong>Mensaje</strong><br><br>";
$body.= "Se ha enviado una solicitud de afiliaci&oacute;n.<br>";
$body.= "<i>Enviado por http://www.syrec.com.mx</i>";
$mail->Body = $body;
$mail->IsHTML(true);
if ($mail->Send()) {
    echo "<script type = 'text/javascript'>
			alert('El correo se ha enviado satifactoriamente');
			history.back();
		 </script>";;
} else {
    echo "<script type = 'text/javascript'>
			alert('Hubo un fallo al enviar el correo, por favor, pruebe de nuevo');
			history.back();
		 </script>";;
}
?>