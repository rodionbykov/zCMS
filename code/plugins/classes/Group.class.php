<?php

class Group {

	var $fID;
	var $fCode;
	var $fName;
	var $fDescription;
	var $fIsDefaultGroup;
	var $fHomePage;
	
    function Group ($id = 0, $code = "", $name = "", $description = "", $homePage = "") {
    	$this->fID = (int) $id;
    	$this->fCode = (string) $code;
    	$this->fName = (string) $name;
    	$this->fDescription = (string) $description;
    	$this->fHomePage = (string) $homePage;
    	$this->fIsDefaultGroup = false;
    }
    
    function getID(){
    	return $this->fID;
    }
    
    function getCode(){
    	return $this->fCode;
    }
    
    function getName(){
    	return $this->fName;
    }
    
    function getDescription(){
    	return $this->fDescription;
    }

    function getHomePage(){
    	return $this->fHomePage;
    }
    
    function isDefaultGroup(){
    	return (bool) $this->fIsDefaultGroup;
    }
  
    function setID($id){
    	if(is_numeric($id)){
    		return $this->fID = (int) $id;
    	}else{
    		return false;
    	}
    }
    
    function setCode($code){
    	if(!empty($code) && preg_match("/^[a-zA-Z0-9]+$/", $code)){
    		return $this->fCode = (string) $code;
    	}else{
    		return false;
    	}
    }
    
    function setName($name){
    	return $this->fName = (string) $name;
    }
    
    function setDescription($description){
    	return $this->fDescription = $description;
    }

    function setHomePage($homePage){
    	return $this->fHomePage = $homePage;
    }
    
    function setIsDefaultGroup($isdefaultgroup){
    	return $this->fIsDefaultGroup = (bool) $isdefaultgroup;
    }
    
}
?>