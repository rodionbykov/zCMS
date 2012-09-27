<?php

/*
 * Fuseaction class
 *
 * (c) Rodion Bykov roddyb@yandex.ru 2006
 * Created on  Aug 12, 2006
 * Last modified on Aug 12, 2006
 * 
 *  Please ask for written permission before redistribute or use this plugin in your project
 *  I give no warranty or support of any kind for this class, neither guarantee its suitability to any purpose
 */
 
 class Fuseaction {
 	
 	var $fID;
 	var $fName;
 	var $fDescription;
 	var $fResponsibility;
 	var $fStickyAttributes;
 	var $fIsDevOnly;
    var $fBirthMoment;
 	
 	function Fuseaction($id, $name, $description = "", $responsibility = "", $stickyattributes = "", $isdevonly = false){
 		
 		$this->fID = $id;
 		$this->fName = $name;
 		$this->fDescription = $description;
 		$this->fResponsibility = $responsibility;
 		$this->fStickyAttributes = explode(",", $stickyattributes);
 		$this->fIsDevOnly = $isdevonly;
        
        list($t0, $t1) = explode(" ", microtime());
        $this->fBirthMoment = $t1+$t0;
 		
 	}
 	
    function getLifeTime(){
    	list($t0, $t1) = explode(" ", microtime());
        $_time1 = $t1+$t0;
        
        return sprintf("%01.4f", $_time1 - $this->fBirthMoment);     
    }
    
 	function getID(){
 		return $this->fID;
 	}
 	
 	function getName(){
 		return $this->fName;
 	}
 	
 	function getDescription(){
 		return $this->fDescription;
 	}
 	
 	function getResponsibility(){
 		return $this->fResponsibility;
 	}
 	
 	function getStickyAttributes(){
 		sort($this->fStickyAttributes);
 		return $this->fStickyAttributes;
 	}
 	
 	function getStickyAttributesList(){
 		return join(",", $this->getStickyAttributes());
 	}
 	
 	function isDevOnly(){
 		return $this->fIsDevOnly;
 	}
 	
 	function setID($id){
 		return $this->fID = (int) $id;
 	}
 	
 	function setName($name){
 		return $this->fName = (string) $name;
 	}
 	
 	function setDescription($description){
 		return $this->fDescription = (string) $description;
 	}
 	
 	function setResponsibility($responsibility){
 		return $this->fResponsibility = (string) $responsibility;
 	}
 	
 	function setStickyAttributes($stickyattributes){
 		return $this->fStickyAttributes = explode(",", $stickyattributes);
 	}
 	
 	function setIsDevOnly($isdevonly){
 		return $this->fIsDevOnly = (bool) $isdevonly;
 	}
 	
 }
 
?>
