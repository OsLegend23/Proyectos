<?php
$handler = curl_init("http://unoautos.hdi.com.mx/unoautos/Emision/CotizadorEnLinea.aspx");
curl_setopt($handler,CURLOPT_USERAGENT,'Mozilla/4.0 (compatible; MSIE 6.1; Windows XP; .NET CLR 1.1.4322; .NET CLR 2.0.50727)');
$response = curl_exec($handler);
curl_close($handler);
echo $response;
?>
