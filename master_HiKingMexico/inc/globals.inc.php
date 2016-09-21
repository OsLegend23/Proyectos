<?php
date_default_timezone_set('America/Tijuana');

$GLOBAL                                         = array();

$GLOBAL['debug-log']                            = 'false';
$GLOBAL['show_server_vars']                     = 'false';


$GLOBAL['site']                                 = 'hikingmexico.com';
$GLOBAL['site-min']                             = 'hikingmexico.com';

$GLOBAL['root-local']                           = 'HiKingMexico';
$GLOBAL['root-server']                          = 'public_html';
$GLOBAL['root']                                 = strpos($_SERVER['SCRIPT_FILENAME'], $GLOBAL['root-local']) > 0 ? $GLOBAL['root-local'] : $GLOBAL['root-server'];

$GLOBAL['root-local-jumps']                     = 2;
$GLOBAL['root-server-jumps']                    = 2;
$GLOBAL['root-jumps']                           = strpos($_SERVER['SCRIPT_FILENAME'], $GLOBAL['root-local']) > 0 ? $GLOBAL['root-local-jumps'] : $GLOBAL['root-server-jumps'];

$GLOBAL['domain-local']                         = 'http://localhost:8080/master_HiKingMexico/';
$GLOBAL['domain-server']                        = 'http://www.hikingmexico.com/';

$GLOBAL['domain-root']                          = strpos($_SERVER['SCRIPT_FILENAME'], $GLOBAL['root-local']) > 0 ? $GLOBAL['domain-local'] : $GLOBAL['domain-server'];

$GLOBAL['mode-localhost']                       = strpos($_SERVER['SCRIPT_FILENAME'], $GLOBAL['root-local']) > 0 ? true : false;
$GLOBAL['debug']                                = strpos($_SERVER['SCRIPT_FILENAME'], $GLOBAL['root-local']) > 0 ? 1 : 0;

$GLOBAL['show_error_reporting']                 = strpos($_SERVER['SCRIPT_FILENAME'], $GLOBAL['root-local']) > 0 ? 'true' : 'false';

$GLOBAL['icon']                                 = 'icon.png';

$GLOBAL['jquery']                               = 'jQuery/jquery-1.7.1.min.js';

$GLOBAL['theme']                                = 'Materialize';
$GLOBAL['jquery-ui']                            = 'jquery-ui-1.10.4';

$GLOBAL['logo']                                 = 'logoHikingMexico.png';

$GLOBAL['noRequiredId']                         = '9999';

$GLOBAL['emailVerificationRemainingDays']       = '30';
$GLOBAL['promotionPlannRemainingDays']          = '30';
$GLOBAL['postulantScrapRemaininDays']           = '90';

/* DATA BASE CONNECTION */
/*$GLOBAL['db_host']                              = 'mysql.hostinger.mx';
$GLOBAL['db_name']                              = 'u290960162_hkm';
$GLOBAL['db_user']                              = 'u290960162_hkm';
$GLOBAL['db_password']                          = 'nemesis@23';*/

$GLOBAL['db_host']                              = 'localhost';
$GLOBAL['db_name']                              = 'hiKingMexico';
$GLOBAL['db_user']                              = 'root';
$GLOBAL['db_password']                          = 'nemesis@23';

/* USER STATUS */
$GLOBAL['user_enable']                          = array('label' => 'Habilitado', 'value' => 1000);
$GLOBAL['user_disable']                         = array('label' => 'Deshabiliado', 'value' => 1001);
$GLOBAL['user_blocked']                         = array('label' => 'Bloqueado', 'value' => 1002);
$GLOBAL['user_unsingned']                       = array('label' => 'Sin autenticar', 'value' => 1003);

$GLOBAL['user_status']                          = array('1000' => $GLOBAL['user_enable'],
                                                        '1001' => $GLOBAL['user_disable'],
                                                        '1002' => $GLOBAL['user_blocked'],
                                                        '1003' => $GLOBAL['user_unsingned']);


$GLOBAL['user_postulant']                       = array('label' => 'Postulante', 'location' => 'postulant', 'value' => 2000);
$GLOBAL['user_company']                         = array('label' => 'Empresa', 'location' => 'company', 'value' => 3000);
$GLOBAL['user_administrator']                   = array('label' => 'Administrador', 'location' => 'PanelHKM', 'value' => 4000);
$GLOBAL['user_websupport']                      = array('label' => 'Web Support', 'location' => 'PanelHKM', 'value' => 5000);
$GLOBAL['user_guest']                           = array('label' => 'Invitado', 'location' => 'guest', 'value' => 0000);

$GLOBAL['user_list']                            = array('2000' => $GLOBAL['user_postulant'],
                                                        '3000' => $GLOBAL['user_company'],
                                                        '4000' => $GLOBAL['user_administrator'],
                                                        '5000' => $GLOBAL['user_websupport'],
                                                        '0000' => $GLOBAL['user_guest']);

