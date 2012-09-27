<?php

class UserManager {

	var $fDB;
	var $fUsersTable;
	var $fDefaultUser;
	var $fDevLogin;
	var $fDevPassword;

    function UserManager(&$db, $userstable, $defaultuser, $devlogin, $devpassword) {
    	
    	$this->fDB = &$db;
    	$this->fUsersTable = (string) $userstable;
    	$this->fDefaultUser = (string) $defaultuser;
    	$this->fDevLogin = (string) $devlogin;
    	$this->fDevPassword = (string) $devpassword;
    
    }
    
    function initialize(){
    	
    	$sql =  "SELECT id, login, pwd, email, firstname, middlename, lastname, birthdate, phone, address, city, state, postalcode, country, registeredmoment, previousvisitmoment, previousvisitip, currentvisitmoment, currentvisitip FROM " . 
    			$this->fUsersTable . " WHERE 1 = 2";
				
    	return $this->fDB->query($sql);
    	
    }
    
    function getUser($login){
    	
    	$id = 0;
    	
    	if($id = $this->checkUser($login)){
    		return $this->getUserByID($id);
    	}else{
    		return false;
    	}
    	
    }   
    
    function checkUser($login){
    	
    	$id = 0;
    	
    	$sql = "SELECT id FROM " . $this->fUsersTable . " WHERE login = '" . addslashes($login) . "'";
    	
    	if($id = $this->fDB->getQueryField($sql)){
    		return $id;
    	}else{
    		return false;
    	}
    	
    }   
    
    function checkUserByID($id){
    	
    	if(is_numeric($id)){
    		$sql = "SELECT id FROM " . $this->fUsersTable . " WHERE id = " . (int) $id;
    		if($this->fDB->getQueryRecord($sql)){
    			return $id;
    		}
    	}else{
    		return false;
    	}
    	
    }
    
