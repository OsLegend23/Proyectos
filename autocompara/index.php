<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <title>Cotiza, compara y contrata el mejor seguro para tu autom&oacute;vil |Solo en Autocompara </title>
        <!-- Bootstrap -->
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js" type="text/javascript"></script>
        <script src="lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/jquery.form.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var options = {
                    beforeSubmit: showLoader,
                    success: showResponse,
                };
                // bind to the form's submit event 
                $('#myForm').submit(function() {
                    $(this).ajaxSubmit(options);
                    return false;
                });

                $('#modelo').change(function() {
                    getMarca(this.value);
                    $("#loading_marca").fadeIn("slow");
                    $("#loading_marca").fadeOut("slow");
                });
                $('#marca').change(function() {
                    getSubMarca($('#modelo').val(), escape(this.value));
                    getSerieGNP($('#modelo').val(), escape(this.value));
                    $(".loading_serie").fadeIn("slow");
                    $(".loading_serie").fadeOut("slow");
                });
                $('#serie').change(function() {
                    getVersion($('#modelo').val(), escape($('#marca').val()), escape(this.value));
                    $("#loading_version").fadeIn("slow");
                    $("#loading_version").fadeOut("slow");
                });
                $('#sel_estado').change(function() {
                    getMpo(escape(this.value));
                    $("#loading_mpo").fadeIn("slow");
                    $("#loading_mpo").fadeOut("slow");
                });
                //$('#myForm').ajaxForm(options);
                var form;
                function showLoader() {
                    $("#loader_gif").fadeIn("slow");
                    form = $("#myForm").detach();
                }
                ;

                function showResponse(responseText) {
                    $("#loader_gif").fadeOut("slow");
                    $("#result").append(responseText);
//                    $(".modal-body").append(responseText);
                }
                ;

                function getMarca(year) {
                    $("#marca").load('collect_info.php?year=' + year + '&getMarca=1');
                }
                ;
                function getSubMarca(year, marca) {
                   $("#serie").load('collect_info.php?year=' + year + '&marca=' + marca + '&getSubMarca=1');
                }
                ;
                function getVersion(year, marca, submarca) {
                    $("#version").load('collect_info.php?year=' + year + '&marca=' + marca + '&subMarca=' + submarca + '&getVersion=1');
                }
                ;
                function getMpo(idState) {
                    $("#Mpo").load('collect_info.php?idMpo=' + idState + '&getMpo=1');
                }
                ;
                function getSerieGNP(year, marca) {
                    $("#serieGNP").load('collect_info.php?year=' + year + '&marca=' + marca + '&getSubMarcaGNP=1');
                }
                ;
            });
        </script>
    </head>

    <body>
        <br>
        <div class="container">
            <div class="row">
                <div class="span2"></div>
                <div class="span8" id="logo" style="text-align: center;">
                    <img class="img-rounded" src="img/haztusegurologo.png" alt="Haz Tu Seguro" />
                </div>
                <div class="span2"></div>
            </div>
            <div class="row" id="result">
            </div>
            <div class="row">
                <div class="span2"></div>
                <div id="formulario" class="span8">
                    <div style="text-align: center;">
                        <img id="loader_gif" src="img/loader.gif" style="display: none;" alt="loading"/>
                    </div>
                    <form id="myForm" class="form-horizontal well" action="cotizaSeguro.php" method="post">
                        <fieldset>
                            <h2>Datos Personales</h2>
                            <hr/>
                            <div class="control-group">
                                <label class="control-label">
                                    *Nombre:
                                </label>
                                <div class="controls">
                                    <input class="input-xlarge" type="text" id="nombre" tabindex="1" name="nombre" placeholder="Nombre" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">
                                    *Apellido Paterno:
                                </label>
                                <div class="controls">
                                    <input class="input-xlarge" type="text" id="apPaterno" tabindex="2" name="apPaterno" placeholder="Apellido Paterno" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">
                                    Apellido Materno:
                                </label>
                                <div class="controls">
                                    <input class="input-xlarge" type="text" id="apMaterno" tabindex="3" name="apMaterno" placeholder="Apellido Materno" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">
                                    Sexo:
                                </label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="genero" tabindex="4" checked="" value="Hombre" >
                                        Hombre
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="genero" tabindex="5" value="Mujer" >
                                        Mujer
                                    </label>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">
                                    *Mail:
                                </label>
                                <div class="controls">
                                    <input class="input-xlarge" type="text" maxlength="70" id="eMail" tabindex="6" name="eMail" placeholder="user@domain" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">
                                    *Celular (10 dígitos):
                                </label>
                                <div class="controls">
                                    <input class="input-xlarge" type="text" id="Cel" tabindex="7" name="Cel" placeholder="###" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">
                                    Estado:
                                </label>
                                <div class="controls">
                                    <select id="sel_estado" name="sel_estado" tabindex="8" style="width:80%;">
                                        <option value="-111" selected="selected">&lt;SELECCIONAR ESTADO&gt;</option>
                                        <option value="1@AGUASCALIENTES">AGUASCALIENTES</option>
                                        <option value="2@BAJA CALIFORNIA">BAJA CALIFORNIA</option>
                                        <option value="3@BAJA CALIFORNIA SUR">BAJA CALIFORNIA SUR</option>
                                        <option value="4@CAMPECHE">CAMPECHE</option>
                                        <option value="7@CHIAPAS">CHIAPAS</option>
                                        <option value="8@CHIHUAHUA">CHIHUAHUA</option>
                                        <option value="5@COAHUILA">COAHUILA</option>
                                        <option value="6@COLIMA">COLIMA</option>
                                        <option value="9@DISTRITO FEDERAL">DISTRITO FEDERAL</option>
                                        <option value="10@DURANGO">DURANGO</option>
                                        <option value="15@ESTADO DE MEXICO">ESTADO DE MEXICO</option>
                                        <option value="11@GUANAJUATO">GUANAJUATO</option>
                                        <option value="12@GUERRERO">GUERRERO</option>
                                        <option value="13@HIDALGO">HIDALGO</option>
                                        <option value="14@JALISCO">JALISCO</option>
                                        <option value="16@MICHOACAN">MICHOACAN</option>
                                        <option value="17@MORELOS">MORELOS</option>
                                        <option value="18@NAYARIT">NAYARIT</option>
                                        <option value="19@NUEVO LEON">NUEVO LEON</option>
                                        <option value="20@OAXACA">OAXACA</option>
                                        <option value="21@PUEBLA">PUEBLA</option>
                                        <option value="22@QUERETARO">QUERETARO</option>
                                        <option value="23@QUINTANA ROO">QUINTANA ROO</option>
                                        <option value="24@SAN LUIS POTOSI">SAN LUIS POTOSI</option>
                                        <option value="25@SINALOA">SINALOA</option>
                                        <option value="26@SONORA">SONORA</option>
                                        <option value="27@TABASCO">TABASCO</option>
                                        <option value="29@TLAXCALA">TLAXCALA</option>
                                        <option value="30@VERACRUZ">VERACRUZ</option>
                                        <option value="31@YUCATAN">YUCATAN</option>
                                        <option value="32@ZACATECAS">ZACATECAS</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">
                                    Municipio:
                                </label>
                                <div class="controls">
                                    <select id="Mpo" name="Mpo" tabindex="9" style="width:80%;">
                                        <option value="-111">SELECCIONA UNA OPCION</option>
                                    </select>
                                    <span class="help-inline">
                                        <img id="loading_mpo" src="img/loading.gif" alt="loadign" style="display: none" />
                                    </span>
                                </div>
                            </div>
                            <hr/>
                            <h2>Cotiza</h2>
                            <hr/>
                            <div class="control-group">
                                <label class="control-label">
                                    Modelo:
                                </label>
                                <div class="controls">
                                    <select id="modelo" tabindex="10" name="modelo" style="width:80%;">
                                        <option value="-111">SELECCIONA UNA OPCION</option>
                                        <option value="2014">2014</option>
                                        <option value="2013">2013</option>
                                        <option value="2012">2012</option>
                                        <option value="2011">2011</option>
                                        <option value="2010">2010</option>
                                        <option value="2009">2009</option>
                                        <option value="2008">2008</option>
                                        <option value="2007">2007</option>
                                        <option value="2006">2006</option>
                                        <option value="2005">2005</option>
                                        <option value="2004">2004</option>
                                        <option value="2003">2003</option>
                                        <option value="2002">2002</option>
                                        <option value="2001">2001</option>
                                        <option value="2000">2000</option>
                                        <option value="1999">1999</option>
                                        <option value="1998">1998</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">
                                    Marca:
                                </label>
                                <div class="controls">
                                    <select id="marca" tabindex="11" name="marca" style="width:80%;">
                                        <option value="-111">SELECCIONA UNA OPCION</option>
                                    </select>
                                    <span class="help-inline">
                                        <img id="loading_marca" src="img/loading.gif" alt="loadign" style="display: none" />
                                    </span>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">
                                    Serie Anaseguros/ATLAS:
                                </label>
                                <div class="controls">
                                    <select id="serie" tabindex="12" name="serie" style="width:80%;">
                                        <option value="-111">SELECCIONA UNA OPCION</option>
                                    </select>
                                    <span class="help-inline">
                                        <img class="loading_serie" src="img/loading.gif" alt="loadign" style="display: none" />
                                    </span>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">
                                    Serie GNP:
                                </label>
                                <div class="controls">
                                    <select id="serieGNP" tabindex="13" name="serieGNP" style="width:80%;">
                                        <option value="-111">SELECCIONA UNA OPCION</option>
                                    </select>
                                    <span class="help-inline">
                                        <img class="loading_serie" src="img/loading.gif" alt="loadign" style="display: none" />
                                    </span>
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">
                                    Versión:
                                </label>
                                <div class="controls">
                                    <select id="version" tabindex="14" name="version" style="width:80%;">
                                        <option value="-111">SELECCIONA UNA OPCION</option>
                                    </select>
                                    <span class="help-inline">
                                        <img id="loading_version" src="img/loading.gif" alt="loadign" style="display: none" />
                                    </span>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" name="cmdCotizar" tabindex="15" value="COTIZAR" id="cmdCotizar" class="btn btn-info">
                            </div>

                        </fieldset>
                    </form>
                </div>
                <div class="span2"></div>
            </div>
        </div>
    </body>
</html>