$GLOBAL['email_job']                            = 'trabajo@hikingmexico.com';
$GLOBAL['email_support']                        = 'soporte@hikingmexico.com';
$GLOBAL['email_associated']                     = 'asociados@hikingmexico.com';
$GLOBAL['email_enlace']                         = 'enlace@hikingmexico.com';
$GLOBAL['email_hotmail']                        = 'enlaceempleo_oficial@hotmail.com';
$GLOBAL['email_no_reply']                       = 'no-reply@hikingmexico.com';


$GLOBAL['min_years_ago']                        = '17';
$GLOBAL['max_years_ago']                        = '66';

$GLOBAL['salaryOffered']                        = '4000';


/* VACANCY STATUS */
$GLOBAL['vacancy_enable']                       = array('label' => 'Publicación activa', 'value' => 1);
$GLOBAL['vacancy_canceled']                     = array('label' => 'Suspender publicación', 'value' => 2);
$GLOBAL['vacancy_taken']                        = array('label' => 'Vacante cubierta', 'value' => 3);


$GLOBAL['vacancy_status']                       = array(1 => $GLOBAL['vacancy_enable'],
                                                        2 => $GLOBAL['vacancy_canceled'],
                                                        3 => $GLOBAL['vacancy_taken']);


/* COMMON STATUS */
$GLOBAL['status_enable']                        = array('label' => 'Activo', 'value' => 'A');
$GLOBAL['status_finished']                      = array('label' => 'Finalizado', 'value' => 'F');

$GLOBAL['status']                               = array('A' => $GLOBAL['status_enable'],
                                                        'F' => $GLOBAL['status_finished']);

/* ANNUAL PLAN STATUS */
$GLOBAL['plan_enable']                          = array('label' => 'Activo', 'value' => 'A');
$GLOBAL['plan_outrange']                        = array('label' => 'Finalizado', 'value' => 'F');

$GLOBAL['plan_status']                          = array('A' => $GLOBAL['plan_enable'],
                                                        'F' => $GLOBAL['plan_outrange']);


/* INTERVIEWDATE STATUS */
$GLOBAL['interview_enable']                     = array('label' => 'Activo', 'value' => 'A');
$GLOBAL['interview_suspended']                  = array('label' => 'Suspendido', 'value' => 'S');
$GLOBAL['interview_finished']                   = array('label' => 'Finalizado', 'value' => 'F');

$GLOBAL['interview_status']                     = array('A' => $GLOBAL['interview_enable'],
                                                        'S' => $GLOBAL['interview_suspended'],
                                                        'F' => $GLOBAL['interview_finished']);

$GLOBAL['postulant_MaxStudies']                 = '5';
$GLOBAL['postulant_MaxInformatic']              = '5';
$GLOBAL['postulant_MaxLanguages']               = '5';
$GLOBAL['postulant_MaxExperience']              = '5';
$GLOBAL['postulant_MaxKnowledge']               = '5';
$GLOBAL['postulant_MaxExpectatives']            = '5';


$GLOBAL['vacancy_MaxStudies']                   = '5';
$GLOBAL['vacancy_MaxInformatic']                = '5';
$GLOBAL['vacancy_MaxLanguages']                 = '5';
$GLOBAL['vacancy_MaxExperience']                = '5';
$GLOBAL['vacancy_MaxKnowledge']                 = '5';
$GLOBAL['vacancy_MaxExpectatives']              = '5';

$GLOBAL['Verified_YES']                         = 'S';
$GLOBAL['Verified_NO']                          = 'N';

$GLOBAL['Authenticated_YES']                    = 'S';
$GLOBAL['Authenticated_NO']                     = 'N';

$GLOBAL['confidential_YES']                     = 'S';
$GLOBAL['confidential_NO']                      = 'N';

$GLOBAL['linkPhotoCompany']                     = 'media/image/photo/company/';
$GLOBAL['linkPhotoPostulant']                   = 'media/image/photo/postulant/';
$GLOBAL['postulantDefaultImage']                = 'media/image/photo/postulant/default/';
$GLOBAL['companyDefaultImage']                  = 'media/image/photo/company/default/';

$GLOBAL['postulantCVfile']                      = 'media/cvfile/';

$GLOBAL['linkslideshow']                        = 'media/image/slideshow/';


$GLOBAL['vacancy_normalPriority']               = '1';
$GLOBAL['vacancy_highPriority']                 = '2';
$GLOBAL['vacancy_priority']                     = array('1' => 'Normal',
                                                        '2' => 'Alta');


/* PASSWORD NO CHANGED */
$GLOBAL['passwordNotChanged']                   = 'PwdN0tC4ng3d';
$GLOBAL['token']                                = '*T0K3N#';

