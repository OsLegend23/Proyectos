<div style='display:none'><!-- -->
    <div class='contact-top'>
    </div>
    <div align="center" class='contact-content'>
    	<h1 class='contact-title'>DATOS DEL CAJERO</h1>
        <div class='contact-loading' style='display:none'>
        </div>
        <div class='contact-message' style='display:none'>
        </div>
        <form action="registrarCajero.php" method="post" style='display:none' ><!---->
            <table align="center" cellspacing="1" class="tablesorter">
                <thead>
                    <tr>
                        <th colspan="8" align="center">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Nombre:</strong>
                        </td>
                        <td colspan="7" align="left">
                            <input name="nombre" type="text" id="nombre" size="56" maxlength="100" onkeyup="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" />
                        </td>
                    </tr>
					<tr>
                        <td>
                            <strong>Correo Elctr&oacute;nico: </strong>
                        </td>
                        <td colspan="7" align="left">
                            <input name="email" type="text" id="email" size="56" maxlength="100" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Tel&eacute;fono:</strong>
                        </td>
                        <td colspan="7" align="left">
                            <input name="phone" type="text" id="phone" size="10" maxlength="10" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Celular:</strong>
                        </td>
                        <td colspan="7" align="left">
                            <input name="celular" type="text" id="celular" size="10" maxlength="10" />
                        </td>
                    </tr>
                    <!--<tr>
                        <td>
                            <strong>Hora de entrada: </strong>
                        </td>
                        <td colspan="7" align="left">
                            <input name="entrada" type="text" id="entrada" value="00:01" size="10" maxlength="5" />&nbsp;<em>E. 00:01</em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Hora de Salida: </strong>
                        </td>
                        <td colspan="7" align="left">
                            <input name="salida" type="text" id="salida" value="23:59" size="10" maxlength="5" />&nbsp;<em>E. 23:59 </em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Dias de labores: </strong>
                        </td>
                        <td align="center" valign="top">
                            <input name="semana[do]" type="checkbox" id="do" value="1" />D
                        </td>
                        <td align="center" valign="top">
                            <input name="semana[lu]" type="checkbox" id="lu" value="1" />L
                        </td>
                        <td align="center" valign="top">
                            <input name="semana[ma]" type="checkbox" id="ma" value="1" />M
                        </td>
                        <td align="center" valign="top">
                            <input name="semana[mi]" type="checkbox" id="mi" value="1" />M
                        </td>
                        <td align="center" valign="top">
                            <input name="semana[ju]" type="checkbox" id="ju" value="1" />J
                        </td>
                        <td align="center" valign="top">
                            <input name="semana[vi]" type="checkbox" id="vi" value="1" />V
                        </td>
                        <td align="center" valign="top">
                            <input name="semana[sa]" type="checkbox" id="sa" value="1" />S
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Cajero: </strong>
                        </td>
                        <td colspan="7" align="left" valign="top">
                            <input name="cajero" type="text" id="cajero" size="15" maxlength="15" onkeyup="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" />
                        </td>
                    </tr>-->
                    <tr>
                        <td colspan="8" align="center">
                            <input name="Guardar" type="submit" class='contact-send contact-button' value="Registrar Cajero" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div class='contact-bottom'>
    </div>
</div>
