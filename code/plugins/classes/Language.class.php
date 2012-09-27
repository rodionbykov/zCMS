<?php

/*
 * Language class
 *
 * (c) Rodion Bykov roddyb@yandex.ru 2006
 * Created on  Aug 17, 2006
 * Last modified on Aug 4, 2008
 *
 *  Please ask for written permission before redistribute or use this plugin in your project
 *  I give no warranty or support of any kind for this class, neither guarantee its suitability to any purpose
 */

class Language {

	var $fID;
	var $fCode;
	var $fName;
	var $fEncoding;
	var $fContentLanguage;
	var $fDirection;


	function Language($id = 0, $code = "", $name = "", $encoding = "", $contentlanguage = "", $direction = "ltr") {
		$this->fID = (int) $id;
		$this->fCode = (string) $code;
		$this->fName = (string) $name;
		$this->fEncoding = (string) $encoding;
		$this->fContentLanguage = (string) $contentlanguage;
		$this->fDirection = (string) $direction;
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

	function getEncoding(){
        if(strlen($this->fEncoding) > 0){
            return $this->fEncoding;
        }else{
            return "utf-8";
        }
	}
    
	function getContentLanguage(){
		return $this->fContentLanguage;
	}

	function getDirection(){
		return $this->fDirection;
	}
	
	function setID($id){
		if(is_numeric($id)){
			return $this->fID = (int) $id;
		}else{
			return false;
		}
	}

	function setCode($code){
		if(!empty($code) && preg_match("/^[a-zA-Z0-9\_\-\.]+$/", $code)){
			return $this->fCode = (string) $code;
		}else{
			return false;
		}
	}

	function setName($name){
		return $this->fName = (string) $name;
	}

	function setEncoding($encoding){
		return $this->fEncoding = (string) $encoding;
	}

	function setContentLanguage($contentlanguage){
		return $this->fContentLanguage = (string) $contentlanguage;
	}

	function setDirection($direction){
		return $this->fDirection = (string) $direction;
	}
}

?>