$GLOBAL['photoTypes']                           = array('jpg', 'jpeg', 'png', 'gif', 'bmp');
$GLOBAL['fileTypes']                            = array('pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'rar', 'zip');
$GLOBAL['PDFfileType']                          = array('pdf');
$GLOBAL['AllfileTypes']                         = array_merge($GLOBAL['fileTypes'], $GLOBAL['photoTypes']);

$GLOBAL['photoTypes_image']                     = array('jpg' => 'file_img', 'jpeg' => 'file_img', 'png' => 'file_img', 'gif' => 'file_img', 'bmp' => 'file_img');
$GLOBAL['fileTypes_image']                      = array('pdf' => 'file_pdf', 'doc' => 'file_doc', 'docx' => 'file_doc', 'xls' => 'file_xls', 'xlsx' => 'file_xls', 'ppt' => 'file_ppt', 'pptx' => 'file_ppt', 'rar' => 'file_zip', 'zip' => 'file_zip');
$GLOBAL['AllfileTypes_image']                   = array_merge($GLOBAL['fileTypes_image'], $GLOBAL['photoTypes_image']);

$GLOBAL['date_range']                           = '99';
$GLOBAL['date_currentYear']                     = date('Y');
$GLOBAL['date_lastYear']                        = date('Y') - $GLOBAL['date_range'];


$GLOBAL['vld_tx_email']                         = "validate[required,custom[email],maxSize[50]] text-input";
$GLOBAL['vld_confirm_tx_email']                 = "validate[required,custom[email],equals[Email],maxSize[50]] text-input";
$GLOBAL['vld_tx_password']                      = "validate[required,minSize[6],maxSize[15]] text-input";
$GLOBAL['vld_confirm_tx_password']              = "validate[required,minSize[6],equals[Pass],maxSize[15]] text-input";
$GLOBAL['vld_tx_req']                           = "validate[required] text-input";
$GLOBAL['vld_tx_req_max10']                     = "validate[required,maxSize[10]] text-input";
$GLOBAL['vld_tx_req_max15']                     = "validate[required,maxSize[15]] text-input";
$GLOBAL['vld_tx_req_max16']                     = "validate[required,maxSize[16]] text-input";
$GLOBAL['vld_tx_req_max20']                     = "validate[required,maxSize[20]] text-input";
$GLOBAL['vld_tx_req_max25']                     = "validate[required,maxSize[25]] text-input";
$GLOBAL['vld_tx_req_max50']                     = "validate[required,maxSize[50]] text-input";
$GLOBAL['vld_tx_req_max100']                    = "validate[required,maxSize[100]] text-input";
$GLOBAL['vld_tx_req_max150']                    = "validate[required,maxSize[150]] text-input";
$GLOBAL['vld_tx_req_max600']                    = "validate[required,maxSize[600]] text-input";
$GLOBAL['vld_tx_area_opt_max600']               = "validate[optional,maxSize[600]";
$GLOBAL['vld_tx_opt_max10']                     = "validate[optional,maxSize[10]] text-input";
$GLOBAL['vld_tx_opt_max15']                     = "validate[optional,maxSize[15]] text-input";
$GLOBAL['vld_tx_opt_max16']                     = "validate[optional,maxSize[16]] text-input";
$GLOBAL['vld_tx_opt_max20']                     = "validate[optional,maxSize[20]] text-input";
$GLOBAL['vld_tx_opt_max25']                     = "validate[optional,maxSize[25]] text-input";
$GLOBAL['vld_tx_opt_max50']                     = "validate[optional,maxSize[50]] text-input";
$GLOBAL['vld_tx_opt_max100']                    = "validate[optional,maxSize[100]] text-input";
$GLOBAL['vld_tx_opt_max150']                    = "validate[optional,maxSize[150]] text-input";
$GLOBAL['vld_tx_opt_max600']                    = "validate[optional,maxSize[600]] text-input";
$GLOBAL['vld_ch_req_radio']                     = "validate[required] radio";
$GLOBAL['vld_dt_req']                           = "validate[required,custom[date]] text-input";
$GLOBAL['vld_nm_req']                           = "validate[required]";
$GLOBAL['vld_nm_opt']                           = "validate[optional]";
$GLOBAL['vld_ch_req_checkbox_min1']             = "validate[minCheckbox[1]] checkbox";
$GLOBAL['vld_ch_req_max3']                      = "validate[required ,maxSize[3]] text-input";
$GLOBAL['vld_nm_req_on']                        = "validate[required ,custom[number]] text-input";
$GLOBAL['vld_nm_req_max4_on']                   = "validate[required ,maxSize[4],custom[number]] text-input";
$GLOBAL['vld_nm_opt_max4_on']                   = "validate[optional ,maxSize[4],custom[number]] text-input";
$GLOBAL['vld_nm_req_max15_on']                  = "validate[required,maxSize[15],custom[number]] text-input";
?>