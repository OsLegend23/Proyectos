<?php

/*
  remote.php
 */
session_start();

class remote {

    var $accountId;
    var $COMMON;
    var $db;
    var $STR;
    var $GLOBAL;
    var $QUERY;
    var $day_of_week;
    var $day_of_weekFull;
    var $month;
    var $monthFull;
    var $datefmt;

    function __construct() {
        include('../../inc/common.inc.php');
        include($COMMON->getMySQL());
        include($COMMON->getQuery());
        $this->db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
        $QUERY = new Query($this->db, $GLOBAL);

        $this->COMMON = $COMMON;
        $this->STR = $STR;
        $this->GLOBAL = $GLOBAL;
        $this->QUERY = $QUERY;
        $this->accountId = isset($_SESSION['enlaceemp_accountid']) ? $_SESSION['enlaceemp_accountid'] : null;

        $this->day_of_week = $day_of_week;
        $this->day_of_weekFull = $day_of_weekFull;
        $this->month = $month;
        $this->monthFull = $monthFull;
        $this->datefmt = $datefmt;
    }

    function simplequery() {
        $page = $_POST['page'];
        $rowsPerPage = $_POST['rowsPerPage'];

        $keyword = $this->COMMON->getEscapeString($_POST['keyword']);
        $location = $this->COMMON->getEscapeString($_POST['location']);

        $condition = "WHERE a.ch_status = '" . $this->GLOBAL['vacancy_enable']['value'] . "' AND k.nm_status = '" . $this->GLOBAL['user_enable']['value'] . "'";

        if (strlen($keyword) > 0) {
            $rGetSubarea = $this->QUERY->getSubarea(" WHERE a.tx_description LIKE '%$keyword%' GROUP BY a.id_workarea");

            $condition.= " AND (a.tx_name LIKE '%$keyword%' OR d.tx_description LIKE '%$keyword%' OR a.id = '$keyword' ";


            while ($rSubarea = $rGetSubarea->fetch()) {

                $workArea = $rSubarea['id_workarea'];
                $condition.= "OR a.id_workarea = '$workArea' ";
            }

            $condition.= " ) ";
        }

        if ($location > 0)
            $condition.= " AND (a.id_location = '$location') ";

        $condition.=' GROUP BY a.id ORDER BY a.dt_update DESC, a.tx_hour DESC ';

        $rGetVacancy = $this->QUERY->searchVacancy($condition);

        $answer = array('page' => $page, 'total' => $rGetVacancy->size(), 'rows' => array());

        $limitINIT = $page == 1 ? 0 : ($page - 1) * $rowsPerPage;

        $condition.= " LIMIT $limitINIT, $rowsPerPage";

        $rGetVacancy = $this->QUERY->searchVacancy($condition);

        while ($row = $rGetVacancy->fetch()) {


            $idVacancy = $row['id'];
            $tx_name = $row['tx_name'];
            $tx_trademark = $row['ch_confidential'] == $this->GLOBAL['confidential_YES'] ? $row['tx_confidential_trademark'] : $row['tx_trademark'];
            $dt_update = $row['dt_update'];
            $vacancytype = $row['vacancy_type_tx_description'];
            $tx_city = $row['tx_city'];
            $id_company = $row['id_company'];
            $tx_image = $row['tx_image'];


            $dt_update = date("j-n-Y", strtotime($dt_update));
            $dt_update = explode('-', $dt_update);

            $dt_update_day = $dt_update[0];
            $dt_update_month = $this->month[$dt_update[1]];
            $dt_update_year = $dt_update[2];

            $folder = $id_company;
            $link = $this->GLOBAL['linkPhotoCompany'] . $folder . '/';

            if ($row['ch_confidential'] == $this->GLOBAL['confidential_YES']) {
                $fileImage = $this->COMMON->findPhoto("confidential_30p", $this->GLOBAL['linkPhotoCompany'] . "confidential" . '/', '../');
            } else {
                $fileImage = $this->COMMON->findPhoto($tx_image . '_30p', $link, '../');

                if (!$fileImage)
                    $fileImage = $this->COMMON->findPhoto('default_30p', $this->GLOBAL['companyDefaultImage'], '../');
            }

            $entry = array(
                'id' => $idVacancy
                , 'tx_tradename' => $tx_trademark
                , 'idVacancy' => $idVacancy
                , 'fileImage' => $fileImage
                , 'tx_name' => $tx_name
                , 'labelVacancyType' => $this->STR['VacancyType']
                , 'vacancytype' => $vacancytype
                , 'day' => $dt_update_day
                , 'month' => $dt_update_month
                , 'year' => $dt_update_year
                , 'labelLocation' => $this->STR['Location']
                , 'location' => $tx_city
                , 'labelSector' => $this->STR['Sector']
            );

            $answer['rows'][] = $entry;
        }

        echo json_encode($answer);
    }

