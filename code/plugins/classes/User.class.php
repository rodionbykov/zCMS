<?php

class User {

	var $fID = 0;
	var $fLogin = "";
	var $fPassword = "";
	var $fEmail = "";	
	var $fFirstName = "";
	var $fMiddleName = "";
	var $fLastName = "";
	var $fBirthDate = 0;
	var $fPhone = "";
	var $fAddress = "";
	var $fCity = "";
	var $fState = "";
	var $fPostalCode = "";
	var $fCountry = "";
	var $fRegisteredDate = 0;
	var $fPreviousVisitMoment = 0;
	var $fPreviousVisitIP = 0;
	var $fCurrentVisitMoment = 0;
	var $fCurrentVisitIP = 0;
	var $fUserAgent = "";
	var $fIsDev = false;
	var $fIsDefaultUser = false;
	var $fGroups;
	
    function User($id = 0, $login = "", $password = "", $email = "", $firstname = "", $middlename = "", $lastname = "") {
    	
    	$this->setID($id);
    	$this->setFirstName($firstname);
    	$this->setMiddleName($middlename);
    	$this->setLastName($lastname);
    	$this->setEmail($email);
    	$this->setLogin($login);
    	$this->setPassword($password);
    
    	$this->fGroups = array(); // array of Group objects
    }
    
    function getID(){
    	return $this->fID;
    }
    
    function getFirstName(){
    	return $this->fFirstName;
    }
    
    function getMiddleName(){
    	return $this->fMiddleName;
    }
    
    function getLastName(){
    	return $this->fLastName;
    }
    
    function getFullName($reverseorder = false){
    	if($reverseorder){
    		return $this->getLastName() . ", " . $this->getFirstName() . " " . $this->getMiddleName();
    	}else{
	    	return $this->getFirstName() . " " . $this->getMiddleName() . " " . $this->getLastName();
    	}
    }
    
    function getEmail(){
    	return $this->fEmail;
    }
    
    function getLogin(){
    	return $this->fLogin;
    }
    
    function getPassword(){
    	return $this->fPassword;
    }
    
    function getBirthDate($format){
    	if($this->fBirthDate == 0){
    		return "";
    	}else{
    		return date($format, (int) $this->fBirthDate);
    	}
    }
    
    function getPhone(){
    	return $this->fPhone;
    }
    
    function getAddress(){
    	return $this->fAddress;
    }
    
    function getCity(){
    	return $this->fCity;
    }
    
    function getState(){
    	return $this->fState;
    }
    
    function getPostalCode(){
    	return $this->fPostalCode;
    }
	
	function getCountry(){
		return $this->fCountry;
	}
	
    function getRegisteredDate($format){
    	if($this->fRegisteredDate == 0){
    		return "";
    	}else{
    		return date($format, (int) $this->fRegisteredDate);
    	}
    }
    
    function getPreviousVisitMoment($format){	
    	if($this->fPreviousVisitMoment == 0){
    		return "";	
    	}else{
    		return date($format, (int) $this->fPreviousVisitMoment);
    	}
    } 
    
    function getPreviousVisitIP(){
    	return long2ip($this->fPreviousVisitIP);
    } 
      
    function getCurrentVisitMoment($format){
    	if($this->fCurrentVisitMoment == 0){
    		return "";
    	}else{
    		return date($format, (int) $this->fCurrentVisitMoment);
    	}
    } 
        
    function getCurrentVisitIP(){
    	return long2ip($this->fCurrentVisitIP);
    } 
    
    function getUserAgent(){
    	return $this->fUserAgent;
    }
    
    function getGroups(){
    	return $this->fGroups;
    }
    
   	function inGroup(&$group){
   		$result = false;
		if(is_a($group, "Group")){
			foreach($this->fGroups as $g){
				if(($g->getID() == $group->getID()) && ($g->getCode() == $group->getCode())){
					$result = true;
				}
			}
			return $result;
		}else{
			return false;
		}
	}
    
