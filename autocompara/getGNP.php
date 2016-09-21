<?php
include "lib/nusoap/nusoap.php";

$client = new nusoap_client('http://gnpventamasiva.com.mx/WsAutos/CotizadorGNP.asmx?WSDL', true);

$sError = $client->getError();
if($sError)
    print_r($sError);


$getAuto = "<SolicitudCatalogo>
	<Catalogo>
		<Usuario>MI_AGENTE</Usuario>
		<Password>MIAGENTEWsPer</Password>
		<Tipo>marcas</Tipo>
		<Parametro1>509</Parametro1>
		<Parametro2>AUT</Parametro2>
		<Parametro3></Parametro3>
		<Parametro4></Parametro4>
		<Parametro5></Parametro5>
		<Parametro6></Parametro6>
	</Catalogo>
</SolicitudCatalogo>";

$getRC = "<Solicitud>
	<General>
		<Usuario>MI_AGENTE</Usuario>
		<Password>MIAGENTEWsPer</Password>
		<CodigoPromocion>MIAGENTE_LN</CodigoPromocion>
		<Tienda>0</Tienda>
		<OpcionesAContratar>Limitada y RC LN MIAGENTE</OpcionesAContratar>
		<Paquete>RC</Paquete>
		<FormaPago>Semestral</FormaPago>
		<MetodoPago>I</MetodoPago>
		<InicioVig>04/09/2013</InicioVig>Fecha Actual del Sistema
		<FinVig>04/09/2014</FinVig>Cobertura de un año
		<Accion>C</Accion>
		<Cotizacion/>
		<descuentoGC>0</descuentoGC>
		<cesioncomision>0</cesioncomision>
		<primerrecibo>IN</primerrecibo>
		<recibosubsecuente>IN</recibosubsecuente>
		<CodigoIntermediario>0067807001</CodigoIntermediario>
		<CodigoCliente></CodigoCliente>
		<TipoPago/>
		<ValVehi>0</ValVehi>
		<PrimaTotal>0</PrimaTotal>
	</General>
	<Autos>
		<Auto>
			<EstadoCirculacion>08</EstadoCirculacion>
			<Uso></Uso>
			<ClaveMarca>AUTFR1257</ClaveMarca>
			<Marca>FORD</Marca>
			<Modelo>2012</Modelo>
			<Descripcion>FORD MUSTANG SHELBY CONVERTIBLE</Descripcion>
			<Motor></Motor>
			<Serie></Serie>
			<Placas></Placas>
		</Auto>
	</Autos>
</Solicitud>";


$getResponse = $client->call("ObtenerCatalogo", array('mixml'=>$getAuto));
//$getResponse = $client->call("Cotizar", array('mixml'=>$getRC));
if ($client->fault) {
	print_r($client->fault);
}else{
	$sError = $client->getError();
}
$getData = array();
$getData = $getResponse;
echo '<pre>';
print_r($getResponse);
//print_r($getResponse['ObtenerCatalogoResult']['Catalogo']['Elemento']);
echo '</pre>';

?>