    function getUserByID($id){
    	
    	$arrUser = array();
    	$user = false;
    	
    	if (is_numeric($id)){
	    	$sql = "SELECT 	id, 
							login, 
							'' AS pwd, 
							IF(login = '" . $this->fDevLogin . "' AND pwd = MD5('" . $this->fDevPassword . "'), 1, 0) AS is_dev,  
							IF(login = '" . $this->fDefaultUser . "', 1, 0) AS is_defaultuser, 
							email, 
							firstname, 
							middlename, 
							lastname,  
							DATE_FORMAT(birthdate, '%m/%d/%Y') AS f_birthdate,  
							phone, 
							address, 
							city, 
							state, 
							postalcode, 
							country, 
							DATE_FORMAT(registeredmoment, '%m/%d/%Y %H:%i:%s') AS f_registeredmoment, 
							DATE_FORMAT(previousvisitmoment, '%m/%d/%Y %H:%i:%s') AS f_previousvisitmoment, 
							INET_NTOA(previousvisitip) AS f_previousvisitip, 
							DATE_FORMAT(currentvisitmoment, '%m/%d/%Y %H:%i:%s') AS f_currentvisitmoment, 
							INET_NTOA(currentvisitip) AS f_currentvisitip
					FROM " . $this->fUsersTable . " WHERE id = " . (int) $id;
					
	    	if($arrUser = $this->fDB->getQueryRecord($sql)){
	    		$user = new User ($arrUser['id'], $arrUser['login'], $arrUser['pwd'], $arrUser['email'], $arrUser['firstname'], $arrUser['middlename'], $arrUser['lastname']);
	    		$user->setBirthDate($arrUser['f_birthdate']);
	    		$user->setPhone($arrUser['phone']);
	    		$user->setAddress($arrUser['address']);
	    		$user->setCity($arrUser['city']);
	    		$user->setState($arrUser['state']);
	    		$user->setPostalCode($arrUser['postalcode']);
	    		$user->setCountry($arrUser['country']);
	    		$user->setRegisteredDate($arrUser['f_registeredmoment']);
	    		$user->setPreviousVisitMoment($arrUser['f_previousvisitmoment']);
	    		$user->setPreviousVisitIP($arrUser['f_previousvisitip']);
	    		$user->setCurrentVisitMoment($arrUser['f_currentvisitmoment']);
	    		$user->setCurrentVisitIP($arrUser['f_currentvisitip']);
	    		$user->setIsDev($arrUser['is_dev']);
	    		$user->setIsDefaultUser($arrUser['is_defaultuser']);
	    		return $user;
	    	}else{
	    		return false;
	    	}
    	}else{
    		return false;
    	}
    	
    }
    
    
    function getUsers($order = "login", $sort = "ASC", $offset = 0, $count = 0, $filter = array()){
    	
    	$users = false;
    	$order = (in_array($order, array('id', 'login', 'email', 'firstname', 'lastname', 'fullname', 'birthdate', 'registeredmoment'))) ? $order : "login";
    	$sort = (in_array($sort, array('ASC', 'DESC'))) ? $sort : "ASC";
    	
    	$sql = "SELECT 	id, 
						login, 
						'' AS pwd, 
						IF(login = '" . $this->fDevLogin . "' AND pwd = MD5('" . $this->fDevPassword . "'), 1, 0) AS is_dev, 
						IF(login = '" . $this->fDefaultUser . "', 1, 0) AS is_defaultuser, 
						email, 
						firstname, 
						middlename, 
						lastname, 
						CONCAT(firstname, ' ', middlename, ' ', lastname) AS fullname, 
						DATE_FORMAT(birthdate, '%m/%d/%Y') AS f_birthdate, 
						phone, 
						address, 
						city, 
						state, 
						postalcode, 
						country, 
						DATE_FORMAT(registeredmoment, '%m/%d/%Y') AS f_registeredmoment, 
						DATE_FORMAT(previousvisitmoment, '%m/%d/%Y') AS f_previousvisitmoment, 
						INET_NTOA(previousvisitip) AS f_previousvisitip, 
						DATE_FORMAT(currentvisitmoment, '%m/%d/%Y') AS f_currentvisitmoment, 
						INET_NTOA(currentvisitip) AS f_currentvisitip 
					FROM " . $this->fUsersTable . " ORDER BY " . $order . " " . $sort;
					
    	if($count > 0 && $offset > 0){
    		$sql .= " LIMIT " . (int) $offset. ", " . (int) $count;
    	}elseif($count > 0){
    		$sql .= " LIMIT " . (int) $count;
    	}
    	
    	if($arrUsers = $this->fDB->getQueryRecordSet($sql)){
    		$users = array();
    		foreach($arrUsers as $arrUser){
    			$user = new User ($arrUser['id'], $arrUser['login'], $arrUser['pwd'], $arrUser['email'], $arrUser['firstname'], $arrUser['middlename'], $arrUser['lastname']);
	    		$user->setBirthDate($arrUser['f_birthdate']);
	    		$user->setPhone($arrUser['phone']);
	    		$user->setAddress($arrUser['address']);
	    		$user->setCity($arrUser['city']);
	    		$user->setState($arrUser['state']);
	    		$user->setPostalCode($arrUser['postalcode']);
	    		$user->setCountry($arrUser['country']);
	    		$user->setRegisteredDate($arrUser['f_registeredmoment']);
	    		$user->setPreviousVisitMoment($arrUser['f_previousvisitmoment']);
	    		$user->setPreviousVisitIP($arrUser['f_previousvisitip']);
	    		$user->setCurrentVisitMoment($arrUser['f_currentvisitmoment']);
	    		$user->setCurrentVisitIP($arrUser['f_currentvisitip']);
	    		$user->setIsDev($arrUser['is_dev']);
	    		$user->setIsDefaultUser($arrUser['is_defaultuser']);
	    		$users[] = $user;
    		}
    	}
    	
    	return $users;
    }
    
    function getUsersCount(){
    	$sql = "SELECT COUNT(*) AS cnt FROM " . $this->fUsersTable;
    	
    	return $this->fDB->getQueryField($sql);
    }
    