    function isDev(){
    	return (bool) $this->fIsDev;
    }
    
    function isDefaultUser(){
    	return (bool) $this->fIsDefaultUser;
    }
    
    
    
    function setID($id){
	    if (!is_numeric($id)){
	    	return false;
	    }else{
	    	return $this->fID = (int) $id;
	    }
    }
    
    function setFirstName($firstname){
    	return $this->fFirstName = (string) $firstname;
    }
    
    function setMiddleName($middlename){
    	return $this->fMiddleName = (string) $middlename;
    }
    
    function setLastName($lastname){
    	return $this->fLastName = (string) $lastname;
    }
    
    function setEmail($email){
    	if ((strlen($email) > 0) && preg_match('/^[\w\-\_\.]+\@[\w\-\_]+\.[\w\-\_\.]+$/i', $email)){
    		return $this->fEmail = (string) $email;
    	}else{
    		return false;
    	}
    }
    
    function setLogin($login){
    	if((strlen($login) > 0) && (preg_match("/^[\_\-\.0-9a-zA-Z]+$/i", $login))){
    		return $this->fLogin = (string) $login;
    	}else{
    		return false;
    	}
    }
    
    function setPassword($password){
    	if(strlen($password) > 0){
    		return $this->fPassword = (string) $password;
    	}else{
    		return false;
    	}
    }
 
    function setBirthDate($datestring){
    	if(strlen($datestring)){
    		return (int) $this->fBirthDate = (int) strtotime($datestring);
    	}else{
    		$this->fBirthDate = 0;
    		return false;
    	}
    }

    function setPhone($phone){
    	return $this->fPhone = (string) $phone;
    }
    
    function setAddress($address){
    	return $this->fAddress = (string) $address;
    }
    
    function setCity($city){
    	return $this->fCity = (string) $city;
    }
    
    function setState($state){
    	return $this->fState = (string) $state;
    }
    
    function setPostalCode($postalcode){
    	return $this->fPostalCode = (string) $postalcode;
    }
	
	function setCountry($country){
		return $this->fCountry = (string) $country;
	}
       
    function setRegisteredDate($datestring = ""){
    	if(strlen($datestring)){
    		return $this->fRegisteredDate = (int) strtotime($datestring);
    	}else{
    		$this->fRegisteredDate = (int) time();
    		return false;
    	}
    }
    
    function setPreviousVisitMoment($datestring = ""){
    	if(strlen($datestring)){
    		return $this->fPreviousVisitMoment = (int) strtotime($datestring);
    	}else{
    		$this->fPreviousVisitMoment = (int) time();
    		return false;
    	}
    } 
    
    function setPreviousVisitIP($ip){
    	$long = ip2long($ip);
		if ($long == -1 || $long === FALSE) {
   			return false;
		}else{
    		return $this->fPreviousVisitIP = $long;
		}
    } 
      
    function setCurrentVisitMoment($datestring = ""){
    	if(strlen($datestring)){
    		return $this->fCurrentVisitMoment = (int) strtotime($datestring);
    	}else{
    		$this->fCurrentVisitMoment = (int) time();
    		return false;
    	}
    } 
        
    function setCurrentVisitIP($ip){
    	$long = ip2long($ip);
		if ($long == -1 || $long === FALSE) {
   			return false;
		}else{
    		return $this->fCurrentVisitIP = $long;
		}
    } 
    
    function setUserAgent($agent){
    	return $this->fUserAgent = $agent;
    }
    
    function setGroups($groups){
    	if(is_array($groups)){
    		return $this->fGroups = $groups;
    	}else{
    		return false;
    	}
    }
        
    function setIsDev($isdev){
    	return $this->fIsDev = (bool) $isdev;
    }
 
    function setIsDefaultUser($isdefaultuser){
    	return $this->fIsDefaultUser = (bool) $isdefaultuser;
    }
    
}

?>