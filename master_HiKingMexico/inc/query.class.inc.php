<?php

class Query {

    public $db;
    public $GLOBAL;

    public function __construct($db, $GLOBAL) {
        $this->db = $db;
        $this->GLOBAL = $GLOBAL;
    }

    public function __destruct() {}

    public function getState($condition = '') {
        mysql_query('SET NAMES "UTF8"');
        $sql = "SELECT  id,
                        id_country,
                        tx_state
                FROM state
                $condition";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getComments($condition = '') {
        mysql_query('SET NAMES "UTF8"');
        $sql = "SELECT  a.id,
                        a.tx_name,
                        a.tx_email,
                        a.tx_comment,
                        a.dt_registry,
                        a.tm_registry,
                        a.tx_ipaddress,
                        a.nm_status
                FROM comments AS a
                $condition";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertComments($params = null, $condition = '') {
        mysql_query('SET NAMES "UTF8"');

        $sql = "INSERT INTO comments (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field)) {
                $field .= " ,";
            }
            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updateComments($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE comments SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getHitscounter($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.tx_ipaddress, a.dt_registry, a.tx_hour, MINUTE(timediff(NOW() , CONCAT(a.dt_registry,' ',a.tx_hour)))  AS dif
				FROM hitscounter AS a
			
			$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertHitscounter($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO hitscounter (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getSoftware($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.tx_description AS software_tx_description 
				FROM software AS a				 
			$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function searchVacancy($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.id_company, a.tx_name, CONCAT(a.id,' ',a.tx_name) AS mergeName, a.dt_registry, a.dt_update, a.nm_totalvacancies, a.ch_confidential, d.tx_description AS workarea_tx_description, 
				e.tx_description AS vacancy_type_tx_description, f.tx_city, h.tx_tradename, h.tx_trademark, h.tx_image, h.tx_confidential_trademark
			
			FROM vacancy a
			
			LEFT OUTER JOIN workarea 				AS d ON a.id_workarea 		= d.id
			LEFT OUTER JOIN vacancy_type 			AS e ON a.id_type 			= e.id
			LEFT OUTER JOIN location 				AS f ON a.id_location 		= f.id			
			LEFT OUTER JOIN company 				AS h ON a.id_company 		= h.id_user
			LEFT OUTER JOIN user 					AS k ON a.id_company  		= k.id			
			
			$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function searchVacancyByPractices($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.id_company, a.tx_name, a.dt_update, a.nm_totalvacancies, a.ch_confidential, d.tx_description AS workarea_tx_description, 
				e.tx_description AS vacancy_type_tx_description, f.tx_city, h.tx_tradename, h.tx_trademark, h.tx_image, h.tx_confidential_trademark
			
			FROM vacancy a
			
			LEFT OUTER JOIN workarea 				AS d ON a.id_workarea 		= d.id
			LEFT OUTER JOIN vacancy_type 			AS e ON a.id_type 			= e.id
			LEFT OUTER JOIN location 				AS f ON a.id_location 		= f.id			
			LEFT OUTER JOIN company 				AS h ON a.id_company 		= h.id_user
			LEFT OUTER JOIN user 					AS k ON a.id_company  		= k.id
			LEFT OUTER JOIN vacancy_studylevel 		AS l ON l.id_vacancy 		= a.id
			LEFT OUTER JOIN studylevel 				AS m ON m.id 				= l.id_studylevel
			LEFT OUTER JOIN studyarea 				AS n ON n.id 				= l.tx_studyarea			
			
			$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getVacancy($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.id_company, a.tx_name, a.id_location, a.dt_registry, a.dt_update, a.tx_hour, a.ch_status, a.id_type, a.nm_minage, a.nm_maxage, a.ch_gender, a.ch_maritalstatus,
				a.ch_studystatus, a.tx_reqstudy, a.id_workarea, a.ch_timeexperience, a.tx_requirements, a.tx_activitydetail, a.tx_salaryoffered, a.ch_relatedstudylevel, 
				a.ch_relatedworkexperience, a.ch_confidential, a.nm_vacancypriority, a.nm_totalvacancies,d.tx_description AS workarea_tx_description, 
				e.tx_description AS vacancy_type_tx_description, f.tx_city, h.tx_tradename, h.tx_trademark, h.tx_companyemail, h.tx_confidentialemail,
				h.tx_image, h.tx_about, i.tx_state, j.tx_country, h.tx_web, h.tx_twitter, h.tx_facebook, h.tx_gmap, h.tx_confidential_trademark, o.tx_description AS vacanty_status_tx_description 			 
			FROM vacancy a
			
			LEFT OUTER JOIN workarea 				AS d ON a.id_workarea 		= d.id
			LEFT OUTER JOIN vacancy_type 			AS e ON a.id_type 			= e.id
			LEFT OUTER JOIN location 				AS f ON a.id_location 		= f.id			
			LEFT OUTER JOIN company 				AS h ON a.id_company 		= h.id_user 
			LEFT OUTER JOIN state 					AS i ON f.id_state 			= i.id 
			LEFT OUTER JOIN country 				AS j ON f.id_country  		= j.id
			LEFT OUTER JOIN user 					AS k ON a.id_company  		= k.id
			LEFT OUTER JOIN vacancy_studylevel 		AS l ON l.id_vacancy 		= a.id
			LEFT OUTER JOIN studylevel 				AS m ON m.id 				= l.id_studylevel
			LEFT OUTER JOIN studyarea 				AS n ON n.id 				= l.tx_studyarea
			LEFT OUTER JOIN vacancy_status 			AS o ON o.id 				= a.ch_status
			

			$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getCountVacancies($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT COUNT(a.id) AS total
			
			FROM vacancy a
			
			$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getCountVacanciesInfo($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT b.tx_tradename, b.tx_trademark, COUNT( a.id ) AS totalvacancies
			
			FROM vacancy AS a

			LEFT OUTER JOIN company AS b ON a.id_company = b.id_user
			
			$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertVacancy($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO vacancy (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updateVacancy($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE vacancy SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertVacancy_StudyLevel($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO vacancy_studylevel (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deleteVacancy_Studylevel($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM vacancy_studylevel

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertVacancy_Language($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO vacancy_language (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deleteVacancy_Language($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM vacancy_language

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertVacancy_WorkExperience($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO vacancy_workexperience (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getUser($condition = "") {
        mysql_query('SET NAMES "UTF8"');
        $sql = "SELECT  a.id, a.tx_email, a.tx_password, a.tx_name, a.tx_surname, 
				a.nm_status, a.nm_type, a.tx_sign, a.dt_registry, a.dt_sign, a.dt_lastvisit, a.tx_ipaddress				
				FROM user AS a
            	$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getRFC($condition = ""){
        mysql_query('SET NAMES "UTF8"');
        $sql = "SELECT c.tx_rfc FROM company c WHERE c.tx_rfc = '$condition'";
        $q = $this->db->query($sql);
        if($q->isError()){
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }
        return $q;
    }

    public function getCountUser($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT  COUNT(a.id) AS totalUsers				
				FROM user AS a
            	$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getMailingList($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT  a.id, a.tx_email, a.tx_name, a.dt_registry, a.ch_status, a.tx_binary
				FROM mailing_list AS a

            	$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertMailingList($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO mailing_list (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getCandidate($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT  a.id, a.tx_email, a.tx_name, a.tx_surname, a.nm_status,
				b.dt_borndate, e.tx_description AS workarea_tx_description, f.tx_description AS studylevel_tx_description, 
				g.tx_description AS studyarea_tx_description 
				
				FROM user AS a

				LEFT OUTER JOIN postulant 				AS b ON a.id 				= b.id_user
				LEFT OUTER JOIN postulant_experience 	AS c ON a.id 				= c.id_postulant
				LEFT OUTER JOIN postulant_studies 		AS d ON a.id 				= d.id_postulant

				LEFT OUTER JOIN workarea 				AS e ON c.id_workarea 		= e.id
				LEFT OUTER JOIN studylevel 				AS f ON d.id_studylevel 	= f.id
				LEFT OUTER JOIN studyarea 				AS g ON d.id_studyarea 		= g.id

            	$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertUser($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO user (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field)) {
                $field .= " ,";
            }
            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values)) {
                $values .= " ,";
            }
            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updateUser($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE user SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param)) {
                $param .= ", ";
            }
            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getVacancyByArea($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT  COUNT( a.id ) AS total,
                        b.id,
                        b.tx_description AS workarea_tx_description
			    FROM vacancy a
			    LEFT OUTER JOIN workarea AS b ON a.id_workarea = b.id
			    LEFT OUTER JOIN user AS c ON a.id_company = c.id
			    $condition
			    GROUP BY a.id_workarea
			    ORDER BY b.tx_description DESC";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getCompany($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT  a.id,
                        a.id_user,
                        a.tx_tradename,
                        a.tx_trademark,
                        a.tx_companyemail,
                        a.tx_confidentialemail,
                        a.tx_rfc,
                        a.tx_colony,
                        a.tx_street,
                        a.tx_number,
                        a.tx_phone,
                        a.tx_mobil,
                        a.id_country,
                        a.id_state,
                        a.tx_city,
                        a.tx_web,
                        a.id_worksector,
                        a.tx_activity,
                        a.tx_about,
                        a.tx_twitter,
                        a.tx_facebook,
                        a.tx_gmap,
                        a.tx_image,
                        a.tx_benefits,
                        a.ch_verified,
                        a.nm_employees,
                        a.tx_confidential_trademark,
                        b.tx_email,
                        b.tx_name,
                        b.tx_surname,
                        b.dt_registry,
                        b.dt_sign,
                        b.nm_status
                FROM    company a
                  LEFT OUTER JOIN user AS b ON a.id_user = b.id
                $condition";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getCountCompany($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT COUNT(a.id_user) AS totalCompanies
                FROM company a
                  LEFT OUTER JOIN user AS b ON a.id_user  = b.id
                $condition";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getCompany_Plan($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.id_company, a.tx_planname, a.nm_posts, a.tx_cost, a.dt_registry, a.dt_initialperiod,
				a.dt_periodended, a.tx_description, a.tx_admin_comment, a.ch_status 
				
				FROM company_plan a

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertCompany_Plan($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO company_plan (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updateCompany_Plan($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE company_plan SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getAnnualPlan($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT  a.id, a.tx_name, a.tx_cost, a.nm_posts, a.tx_description, a.nm_totaldays 
				
				FROM annualplan a

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertAnnualPlan($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO annualplan (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updateAnnualPlan($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE annualplan SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deleteAnnualPlan($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM annualplan

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getCompany_request_plan($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT   a.id, a.id_company, a.dt_registry, a.ch_status, a.id_plan, a.tx_company_comment, a.tx_admin_comment,
				b.tx_name, b.tx_cost, b.nm_posts, b.tx_description, b.nm_totaldays, c.tx_tradename, c.tx_trademark
				
				FROM company_request_plan AS a

				LEFT OUTER JOIN annualplan 	AS b ON a.id_plan		= b.id
				LEFT OUTER JOIN company 	AS c ON a.id_company	= c.id_user
				
				$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertCompanyRequestPlan($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO company_request_plan (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updateCompanyRequestPlan($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE company_request_plan SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulant($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.tx_image, a.ch_gender, a.dt_borndate, a.tx_rfc, a.ch_maritalstatus,
				a.nm_country, a.nm_state, a.tx_city, a.tx_colony, a.tx_street, a.tx_number, a.tx_phone, a.tx_mobil,
				a.nm_toeflscore, a.ch_verified, a.ch_firstjob, b.id, b.tx_email, b.tx_name, b.tx_surname, 
				b.dt_registry, b.tx_ipaddress, b.nm_status, b.nm_type, b.tx_sign, b.dt_lastvisit
			
			FROM postulant a

			LEFT OUTER JOIN user AS b ON a.id_user  = b.id

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getCountPostulant($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT COUNT(a.id_user) AS totalPostulants
			
			FROM postulant a

			LEFT OUTER JOIN user AS b ON a.id_user  = b.id

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function searchPostulant_Scrap($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT  a.id, a.tx_email, a.tx_name, a.tx_surname, b.dt_notification, b.ch_status, DATEDIFF(DATE_ADD(b.dt_notification,INTERVAL 90 DAY), CURDATE()) AS remainingdays
			
			FROM user a

			LEFT OUTER JOIN postulant_scrap AS b ON a.id  = b.id_postulant

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulant_Scrap($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.id_postulant, a.dt_notification, a.ch_status
			
			FROM postulant_scrap a

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPostulant_Scrap($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO postulant_scrap (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);


        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updatePostulant_Scrap($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE postulant_scrap SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deletePostulant_Scrap($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM postulant_scrap 

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulant_CVFile($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.id_postulant, a.dt_registry, a.tx_filename, a.tx_binaryname
			
			FROM postulant_cvfile a

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPostulant_CVFile($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO postulant_cvfile (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);


        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updatePostulant_CVFile($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE postulant_cvfile SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deletePostulant_CVFile($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM postulant_cvfile 

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getVacancyType($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.tx_description AS vacancy_type_tx_description

			FROM vacancy_type AS a
			
			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulant_studies($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.id_postulant, a.id_studylevel, a.id_studyarea, a.tx_graduate, a.ch_status, a.tx_institution, a.dt_startdatemonth, a.dt_startdateyear,
				a.dt_enddatemonth, a.dt_enddateyear, a.tx_average, a.tx_comment, b.tx_description AS studylevel_tx_description, c.tx_description AS studyarea_tx_description 
				
				FROM postulant_studies AS a

			    LEFT OUTER JOIN studylevel AS b 	ON a.id_studylevel 	= 	b.id 
			    LEFT OUTER JOIN studyarea AS c 		ON a.id_studyarea	=	c.id
			
			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulant_informatic($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.id_postulant, a.id_softwaretype, a.tx_softwarename, a.ch_domain, a.tx_description AS postulant_informatic_tx_description, 
				b.tx_description AS software_tx_description 
				
				FROM postulant_informatic AS a
				
				LEFT OUTER JOIN software AS b ON a.id_softwaretype = b.id
			
			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulant_knowledge($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.id_postulant, a.ch_domain, a.tx_knowledgename, a.tx_description AS postulant_knowledge_tx_description

			FROM postulant_knowledge AS a
			
			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulant_language($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.id_postulant, a.nm_language, a.nm_speak, a.nm_write, a.nm_read, b.tx_description AS language_tx_description 

				FROM postulant_language AS a

				LEFT OUTER JOIN language AS b ON b.id 	= a.nm_language
			
			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulant_experience($condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "SELECT a.id, a.id_postulant, a.tx_tradename, a.id_hierarchy, a.tx_salary, 
					a.id_workarea, a.tx_jobtitle, a.dt_startdatemonth, a.dt_startdateyear, a.dt_enddatemonth, a.dt_enddateyear, 
					a.tx_activitydetail, a.ch_isactualwork, d.tx_description AS workarea_tx_description 

					FROM postulant_experience AS a

				    LEFT OUTER JOIN workarea 	AS d ON a.id_workarea		= d.id
			
			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulant_expectative($condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "SELECT a.id, a.id_postulant, a.nm_hierarchyLevel, a.ch_changeresidence, a.ch_fulltimework, a.ch_parttimework, a.ch_workfees,
                a.ch_worktemporarily, a.nm_monthlysalary, a.tx_comment 

                FROM postulant_expectative AS a
			
			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPostulant_expectative($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO postulant_expectative (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);


        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updatePostulant_expectative($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE postulant_expectative SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulant_expectative_towork($condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "SELECT a.id, a.id_postulant, a.id_workarea, d.tx_description AS workarea_tx_description 
				
				FROM postulant_expectative_towork AS a

				LEFT OUTER JOIN workarea 	AS d ON a.id_workarea		= d.id

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPostulant_Expectative_ToWork($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO postulant_expectative_towork (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updatePostulant_Expectative_ToWork($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE postulant_expectative_towork SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deletePostulant_Expectative_ToWork($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM postulant_expectative_towork

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updatePostulant($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE postulant SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPostulant($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO postulant (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertCompany($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO company (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field)) {
                $field .= " ,";
            }
            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values)) {
                $values .= " ,";
            }
            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updateCompany($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE company SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPostulant_Studies($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO postulant_studies (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updatePostulant_Studies($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE postulant_studies SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deletePostulant_Studies($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM postulant_studies

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPostulant_Experience($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO postulant_experience (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updatePostulant_Experience($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE postulant_experience SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deletePostulant_Experience($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM postulant_experience

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPostulant_Informatic($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO postulant_informatic (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updatePostulant_Informatic($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE postulant_informatic SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deletePostulant_Informatic($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM postulant_informatic

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPostulant_Knowledge($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO postulant_knowledge (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updatePostulant_Knowledge($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE postulant_knowledge SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deletePostulant_Knowledge($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM postulant_knowledge

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPostulant_Language($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO postulant_language (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updatePostulant_Language($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE postulant_language SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deletePostulant_Language($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM postulant_language

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getLocation($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.tx_city, d.tx_state, c.tx_country						
				FROM location a
				LEFT OUTER JOIN country 		AS c ON c.id 				= a.id_country
		       	LEFT OUTER JOIN state 			AS d ON d.id 				= a.id_state				       	
				
				$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getWorkArea($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.tx_description AS workarea_tx_description
				FROM workarea AS a 
				
				$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getSubarea($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT  a.id, a.id_workarea, a.tx_description AS subarea_txt_description
				FROM subarea AS a

            	$condition
		";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertSubarea($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO subarea (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updateSubarea($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE subarea SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deleteSubarea($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM subarea

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getStudyArea($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT id, id_studylevel, tx_description 
				FROM studyarea		
				
				$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getStudyLevel($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT id, tx_description 
				FROM studylevel		
				
				$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getVacancyStudyLevel($condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "SELECT a.id, a.id_vacancy, a.id_studylevel, a.tx_studyarea, 
				b.tx_description AS studylevel_tx_description, c.tx_description AS studyarea_tx_description
				FROM vacancy_studylevel AS a
				LEFT OUTER JOIN studylevel AS b ON b.id = a.id_studylevel
				LEFT OUTER JOIN studyarea AS c ON c.id = a.tx_studyarea
				
				$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getVacancyLanguage($condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "SELECT a.id, a.id_vacancy, a.id_language, a.nm_domain, b.tx_description AS tx_description_language
				FROM vacancy_language AS a
				LEFT OUTER JOIN language AS b ON b.id = a.id_language
				
				$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getSector($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT id, tx_description 
				FROM worksector		
				
				$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getInterviewDate($condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "SELECT a.id, a.id_company, a.tx_vacancyname, a.dt_registry, a.dt_start, a.dt_end, a.id_vacancy, a.tx_comment, a.ch_status 
			FROM interviewdate AS a

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertInterviewDate($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO interviewdate (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updateInterviewDate($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE interviewdate SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deleteInterviewDate($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM interviewdate

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getInterviewDate_Config($condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "SELECT a.id, a.id_company, a.tx_feedback, a.tx_askfor 
			FROM interviewdate_config AS a
			
			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertInterviewDate_Config($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO interviewdate_config (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updateInterviewDate_Config($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE interviewdate_config SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param))
                $param .= ", ";

            $param .= "$key = '$value'";
        }

        $sql .= $param . " " . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function deleteInterviewDate_Config($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "DELETE FROM interviewdate_config

			$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getLanguage($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.tx_description AS language_tx_description 
				FROM language AS a
				
				$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulation($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT   a.id, a.id_postulant, a.id_company, a.id_vacancy, a.dt_registry, a.nm_status, b.tx_name, b.ch_confidential, 
				c.tx_tradename, c.tx_trademark, d.tx_description AS postulation_status_tx_description, e.tx_email, e.tx_name AS postulatname, e.tx_surname
				FROM postulation AS a

				LEFT OUTER JOIN vacancy AS b 			ON a.id_vacancy 				= b.id
				LEFT OUTER JOIN company AS c 			ON a.id_company 				= c.id_user
				LEFT OUTER JOIN postulation_status AS d ON a.nm_status 					= d.id
				LEFT OUTER JOIN user AS e 				ON a.id_postulant 				= e.id
				
				$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPostulationList($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT a.id, a.id_postulant, a.dt_registry, a.id_company, a.id_vacancy, a.nm_status AS postulation_nm_status, 
				b.dt_borndate, b.ch_gender, c.tx_email, c.tx_name, c.tx_surname, c.tx_sign,c.nm_status AS user_nm_status,
				d.tx_description AS postulation_status_tx_description
				
				FROM postulation a
				
				LEFT OUTER JOIN postulant AS b ON a.id_postulant 			= b.id_user 
				LEFT OUTER JOIN user AS c ON a.id_postulant 				= c.id
				LEFT OUTER JOIN postulation_status AS d ON a.nm_status 		= d.id
				
				$condition
		";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPostulation($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO postulation (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function getPublicity($condition = "") {
        mysql_query("SET NAMES 'UTF8'");
        $sql = "SELECT 
                        a.id,
                        a.nm_order,
                        a.nm_location,
                        a.dt_registry,
                        a.tx_name,
                        a.tx_description,
                        a.tx_url,
                        a.tx_image,
                        a.dt_initpublication,
                        a.dt_finishpublication,
                        a.ch_status
				  FROM
				        publicity AS a
			      $condition";
        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function insertPublicity($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "INSERT INTO publicity (
				id , 
				";
        $field = null;
        foreach ($params as $key => $value) {
            if (isset($field))
                $field .= " ,";

            $field .= "$key";
        }

        $sql .= $field . " ) VALUES ( NULL ,";

        $values = null;
        foreach ($params as $key => $value) {
            if (isset($values))
                $values .= " ,";

            $values .= "'$value'";
        }

        $sql .= $values . " );";

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function updatePublicity($params = null, $condition = "") {
        mysql_query("SET NAMES 'UTF8'");

        $sql = "UPDATE publicity SET ";

        $param = null;
        foreach ($params as $key => $value) {
            if (isset($param)) {
                $param .= ', ';
            }
            $param .= "$key = '$value'";
        }

        $sql .= $param . ' ' . $condition;

        $q = $this->db->query($sql);

        if ($q->isError()) {
            $this->displayError($q->getError($this->GLOBAL['debug']));
            return false;
        }

        return $q;
    }

    public function displayError($error) {
        $answer = array('answer' => 'fail', 'msg' => $error);
        echo json_encode($answer);
    }
}
//End Query