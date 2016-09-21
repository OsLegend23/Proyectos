(function($) {
    $.fn.validationEngineLanguage = function() {};
    $.validationEngineLanguage = {
        newLang: function() {
            $.validationEngineLanguage.allRules = 	{
                "required":{    			// Add your regex rules here, you can take telephone as an example
                    "regex":"none",
                    "alertText":"* Este campo es requerido",
                    "alertTextOk":"* OK",
                    "alertTextCheckboxMultiple":"* Por favor seleccione una opci�n",
                    "alertTextCheckboxe":"* Este checkbox requerido"
                },
                "length":{
                    "regex":"none",
                    "alertText":"*Entre ",
                    "alertText2":" y ",
                    "alertText3": " caracteres permitidos"
                },
                "maxCheckbox":{
                    "regex":"none",
                    "alertText":"* Checks allowed Exceeded"
                },
                "minCheckbox":{
                    "regex":"none",
                    "alertText":"* Por favor escoja ",
                    "alertText2":" opciones"
                },
                "confirm":{
                    "regex":"none",
                    "alertText":"* El campo no coincide con el anterior"
                },
                "telephone":{
                    "regex":"/^[0-9\-\(\)\ ]+$/",
                    "alertText":"* N�mero de Tel�fono Inv�lido"
                },
                "email":{
                    "regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/",
                    "alertText":"* Direcci�n de Correo Electr�nico Inv�lido"
                },
                "date":{
                    "regex":"/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/",
                    "alertText":"* Fecha Inv�lida, debe estar en este formato YYYY-MM-DD"
                },
                "onlyNumber":{
                    "regex":"/^[0-9\ ]+$/",
                    "alertText":"* N�mero Solamente"
                },
                "noSpecialCaracters":{
                    "regex":"/^[0-9a-zA-Z]+$/",
                    "alertText":"* Carateres especiales no permitidos"
                },
                "ajaxUser":{
                    "file":"validateUser.php",
                    "extraData":"name=eric",
                    "alertTextOk":"* Este usuario est� disponible",
                    "alertTextLoad":"* Cargando, por favor espere",
                    "alertText":"* Este usuario ya est� en uso"
                },
                "ajaxName":{
                    "file":"validateUser.php",
                    "alertText":"* Este nombre ya est� en uso",
                    "alertTextOk":"* Este nombre est� disponible",
                    "alertTextLoad":"* Cargando, por favor espere"
                },
                "onlyLetter":{
                    "regex":"/^[a-zA-Z\ \']+$/",
                    "alertText":"* Letras �nicamente"
                }
            }
        }
    }
})(jQuery);

$(document).ready(function() {
    $.validationEngineLanguage.newLang()
});