    function advancedquery() {
        $page = $_POST['page'];
        $rowsPerPage = $_POST['rowsPerPage'];

        $workArea = $this->COMMON->getEscapeString($_POST['workArea']);
        $location = $this->COMMON->getEscapeString($_POST['location']);

        $condition = "WHERE a.ch_status = '" . $this->GLOBAL['vacancy_enable']['value'] . "' AND k.nm_status = '" . $this->GLOBAL['user_enable']['value'] . "'";

        if ($workArea > 0)
            $condition .= " AND (a.id_workarea = '$workArea') ";

        if ($location > 0)
            $condition .= " AND (a.id_location = '$location') ";

        $condition.=' GROUP BY a.id ORDER BY a.dt_update DESC, a.tx_hour DESC ';

        $rGetVacancy = $this->QUERY->searchVacancy($condition);

        $answer = array('page' => $page, 'total' => $rGetVacancy->size(), 'rows' => array());

        $limitINIT = $page == 1 ? 0 : ($page - 1) * $rowsPerPage;

        $condition.= " LIMIT $limitINIT, $rowsPerPage";

        $rGetVacancy = $this->QUERY->searchVacancy($condition);

        while ($row = $rGetVacancy->fetch()) {
            $idVacancy = $row['id'];
            $tx_name = $row['tx_name'];
            $tx_trademark = $row['ch_confidential'] == $this->GLOBAL['confidential_YES'] ? $row['tx_confidential_trademark'] : $row['tx_trademark'];
            $dt_update = $row['dt_update'];
            $vacancytype = $row['vacancy_type_tx_description'];
            $tx_city = $row['tx_city'];
            $id_company = $row['id_company'];
            $tx_image = $row['tx_image'];


            $dt_update = date("j-n-Y", strtotime($dt_update));
            $dt_update = explode('-', $dt_update);

            $dt_update_day = $dt_update[0];
            $dt_update_month = $this->month[$dt_update[1]];
            $dt_update_year = $dt_update[2];

            $folder = $id_company;
            $link = $this->GLOBAL['linkPhotoCompany'] . $folder . '/';

            if ($row['ch_confidential'] == $this->GLOBAL['confidential_YES']) {
                $fileImage = $this->COMMON->findPhoto("confidential_30p", $this->GLOBAL['linkPhotoCompany'] . "confidential" . '/', '../');
            } else {
                $fileImage = $this->COMMON->findPhoto($tx_image . '_30p', $link, '../');

                if (!$fileImage)
                    $fileImage = $this->COMMON->findPhoto('default_30p', $this->GLOBAL['companyDefaultImage'], '../');
            }

            $entry = array(
                'id' => $idVacancy
                , 'tx_tradename' => $tx_trademark
                , 'idVacancy' => $idVacancy
                , 'fileImage' => $fileImage
                , 'tx_name' => $tx_name
                , 'labelVacancyType' => $this->STR['VacancyType']
                , 'vacancytype' => $vacancytype
                , 'day' => $dt_update_day
                , 'month' => $dt_update_month
                , 'year' => $dt_update_year
                , 'labelLocation' => $this->STR['Location']
                , 'location' => $tx_city
                , 'labelSector' => $this->STR['Sector']
            );

            $answer['rows'][] = $entry;
        }

        echo json_encode($answer);
    }

    function practices() {
        $page = $_POST['page'];
        $rowsPerPage = $_POST['rowsPerPage'];

        $location = $this->COMMON->getEscapeString($_POST['location']);
        $studyLevel = $this->COMMON->getEscapeString($_POST['studyLevel']);
        $studyArea = $this->COMMON->getEscapeString($_POST['studyArea']);


        $condition = "WHERE a.ch_status = '" . $this->GLOBAL['vacancy_enable']['value'] . "' AND k.nm_status = '" . $this->GLOBAL['user_enable']['value'] . "' AND (a.id_type = '5') ";

        if ($location > 0)
            $condition.= " AND (a.id_location = '$location') ";

        if ($studyLevel > 0)
            $condition.= " AND (l.id_studylevel = '$studyLevel') ";

        if ($studyArea > 0)
            $condition.= " AND (l.tx_studyarea = '$studyArea') ";

        $condition.=' GROUP BY a.id ORDER BY a.dt_update DESC, a.tx_hour DESC ';

        $rGetVacancy = $this->QUERY->searchVacancyByPractices($condition);

        $answer = array('page' => $page, 'total' => $rGetVacancy->size(), 'rows' => array());

        $limitINIT = $page == 1 ? 0 : ($page - 1) * $rowsPerPage;

        $condition.= " LIMIT $limitINIT, $rowsPerPage";

        $rGetVacancy = $this->QUERY->searchVacancyByPractices($condition);

        while ($row = $rGetVacancy->fetch()) {

            $idVacancy = $row['id'];
            $tx_name = $row['tx_name'];
            $tx_trademark = $row['ch_confidential'] == $this->GLOBAL['confidential_YES'] ? $row['tx_confidential_trademark'] : $row['tx_trademark'];
            $dt_update = $row['dt_update'];
            $vacancytype = $row['vacancy_type_tx_description'];
            $tx_city = $row['tx_city'];
            $id_company = $row['id_company'];
            $tx_image = $row['tx_image'];


            $dt_update = date("j-n-Y", strtotime($dt_update));
            $dt_update = explode('-', $dt_update);

            $dt_update_day = $dt_update[0];
            $dt_update_month = $this->month[$dt_update[1]];
            $dt_update_year = $dt_update[2];

            $folder = $id_company;
            $link = $this->GLOBAL['linkPhotoCompany'] . $folder . '/';

            if ($row['ch_confidential'] == $this->GLOBAL['confidential_YES']) {
                $fileImage = $this->COMMON->findPhoto("confidential_30p", $this->GLOBAL['linkPhotoCompany'] . "confidential" . '/', '../');
            } else {
                $fileImage = $this->COMMON->findPhoto($tx_image . '_30p', $link, '../');

                if (!$fileImage)
                    $fileImage = $this->COMMON->findPhoto('default_30p', $this->GLOBAL['companyDefaultImage'], '../');
            }

            $entry = array(
                'id' => $idVacancy
                , 'tx_tradename' => $tx_trademark
                , 'idVacancy' => $idVacancy
                , 'fileImage' => $fileImage
                , 'tx_name' => $tx_name
                , 'labelVacancyType' => $this->STR['VacancyType']
                , 'vacancytype' => $vacancytype
                , 'day' => $dt_update_day
                , 'month' => $dt_update_month
                , 'year' => $dt_update_year
                , 'labelLocation' => $this->STR['Location']
                , 'location' => $tx_city
                , 'labelSector' => $this->STR['Sector']
            );

            $answer['rows'][] = $entry;
        }

        echo json_encode($answer);
    }