    function loginUser($login, $password){	
    	$id = 0;    	
    	$user = false;
    	$sql = "SELECT id FROM " . $this->fUsersTable . " WHERE login = '" . addslashes($login) . "' AND pwd = MD5('" . addslashes($password) . "')";
    	if($id = $this->fDB->getQueryField($sql)){
    		$sql = "UPDATE " . $this->fUsersTable . " SET previousvisitmoment = currentvisitmoment, previousvisitip = currentvisitip, currentvisitmoment = NOW(), currentvisitip = INET_ATON('" . $_SERVER['REMOTE_ADDR'] . "') WHERE id = " . $id;
    		if($this->fDB->query($sql)){ 
    			$user = $this->getUserByID($id);
    			return $user;
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }
 
    function logoutUser(){	
    	$id = 0;    	
    	
    	if($id = $this->checkUser($this->fDefaultUser)){
    		return $this->getUserByID($id);
    	}else{
    		return false;
    	}
    }   
    
    function setUser($login, &$user){
    	
    	$id = 0;
    	
    	if($id = $this->checkUser($login)){
    		return $this->setUserByID($id, $user);
    	}else{
    		return false;
    	}
    }
    
    function setUserByID($id, &$user){
    	
    	if(is_numeric($id) && is_object($user)){
    		if($id = $this->checkUserByID($id)){
	    		$sql = "UPDATE " . $this->fUsersTable . " SET 
							login = '" . addslashes($user->getLogin()) . "', ";
				if($user->getPassword() != ""){ $sql .= "pwd = '" . md5($user->getPassword()) . "', "; }
				$sql .= "email = '" . addslashes($user->getEmail()) . "', 
							firstname = '" . addslashes($user->getFirstName()) . "',   
							middlename = '" . addslashes($user->getMiddleName()) . "',   
							lastname = '" . addslashes($user->getLastName()) . "', 
							birthdate = IF('" . $user->getBirthDate('Y-m-d') . "' = '', NULL, '" . $user->getBirthDate('Y-m-d') . "'),  
							phone = '" . addslashes($user->getPhone()) . "', 
							address = '" . addslashes($user->getAddress()) . "', 
							city = '" . addslashes($user->getCity()) . "', 
							state = '" . addslashes($user->getState()) . "', 
							postalcode = '" . addslashes($user->getPostalCode()) . "', 
							country = '" . addslashes($user->getCountry()) . "', 
							registeredmoment = IF('" . $user->getRegisteredDate('Y-m-d H:i:s') . "' = '', NULL, '" . $user->getRegisteredDate('Y-m-d H:i:s') . "'), 
							previousvisitmoment = IF('" . $user->getPreviousVisitMoment('Y-m-d H:i:s') . "' = '', NULL, '" . $user->getPreviousVisitMoment('Y-m-d H:i:s') . "'),  
							previousvisitip = INET_ATON('" . $user->getPreviousVisitIP() . "'),  
							currentvisitmoment = IF('" . $user->getCurrentVisitMoment('Y-m-d H:i:s') . "' = '', NULL, '" . $user->getCurrentVisitMoment('Y-m-d H:i:s') . "'), 
							currentvisitip = INET_ATON('" . $user->getCurrentVisitIP() . "') 
						WHERE id = " . (int) $id;
						
				return $this->fDB->query($sql);
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    	
    }
    
    function addUser(&$user){
    	
    	if(is_object($user)){
    		
    		$sql = "INSERT INTO " . $this->fUsersTable . 
					" (login, 
						pwd, 
						email, 
						firstname, 
						middlename, 
						lastname, 
						birthdate, 
						phone, 
						address, 
						city, 
						state, 
						postalcode, 
						country, 
						registeredmoment, 
						previousvisitmoment, 
						previousvisitip, 
						currentvisitmoment, 
						currentvisitip) VALUES " . 
					" ('" . addslashes($user->getLogin()) . "', " .
					"'" . md5($user->getPassword()) . "', " .
					"'" . addslashes($user->getEmail()) . "', " . 
					"'" . addslashes($user->getFirstName()) . "', " . 
					"'" . addslashes($user->getMiddleName()) . "', " .
					"'" . addslashes($user->getLastName()) . "', " .
					"IF('" . $user->getBirthDate("Y-m-d") . "' = '', NULL, '" . $user->getBirthDate("Y-m-d") . "'), " . 
					"'" . addslashes($user->getPhone()) . "', " .
					"'" . addslashes($user->getAddress()) . "', " .
					"'" . addslashes($user->getCity()) . "', " .
					"'" . addslashes($user->getState()) . "', " .
					"'" . addslashes($user->getPostalcode()) . "', " .
					"'" . addslashes($user->getCountry()) . "', " .
					"IF('" . $user->getRegisteredDate("Y-m-d H:i:s") . "' = '', NULL, '" . $user->getRegisteredDate("Y-m-d H:i:s") . "'), " . 
					"IF('" . $user->getPreviousVisitMoment("Y-m-d H:i:s") . "' = '', NULL, '" . $user->getPreviousVisitMoment("Y-m-d H:i:s") . "'), " .
					"INET_ATON('" . $user->getPreviousVisitIP() . "'), " . 
					"IF('" . $user->getCurrentVisitMoment("Y-m-d H:i:s") . "' = '', NULL, '" . $user->getCurrentVisitMoment("Y-m-d H:i:s") . "'), " .
					"INET_ATON('" . $user->getCurrentVisitIP() . "')" .
					")";
					
    		if($this->fDB->query($sql)){
    			return $this->fDB->getID();
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }
    
    function removeUser($login){
    	$id = 0;
    	if($id = $this->checkUser($login)){
    		return $this->removeUsersByID($id);
    	}else{
    		return false;
    	}
    }
    
    function removeUsersByID($id){
    	
    	if(is_numeric($id)){
    		if($this->checkUserByID($id)){
    			$sql = "DELETE FROM " . $this->fUsersTable . " WHERE id = " . (int) $id;
    			return $this->fDB->query($sql);
    		}else{
    			return false;
    		}
    	}elseif(is_array($id)){
			$arrID = array();
			foreach($id as $i){
				if(is_numeric($i)){
					$arrID[] = (int) $i;
				}
			}
			$sql = "DELETE FROM " . $this->fUsersTable . " WHERE id IN (" . join(",", $arrID) . ")";
			return $this->fDB->query($sql);
    	}else{
    		return false;
    	}
    	
    }
    
    /** Creating random password with given length
     * 
     * @return string password
     */     
    function createPassword($charnum = 8, $case = "M"){
    	$strChars = "a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,0,1,2,3,4,5,6,7,8,9";
    	$arrChars = explode(",", $strChars);
    	shuffle($arrChars);
    	$strPassword = "";
    		
    	for($i=0; $i < $charnum; $i++){
    		$strPassword .= $arrChars[ array_rand($arrChars) ];
    	}
    	
    	if($case == "L"){ // lowercased
    		$strPassword = strtolower($strPassword);
    	}elseif($case == "U"){ //uppercased
    		$strPassword = strtoupper($strPassword);
    	}
    	  
    	return $strPassword;
    }
    
    /** Resetting password for user given by login
     * 
     * @return string user's new password
     */   
    function resetPassword($login, $charnum = 8, $password = ""){
    	$id = 0;
    	if($id = $this->checkUser($login)){
    		return $this->resetPasswordByID($id, $charnum, $password);
    	}else{
    		return false;
    	}
    }
    
    /** Resetting password for user given by ID
     * 
     * @return string user's new password
     */
    function resetPasswordByID($userid, $charnum = 8, $password = ""){
    	if(is_numeric($userid) && $this->checkUserByID($userid)){
    		$strPassword = (strlen($password) > 0) ? $password : $this->createPassword($charnum);
    		$sql = "UPDATE " . $this->fUsersTable . " SET pwd = MD5('" . addslashes($strPassword) . "') WHERE id = " . $userid;
    		if($this->fDB->query($sql)){
    			return $strPassword;
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }
    
}	
?>