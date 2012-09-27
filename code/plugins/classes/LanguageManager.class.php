<?php

/*
 * LanguageManager class
 *
 * (c) Rodion Bykov roddyb@yandex.ru 2006
 * Created on  Aug 17, 2006
 * Last modified on Aug 4, 2008
 *
 *  Please ask for written permission before redistribute or use this plugin in your project
 *  I give no warranty or support of any kind for this class, neither guarantee its suitability to any purpose
 */

class LanguageManager {

	var $fDB;
	var $fLanguageTable;
	var $fLanguagesCount;

	function LanguageManager(&$db, $languagetable){
		$this->fDB = &$db;
		$this->fLanguageTable = strval($languagetable);
	}

	function initialize(){
		$sql = "SELECT id, code, name, encoding, contentlanguage, direction FROM " . $this->fLanguageTable;

		if($this->fDB->query($sql)){
			$this->fLanguagesCount = $this->fDB->getRowsCount();
			return true;
		}else{
			return false;
		}
	}

	function getLanguage($code, $addifnotexists = false){

		$id = 0;
		$addifnotexists = (bool) $addifnotexists;

		if($id = $this->checkLanguage($code, $addifnotexists)){
			return $this->getLanguageByID($id);
		}else{
			return false;
		}
	}

	function getLanguageByID($id){

		$arrLanguage = array();

		$sql = "SELECT id, code, name, encoding, contentlanguage, direction FROM " . $this->fLanguageTable . " WHERE id = " . (int) $id;

		if($arrLanguage = $this->fDB->getQueryRecord($sql)){
			$language = new Language($arrLanguage['id'], $arrLanguage['code'], $arrLanguage['name'], $arrLanguage['encoding'], $arrLanguage['contentlanguage'], $arrLanguage['direction']);
			return $language;
		}else{
			return false;
		}
	}


	function addLanguage(&$language){

		if(is_object($language)){
			$sql = "INSERT INTO " . $this->fLanguageTable . " (code, name, encoding, contentlanguage, direction) VALUES ('" . addslashes($language->getCode()) . "', '" . addslashes($language->getName()) . "', '" . addslashes($language->getEncoding()) . "', '" . addslashes($language->getContentLanguage()) . "', '" . addslashes($language->getDirection()) . "')";

			if($this->fDB->query($sql)){
				return $this->fDB->getID();
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function checkLanguage($code, $addifnotexists = false){

		$addifnotexists = (bool) $addifnotexists;

		$sql = "SELECT id FROM " . $this->fLanguageTable . " WHERE code = '" . addslashes($code) . "'";

		if($lng = $this->fDB->getQueryRecord($sql)){
			return (int) $lng['id'];
		}else{
			if($addifnotexists){
				$tmpLanguage = new Language(0, $code);
				return $this->addLanguage($tmpLanguage);
			}else{
				return false;
			}
		}
	}

	function setLanguage($code, &$language){

		$id = 0;

		if($id = $this->checkLanguage($code)){
			if(is_object($language)){
				return $this->setLanguageByID($id, $language);
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function setLanguageByID($id, &$language){

		if (is_numeric($id) && is_object($language)){
			$sql = 	"UPDATE " . $this->fLanguageTable .
					" SET code = '" . addslashes($language->getCode()) .
					"', name = '" . addslashes($language->getName()) .
					"', encoding = '" . addslashes($language->getEncoding()) .
					"', contentlanguage = '" . addslashes($language->getContentLanguage()) .
					"', direction = '" . addslashes($language->getDirection()) .
					"' WHERE id = " . (int) $id;

			return $this->fDB->query($sql);
		}else{
			return false;
		}
	}

	function removeLanguage($code){

		$sql = "DELETE FROM " . $this->fLanguageTable . " WHERE code = '" . addslashes($code) . "'";

		return $this->fDB->query($sql);

	}

	function removeLanguagesByID($id){

		if(is_array($id)){
			$sql = "DELETE FROM " . $this->fLanguageTable . " WHERE id IN (" . join(",", $id) . ")";
		}else{
			$sql = "DELETE FROM " . $this->fLanguageTable . " WHERE id = " . intval($id);
		}
		return $this->fDB->query($sql);

	}

	function getLanguages($order = "code", $sort = "ASC", $offset = 0, $count = 0, $filter = array()){

		$arrLanguages = array();

		$order = (in_array($order, array("id", "code", "name", "encoding", "contentlanguage", "direction"))) ? $order : "code";
		$sort = (in_array($sort, array("ASC", "DESC"))) ? $sort : "ASC";

		$sql = "SELECT id, code, name, encoding, contentlanguage, direction FROM " . $this->fLanguageTable . " ORDER BY " . $order . " " . $sort;

		if($count > 0 && $offset > 0){
			$sql .= " LIMIT " . (int) $offset. ", " . (int) $count;
		}elseif($count > 0){
			$sql .= " LIMIT " . (int) $count;
		}

		$arrLangs = $this->fDB->getQueryRecordSet($sql);

		foreach($arrLangs as $l){
			$language = new Language($l['id'], $l['code'], $l['name'], $l['encoding'], $l['contentlanguage'], $l['direction']);
			$arrLanguages[] = $language;
		}

		return $arrLanguages;

	}

	function getLanguagesCount(){
		return $this->fLanguagesCount;
	}

}

?>