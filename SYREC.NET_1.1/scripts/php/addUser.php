<div style='display:none'>
    <div class='contact-top'>
    </div>
    <div class='contact-content'>
        <h1 class='contact-title'>Alta Cliente</h1>
        <div class='contact-loading' style='display:none'>
        </div>
        <div class='contact-message' style='display:none'>
        </div>
        <form action='#' style='display:none'>
            <label for='contact-name'>
                *Nombre Comercial:
            </label>
            <input type='text' id='nombre-comercial' class='contact-input' name='NombreComercial' onkeyup="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" />
            <label for='contact-name'>
                *Responsable:
            </label>
            <input type='text' id='responsable' class='contact-input' name='NombredelResponsable' onkeyup="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" />
            <label for='contact-email'>
                *E-mail:
            </label>
            <input type='text' id='email' class='contact-input' name='Email' />
            <label for='contact-name'>
                *Tel&eacute;fono Fijo:
            </label>
            <input type='text' id='telefono-fijo' class='contact-input' name='TelefonoFijo' maxlength='10' />
            <label for='contact-name'>
                *Tel&eacute;fono Movil:
            </label>
            <input type='text' id='telefono-movil' class='contact-input' name='TelefonoCelular' maxlength='10' />
            <label for='contact-name'>
                *Direcci&oacute;n:
            </label>
            <input type='text' id='domicilio' class='contact-input' name='Direccion' onkeyup="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" />
            <label for='contact-name'>
                *Colonia:
            </label>
            <input type='text' id='colonia' class='contact-input' name='Colonia' onkeyup="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" />
            <label for='contact-name'>
                *Ciudad:
            </label>
            <input type='text' id='ciudad' class='contact-input' name='Ciudad' onkeyup="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" />
            <label for='contact-name'>
                *Estado:
            </label>
            <input type='text' id='estado' class='contact-input' name='Estado' onkeyup="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" />
            <label for='contact-name'>
                *C&oacute;digo Postal:
            </label>
            <input type='text' id='codigo-postal' class='contact-input' name='CdigoPostal' maxlength='5' />
			<label for='contact-name'>
                *RFC:
            </label>
            <input type='text' id='rfc' class='contact-input' name='rfc' onkeyup="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" value="---" />
			<label for='contact-name'>
                *Giro:
            </label>
            <input type='text' id='giro' class='contact-input' name='giro' onkeyup="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" />
			<label for='contact-name'>
                *Agente:
            </label>
            <input type='text' id='agente' class='contact-input' name='agente' onkeyup="this.value=this.value.toUpperCase();" style="text-transform:uppercase;" />
			<button type='submit' class='contact-send contact-button'>
                Enviar
            </button>
            <br/>
            <input type='hidden' name='token' value='registrar'/>
        </form>
    </div>
    <div class='contact-bottom'>
    </div>
</div>
