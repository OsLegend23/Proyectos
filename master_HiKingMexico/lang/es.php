<?php
/*
Idioma Español
*/

$STR = array();

date_default_timezone_set('America/Los_Angeles');

$charset = 'utf-8';

$byteUnits = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');

$day_of_week = array('1'=>'Dom', '2'=>'Lun', '3'=>'Mar', '4'=>'Mie', '5'=>'Jue', '6'=>'Vie', '7'=>'Sab');
$day_of_weekFull = array('1'=>'Domingo', '2'=>'Lunes', '3'=>'Martes', '4'=>'Miércoles', '5'=>'Jueves', '6'=>'Viernes', '7'=>'Sábado');

$month = array('1'=>'Ene', '2'=>'Feb', '3'=>'Mar', '4'=>'Abr', '5'=>'May', '6'=>'Jun', '7'=>'Jul', '8'=>'Ago', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dic');
$monthFull = array('-1'=>'Selecciona Mes','1'=>'Enero', '2'=>'Febrero', '3'=>'Marzo', '4'=>'Abril', '5'=>'Mayo', '6'=>'Junio', '7'=>'Julio', '8'=>'Agosto', '9'=>'Septiembre', '10'=>'Octubre', '11'=>'Noviembre', '12'=>'Diciembre');

$datefmt 										= 'Y-m-d';

$STR['CurrentDate'] 					= Date('Y-m-d');
$STR['CurrentHour'] 					= Date("H:i:s");
$STR['Accept']                      			= "Aceptar";
$STR['Cancel']                      			= "Cancelar";
$STR['Yes']                         			= "Si";
$STR['No']                          			= "No";
$STR['QuestionYesNo']               			= array("S"=>$STR['Yes'],"N"=>$STR['No']);
$STR['From']                        			= "de";
$STR['Warning']                     			= "Advertencia";
$STR['Since']                       			= "Desde";
$STR['Until']                       			= "Hasta";
$STR['Add']                         			= "Agregar";
$STR['Save']                        			= "Guardar";
$STR['Validate']                    			= "Iniciar sesión";
$STR['Saving']                      			= "Guardando...";
$STR['Delete']                      			= "Eliminar";
$STR['Remove']                      			= "Remover";
$STR['Edit']                        			= "Editar";
$STR['Date']                        			= "Fecha";
$STR['Insert']                      			= "Insertar";
$STR['Return']                      			= "Regresar";
$STR['Back']                      			= "Atrás";
$STR['Search']                      			= "Buscar";
$STR['Go']                          			= "Ir";
$STR['Account']                 			= "Cuenta";
$STR['Menu']                      			= "Menú";
$STR['Config']                      			= "Configuración";
$STR['Copy']                        			= "Copiar";
$STR['Paste']                       			= "Pegar";
$STR['Loading']                     			= "Cargando...";
$STR['Deleting']                    			= "Eliminando...";
$STR['Send']                        			= "Enviar";
$STR['Option']                        			= "Opción";
$STR['Details']                     			= "Detalles";
$STR['Recover']                     			= "Recuperar";
$STR['Second']                      			= "segundo(s)";
$STR['Consult']                     			= "Consultar";
$STR['ConsultAll']                 			= "Consultar todas";
$STR['MoreInfo']                    			= "Más información";
$STR['Info']                    			= "Información";
$STR['Hello']                       			= "Hola";
$STR['CloseSession']	            			= "Cerrar sesión";
$STR['Close']	                    			= "Cerrar";
$STR['SignIn']						= "Inicia sesión";
$STR['User']						= "Correo electrónico";
$STR['Password']					= "Contraseña";
$STR['PasswordRepeat']					= "Repetir contraseña";
$STR['Captcha']						= "Caracteres de validación";
$STR['TypeChars_Msg']                      		= "Ingresa los caracteres de validación que se muestra en la imagen";
$STR['permanentEvaluationLbl']				= "Formato de solicitud de examen evaluación permanente/regularización";
$STR['Logout_Msg']                  			= "Deseas finalizar tu sesión";
$STR['Delete_Title']            			= "¿Borrar?";
$STR['Delete_Msg']                      		= "¿Seguro que deseas eliminar este registro?";
$STR['Message']						= "Mensaje";
$STR['OpenNewTab_Msg']                                  = "Esta información será mostrada en una nueva pestaña del navegador, ten en cuenta desbloquear las ventanas emergentes para este sitio.";
$STR['request']						= "Solicitud";
$STR['CreateAccount']					= "Crear cuenta";
$STR['DataNotFound_Error']            			= "Error: No se encontró registro previo.";
$STR['ValidateChars_Error']           			= "Error: Caracteres de Validación no coinciden.";
$STR['ValidatePassword_Error']        			= "Error: La contraseña no coincide.";
$STR['SQLConection_Error']                		= "Error: SQL Excepción. Intentando conectar a base de datos";
$STR['SQLAnswer_Error']        				= "Error: Respuesta invalida del servidor";
$STR['RemoteConection_Error']                           = "Error: Conexión en consulta remota no logrado";
$STR['RequiredFields_Warning']				= "Advertencia: Aun existen campos requeridos.";
$STR['LoginError_Error']                                = "Error: Correo electrónico y contraseña inválidos";
$STR['UserNotFound_Error']   				= "Error: Correo electrónico no encontrado en nuestro registros";
$STR['GenerateFile_Error']   				= "Error: No se pudo generar el archivo {fileName}";
$STR['InvalidMail_Error']				= "Correo electrónico invalido";


$STR['Enlace']						= "Enlace";
$STR['Format']						= "Formato";
$STR['Want']						= "Deseas";
$STR['PrintReport']					= "Imprimir Reporte";
$STR['AddToList']                      			= "Agregar a la lista";
$STR['Select']						= "Seleccionar";
$STR['SelectFile']					= "Seleccionar archivo";
$STR['SelectImage']					= "Seleccionar imagen";
$STR['Period']						= "Periodo";
$STR['Folio']						= "Folio";
$STR['Made']						= "Formuló";
$STR['Key']						= "Clave";
$STR['Report']						= "Reporte";
$STR['FilterBy']					= "filtrar por {FilterName}";
$STR['Status']						= "Estatus";
$STR['Comment']						= "Comentario";
$STR['Insertcomment']					= "Ingresa tu comentario";
$STR['Addedcomment']					= "Comentario agregado";
$STR['Updatedcomment']					= "Comentario actualizado";
$STR['Schedule']					= "Horario";
$STR['Redirecting']       				= "Redireccionando...";
$STR['Name(s)']						= "Nombre(s)";
$STR['UserName']					= "Nombre de usuario";
$STR['Surname(s)']					= "Apellido(s)";
$STR['Surnamematernal']					= "Apellido Materno";
$STR['Forgotyourpassword']				= "¿Has olvidado tu contraseña?";
$STR['Recoverpassword']					= "Recupera tu contraseña dando <a href='#' id='recoverpassword'>clic aquí</a>";
$STR['Permissiondenied']				= "Permiso denegado";
$STR['accountData']					= "Información para crear a tu cuenta";
$STR['SavedSuccess']					= "Guardado correctamente";
$STR['UpdatedSuccess']					= "Actualizado correctamente";
$STR['DeletedSuccess']					= "Eliminado correctamente";


$STR['Init']                                            = "Inicio";
$STR['Registry']                           		= "Regístrate";
$STR['RegisterAsCompany']	           		= "Regístrate como empresa";
$STR['ClickToCreateCompany']                            = "Para ver los beneficios que <b>hikingmexico.com</b> te ofrece.";
$STR['RegisterAsCandidate']                             = "Regístrate como postulante";
$STR['ClickToCreatePostulant']                          = "Para ver los beneficios que <b>hikingmexico.com</b> te ofrece.";
$STR['ClickHere']                    			= "Ingresa aquí ";
$STR['SearchJob']                                       = "Buscar Trabajo";
$STR['Support']                                         = "Ayuda";
$STR['AboutUs']                            		= "¿Quiénes somos?";
$STR['Contact']                      			= "Contáctanos";
$STR['T&Conditions']	                 		= "Términos y condiciones";

$STR['PrivacyLaw']                 			= "Sus datos personales están protegidos conforme a la <strong>Ley Federal De Protección De Datos Personales En Posesión De Los Particulares.</strong>";
$STR['PrivacyPolitic']             			= "Política de Privacidad";
$STR['SeePrivacyPolitic']          			= "Consulte el aviso de Privacidad";

$STR['Page']                                            = "Página";
$STR['MoreInfo']                                        = "Más información";
$STR['Hello']                                           = "Hola";
$STR['CV']                                              = "Currículum";
$STR['Photo']                                           = "Fotografía";
$STR['Charge']                                          = "Cargar";
$STR['Upload']                                          = "Publicar";
$STR['UploadCompanyLogo']                               = "Publicar Logo de Empresa";
$STR['Correct']                                         = "Correcto";
$STR['InsufficientInfo']                                = "Información insuficiente";
$STR['InsufficientSectorToWork']                        = "Falta sector donde deseas laborar";
$STR['InsufficientExpectatives']                        = "Falta expectativas";
$STR['Logo']                                            = "Logo";
$STR['SelectLogo']                                      = "Seleccionar logo";
$STR['SelectPicture']                                   = "Seleccionar fotografía";
$STR['AddToList']                                       = "Agregar a la lista";
$STR['Twitter']                      			= "Síguenos en Twitter";
$STR['TwitterLink']                                     = "hikingmexico";
$STR['FaceBook']                      			= "Síguenos en FaceBook";
$STR['FaceBookLink']                                    = "hikingmexico";
$STR['Month']                                           = "Mes";
$STR['MonedaMonth']                                     = "Mensual";
$STR['Moneda']                                          = "M.N. ".$STR['MonedaMonth'];
$STR['Year']                                            = "Año";
$STR['Years']                                           = "Años";
$STR['SelectMonth']                                     = "Seleccionar Mes";
$STR['SelectYear']                                      = "Seleccionar Año";
$STR['RecentVacancy']                                   = "Vacantes recientes";
$STR['VacancyByArea']                           = "Vacantes por área";
$STR['SearchVacancy']                           = "Búsqueda de vacantes";
$STR['NoRecentVacancy']                         = "No existen vacantes recientes";
$STR['FieldsNeededComment']                     = "Los campos con (*) son obligatorios";
$STR['CompleteTime']                            = "Tiempo completo";
$STR['MiddleTime']                              = "Medio tiempo";
$STR['Honorarios']                              = "Honorarios";
$STR['Temporal']                                = "Temporal";
$STR['FirstJob']                                = "¿Estas buscando tu primer trabajo?";
$STR['Visible']                                 = "Visible";
$STR['NoVisible']                               = "No Visible";
$STR['Spanish']                                 = "Español";
$STR['English']                                 = "Ingles";
$STR['InitAge']                                 = "Edad desde";
$STR['FinishAge']                               = "Edad hasta";
$STR['Onwards']                                 = "En adelante";
$STR['SelectAge']                               = "Seleccionar Edad";
$STR['NoRequired']                              = "Indistinto";
$STR['6months']                                 = "Seis meses";
$STR['1year']                                   = "Un año";
$STR['2year']                                   = "Dos años";
$STR['3year']                                   = "Tres años";
$STR['4year']                                   = "Cuatro años";
$STR['5year']                                   = "Cinco años";
$STR['SimilarJob']                              = "Puesto similar";
$STR['OutOfCountry']                            = "Ubicación fuera de México";
$STR['Msg_Insert_Success']                      = "Registro exitoso.";
$STR['Msg_Insert_DuplicateData']                = "Alerta: Se intentó registrar una vacante, cuyos datos son similares a un registro ya existente.";
$STR['Msg_SendingEmail']                        = "<p>En unos momentos recibirás un correo electrónico, sigue las instrucciones para terminar de validar el acceso a tu cuenta postulante.</p><p>Si no visualizas este correo en la bandeja de entrada, puedes revisar en la bandeja de correo no deseado</p> ";
$STR['Msg_Update_Success']                      = "Actualización exitoso.";
$STR['Msg_FormValidate_fail']                   = "Aun existen campos requeridos.";
$STR['Msg_FormValidate_fail_list']              = "Se requiere agregar por lo menos un registro en la lista";
$STR['Msg_Delete_Success']                      = "Registro borrado exitosamente.";
$STR['Msg_Query_Success']                       = "Consulta exitoso.";
$STR['Msg_IdDuplicate']                         = "Error: Se intenta duplicar ID.";
$STR['Msg_DataNotFound']                        = "Error: No se encontró registro previo.";
$STR['Msg_PostulantNoRegistred']                = "Error: No se encontró registro previo de postulante.";
$STR['Msg_CompanyNoRegistred']                  = "Error: No se encontró registro previo de Empresa.";
$STR['Msg_DuplicateEmail']                      = "Error: Correo electrónico ya ha sido registrado anteriormente.";

$STR['Msg_NoCompanyPlan_Found']                 = "Advertencia, tu cuenta no tiene activada un plan, para mas información consulta la sección de planes anuales.";
$STR['Msg_LimitPlan_Reached']                 	= "Advertencia, Has llegado al limite de tu plan, para mas información consulta la sección de planes anuales.";
$STR['Msg_ExpiredPlan']                 		= "Advertencia, tu plan de anualidad ha expirado:<div class='cleaner'></div> fecha inicio {initialPeriod}<div class='cleaner'></div> fecha de término {periodEnded} <div class='cleaner h10'></div> Para mas información consulta la sección de planes anuales.";

$STR['Msg_DuplicateCompanyEmail']               = "Error: Correo electrónico ya ha está ligado a una empresa registrada.";
$STR['Msg_DuplicateCompany']                    = "Error: Esta empresa ya se encuentra registrada.";

$STR['Msg_ValidateChars']                       = "Error: Caracteres de Validación no coinciden.";
$STR['Msg_ValidatePassword']                    = "Error: La contraseña no coincide.";
$STR['Msg_SQLError']                            = "Error: SQL Excepción. 10001";
$STR['Msg_SQLErrorResponse']                    = "Error: SQL Excepción. 10501";
$STR['Msg_WebError']                            = "Error: WEB Excepción, no se encontró respuesta del servidor";
$STR['Msg_DateError']                           = "Error: Las fechas en el periodo son invalidas.";

$STR['Msg_DateJobExperienceError']            	= "Error: el año de ingreso no concuerda con la fecha de egreso en experiencia laboral.";

$STR['Msg_MaxRegistry']                         = "Error: Limite de capturas alcanzado.";
$STR['Msg_DuplicateRegistry']                   = "Error: Se intenta duplicar el registro.";
$STR['Dear']                                    = "Estimado";
$STR['MaliSendedTo']                      		= "Correo enviado a:";
$STR['Msg_Delete_Title']                        = "Borrar...";
$STR['Msg_Delete_Dialog']                      	= "Seguro que deseas eliminar este registro?";
$STR['Msg_Confirm_Dialog_Cancel']               = "Deseas cancelar?";
$STR['Msg_Confirm_Dialog_Cancel_Txt']           = "Se perderán todos los cambios";
$STR['LoginLabel']                              = "Ingresa usuario y contraseña";
$STR['LoginUser']                               = "Usuario";
$STR['LoginPassword']                           = "Contraseña";
$STR['ConfPass']                                = "Confirmar Contraseña";
$STR['Msg_LoginError']                      	= "Error: Usuario y Contraseña inválidos";
$STR['CloseSession']                            = "Cerrar Sesión";
$STR['Close']                                   = "Cerrar";
$STR['Msg_Logout']                              = "Deseas finalizar tu sesión";
$STR['AccessHowPostulant']                      = "Como Postulante";
$STR['AccessHowCompany']                        = "Como Empresa";
$STR['CompanyAddress']                          = "Dirección";
$STR['ReferenceCode']                           = "Referencia";
$STR['Location']                                = "Ubicación";
$STR['Status']                                  = "Estatus";
$STR['Requires']                                = "Requisitos";
$STR['Gender']                                  = "Género";
$STR['MaritalStatus']                           = "Estado Civil";
$STR['LanguageRequires']                        = "Idioma";
$STR['Apply']                                   = "Postularme";
$STR['Postulate']                               = "Postular";
$STR['Print']                                   = "Vista impresión";
$STR['Share']                                   = "Compartir con un amigo";
$STR['SendByEmail']                             = "Correo electrónico";
$STR['SendToFriend']                            = "Enviar por correo electrónico";
$STR['Privacy']                                 = "Confidencialidad/Privacidad";
$STR['Maximum']                                 = "Máximo";
$STR['Postulate_Success']                       = "Tu postulación ha sido registrada exitósamente. Recuerda que puedes consultar el seguimiento de tus postulaciones dentro del módulo de administración de tu cuenta";
$STR['GoToTrackingView']						= "Puedes consultar el seguimiento de tus postulaciones aquí.";
$STR['ApplyDialog_nologged']                    = "Para poder postularte a esta vacante es necesario ingresar con tu cuenta de usuario.";
$STR['ApplyDialog_nologged2']                   = "Si no tienes una cuenta, da clic en el botón “Registrarme”.";
$STR['ApplyRegistry']                           = "Registro";
$STR['PostulationAlreadyExist']                 = "Tu postulación ya ha sido recibida con anterioridad para esta vacante";
$STR['Msg_UploadImageSuccess']                  = "Carga de imagen exitoso";
$STR['Msg_UploadImageFail']                     = "Error: Carga de imagen Fallido";
$STR['Msg_UploadImageFail_size']                = "Error: Tamaño de imagen excede limite permitido";
$STR['Msg_UploadImageFail_format']              = "Error: Formato de imagen incorrecta";
$STR['Msg_UploadFailFail_format']               = "Error: Formato de documento incorrecto";
$STR['Msg']                                     = "Mensaje";
$STR['OpenNewTab']                      		= "Esta información será mostrada en una nueva pestaña del navegador, ten en cuenta desbloquear las ventanas emergentes para este sitio. ";
$STR['PostulantList']                           = "Postulantes registrados en esta vacante";
$STR['Comments']                                = "Puedes enviarnos tus comentarios y sugerencias.";
$STR['Comment']                                 = "Comentario";
$STR['Subject']                                 = "Asunto";
$STR['Msg_Comment_Success']                     = "Tu comentario ha sido enviado correctamente.";
$STR['Msg_Comment_Fail']                      	= "Error: No se pudo registrar tu comentario, inténtalo de nuevo.";
$STR['Msg_Comment_Added']                       = "El equipo de <b>hikingmexico.com</b>, está atendiendo tus comentarios.";

$STR['Email_Postulant_registry']             	= "<p>{logo}</p> <p>Hola <strong>{userName}</strong>. <b>hikingmexico.com</b> te da la bienvenida</p><p>Recuerda utilizar tu clave de acceso para ingresar al módulo de administración:</p> <p>usuario:<strong>{userEmail}</strong></p> <p>contraseña:<strong>{password}</strong></p> <p>para ingresar a tu módulo de administración da clic <a href='{goToAdmin}'>aquí</a></p> <p> Para verificar tu dirección de correo electrónico haz clic en el siguiente enlace:<br /><br /> <a href='{linkValidation}'>{linkValidation}</a><br /><br /> Si al hacer clic en el enlace anterior no funciona, copia y pega el URL en una<br />nueva ventana del navegador.<br /> <br> Recuerda que tienes <strong>{daysTolimitDate}</strong> para realizar la verificación de tu correo electrónico. Si al finalizar este periodo aun no has autenticado tu correo electrónico tu cuenta puede quedar deshabilitada. Fecha limite <strong>{limitDate}</strong></br> <br /> Gracias por utilizar <b>hikingmexico.com</b>. <br /> <br />Si tienes preguntas o inquietudes sobre tu cuenta visita<br /> <a href='{linkSupport}'>{linkSupport}</a> o bien escríbenos a {empleoEmail} con gusto te brindaremos soporte.";
$STR['Email_Postulant_Resend']             		= "<p>{logo}</p> <p>Hola <strong>{userName}</strong>. <b>hikingmexico.com</b> te da la bienvenida</p><p>para ingresar a tu módulo de administración da clic <a href='{goToAdmin}'>aquí</a></p> <p> Para verificar tu dirección de correo electrónico haz clic en el siguiente enlace:<br /><br /> <a href='{linkValidation}'>{linkValidation}</a><br /><br /> Si al hacer clic en el enlace anterior no funciona, copia y pega el URL en una<br />nueva ventana del navegador.<br /> <br> Recuerda que tienes <strong>{daysTolimitDate}</strong> para realizar la verificación de tu correo electrónico. Si al finalizar este periodo aun no has autenticado tu correo electrónico tu cuenta puede quedar deshabilitada. Fecha limite <strong>{limitDate}</strong></br> <br /> Gracias por utilizar <b>hikingmexico.com</b>. <br /> <br />Si tienes preguntas o inquietudes sobre tu cuenta visita<br /> <a href='{linkSupport}'>{linkSupport}</a> o bien escríbenos a {empleoEmail} con gusto te brindaremos soporte.";
$STR['Email_Postulant_registryLocal']           = "<p>Hola <strong>{userName}</strong>. <b>hikingmexico.com</b> te da la bienvenida</p> <p>Recuerda utilizar tu clave de acceso para ingresar al módulo de administración:</p> <p>usuario:<strong>{userEmail}</strong></p> <p>contraseña:<strong>{password}</strong></p> <p>Para verificar tu dirección de correo electrónico haz clic en el enlace que te hemos enviado a <strong>{email}</strong><br /> <br> Recuerda que tienes <strong>{daysTolimitDate}</strong> para realizar la verificación de tu correo electrónico. Si al finalizar este periodo aun no has autenticado tu correo electrónico tu cuenta puede quedar deshabilitada. Fecha limite <strong>{limitDate}</strong></br> <br /> Gracias por utilizar <b>hikingmexico.com</b>. <br /> <br />Si tienes preguntas o inquietudes sobre tu cuenta visita<br /> <a href='{linkSupport}'>{linkSupport}</a> o bien escríbenos a {empleoEmail} con gusto te brindaremos soporte.</p>";

$STR['Email_Company_registry']               	= "<p>{logo}</p> <p>&nbsp;</p> <p>Hola <strong>{userName}</strong>.</p> <p><b>hikingmexico.com</b> te da la bienvenida y te  obsequia <strong>{daysToPost}</strong> días para publicar  vacantes sin costo alguno, solo te pedimos que la escolaridad mínima que  solicites en tus vacantes sea técnico o bachillerato.</p> <p>Periodo de publicación activado  desde: <strong>{periodInit}</strong><br /> Periodo de publicación de vacantes valido  hasta: <strong>{periodEnded}</strong></p> <p>Uno de nuestros asesores se pondrá en contacto  contigo vía telefónica o por correo electrónico para verificar que los datos  que has ingresado sobre tu empresa sean validos y correctos.</p> <p>Recuerda utilizar tu clave de acceso para ingresar al módulo de administración:</p> <p>usuario:<strong>{userEmail}</strong></p> <p>contraseña:<strong>{password}</strong></p><p>para ingresar a tu módulo de administración da clic <a href='{goToAdmin}'>aquí</a></p> <p> Para verificar tu dirección de correo electrónico haz clic en el siguiente enlace:<br /><br /> <a href='{linkValidation}'>{linkValidation}</a><br /> <br />.  Si al hacer clic en el enlace anterior no funciona, copia y pega el URL en una<br />nueva ventana del navegador.<br /> <br> Recuerda que tienes <strong>{daysTolimitDate}</strong> días para realizar la verificación de tu correo electrónico, de lo contrario tu cuenta será  eliminada de nuestros registros. Fecha limite <strong>{limitDate}</strong></br> <br /> Gracias por utilizar <b>hikingmexico.com</b>. <br /> <br />Si tienes preguntas o inquietudes sobre tu cuenta visita<br /> <a href='{linkSupport}'>{linkSupport}</a> o bien escríbenos a {asociatedEmail} con gusto te brindaremos soporte.<br />";
$STR['Email_Company_Resend']               		= "<p>{logo}</p> <p>Hola <strong>{userName}</strong>.</p> <p>Plan actual: <strong>{planName}</strong></p> <p>Estatus de plan actual: <strong>{statusPlan}</strong></p> <p>Periodo de publicación activado  desde: <strong>{periodInit}</strong><br /> Periodo de publicación de vacantes valido  hasta: <strong>{periodEnded}</strong></p> <p> Para verificar tu dirección de correo electrónico por favor haz clic en el siguiente enlace:<br /><br /> <a href='{linkValidation}'>{linkValidation}</a><br /><br /> Si al hacer clic en el enlace anterior no funciona, copia y pega el URL en una<br />nueva ventana del navegador.<br /> <br> Recuerda cuentas con <strong>{daysTolimitDate}</strong> para realizar la verificación de tu correo electrónico, de lo contrario tu cuenta será  cancelada. Fecha limite <strong>{limitDate}</strong></br> <br /> Gracias por utilizar <b>hikingmexico.com</b>. <br /> <br />Si tienes preguntas o inquietudes sobre tu cuenta, por favor visita<br /> <a href='{linkSupport}'>{linkSupport}</a> o bien escríbenos a {asociatedEmail} con gusto te brindaremos soporte.<br />"; 
$STR['Email_Company_registryLocal']          	= "<p>Hola <strong>{userName}</strong>.</p> <p><b>hikingmexico.com</b> te da la bienvenida y te  obsequia <strong>{daysToPost}</strong> días para publicar  vacantes sin costo alguno, solo te pedimos que la escolaridad mínima que  solicites en tus vacantes sea técnico o bachillerato.</p> <p>Periodo de publicación activado  desde: <strong>{periodInit}</strong><br /> Periodo de publicación de vacantes valido  hasta: <strong>{periodEnded}</strong></p> <p>Uno de nuestros asesores se pondrá en contacto  contigo vía telefónica o por correo electrónico para verificar que los datos  que has ingresado sobre tu empresa sean validos y correctos.</p> <p>Recuerda utilizar tu clave de acceso para ingresar al módulo de administración:</p> <p>usuario:<strong>{userEmail}</strong></p> <p>contraseña:<strong>{password}</strong></p> <p> Para verificar tu dirección de correo electrónico haz clic en el enlace que te hemos enviado a <strong>{email}</strong><br /> <br> Recuerda que tienes <strong>{daysTolimitDate}</strong> días para realizar la verificación de tu correo electrónico, de lo contrario tu cuenta será  eliminada de nuestros registros. Fecha limite <strong>{limitDate}</strong></br> <br /> Gracias por utilizar <b>hikingmexico.com</b>. <br /> <br />Si tienes preguntas o inquietudes sobre tu cuenta visita<br /> <a href='{linkSupport}'>{linkSupport}</a> o bien escríbenos a {asociatedEmail} con gusto te brindaremos soporte.<br />";

$STR['Company_registry_subject']              	= "Registro de empresa {TradeName} en <b>hikingmexico.com</b>";
$STR['Postulant_registry_subject']              = "Registro de postulante {userName} en <b>hikingmexico.com</b>";

$STR['Email_Autentication_Success']             = "<p>Hola {userName},<br />La verificación de tu correo electrónico ha concluido satisfactoriamente.";
$STR['Email_Autentication_Subject']             = "Autenticado correctamente";
$STR['AutenticationSuccess']                    = "<p>La verificación de tu cuenta ha concluido satisfactoriamente.</p> <p>Hemos enviado información adicional a tu cuenta de correo electrónico.</p> <p>Para garantizar  la seguridad de su información,  tendrás  que iniciar sesión cada vez que visites <b>hikingmexico.com</b>,  así que asegúrate de mantener esta  información de la cuenta para uso futuro.<br /> Para  acceder a tu panel de administración, consulta el siguiente  enlace:<br /> {link_to_account} </p>";
$STR['AutenticationAlreadyRegistered']          = "La autentificación de tu cuenta es correcta";
$STR['AutenticationFailed']                     = "La autentificación ha fallado, Para obtener más información de cuáles son las causas, ponte en contacto con nosotros enviando un email a {support-mail}";
$STR['AccountAutentication']                    = "Autentificación de tu cuenta";
$STR['Email_Comment']                           = "<p>{logoLink}</p><p>Ticket: <strong>{ticketId}</strong></p><p>Hola <strong>{userName}</strong>, hemos recibido tu comentario con fecha <strong>{dt_registry}</strong></p> <p>Tu comentario:</p> <p><strong>{comment}</strong></p> <p>Uno de nuestros asesores se contactará contigo vía correo electrónico a <strong>{email}</strong> para darte pronta respuesta.</p> <p>Quedamos  a sus órdenes en caso de cualquier duda o ampliación de la información.</p> <p>Gracias por tu comentario.</p> <p>Contacto: <strong>{supportMail}</strong></p>";
$STR['Email_Comment_Subject']                   = "<b>hikingmexico.com</b>, comentario ticket: {ticketId}";
$STR['VacancyByCodeLbl']                        = "Buscar una vacante por código";
$STR['VacancyByCodeTxt']                        = "Ingresa el código de referencia aquí";
$STR['HaveProblems']                            = "¿Tienes problemas?";
$STR['DoNotHaveAnAccount']                      = "¿No tienes una cuenta?";
$STR['ForgotPassword']                          = "Olvidé mi contraseña.";
$STR['ForgotUser']                              = "Olvidé mi usuario.";
$STR['CompleteFormPassword']                    = "Completa este formulario y enviaremos a tu e-mail las instrucciones para recuperar tu contraseña";
$STR['CompleteFormUser']                        = "Completa este formulario y enviaremos a tu e-mail tu usuario";
$STR['PassRecover']                             = "<b>hikingmexico.com</b>, solicitud para recuperar contraseña";
$STR['PassRecoverSuccess']                      = "<b>hikingmexico.com</b>, has modificado tu contraseña";
$STR['PassRecoverNotFound']                     = "Al parecer la solicitud para recuperar tu contraseña ha caducado, intenta enviando una nueva solicitud.";

$STR['PassRecoverLbl']                          = "Recuperar contraseña";
$STR['UserNotExist']                            = "Usuario no existe";
$STR['SentEmailWithRecoverInstructions']        = "Hemos enviado un correo electrónico con las instrucciones para recuperar tu contraseña a ";
$STR['User_Password_Recover']                	= "<p>{logoLink}</p> <p>Recuperar contraseña.<strong></strong></p> <p>Hola <strong>{userName}</strong>, para generar una nueva contraseña ingresa <a href='{linktorecovery}'>aquí</a></p> <p>o bien copia el siguiente link en el navegador <a href='{linktorecovery}'>{linktorecovery}</a></p> <p>Quedamos  a sus órdenes en caso de cualquier duda o ampliación de la información.</p> <p>Gracias.</p> <p>Contacto: <strong>{supportMail}</strong></p>";
$STR['Send_User_NewPassword']					= "<p>{logoLink}</p> <p>Hola <strong>{userName}</strong>.</p> <p>Recuerda utilizar tu clave de acceso para ingresar al módulo de administración:</p> <p>usuario:<strong>{userEmail}</strong></p> <p>contraseña:<strong>{password}</strong><br /> <br /> Si tienes preguntas o inquietudes sobre tu cuenta visita <a href='{linkSupport}'>{linkSupport}</a><br /> </p>";
$STR['NewPassword']                             = "Ingresa tu nueva contraseña";
$STR['BasicSearch']                             = "Búsqueda básica de vacantes";
$STR['AdvancedSearch']                          = "Búsqueda avanzada de vacantes";
$STR['VacancySearch']                           = "Búsqueda de vacantes";
$STR['Keyword']                      			= "Palabra clave o Código de referencia";
$STR['VacancyNotFound']                      	= "No se encontraron vacantes en base a estos parámetros.";
$STR['VacancyNotDisplayedLbl']                  = "No se encontró vacante.";
$STR['VacancyNotDisplayedTxt']                  = "Por alguna extraña razón, esta vacante no puede ser mostrada.";
$STR['ValidateChars']                           = "Caracteres de Validación";
$STR['TypeCharsComment']                      	= "Ingresa los caracteres de validación que se muestra en la imagen";
$STR['MailTooltip']                             = "En caso de que la vacante sea confidencial, registre un correo electrónico donde quiere recibir el CV, procurando que el dominio no corresponda con el de su empresa.";
$STR['PasswordChanged']                         = "Hemos modificado tu contraseña exitosamente";
$STR['RedirectIn']                              = "Redireccionando en";
$STR['TimeOverPasswordRecover']                 = "Lo sentimos, el periodo para realizar la modificación de tu contraseña ha terminado <br> necesitarás enviar de nuevo una solicitud de cambio de contraseña ";                                                        
$STR['statistics_Period']                       = "Rango de fechas";
$STR['statistics_initYear']                     = "Año inicial";
$STR['statistics_finishYear']                   = "Año Término";
$STR['statistics_Histrory']                     = "Histórica";
$STR['statistics_LevelLife']                    = "Nivel de vida";
$STR['statistics_market']                       = "Mercado";
$STR['statistics_Taste']                        = "muestra";
$STR['statistics_Avg']                          = "Promedio";
$STR['statistics_Min']                          = "Mínimo";
$STR['statistics_Max']                          = "Máximo";
$STR['statistics_Mode']                         = "Moda";
$STR['Welcome']                                 = "<b>hikingmexico.com</b> te da la bienvenida.";
$STR['statistics_SalaryRange']                  = "Rango de sueldos permitidos en la muestra";
$STR['statistics_SalaryRange_min']              = "Rango Mínimo";
$STR['statistics_SalaryRange_max']              = "Rango Máximo";
$STR['professionalPractices']                   = "Búsqueda de Prácticas profesionales";
$STR['SearchProfessionalPractices']             = "¿Buscas prácticas profesionales?";
$STR['SearchPractices']                         = "Buscar Prácticas";

$STR['ConsultAllPreactices']                    = "Consulta todas las prácticas";
$STR['ConsultAllVacancies']                     = "Consulta todas las vacantes";

$STR['ResultSearch']                            = "Resultado de la consulta";
$STR['WorkArea']                                = "Área o departamento";
$STR['Sector']                                  = "Sector";
$STR['VacancyType']                             = "Tipo de vacante";
$STR['StudyLevel']                              = "Nivel de estudio";
$STR['StudyArea']                               = "Área de estudio";
$STR['VacancyModeType']                         = "Modo de publicación";
$STR['ShareJobWithFriend']                      = "Compartir esta vacante de trabajo con un amigo";
$STR['ShareTo']                                 = "Correo electrónico de tu amigo";
$STR['YourName']                                = "Escribe tu nombre";
$STR['ShareToLbl']                              = "Introducir la dirección de correo electrónico del destinatario";
$STR['YourEmailAddress']                        = "Introduzca su dirección de correo electrónico.";
$STR['YourEmailAddressLbl']                     = "Esta dirección se utilizará para la entrega de correo única. no se puede utilizar para cualquier otro fin.";
$STR['Oportunity']                              = "Oportunidad de trabajo";
$STR['ShareToCorrect']                          = "Hemos enviado esta vacante por correo electrónico";
$STR['ShateToWrong']                      		= "Error: el mensaje no fue enviado, inténtalo mas tarde";
$STR['VacancyLimitReached']                     = "Advertencia: Has alcanzado el límite de vacantes permitidas, no se puede guardar la vacante";
$STR['ListAllVacancy']                          = "Listar todas las vacantes";
$STR['AccessDenied']                            = "Acceso Denegado";
$STR['ShowPostulations']                        = "Total Postulaciones";
$STR['PublicationDate']                         = "Fecha de publicación";
$STR['PostulationDate']                         = "Fecha de postulación";
$STR['CreationDate']                         	= "Fecha de creación";
$STR['Msg_Login_Redirecting']                   = "Redireccionando...";
$STR['MsgConsultDenied']                        = "No se puede mostrar esta información";
$STR['StudyAreaTxtNull']                        = "Se requiere ingresar información en área de estudio";
$STR['Confidential']                            = "Confidencial";
$STR['ConfidentialMode']			= "¿Publicar de manera confidencial?";
$STR['Publicate']				= "Publicar";
$STR['ConfidentialCompanyName']                 = "Empresa líder en su ramo";
$STR['MyAccount']                      		= "Inicio";
$STR['PersonalInfo']                            = "Información Personal";
$STR['CommentUserInfo']                         = "Información de Usuario";
$STR['CommentCompanyInfo']                      = "Información de la Empresa";
$STR['URLWeb']                                  = "Sitio web";
$STR['LinkFacebook']                            = "Dirección de FaceBook";
$STR['LinkTwitter']                             = "Dirección de Twitter";
$STR['CompanyMail']                             = "Correo electrónico de empresa";
$STR['CompanyAbout']                            = "Acerca de la Empresa";
$STR['BenefitsAndEntitlements']                 = "Beneficios y Prestaciones";
$STR['BenefitsList']                 		    = array("Seguro de Desempleo","Capacitación","Vacaciones","Caja de Ahorro","Días Feriados","Ausencia por Enfermedad","Seguro de Vida","Seguro Médico","Planes de Pensión","Prestaciones de Servicios Personales","Plan de Cafetería, Alimentación","Seguridad Social","Despensa, Vales","Prima Vacacional","Aguinaldo","Comisiones","Vivienda","Días de Descanso","Prima Dominical","Prima de Antigüedad","Reparto de Utilidades");
$STR['Info']                                    = "Información";
$STR['AddVacancy']                              = "Generar Nueva Vacante";
$STR['Update']                              	= "Actualizar";
$STR['PublicatedVacancies']                     = "Vacantes Publicadas";
$STR['Vacancies']                     		    = "Vacantes";
$STR['NoVacany']                                = "No existen vacantes generadas";
$STR['SearchPostulant']                         = "Buscar Postulante";
$STR['Statistics']                              = "Encuesta de Compensaciones";
$STR['VacancyName']                             = "Nombre de la vacante";
$STR['DocumentName']                            = "Nombre de documento";
$STR['VacancyType']                             = "Tipo de vacante";
$STR['Location']                            	= "Ubicación";
$STR['SelectLocation']                      	= "Seleccionar ubicación";
$STR['AllLocation']                         	= "Todas las ubicaciones";
$STR['SelectVacancyType']                       = "Seleccionar tipo de vacante";
$STR['SelectVacancy']                       	= "Seleccionar vacante";
$STR['Vacancy']                                	= "Vacante";
$STR['Postulant']                           	= "Postulante";
$STR['StudySpecs']                              = "Escolaridad";
$STR['CanAddFiveStudySpecs']                    = "Puedes agregar hasta 5 niveles educativos específicos o afines al nivel educativo deseado";
$STR['JobExperience']                           = "Experiencia laboral";
$STR['JobExperiencealone']                      = "Experiencia";
$STR['DefineExperienceTime']                    = "Especifica el tiempo de experiencia laboral necesario";
$STR['CanAddFiveLaborExperience']               = "Puedes agregar hasta 5 sectores específicos o afines a la experiencia laboral deseado";

$STR['VacancySectorActivityArea']               = "Especifica área en la que se desempeñara el postulante";

$STR['AgeOld']                                  = "Edad";
$STR['InvalidAgeOld']                           = "Debes cumplir con un mínimo de edad para poder ingresar tu currículum, debes tener al menos 17 años";
$STR['AgeOldError']                             = "Las edades que quieres ingresar son invalidas, el campo EDAD DESDE debe ser menor al campo EDAD HASTA";
$STR['AddStudyLevel']                           = "Agregar nivel educativo a lista";
$STR['AddLanguage']                             = "Agregar idioma a lista";
$STR['CanAddFiveLanguages']                     = "Puedes agregar hasta 5 idiomas, incluyendo el dominio que se requiere";
$STR['OtherStudyRequires']                      = "Otros requisitos de estudio";
$STR['AddJobExperience']                        = "Agregar experiencia laboral a lista";
$STR['ExperienceTime']                          = "Tiempo de experiencia laboral";
$STR['SelectExperienceTime']                    = "Seleccionar tiempo de experiencia";
$STR['StudyNoNeeded']                           = "Nivel de estudio indistinto";
$STR['LanguageNoNeeded']                        = "No se requiere idioma adicional";
$STR['ExperienceNoNeeded']                      = "Experiencia Laboral indistinto";
$STR['Experience2YearLess']                     = "Menos de 2 años";
$STR['Experience3YearTo5']                      = "3 a 5 años";
$STR['Experience5YearMore']                     = "Más de 5 años";
$STR['ExperienceTimeList']                      = array("-1"=>$STR['SelectExperienceTime'],"99"=>$STR['NoRequired'], "1"=>$STR['Experience2YearLess'],"2"=>$STR['Experience3YearTo5'],"3"=>$STR['Experience5YearMore']);
$STR['WorkRequires']                       		= "Requisitos laborales";
$STR['WorkDetail']                              = "Detalle de actividades";
$STR['AdditionalInfo']                          = "Información adicional";
$STR['PreviewVacancy']                          = "Pre visualizar";
$STR['Preview']                                 = "Vista previa";
$STR['ViewInfo']                                = "Ver información";
$STR['ViewPDF']                                 = "PDF";
$STR['Salary']                                  = "Sueldo percibido";
$STR['SalaryHelp']                              = "Se debe indicar el sueldo mensual percibido, este valor no ser&aacute mostrado en el currículum, solo es con fin estadístico";
$STR['SalaryOffered']                           = "Sueldo ofrecido";
$STR['SalaryOfferedHelp']                       = "Se debe indicar el sueldo mensual ofrecido, este valor no ser&aacute mostrado en la vacante, solo es con fin estadístico";
$STR['WorkingHours']                            = "Horario laboral";
$STR['SameAsCompany']                           = "Utilizar sector y giro predeterminados";
$STR['LimitList']                            	= "Se ha alcanzado el limite de la lista";
$STR['Relatedstudylevel']                       = "¿Quieres indicar la leyenda de nivel educativo afín al final de la lista?";
$STR['RelatedstudylevelHelp']                   = "Agregar nivel de estudio afín, al final de la lista";
$STR['RelatedstudylevelList']                   = "o nivel educativo afín";
$STR['Relatedworkexperience']                   = "¿Quieres indicar la leyenda de experiencia laboral afín al final de la lista?";
$STR['RelatedworkexperienceHelp']               = "Agregar experiencia laboral afín, al final de la lista";
$STR['RelatedworkexperienceList']               = "o experiencia laboral afín";
$STR['TimeExperienceHelp']                      = "Si selecciona la opción '".$STR['ExperienceNoNeeded']."', no se requiere indicar sector, actividad y área";
$STR['Gmap']                                    = "Ubicación Google Maps";
$STR['UploadLogoComment']                       = "El tamaño de la imagen que subas será modificado automáticamente a un tamaño de 430 pixeles de ancho por 130 pixeles de alto.";
$STR['UploadPictureComment']                    = "El tamaño de la imagen que subas será modificado automáticamente a un tamaño de 430 pixeles de ancho por 130 pixeles de alto.";
$STR['Registry']                                = "Regístrate";
$STR['RegistryMe']                              = "Registrarme";
$STR['FieldsNeededComment']                     = "Los campos con (*) son obligatorios";
$STR['Email']                                   = "Correo electrónico";
$STR['EmailForReceiptOfCurriculum']                      			= "Correo electrónico para recepción de currículum";
$STR['Confemail']                               = "Confirmación Correo Electrónico";
$STR['Pass']                                    = "Contraseña";
$STR['ConfPass']                                = "Confirmar Contraseña";
$STR['Name']                                    = "Nombre";
$STR['Gender']                                  = "Género";
$STR['BornDate']                                = "Fecha Nacimiento";
$STR['RFC']                                     = "R.F.C";
$STR['Nacionality']                             = "Nacionalidad";
$STR['SelectState']                             = "Seleccionar estado";
$STR['SelectCountry']                           = "Seleccionar País";
$STR['MaritalStatus']                           = "Estado Civil";
$STR['ActualAddress']                           = "Domicilio Actual";
$STR['Country']                                 = "País";
$STR['State']                                   = "Estado";
$STR['City']                                    = "Ciudad";
$STR['Colony']                                  = "Colonia";
$STR['Street']                                  = "Calle";
$STR['Number']                                  = "Numero";
$STR['PostalCode']                              = "Código Postal";
$STR['Phone']                                   = "Teléfono Fijo";
$STR['Mobil']                                	= "Teléfono Móvil";
$STR['Ext']                                     = "Extensión";
$STR['ValidateChars']                           = "Caracteres de validación";
$STR['TypeCharsComment']                        = "Ingresa los caracteres de validación que se muesta en la imagen";
$STR['AceptPolitics']                           = "Términos y Condiciones";
$STR['ReadPolitics']                            = "He leído y acepto los términos y condiciones.";
$STR['RegistryNow']                             = "Registro de postulante";
$STR['CompanyRegistry']                         = "Registro de empresa";
$STR['TypeTwoWords']                            = "Escribe los caracteres";
$STR['MaritalStatusMarried']                    = "Casado(a)";
$STR['MaritalStatusDivorced']                   = "Divorciado(a)";
$STR['MaritalStatusSingle']                     = "Soltero(a)";
$STR['MaritalStatusWidowed']                    = "Viudo(a)";
$STR['MaritalStatusList']                       = array("S"=>$STR['MaritalStatusSingle'],"C"=>$STR['MaritalStatusMarried'],"D"=>$STR['MaritalStatusDivorced'], "V"=>$STR['MaritalStatusWidowed']);
$STR['GenderFemale']                            = "Femenino";
$STR['GenderMale']                              = "Masculino";
$STR['GenderList']                              = array("F"=>$STR['GenderFemale'], "M"=>$STR['GenderMale']);
$STR['Nacionality_Selone']                      = "Seleccione una opción";
$STR['AlterEmail']                              = "Correo electrónico alternativo";
$STR['NumSons']                                 = "Número de hijos";
$STR['SelectNumSons']                           = "Seleccionar número de hijos";
$STR['NumSonsNone']                             = "No tengo hijos";
$STR['NumSonsOne']                              = "Un hijo";
$STR['NumSonsTwo']                              = "Dos hijos";
$STR['NumSonsThree']                            = "Tres hijos";
$STR['NumSonsFour']                             = "Cuatro hijos";
$STR['NumSonsFive']                             = "Cinco hijos o mas";
$STR['OwnCar']                                  = "Automóvil propio";
$STR['Driverlicense']                           = "Número de licencia de conducir";
$STR['MyAccount']                               = "Inicio";
$STR['AccountData']                             = "Datos personales";
$STR['Studies']                                 = "Estudios";
$STR['Academic']                                = "Académicos";
$STR['Laborexperience']                         = "Experiencia laboral";
$STR['Informatic']                              = "Informática";
$STR['Knowledge']                               = "Más conocimientos";
$STR['Languages']                               = "Idiomas";
$STR['Expectatives']                            = "Expectativas";
$STR['PreviewCV']                               = "Visualizar C.V.";
$STR['ShowPostulations']                        = "Postulaciones";
$STR['ViewPostulations']                        = "Ver postulaciones";
$STR['VacancyAfin']                      			= "Vacantes afín a tu perfil";
$STR['NoPostulations']                          = "No existen postulaciones";
$STR['StudyLevel']                              = "Nivel de estudio";
$STR['StudyArea']                               = "Área de estudio";
$STR['SelectStudyLevel']                        = "Seleccionar nivel de estudio";
$STR['NeededSelectStudyLevel']                  = "Debes seleccionar nivel de estudio para agregarlo a la lista";
$STR['NeededSelectStudyArea']                   = "Debes seleccionar área de estudio para agregarlo a la lista";
$STR['NeededSelectStudyAreaDME']                = "Debes escribir el área de estudio para agregarlo a la lista";

$STR['StudyLevelDuplicated']                    = "Nivel de estudio y área de estudio ya pertenecen a la lista";
$STR['LanguageDuplicated']                    	= "Idioma ya pertenece a la lista";
$STR['NeededSelectLanguage']                  	= "Debes seleccionar idioma para agregarlo a la lista";
$STR['NeededSelectDomain']                  	= "Debes seleccionar dominio para agregarlo a la lista";

$STR['ExperienceDuplicated']                    = "Experiencia ya pertenece a la lista";
$STR['NeededSelectSector']                  	= "Debes seleccionar sector para agregarlo a la lista";
$STR['NeededSelectActivity']                  	= "Debes seleccionar actividad para agregarlo a la lista";
$STR['NeededSelectArea']                  		= "Debes seleccionar área para agregarlo a la lista";

$STR['AllStudyLevel']                           = "Todos los niveles de estudio";
$STR['SelectStudyArea']                         = "Seleccionar área de estudio";
$STR['AllStudyArea']                            = "Todas las área de estudio";
$STR['ActualStudy']                             = "Actualmente cursando estudios";
$STR['DateIn']                                  = "Fecha de ingreso";
$STR['DateOut']                                 = "Fecha de egreso";
$STR['ActualStatus']                            = "Estatus actual";
$STR['Vacancystatus']                           = "Estatus de la vacante";
$STR['StudyPeriod']                             = "Periodo de Estudios";
$STR['InstituteName']                           = "Nombre de Institución";
$STR['Abort']                                   = "Abandonado";
$STR['InCurse']                                 = "En curso";
$STR['Pasante']                                 = "Pasante";
$STR['Title']                                   = "Titulado";
$STR['StatusStudies']                           = array("A"=>$STR['Abort'],"C"=>$STR['InCurse'], "P"=>$STR['Pasante'], "T"=>$STR['Title']);
$STR['Comment']                                 = "Comentario";
$STR['WaitaMoment']                             = "Un momento por favor...";
$STR['ClasificationAVG']                        = "Calificación Promedio";
$STR['StudiesComment']                          = "Se recomienda comenzar ingresando el nivel de estudio más alto alcanzado. Si tu  área de estudio no se encuentra en la lista, puedes seleccionar un área de Estudio afín, esto con la finalidad de que la relación en la búsqueda por parte de las empresas se mas exacta.";
$STR['InformaticComment']                       = "Se recomienda comenzar indicando el tipo de software que mas domines, describe el uso de manera breve, así como el nombre del software.";
$STR['LanguagesComment']                        = "Se recomienda comenzar indicando el idioma que mas domines, así como el dominio que tienes de el al hablarlo, leerlo y escribirlo";
$STR['ExpectativesComment']                     = "Indica tus expectativas laborales, seleccionando el área y departamento donde deseas desempeñarte.";
$STR['WorksComment']                            = "Se recomienda comenzar indicando la última empresa donde laboraste o en su caso la actual.";
$STR['KnowledgeComment']                        = "Puedes ingresar todas aquellas habilidades o conocimientos adquiridos durante tus estudios o empleos anteriores ej.  Manejo de herramientas, maquinaria,  conocimiento en metodologías de trabajo en grupo, capacidad de razonamiento matemático,  manejo de personal. Todo aquello que te haga único.";
$STR['SoftwareType']                            = "Tipo de software";
$STR['SoftwareName']                            = "Nombre de software";
$STR['Domain']                                  = "Dominio";
$STR['Description']                             = "Descripción";
$STR['SelectSoftwareType']                      = "Seleccionar tipo de software";
$STR['SelectDomain']                            = "Seleccionar dominio de software";
$STR['SoftwareComment']                         = "Descripción en el uso del software";
$STR['SoftwareUseDescribed']                    = "Debes describir el uso del software";

$STR['KnowledgeDescribed']                    	= "Debes describir el conocimiento";
$STR['ActivityDescribed']                    	= "Debes describir la actividad realizada";

$STR['Advance']                                 = "Avanzado";
$STR['Basic']                                   = "Básico";
$STR['Middle']                                  = "Intermedio";
$STR['DomainList']                              = array("A"=>$STR['Advance'], "I"=>$STR['Middle'], "B"=>$STR['Basic']);
$STR['Language']                                = "Idioma";
$STR['SpeakDomain']                             = "Dominio al hablar";
$STR['ReadDomain']                              = "Dominio al leer";
$STR['WriteDomain']                             = "Dominio al escribir";
$STR['SelectLanguageAVG']                       = "Seleccionar porcentaje";
$STR['AVGDomain']                               = "Porcentaje de dominio";
$STR['SelectLanguage']                          = "Seleccionar idioma";
$STR['LanguageList']                            = array("-1"=>$STR['SelectLanguage'], "1"=>"Español", "2"=>"Ingles", "3"=>"Frances", "4"=>"Alemán", "5"=>"Italiano", "6"=>"Japonés", "7"=>"Portugués");
$STR['LanguageScoreList']                       = array("-1"=>$STR['SelectLanguageAVG'], "60"=>"60 %", "70"=>"70 %", "80"=>"80 %", "90"=>"90 %", "100"=>"100 %"/*, "101"=>"Biling&uuml;e"*/);
$STR['ToTalk']                                  = "Al Hablar";
$STR['ToRead']                                  = "Al Leer";
$STR['ToWrite']                                 = "Al Escribir";
$STR['TOEFLLabel']                              = "Si hás realizado el examen TOEFL indica tu puntuación";
$STR['TOEFL']                                   = "Examen TOEFL";
$STR['TOEFLScore']                              = "Puntuación de examen";
$STR['SelectArea']                              = "Seleccionar área o departamento";
$STR['AllArea']                                 = "Todas las áreas o departamentos";
$STR['Sector']                                  = "Sector";
$STR['SelectSector']                            = "Seleccionar sector";
$STR['AllSector']                               = "Todos los sectores";
$STR['HierarchyLevel']                          = "Nivel o jerarquía";
$STR['SelectHierarchyLevel']                    = "Seleccionar nivel o jerarquía";
$STR['HierarchyGerencia']                       = "Gerencia";
$STR['HierarchySupervisor']                     = "Supervisor";
$STR['HierarchySenior']                         = "Senior";
$STR['HierarchyJunior']                         = "Junior";
$STR['HierarchyLevelList']                      =  array("-1"=>$STR['SelectHierarchyLevel'] ,"1"=>$STR['HierarchyGerencia'],"2"=>$STR['HierarchySupervisor'],"3"=>$STR['HierarchySenior'],"4"=>$STR['HierarchyJunior']);
$STR['HomeChange']                              = "Dispuesto a cambiar de Residencia";
$STR['WorkCompleteTime']                        = "Dispuesto a trabajar Tiempo Completo";
$STR['WorkMiddleTime']                          = "Dispuesto a trabajar Medio Tiempo";
$STR['Workfees']                                = "Dispuesto a trabajar por honorarios";
$STR['WorkTemp']                                = "Dispuesto a trabajar temporalmente";
$STR['WantMoney']                               = "Sueldo mensual deseado";
$STR['LikeToWork']                              = "Área donde deseas laborar";
$STR['ComExpectatives']                         = "Puedes describir tu personalidad, anhelos, objetivos a corto, mediano o largo plazo, o un comentario para aclarar o especificar mas a detalle tus expectativas laborales";
$STR['KnowledgeName']                           = "Nombre del conocimiento";
$STR['Company']                                 = "Empresa";
$STR['Puesto']                                  = "Puesto";
$STR['TradeName']                             	= "Razón social";
$STR['TradeMark']                             	= "Nombre comercial / Marca";
$STR['ConfidentialTradeMark']                   = "Nombre comercial / Marca modo confidencial";
$STR['PostulantName']                           = "Nombre de postulante";
$STR['Activity']                                = "Giro o actividad principal";
$STR['SelectActivity']                          = "Seleccionar giro o actividad";
$STR['AllActivity']                             = "Todos los giros o actividades";
$STR['Hierarchy']                               = "Jerarquía desempeñada";
$STR['JobTitle']                                = "Nombre de puesto";
$STR['WorkPeriod']                         		= "Periodo laborado";
$STR['IsActualWork']                            = "Es tu trabajo actual?";
$STR['ActualWork']                              = "Trabajo actual";
$STR['ActivityDescription']                     = "Descripción de actividades";
$STR['Actividades']                             = "Actividades";
$STR['accesstoaccount']                         = "Ingresa a tu cuenta";
$STR['YourOpinion']                             = "Nos interesa tu opinión";
$STR['InterviewTracking']                       = "Seguimiento de postulación";
$STR['GiveInterviewTracking']                   = "Dar seguimiento";
$STR['ViewInterviewTracking']                   = "Ver seguimiento";
$STR['PostulantInformationStatus']              = "Estatus de tu información";
$STR['PostulantInformationStatusComment']       = "hikingmexico te sugiere que ingreses la información que se te solicita con el fin de brindarte un mejor servicio y tener mayores oportunidades de éxito";
$STR['AcademicStudiesList']                     = "Lista de estudios académicos";
$STR['InformaticList']                          = "Lista de estudios informáticos";
$STR['KnowledgeList']                          	= "Lista de conocimientos";
$STR['LenguageList']                          	= "Lista de idiomas";
$STR['LaborExperienceList']						= "Lista de experiencia laboral";

$STR['AddNewAcademicStudy']						= "Agregar nuevo estudio académico";
$STR['AddNewInformaticStudy']					= "Agregar nuevo estudio informático";
$STR['AddNewKnowledge']							= "Agregar nuevo conocimiento";
$STR['AddNewLanguage']							= "Agregar nuevo idioma";
$STR['AddNewLaborExperience']					= "Agregar nuevo experiencia laboral";
$STR['AddNewAnnualPlan']						= "Agregar nuevo plan de anualidad";


$STR['SavingTOEFLScore']                        = "Guardando puntuación de examen";
$STR['TOEFLScoreUpdated']                       = "Puntuación de examen actualizando";
$STR['TOEFLScoreFail']                          = "Puntuación de examen invalido, no se puede guardar este valor";


$STR['WaitEvalutaion']                      	= "En espera de ser evaluado";
$STR['TrackingAnalizando']						= "Analizando currículum";
$STR['TrackingDateInterview']					= "Cita a entrevista";
$STR['TrackingInterview']						= "Entrevista";
$STR['TrackingRetroalimentacion']				= "Retroalimentación";
$STR['TrackingStatus']                          =  array("1"=>$STR['WaitEvalutaion'], "2"=>$STR['TrackingAnalizando'],"3"=>$STR['TrackingDateInterview'],"4"=>$STR['TrackingInterview'],"5"=>$STR['TrackingRetroalimentacion']);


$STR['ViewAllInfo']								= "Mostrar toda la información";

$STR['VacancyListProfile']						= "Lista de vacantes afines a tu perfil";

$STR['WaitEvalutaion_comment']					= "Tu postulación esta por ser evaluada";
$STR['PostulationRegistrySuccess']				= "Tu postulación en <b>hikingmexico.com</b> se realizo exitosamente";

$STR['Akin']                      				= "Afín";
$STR['Based']									= "en base a";
$STR['PermittedTypeFile']						= "Formatos permitidos:";

$STR['ReturnToPostulationList']					= $STR['Return'].' a '.$STR['PostulationList'];

$STR['mail_postulation_css']				= '<style type="text/css"> body {font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";font-size: 1.0em;} .v-field{font-weight: normal;font-size: 1.0em;} .v-link{font-weight: normal;font-size: 1.1em; color: #0981a9;} .v-header{font-weight:normal;font-size: 1.1em; color: #0981a9; width:190px;} .v-legend{font-weight: normal; font-size: 1.1em; color: #0981a9;} .v-header2{font-weight:	normal;font-size: 2.0em;color: #0981a9;} </style> ';
$STR['mail_postulation_share']				= '<fieldset> <div class="v-field" id="v-hello">Hola, {yourName} te ha enviado una oportunidad de trabajo desde <a href="{webpageLink}"><b>hikingmexico.com</b></a> <br> Para obtener más información y poder postularte <br> <a href="{vacancyLink}">da clic aqu&iacute;</a> <br> o bien copia el siguiente link en el navegador <p class="v-link">{vacancyLink}</p> </div> </fieldset> ';
$STR['mail_postulation_postulant']			= '<fieldset> <div class="v-field" id="v-hello"> <p>Hola {yourName} ,</p> <p>Tu postulación en <a href="{webpageLink}"><b>hikingmexico.com</b></a> se realizo exitosamente.</p> <p><br> Para obtener más información y revisar el seguimiento de tu postulación <a href="{postulationLink}">da clic aqu&iacute;</a>	o bien copia el siguiente link en el navegador. </p> <p class="v-link">{postulationLink}</p> </div> </fieldset> ';
$STR['mail_postulation_body']				= '<br> <img src="{logo}"> <br> <fieldset> <legend class="v-legend">{vacancyLbl}</legend> <div class="v-header2" id="v-vacancyName">{vacancyname}</div> </fieldset> <br> <fieldset> <legend>{vacancyInfoLbl}</legend> <table width="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td width="12%"><div class="v-header" style="display: inline-block">{companyNameLbl}</div></td> <td width="88%"><div class="v-field" style="display: inline-block" id="v-strCompany">{companyName} </div></td> </tr> <tr> <td><div class="v-header" style="display: inline-block">{localizationLbl}</div></td> <td><div class="v-field" style="display: inline-block" id="v-strLocation">{localization}</div></td> </tr> <tr> <td><div class="v-header" style="display: inline-block"  id="v-strSector">{sectorLbl}</div></td> <td><div class="v-field" style="display: inline-block" id="v-strActivity">{sector}</div></td> </tr> <tr> <td><div class="v-header"  style="display: inline-block">{vacancyTypeLbl}</div></td> <td><div class="v-field" style="display: inline-block" id="v-strVacancyType">{vacancyType}</div></td> </tr> <tr> <td><div class="v-header"  style="display: inline-block">{timeExperienceLbl}</div></td> <td><div class="v-field" style="display: inline-block" id="v-strJobExperiencealone">{timeExperience}</div></td> </tr> <tr> <td><div class="v-header" style="display: inline-block">{studySpecsLbl}</div></td> <td><div class="v-field" style="display: inline-block" id="v-strStudySpecs">{studySpecs}</div></td> </tr> <tr> <td><div class="v-header" style="display: inline-block">{referenceCodeLbl}</div></td> <td><div class="v-field" style="display: inline-block" id="v-strReferenceCode">{referenceCode}</div></td> </tr> </table> </fieldset> <p><br /> Por favor, no respondas a este mensaje, ya que se env&iacute;a de forma autom&aacute;tica, y su respuesta no ser&aacute; recibida.</p> <p>Atentamente,<br /> El equipo de <b>hikingmexico.com</b></p> '; 

$STR['Web_postulation_body']				= '<fieldset> <div class="vcn_field" id="vcn_hello"> <p>Hola {yourName} ,</p> <p>Tu postulación en <a href="{webpageLink}"><b>hikingmexico.com</b></a> se realizo exitosamente.</p></div> </fieldset><br><fieldset> <legend class="vcn_legend">{vacancyLbl}</legend> <div class="vcn_header2" id="vcn_vacancyName">{vacancyname}</div> </fieldset> <br> <fieldset> <legend>{vacancyInfoLbl}</legend> <table width="100%" border="0" cellspacing="0" cellpadding="0"> <tr> <td width="38%"><div class="vcn_header" style="display: inline-block">{companyNameLbl}</div></td> <td width="62%"><div class="vcn_field" style="display: inline-block" id="vcn_strCompany">{companyName} </div></td> </tr> <tr> <td><div class="vcn_header" style="display: inline-block">{localizationLbl}</div></td> <td><div class="vcn_field" style="display: inline-block" id="vcn_strLocation">{localization}</div></td> </tr> <tr> <td><div class="vcn_header" style="display: inline-block"  id="vcn_strSector">{sectorLbl}</div></td> <td><div class="vcn_field" style="display: inline-block" id="vcn_strActivity">{sector}</div></td> </tr> <tr> <td><div class="vcn_header"  style="display: inline-block">{vacancyTypeLbl}</div></td> <td><div class="vcn_field" style="display: inline-block" id="vcn_strVacancyType">{vacancyType}</div></td> </tr> <tr> <td><div class="vcn_header"  style="display: inline-block">{timeExperienceLbl}</div></td> <td><div class="vcn_field" style="display: inline-block" id="vcn_strJobExperiencealone">{timeExperience}</div></td> </tr> <tr> <td><div class="vcn_header" style="display: inline-block">{studySpecsLbl}</div></td> <td><div class="vcn_field" style="display: inline-block" id="vcn_strStudySpecs">{studySpecs}</div></td> </tr> <tr> <td><div class="vcn_header" style="display: inline-block">{referenceCodeLbl}</div></td> <td><div class="vcn_field" style="display: inline-block" id="vcn_strReferenceCode">{referenceCode}</div></td> </tr> </table> </fieldset>';
$STR['Mail_postulation_CompanyBody']			= '<fieldset> <div class="vcn_field" id="vcn_hello"> <p>Hola {companyUserName} ,</p> <p>{newPostulantName} ha realizado su postulación para la siguiente vacante. <a href="{newPostulantCVLink}">{previewCV}</a></p></div> </fieldset><br><fieldset> <legend class="vcn_legend">{vacancyLbl}</legend> <div class="vcn_header2" id="vcn_vacancyName">{vacancyname}</div> </fieldset> <br> <fieldset> <legend>{postulationList}</legend></fieldset><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><th>{dt_registryLbl}<th>{postulantNameLbl}</th><th>{statusLbl}</th><th>{viewCVLbl}</th></tr></table>';

$STR['FindBestOptions']					= "¿Buscas practicantes?<br> Encuentra aquí las mejores opciones.";
$STR['UABC']						= "Universidad Autónoma de Baja California";
$STR['UPBC']						= "Universidad Politécnica de Baja California";
$STR['CEUVA']						= "Centro de Estudios Universitarios Vizcaya de las Américas";

$STR['OurAliances']					= "Nuestras Alianzas";
$STR['ANGOK']						= "Angok Corporate Services de México";

$STR['Consult']						= "Consultar";
$STR['ConsultAll']					= "Todo";
$STR['SimpleQuery']					= "Consulta básica";
$STR['AdvancedQuery']					= "Consulta especifica";
$STR['PracticesQuery']					= "Prácticas profesionales";

$STR['LaborExperienceQuery']				= "Consulta por experiencia laboral";
$STR['EducativeLevelQuery']				= "Consulta por nivel educativo";

$STR['ReturnToEdit']                                    = "Regresar a editar";
$STR['FrequentlyQuestions']				= "Preguntas Frecuentes";
$STR['FrequentlyQuestions_Generals']			= "Generales";
$STR['FrequentlyQuestions_Postulant']			= "Postulante";
$STR['FrequentlyQuestions_Company']			= "Empresa";

$STR['Autentication']                    		= "Autenticar";

$STR['AccountAdmin']                    		= "Administrar cuentas";
$STR['PortalStatus']                    		= "Estatus del portal";
$STR['PostulantAdmin']                    		= "Administrar postulantes";
$STR['CompanyAdmin']                    		= "Administrar Compañías";
$STR['SearchCandidate']                    		= "Buscar candidato";
$STR['Report']                    				= "Reportes";
$STR['Compensation']                  			= "Encuesta de Compensaciones";
$STR['Catalog']                  				= "Catálogo";

$STR['AddCompany']                  			= "Agregar empresa";
$STR['ConsultCompany']                  		= "Consultar empresa";
$STR['VacancyReport']                    		= "Reporte de vacantes";
$STR['CompanyReport']                    		= "Reporte de Compañías";
$STR['PostulantReport']                    		= "Reporte de postulantes";
$STR['ConsultPostulant']                                = "Consultar postulante";
$STR['Postulants']                    			= "Postulantes";
$STR['Locations']                                       = "Ubicaciones";
$STR['Areas']                            		= "Áreas y subareas";

$STR['AnnualPlans']                                     = "Planes anuales";
$STR['AnnualPlansAssigned']                             = "Planes anuales asignados";

$STR['AnnualPlanName']                                  = "Nombre de Plan";
$STR['AnnualPlanTotalDays']				= "Periodo en dias";

$STR['ConsultWhatOffered']				= "Consulta las vacantes ofertadas por estas empresas";

$STR['wanttocreateaccount']				= "¿Deseas crear una cuenta?";

$STR['toApply']						= "Para postularte a esta vacante debes autentificarte con tu cuenta <b>hikingmexico.com</b>";

$STR['Autentication_success']             		= "Autenticado correctamente";

$STR['PostulationNotAllowed']             		= "Lo sentimos, tu usuario no tiene permitido la acción de postularse";

$STR['NewPostulant']             			= "Nuevo postulante";

$STR['closeWindow']             			= "Cerrar ventana";

$STR['NotSpecificated']					= "No especificado";

$STR['PendingEmailVerify']				= "Hola {userName}, cuentas con <strong>{number}</strong> día(s) para autenticar la dirección de correo electrónico que has utilizado al crear tu cuenta en <b>hikingmexico.com</b>. Si al finalizar este periodo aun no has autenticado tu correo electrónico tu cuenta puede quedar deshabilitada.";
$STR['EmailVerifyForwarding']				= "Hemos enviado un correo electrónico con la información de registro de tu cuenta a <strong>{userEmail}</strong>, si no la has recibido puedes dar clic en el siguiente botón para reenviarte la información ";

$STR['aveCompleted']             			= "% completado";

$STR['CompanyVerifiedAccount']                          = "Hola {userName}, La información de tu cuenta esta en proceso de ser verificada, en breve uno de nuestros asesores se contactara contigo vía telefónica o por correo electrónico para corroborar la información de tu cuenta.";

$STR['ConfidentialMail']             			= "Correo electrónico modo confidencial";

$STR['ExperienceInSector']             			= "Sector ";
$STR['ExperienceInActivity']             		= "actividad de";
$STR['ExperienceInArea']             			= "y enfocado al área de";

$STR['GetAnnualPlan']	             			= "Solicitar plan anual";
$STR['RequestAnnualPlan']	             		= "Solicitud de plan de anualidad";
$STR['SelectPlan']					= "Seleccionar plan";
$STR['AnnualPosts']					= "Puestos anuales";
$STR['PostsCost']					= "Valor en pesos + IVA";
$STR['SendRequest']					= "Enviar solicitud";
$STR['RequestSended']					= "Tu solicitud ha sido enviada exitosamente";
$STR['AnnualPlanDuplicatedName_Error']			= "Advertencia: Ya existe un plan de anualidad con el mismo nombre.";


$STR['AnnualPlansHeaderComment']                      	= "<p>Agradecemos la  oportunidad que nos brinda de presentarle nuestro servicio de reclutamiento  electrónico a través del portal {portalLink} </p> <p>Algunos  de las ventajas de nuestro servicio:</p> <ul> <li>Reducción de costos de  reclutamiento</li> <li>Conocimiento del mercado  laboral local y regional</li> <li>Posibilidad de validar o  recomendar a candidatos a elección de la empresa contratante</li> <li>Flexibilidad en la  publicación de vacantes</li> <li>Publicación de vacantes confidenciales,  bajo 2 modalidades: <ul> <li>Utilizando un correo asignado por la empresa solicitante (Hotmail,  yahoo, gmail, etc.), o bien;</li> <li>Solicitando pre selección de candidatos, bajo esta modalidad un asesor  de hikingmexico verifica la información del postulante antes de enviar el  currículo a la empresa.</li> </ul> </li> </ul>";
$STR['AnnualPlansFooterComment']                        = "<p>Los planes con excepción del único (*) incluyen: <ul> <li>Publicación en el portal.</li> <li>Envió de  la vacante por correo electrónico.</li> <li>Código de prensa.</li> <li>Publicaciones  de practicantes sin costo.</li> <li>entorno para  administración de currículum.</li> </ul>En el caso  del plan ideal el primer pago es por 6 puestos, posteriormente la facturación se  hace mensual, considerando los puestos efectivamente publicados.<div class='cleaner h10'></div>El mismo puesto puede publicarse tantas veces  como sea necesario y puede ser modificado el perfil del mismo.</p> <p>Quedamos  a sus órdenes en caso de cualquier duda o ampliación de la información.</p> <p>Contacto: {associatedMail} </p>";

$STR['CompanyActualPlan']				= "<div class='cv-field'>Plan actual:</div><div class='cv-data'><h5>{planName}</h5></div><div class='cleaner'></div> <div class='cv-field'>Estatus:</div><div class='cv-data'><h5>{statusPlan}</h5></div><div class='cleaner'></div> <div class='cv-field'>Activado desde:</div><div class='cv-data'><h5>{initialPeriod}</h5></div><div class='cleaner'></div> <div class='cv-field'>Valido hasta:</div><div class='cv-data'><h5>{periodEnded}</h5></div><div class='cleaner'></div> ";
$STR['TotalPostedVacancies']				= "Actualmente cuentas con {totalPostedVacancies} vacante(s) publicada(s)";
$STR['PostulationWithOutEvaluation']			= "Numero de postulaciones sin evaluar: {totalPostulations}";

$STR['RequestPlanOnProcess']				= "Actualmente tienes en proceso una solicitud para adquirir un plan anual";

$STR['CompanyPlanNotFound']                             = "La verificación de tu plan de anualidad no ha sido encontrado o su periodo ha finalizado . Para mas información consulta el módulo de planes anuales o contáctanos vía correo electrónico a ";
$STR['CompanyPlanMaxPostReached']                       = "Has alcanzado el limite de vacantes permitidas a publicar, para mas información contáctanos vía correo electrónico a ";


$STR['PlanPeriodEnded_Msg']                             = "El periodo de tu plan anual {planName} ha finalizado, activado desde: {initialPeriod} y concluido el: {periodEnded}. Para mas información consulta el módulo de planes anuales o contáctanos vía correo electrónico a {associatedMail}";

$STR['RequestPlan_Msg']					= "<p>Solicitud de  plan de anualidad</p> <p>{logoLink}</p> <p>Hola {userName}, has solicitado la adquisición de un  plan de anualidad:</p> <p><strong>Información del plan de anualidad</strong></p> <table width='615' border='0' cellpadding='0' cellspacing='0'> <tr> <td>Código  de solicitud</td> <td>{requestId}</td> </tr> <tr bgcolor='#CCCCCC'> <td>Estatus de  solicitud</td> <td>{status}</td> </tr> <tr> <td>Fecha de creación de solicitud</td> <td>{dt_registry}</td> </tr> <tr bgcolor='#CCCCCC'> <td width='233'>Nombre del plan de anualidad</td> <td width='382'>{planName}</td> </tr> <tr> <td>Valor en pesos + IVA</td> <td>{cost}</td> </tr> <tr bgcolor='#CCCCCC'> <td>Puestos anuales</td> <td>{totalPosts}</td> </tr> </table> <p>Tu comentario:</p> <p>{company_comment}</p> <hr /> <p><strong>Información de la empresa</strong></p> <table width='617' border='0' cellpadding='0' cellspacing='0'> <tr> <td>Nombre de empresa</td> <td>{companyName}</td> </tr> <tr bgcolor='#CCCCCC'> <td width='236'>Contacto</td> <td width='381'>{userName}</td> </tr> <tr> <td>Teléfono</td> <td>{phone}</td> </tr> <tr bgcolor='#CCCCCC'> <td>Correo electrónico</td> <td>{email}</td> </tr> <tr> <td>Ubicación</td> <td>{location}</td> </tr> </table><br/><p>Gracias por elegir <b>hikingmexico.com</b> como tu portal favorito de trabajo. Uno de nuestros asesores se contactará contigo vía telefónica  y/o vía correo electrónico para detallar el proceso a seguir  para adquirir tu plan de anualidad deseado.</p> <p>Quedamos  a sus órdenes en caso de cualquier duda o ampliación de la información.</p> <p>Contacto: {associatedMail} </p>"; 

$STR['GoToAdmin']             				= "Ir al módulo de administración";

$STR['WelcomeLogin']             			= "Hola {userName}";

$STR['JobsOffered']             			= "Numero de puestos ofertados";
$STR['LastJobInfo']             			= "Información de empleo actual ó reciente";

$STR['EnterJobRequirements']             		= "Es necesario que ingreses requisitos laborales";
$STR['EnterComments']             			= "Es necesario que ingreses tus comentarios";

$STR['PlanOutRangeNotification']                        = "El periodo de tu plan ha finalizado el <strong>{limitDate}</strong>, no podrás generar nuevas vacantes, así como las vacantes que se encuentren actualmente publicadas serán deshabilitadas. <div class='cleaner h10'></div> Te sugerimos ingresar al módulo de planes anuales para solicitar la renovación de tu plan actual o adquirir uno nuevo.";
$STR['PlanApproachesExpirationDate']                    = "Tu plan actual esta por finalizar el <strong>{limitDate}</strong>. Te sugerimos ingresar al módulo de planes anuales para solicitar la renovación de tu plan actual o adquirir uno nuevo.";

$STR['UploadCVFile']             			= "Sube tu currículum en formato PDF";
$STR['InsertCVFile']             			= "El documento PDF se ha subido correctamente";
$STR['UpdateCVFile']             			= "El documento PDF se ha actualizando correctamente";
$STR['DeleteCVFile']             			= "El documento PDF se ha eliminado";
$STR['NeedSelectFile']                                  = "Debes seleccionar un archivo, presiona Examinar...";

$STR['Download']             				= "Descargar PDF";
$STR['Downloading']             			= "Descargando...";

$STR['InfoNotFound']                      		= "No hemos encontrado la información solicitada.";

$STR['SendYourComments']                                = "Envíanos tus comentarios";

$STR['ForgotyourpasswordLbl']             		= "Ingresa tu correo electrónico, recuerda que debe ser el mismo que ingresaste al momento de crear tu cuenta.";

$STR['RecoverYourPasswordLbl']             		= "Hola <strong>{userName}</strong>, Ingresa tu nueva contraseña.";

$STR['PasswordChange']             			= "Cambiar contraseña";

$STR['EmailValidationSuccess']             		= "<p>Hola <strong>{userName}</strong>,</p> <p>hemos verificado correctamente tu correo electrónico <strong>{email}</strong></p> <p>Gracias.</p>";

$STR['Promotion']					= "Promoción";

$STR['ReceiveVacancyMail']				= "Recibe oportunidades de trabajo a tu correo electrónico";
$STR['ReceiveVacancyMail_lbl']				= "Para ingresar tu correo electrónico a la lista de correos";
$STR['OportunityToMail']				= "Oportunidades de trabajo a tu correo electrónico";
$STR['WantDeleteToMailingList']				= "¿Deseas eliminar tu correo electrónico de la lista?";

$STR['Mailinglist_AddSuccess']             		= "<p>Hola {userName}, tu correo electrónico ha sido agregado satisfactoriamente.";

$STR['Mailinglist_EmailSuccess']                        = "<p>{logoLink}</p> <p>Hola <strong>{userName}</strong>, </p> <p>Hemos recibido tu solicitud para agregar tu correo electrónico <strong>{userEmail}</strong> a nuestra lista de correos de <b>hikingmexico.com</b>.</p> <p><b>hikingmexico.com</b> te enviara periódicamente las oportunidades de trabajo más actuales.</p> <p>Si deseas recibir oportunidades de trabajo afines a tus estudios académicos, experiencia laboral o en base a tus expectativas laborales</p> <p>Puedes registrarte en <b>hikingmexico.com</b> como postulante, llenar tu currículo y nuestro sistema te enviara las oportunidades de trabajo especificas.</p> <p><a href='{postulantRegistry}'>Regístrate aquí como postulante</a></p> <p>Si por alguna razón no deseas recibir  oportunidades de trabajo puedes eliminar tu correo electrónico utilizando la siguiente URL</p> <p><a href='{linkToCancel}'>{linkToCancel}</a></p> <p><b>hikingmexico.com</b></p>";
$STR['EmailValidationFail']             		= "Se produjo un error en la validación de tu correo electrónico, puedes intentarlo de nuevo utilizando la opción de reenviar que aparece en tu módulo de administración";

$STR['JobsFiltered']           				= "Las siguientes vacantes han sido filtrados en base a la información ingresada en tu currículum, experiencia laboral, estudios académicos y expectativas laborales.";


$STR['Support_Q1']					= "He olvidado mi contraseña ¿Cómo puedo recuperarla?";
$STR['Support_A1']					= "<p> Al momento de crear tu cuenta registraste una correo electrónico. Si has olvidado tu contraseña puedes recuperarla ingresando a la opción <a href='../forgotpassword/'>¿HAS OLVIDADO TU CONTRASEÑA?</a> y seguir los pasos</p>";

$STR['Support_Q2']					= "¿Qué significa una vacante confidencial?";
$STR['Support_A2']					= "<p> Las vacantes confidenciales son aquellas donde se omite el nombre de la empresa contratante, las empresas suelen tener una infinidad de motivos para desear NO publicar su nombre ya sea por tratarse de una vacante de reemplazo o por motivos de competencia. </p>";

$STR['Support_Q3']					= "¿Cómo puedo compartir/notificar a un amigo de una vacante disponible en <b><b>hikingmexico.com</b></b>?";
$STR['Support_A3']                      		= "<p> Al visualizar la vacante puedes seleccionar la opción de \"compartir con un amigo\", ahí podrás ingresar el correo electrónico al que enviaras la vacante. Recibirás un correo electrónico con la información principal de la vacante y una liga que te enviara a visualizar la vacante en el portal. </p>";

$STR['Support_Q4']					= "¿Por qué autenticar mi dirección de correo electrónico?";
$STR['Support_A4']                      		= "<p> Al momento de crear tu cuenta se te envía un correo electrónico con la información de tu cuenta, un proceso importante es autenticar tu cuenta ya que así afirmas que la dirección de correo electrónico es valida. </p>";

$STR['Support_Q5']					= "Quiero aplicar para una vacante ¿Cómo puedo hacerlo?";
$STR['Support_A5']                      		= "<p> Al momento de postularte a una vacante, te aparecerá una ventana donde debes ingresar tu correo electrónico, contraseña y los caracteres ve validación que aparece en la imagen de color gris. Si no has creado una cuenta de hikingmexico es necesario registrarte como postulante seleccionando la opción <a href='../postulantregister/'>Registrarte</a> que aparece en la parte superior del portal. </p>";

$STR['Support_Q6']					= "Al enviar mi currículo a una vacante confidencial ¿Existe una protección de mi información?";
$STR['Support_A6']					= "<p> Si. Los currículum de las vacantes confidenciales son captados y valorados por un especialista en reclutamiento de hikingmexico, el especialista envía tu currículo a la empresa contratante solo si considera que reúnes el perfil y que no existe ningún conflicto entre el candidato y la empresa contratante. </p>";

$STR['Support_Q7']					= "¿Cómo puedo actualizar mis datos?";
$STR['Support_A7']					= "<p> hikingmexico te brinda la opción de publicar tu currículum en formato PDF, o bien capturar la información necesaria para generar tu currículum. Puedes publicar o eliminar las veces que sea necesario tu documento PDF y puedes editar o eliminar las veces que sea necesario tu información capturada en el administrador de tu cuenta. </p>";

$STR['Support_Q8']					= "¿Qué diferencia existe en publicar mi información en formato PDF o capturarla en el portal?";
$STR['Support_A8']                      		= "<p> Las dos opciones son válidas. Una de las ventajas de ingresar tu información utilizando las herramientas que te brinda el portal <b>hikingmexico.com</b> es automatizar el envío de vacantes a tu correo electrónico afines a tu experiencia laboral, estudios académicos y expectativas. El equipo de hikingmexico verifica la información que ingreses tanto en el documento pdf como en el portal con el fin de brindarte un mejor apoyo en la búsqueda de un trabajo. </p>";

$STR['Support_Q9']					= "¿Cómo me registro para publicar mis vacantes?";
$STR['Support_A9']                  = "<p> Es necesario capturar la información de tu empresa en <a href=../companyregister/'>Registro de empresa</a> para crear tu usuario como empresa. Una vez creado tu usuario podrás publicar tus vacantes. Uno de nuestros asesores se pondrá en contacto  contigo vía telefónica o por correo electrónico para verificar que los datos  que has ingresado sobre tu empresa sean validos y correctos. </p>";


$STR['Support_Q10']					= "¿Cómo puedo eliminar una vacante que ya se cubrió?";
$STR['Support_A10']					= "<p> Puedes cambiar el estatus de tu vacante para indicar que el puesto esta cubierto, en ese momento la vacante quedara como no disponible para los postulantes. </p>";

$STR['Support_Q11']					= "¿Cómo puedo contratar un plan de anualidad?";

$STR['Employees']					= "Número de empleados";

$STR['InterviewDate']					= "Agendar entrevista";
$STR['AddInterviewDate']				= "Agenda de entrevista";
$STR['CreateInterviewDate']				= "Guardar agenda";

$STR['Support_A11']                      		= "<p> Dentro de tu módulo de administración puedes ingresar a la sección de planes anuales y ahí realizar la solicitud de tu plan. </p>";

$STR['CompanyRegistryBenefits']                         = "<h1>Beneficios</h1> <p>Me proporciona soluciones en la búsqueda de colaboradores con una gran eficacia, rapidez y a un bajo costo.</p> <p>¿Qué me ofrece <b>hikingmexico.com</b>?</p> <ul style='list-style: none;'> <li><img src='{faveIcon}' alt='fave' />Puedo publicar vacantes o bien contar con el apoyo del equipo de <b>hikingmexico.com</b> para publicarlas.</li> <li><img src='{faveIcon}' alt='fave' />Manejo discreto de vacantes confidenciales.</li> <li><img src='{faveIcon}' alt='fave' />Disponibilidad de currículums del banco de datos de <b>hikingmexico.com</b>.</li> <li><img src='{faveIcon}' alt='fave' />Vinculación de practicantes a través de <b>hikingmexico.com</b> con reconocidas universidades de la localidad.</li> <li><img src='{faveIcon}' alt='fave' />Los candidatos pueden conocer nuestra empresa a través del link publicado en las vacantes.</li> <li><img src='{faveIcon}' alt='fave' />Una encuesta de compensaciones que me permite conocer el sueldo de mercado y de nivel de vida.</li> </ul> <p>Lo anterior hace de <b>hikingmexico.com</b> mi portal favorito.</p> </h3> <br>";

$STR['PostulantRegistryBenefits']                       = "<h1>Beneficios</h1> <p>Puedes disfrutar de los siguientes beneficios, las cuales sólo están disponibles para miembros registrados de  <b>hikingmexico.com</b>.</p> <p><img src='{faveIcon}' alt='fave' />Administrar  tu cuenta, agregando y actualizando tus:</p> <ul> <li>Datos Personales.</li> <li>Estudios academicos.</li> <li>Experiencia laboral.</li> <li>Conocimiento en informática.</li> <li>Otros conocimientos.</li> <li>Idiomas.</li> <li>Expectativas laborales.</li> </ul> <p><img src='{faveIcon}' alt='fave' />Podrás  publicar tu currículum en formato PDF.</p> <p><img src='{faveIcon}' alt='fave' />Podrás  postularte en las vacantes disponibles.</p> <p><img src='{faveIcon}' alt='fave' />Tu información  será valorada continuamente por <b>hikingmexico.com</b> para identificar oportunidades  de trabajo afines a tu perfil.</p> <br>";

$STR['SelectVacancyForInterviewDate']			= "¿Deseas utilizar una de tus vacantes publicadas para ligarla a la nueva agenda de entrevista?";
$STR['VacancyForInterviewDateExist']			= "Ya existe una agenda ligada a esta vacante, consulta tu listado";

$STR['InterviewPeriod']                         = "Periodo de entrevista";
$STR['DateIn']                         			= "Fecha de inicio";
$STR['DateOut']                        			= "Fecha de término";

$STR['UnLimited']                        		= "Sin limite";

$STR['PostulantScrap']                        	= "Depurar postulantes";
$STR['PoorInfo']                       			= "Información faltante";
$STR['PendingToDelete']                			= "Pendientes a eliminar";
$STR['NotificationSended']                      = "Notificación enviada";
$STR['SendNotification']                      	= "Enviar notificación";
$STR['SendNotification_Dialog']                 = "Seguro que deseas enviar notificación?";
$STR['PostulantScrap_Dialog']                 	= "Seguro que deseas depurar a este postulante?";
$STR['ScrapCandidate']                      	= "Candidato a depurar";
$STR['PostulantScrap_remainingdays']            = "Faltan <strong>{days}</strong> dias</br>para depurar";

$STR['DontWantSelectVacancyForInterviewDate']	= "Prefiero No ligar a una vacante";

$STR['SalaryOfferedError']                      = "Sueldo ofrecido debe ser mayor o igual a $ {salaryOffered} (M.N. Mensual)";
$STR['SalaryError']                      		= "Sueldo percibido debe ser mayor o igual a $ {salaryOffered} (M.N. Mensual)";

$STR['ScrapNotification_Subject']				= "Completa y actualiza tu perfil";
$STR['ScrapNotification']						= "<p>{logo}</p> <p>Hola <strong>{userName}</strong>.<strong></strong><br /> </p> <p>Al contar con tu currículum completo (100%) nos permite recomendarte a vacantes según tu perfil.</p> <table width='621' border='1' cellpadding='0' cellspacing='0'> <tr> <td width='155'>Datos personales</td> <td width='265'><strong>{aveAccountData}</strong> % completado</td> </tr> <tr> <td>Académicos</td> <td><strong>{aveAcademic} </strong>% completado</td> </tr> <tr> <td>Experiencia laboral</td> <td><strong>{aveJobExperience} </strong>% completado</td> </tr> <tr> <td>Informática</td> <td><strong>{aveInformatic} </strong>% completado</td> </tr> <tr> <td>Más conocimientos</td> <td><strong>{aveKnowledge} </strong>% completado</td> </tr> <tr> <td>Idiomas</td> <td><strong>{aveLanguages} </strong>% completado</td> </tr> <tr> <td>Expectativas</td> <td><strong>{aveExpectatives} </strong>% completado</td> </tr> </table> <p>Te sugerimos completar y actualizar tu información.</p> <p>Gracias por utilizar <b>hikingmexico.com</b>. <br /> <br /> Si tienes preguntas o inquietudes sobre tu cuenta, por favor visita<br /> <a href='{linkSupport}'>{linkSupport}</a> o escríbenos   a {jobEmail} con gusto te brindaremos soporte.</p>";

$STR['RequestCode']                       		= "Código de solicitud";
$STR['RequestStatus']                       	= "Estatus de solicitud";
$STR['RequestCreationDate']                     = "Fecha de creación de solicitud";
$STR['RequestPlanName']                       	= "Nombre del plan de anualidad";
$STR['RequestComment']                       	= "Comentario de solicitante";
$STR['RequestPlanInfo']                       	= "Información del plan de anualidad solicitado";
$STR['AsignedPlanInfo']                       	= "Información del plan de anualidad actual";

$STR['ScrapPostulantSubject']                   = "{site}, registro de cuenta";
$STR['ScrapPostulantMail']                      = "<p>{logo}</p> <p><br /> Hola <strong>{userName}</strong>.</p> <p><br /> Con la finalidad de  brindarte un mejor servicio hemos actualizado nuestro portal.</p> <ul> <li>Ahora es más  fácil consultar nuestro catálogo de opciones de trabajo.</li> <li>Te ofrecemos  un nuevo filtro automático y personalizado de  las opciones de trabajo disponibles en base a tu experiencia laboral, estudios  académicos y expectativas laborales. </li> <li>Para una  mayor comodidad ahora puedes publicar tu currículo en formato PDF.</li> <li>Seguimos  ofreciéndote un enlace personalizado entre tú y la empresa solicitante.</li> </ul> <p>Nuestra principal prioridad es  ubicarte en un mejor trabajo, por lo que es necesario que tu currículo este  completo de esta manera podremos recomendarlo, te invitamos a capturarlo  nuevamente de manera completa.<br /> </p> <p>Puedes capturar tu  currículo <a href='{postulantRegisterLink}'><strong>aquí</strong></a><br /> <strong>{postulantRegisterLink}</strong></p> <p><b>hikingmexico.com</b> te da  las gracias y seguimos trabajando para ofrecerte un mejor servicio.</p>"; 


$STR['AnnualPlanUpdated']						= "Plan actualizado";
$STR['AdminComment']							= "Comentario de administrador";

$STR['Renew']									= "Renovar publicación";
$STR['Msg_Renew_Success']						= "Renovación exitosa";

$STR['TotalPostulants']							= "Total de postulantes";
$STR['TotalAutenticated']						= "Autenticados";

$STR['UnAutenticated']							= "Sin Autenticar";
$STR['Autenticated']							= "Autenticado";
$STR['Autenticate']								= "Autenticar";

$STR['Companies']								= "Compañías";
$STR['TotalCompanies']							= "Total de compañías";

$STR['TotalHitsCounter']						= "Total de accesos";

$STR['Verify']									= "Verificar";
$STR['Verified']								= "Verificado";
$STR['UnVerified']								= "Sin verificar";

$STR['getPortalInfo']							= "Obtener Información de <b>hikingmexico.com</b>";

$STR['HitsCounter']								= "Contador de accesos";

$STR['Order']									= "Orden";

$STR['TotalVacancies']							= "Total de vacantes";
$STR['LastVacancyPublicated']					= "Última vacante publicada";
$STR['TotalActiveVacancies']					= "Vacantes activas";

$STR['Publicity']								= "Publicidad";
$STR['ListPublicity']							= "Listado de publicidad";
$STR['AddPublicity']							= "Agregar publicidad";
$STR['EditPublicity']							= "Editar publicidad";

$STR['SortEnablePublicity']						= "Ordenar publicidad activa";
$STR['ShowEnablePublicity']						= "Ver publicidad activa";
$STR['ShowFinishedPublicity']					= "Ver publicidad finalizada";

$STR['CompanyEmailAutenticate']					= "Autenticar correo electrónico de empresa";
$STR['CompanyInfoVerified']						= "Verificar información de empresa";

$STR['ImagePublicityDimensions']				= "El tamaño de la imagen debe ser de 940 ancho x 280 alto pixeles";


$STR['LinkToVacancy']							= "Enlazar postulante";
$STR['LinkPostulantToVacancy']					= "Enlazar";

$STR['ChangeAccountStatus']						= "Cambiar estatus de cuenta";
$STR['EnableAccount']							= "Habilitar cuenta";
$STR['DisableAccount']							= "Deshabilitar cuenta";

$STR['Verificated_success']						= "Verificado correctamente";