    function company() {
        $page = $_POST['page'];
        $rowsPerPage = $_POST['rowsPerPage'];

        $location = $this->COMMON->getEscapeString($_POST['location']);
        $company = $this->COMMON->getEscapeString($_POST['company']);

        $condition = "WHERE a.ch_status = '" . $this->GLOBAL['vacancy_enable']['value'] . "' AND k.nm_status = '" . $this->GLOBAL['user_enable']['value'] . "' ";

        if ($company > 0)
            $condition.= " AND (a.id_company = '$company') ";

        $condition.=' GROUP BY a.id ORDER BY a.dt_update DESC, a.tx_hour DESC ';

        $rGetVacancy = $this->QUERY->searchVacancy($condition);

        $answer = array('page' => $page, 'total' => $rGetVacancy->size(), 'rows' => array());

        $limitINIT = $page == 1 ? 0 : ($page - 1) * $rowsPerPage;

        $condition.= " LIMIT $limitINIT, $rowsPerPage";

        $rGetVacancy = $this->QUERY->searchVacancy($condition);

        while ($row = $rGetVacancy->fetch()) {

            $idVacancy = $row['id'];
            $tx_name = $row['tx_name'];
            $tx_trademark = $row['ch_confidential'] == $this->GLOBAL['confidential_YES'] ? $row['tx_confidential_trademark'] : $row['tx_trademark'];
            $dt_update = $row['dt_update'];
            $vacancytype = $row['vacancy_type_tx_description'];
            $tx_city = $row['tx_city'];
            $id_company = $row['id_company'];
            $tx_image = $row['tx_image'];


            $dt_update = date("j-n-Y", strtotime($dt_update));
            $dt_update = explode('-', $dt_update);

            $dt_update_day = $dt_update[0];
            $dt_update_month = $this->month[$dt_update[1]];
            $dt_update_year = $dt_update[2];

            $folder = $id_company;
            $link = $this->GLOBAL['linkPhotoCompany'] . $folder . '/';

            if ($row['ch_confidential'] == $this->GLOBAL['confidential_YES']) {
                $fileImage = $this->COMMON->findPhoto("confidential_30p", $this->GLOBAL['linkPhotoCompany'] . "confidential" . '/', '../');
            } else {
                $fileImage = $this->COMMON->findPhoto($tx_image . '_30p', $link, '../');

                if (!$fileImage)
                    $fileImage = $this->COMMON->findPhoto('default_30p', $this->GLOBAL['companyDefaultImage'], '../');
            }

            $entry = array(
                'id' => $idVacancy
                , 'tx_tradename' => $tx_trademark
                , 'idVacancy' => $idVacancy
                , 'fileImage' => $fileImage
                , 'tx_name' => $tx_name
                , 'labelVacancyType' => $this->STR['VacancyType']
                , 'vacancytype' => $vacancytype
                , 'day' => $dt_update_day
                , 'month' => $dt_update_month
                , 'year' => $dt_update_year
                , 'labelLocation' => $this->STR['Location']
                , 'location' => $tx_city
                , 'labelSector' => $this->STR['Sector']
            );

            if ($row['ch_confidential'] != $this->GLOBAL['confidential_YES'])
                $answer['rows'][] = $entry;
        }

        echo json_encode($answer);
    }

}

//end of class

$remote = new remote();
$option = $_POST['opt'];
switch ($option) {

    case 'simplequery':
        $remote->simplequery();
        break;

    case 'advancedquery':
        $remote->advancedquery();
        break;

    case 'practices':
        $remote->practices();
        break;

    case 'company':
        $remote->company();
        break;

    default:
        die();
        break;
}
?>