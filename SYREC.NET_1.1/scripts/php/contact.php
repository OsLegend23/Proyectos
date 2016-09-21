<?php

/*
 * SimpleModal Contact Form
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2009 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: contact-dist.php 204 2009-06-09 22:43:28Z emartin24 $
 *
 */

// User settings
$to = "correo@dominio.com";
$subject = "SimpleModal Contact Form";

// Include extra form fields and/or submitter data?
// false = do not include
$extra = array(
	"form_subject"	=> true,
	"form_cc"		=> true,
	"ip"				=> true,
	"user_agent"	=> true
);

// Process
$action = isset($_POST["action"]) ? $_POST["action"] : "";
if (empty($action)) {
	// Send back the contact form HTML
	$output = "<div style='display:none'>
	<div class='contact-top'></div>
	<div class='contact-content'>
		<h1 class='contact-title'>Alta Cliente</h1>
		<div class='contact-loading' style='display:none'></div>
		<div class='contact-message' style='display:none'></div>
		<form action='#' style='display:none'>
			<label for='contact-name'>*Nombre Comercial:</label>
			<input type='text' id='nombre-comercial' class='contact-input' name='NombreComercial' tabindex='1001' />
			<label for='contact-name'>*Responsable:</label>
			<input type='text' id='responsable' class='contact-input' name='NombredelResponsable' tabindex='1002' />
			<label for='contact-email'>*E-mail:</label>
			<input type='text' id='email' class='contact-input' name='Email' tabindex='1003' />
			<label for='contact-name'>*Tel&eacute;fono Fijo:</label>
			<input type='text' id='telefono-fijo' class='contact-input' name='TelefonoFijo' tabindex='1004' maxlength='10' />
			<label for='contact-name'>*Tel&eacute;fono Movil:</label>
			<input type='text' id='telefono-movil' class='contact-input' name='TelefonoCelular' tabindex='1005' maxlength='10' />
			<label for='contact-name'>*Direcci&oacute;n:</label>
			<input type='text' id='domicilio' class='contact-input' name='Direccion' tabindex='1006' />
			<label for='contact-name'>*Colonia:</label>
			<input type='text' id='colonia' class='contact-input' name='Colonia' tabindex='1007' />
			<label for='contact-name'>*Ciudad:</label>
			<input type='text' id='ciudad' class='contact-input' name='Ciudad' tabindex='1008' />
			<label for='contact-name'>*Estado:</label>
			<input type='text' id='estado' class='contact-input' name='Estado' tabindex='1009' />
			<label for='contact-name'>*C&oacute;digo Postal:</label>
			<input type='text' id='codigo-postal' class='contact-input' name='CdigoPostal' tabindex='1010' maxlength='5' />
			<label>&nbsp;</label>
			<button type='submit' class='contact-send contact-button' tabindex='1006'>Enviar</button>
			<br/>
			<input type='hidden' name='token' value='registrar'/>
		</form>
	</div>
	<div class='contact-bottom'></div>
</div>";

	echo $output;
}
else if ($action == "registrar") {
	// Send the email
	$name = isset($_POST["name"]) ? $_POST["name"] : "";
	$email = isset($_POST["email"]) ? $_POST["email"] : "";
	$subject = isset($_POST["subject"]) ? $_POST["subject"] : $subject;
	$message = isset($_POST["message"]) ? $_POST["message"] : "";
	$cc = isset($_POST["cc"]) ? $_POST["cc"] : "";
	$token = isset($_POST["token"]) ? $_POST["token"] : "";

	// make sure the token matches
	if ($token === smcf_token($to)) {
		smcf_send($name, $email, $subject, $message, $cc);
		echo "Tu mensaje se ha enviado satisfactoriamente.";
	}
	else {
		echo "Error enviando el mensaje. Vuelve a intentarlo.";
	}
}

function smcf_token($s) {
	return md5("smcf-" . $s . date("WY"));
}

// Validate and send email
function smcf_send($name, $email, $subject, $message, $cc) {
	global $to, $extra;

	// Filter and validate fields
	$name = smcf_filter($name);
	$subject = smcf_filter($subject);
	$email = smcf_filter($email);
	if (!smcf_validate_email($email)) {
		$subject .= " - invalid email";
		$message .= "\n\nBad email: $email";
		$email = $to;
		$cc = 0; // do not CC "sender"
	}

	// Add additional info to the message
	if ($extra["ip"]) {
		$message .= "\n\nIP: " . $_SERVER["REMOTE_ADDR"];
	}
	if ($extra["user_agent"]) {
		$message .= "\n\nUSER AGENT: " . $_SERVER["HTTP_USER_AGENT"];
	}

	// Set and wordwrap message body
	$body = "De: $name\n\n";
	$body .= "Mensaje: $message";
	$body = wordwrap($body, 70);

	// Build header
	$headers = "De: $email\n";
	if ($cc == 1) {
		$headers .= "Cc: $email\n";
	}
	$headers .= "X-Mailer: PHP/SimpleModalContactForm";

	// UTF-8
	if (function_exists('mb_encode_mimeheader')) {
		$subject = mb_encode_mimeheader($subject, "UTF-8", "B", "\n");
	}
	else {
		// you need to enable mb_encode_mimeheader or risk 
		// getting emails that are not UTF-8 encoded
	}
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/plain; charset=utf-8\n";
	$headers .= "Content-Transfer-Encoding: quoted-printable\n";

	// Send email
	@mail($to, $subject, $body, $headers) or 
		die("Unfortunately, a server issue prevented delivery of your message.");
}

// Remove any un-safe values to prevent email injection
function smcf_filter($value) {
	$pattern = array("/\n/","/\r/","/content-type:/i","/to:/i", "/from:/i", "/cc:/i");
	$value = preg_replace($pattern, "", $value);
	return $value;
}

// Validate email address format in case client-side validation "fails"
function smcf_validate_email($email) {
	$at = strrpos($email, "@");

	// Make sure the at (@) sybmol exists and  
	// it is not the first or last character
	if ($at && ($at < 1 || ($at + 1) == strlen($email)))
		return false;

	// Make sure there aren't multiple periods together
	if (preg_match("/(\.{2,})/", $email))
		return false;

	// Break up the local and domain portions
	$local = substr($email, 0, $at);
	$domain = substr($email, $at + 1);


	// Check lengths
	$locLen = strlen($local);
	$domLen = strlen($domain);
	if ($locLen < 1 || $locLen > 64 || $domLen < 4 || $domLen > 255)
		return false;

	// Make sure local and domain don't start with or end with a period
	if (preg_match("/(^\.|\.$)/", $local) || preg_match("/(^\.|\.$)/", $domain))
		return false;

	// Check for quoted-string addresses
	// Since almost anything is allowed in a quoted-string address,
	// we're just going to let them go through
	if (!preg_match('/^"(.+)"$/', $local)) {
		// It's a dot-string address...check for valid characters
		if (!preg_match('/^[-a-zA-Z0-9!#$%*\/?|^{}`~&\'+=_\.]*$/', $local))
			return false;
	}

	// Make sure domain contains only valid characters and at least one period
	if (!preg_match("/^[-a-zA-Z0-9\.]*$/", $domain) || !strpos($domain, "."))
		return false;	

	return true;
}

exit;

?>