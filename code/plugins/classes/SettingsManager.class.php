<?php

class SettingsManager {

	var $fDB;
	var $fSettingsTable;
	var $fSettings;


    function SettingsManager(&$db, $settingstable) {
    	$this->fDB = &$db;
    	$this->fSettingsTable = $settingstable;
    	$this->fSettings = array();
    }

	function initialize(){
		$sql = "SELECT id, name, datatype, value, description FROM " . $this->fSettingsTable . " WHERE 1=2";
		return $this->fDB->query($sql);
	}

	function cacheSettings(){
		return $this->fSettings = $this->getSettings();
	}

	function getSettings($order = "description", $sort = "ASC", $offset = 0, $count = 0){

		$arrResult = array();

		if(!in_array($order, array("id", "name", "description"))){
			$order = "description";
		}

		if(!in_array($sort, array("ASC", "DESC"))){
			$sort = "ASC";
		}

		$sql = "SELECT id, name, datatype, value, description FROM " . $this->fSettingsTable . " ORDER BY " . $order . " " . $sort;

	    if($count > 0 && $offset > 0){
			$sql .= " LIMIT " . (int) $offset. ", " . (int) $count;
		}elseif($count > 0){
			$sql .= " LIMIT " . (int) $count;
		}

		if($this->fDB->query($sql)){
			$arrSettings = $this->fDB->getRecordSet();
			foreach($arrSettings as $k=>$s){
				$arrResult[ $s['name'] ]['description'] = $s['description'];
				$arrResult[ $s['name'] ]['datatype'] = $s['datatype'];
				switch ($s["datatype"]){
					case "INT":
						$arrResult[ $s['name'] ]['value'] = (int) $s['value'];
						break;
					case "FLOAT":
						$arrResult[ $s['name'] ]['value'] = (double) $s['value'];
						break;
					case "BOOL":
						$arrResult[ $s['name'] ]['value'] = (bool) $s['value'];
						break;
					default:
						$arrResult[ $s['name'] ]['value'] = (string) $s['value'];
				}
			}
			return $arrResult;
		}else{
			return false;
		}
	}

	function getSettingsCount(){
		$sql = "SELECT COUNT(*) AS cnt FROM " . $this->fSettingsTable;
		return $this->fDB->getQueryField($sql);
	}

	function getSetting($name, $value = "", $datatype = "STRING", $description = ""){
		if($this->checkSetting($name, $value, $datatype, $description)){
			if(array_key_exists($name, $this->fSettings)){
				return $this->fSettings[ $name ];
			}else{
				return false;
			}
		}
	}

	function checkSetting($name, $value, $datatype, $description){
		if (!in_array($datatype, array('STRING','INT','FLOAT','BOOL'))){
			$datatype = "STRING";
		}
		if(!array_key_exists($name, $this->fSettings)){
			$sql = "INSERT INTO " . $this->fSettingsTable . " (name, datatype, value, description) VALUES (" .
				   "'" . addslashes($name) . "', '" . $datatype . "', '" . addslashes($value) . "', '" . addslashes($description) . "')";
			if($this->fDB->query($sql)){
				return $this->cacheSettings();
			}else{
				return false;
			}
		}else{
			return true;
		}
	}

	function getValue($name, $value = "", $datatype = "STRING", $description = ""){
		$setting = false;
		if($setting = $this->getSetting($name, $value, $datatype, $description)){
			return $setting['value'];
		}else{
			return false;
		}
	}

	function setSetting($name, $setting){
		$arrSetting = array();
		if($arrSetting = $this->getSetting($name)){
			$sql = "UPDATE " . $this->fSettingsTable .
					" SET value = '" . addslashes($setting['value']) . "'," .
					" datatype = '" . addslashes($setting['datatype']) . "'," .
					" description = '" . addslashes($setting['description']) . "'" .
					" WHERE name = '" . addslashes($name) . "'";
			return $this->fDB->query($sql);
		}else{
			return false;
		}
	}

	function setSettingValue($name, $value){
		$arrSetting = array();
		if($arrSetting = $this->getSetting($name)){
			if(($arrSetting["datatype"] != "STRING") && !is_numeric($value)){
				return false;
			}
			$sql = "UPDATE " . $this->fSettingsTable . " SET value = '" . addslashes($value) . "' WHERE name = '" . addslashes($name) . "'";
			return $this->fDB->query($sql);
		}else{
			return false;
		}
	}

	function removeSetting($name){
		$sql = "DELETE FROM " . $this->fSettingsTable . " WHERE name = '" . addslashes($name) . "'";
		return $this->fDB->query($sql);
	}

}
?>