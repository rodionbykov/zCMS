<?php
/*
 * FuseManager class
 *
 * (c) Rodion Bykov roddyb@yandex.ru 2006
 * Created on  Aug 12, 2006
 * Last modified on Aug 12, 2006
 * 
 *  Please ask for written permission before redistribute or use this plugin in your project
 *  I give no warranty or support of any kind for this class, neither guarantee its suitability to any purpose
 */
 
 class FuseManager{
 	
 	var $fDB;
 	var $fFuseactionTable;
 	var $fAutoAdd;
 
 	function FuseManager(&$db, $fuseaction_table, $autoadd = false){
 		$this->fDB = &$db;
 		$this->fFuseactionTable = $fuseaction_table;
 		$this->fAutoAdd = $autoadd;
 	}
 	
 	function initialize(){
 		
 		$sql = "SELECT id, name, description, responsibility, sticky_attributes, is_devonly FROM " . $this->fFuseactionTable . " WHERE 1=2";
 		
 		return $this->fDB->query($sql);
 	}
 	
 	function getFuseaction($name){
 		
 		$name = strval($name);
 		$sql = "SELECT id, name, description, responsibility, sticky_attributes, is_devonly FROM " . $this->fFuseactionTable . " WHERE name = '" . addslashes($name) . "'";
 		
 		if($arrFA = $this->fDB->getQueryRecord($sql)){
 			$fuseaction = new Fuseaction($arrFA['id'], $arrFA['name'], $arrFA['description'], $arrFA['responsibility'], $arrFA['sticky_attributes'], (bool) $arrFA['is_devonly']);
 			return $fuseaction;
 		}else{
 			if($this->fAutoAdd == true){
 				return $this->addFuseaction($name);
 			}else{
 				return false;
 			}
 		}
 		
 	}
 	
 	function setFuseaction($name, $fuseaction){
 		
 		$sql = 	"UPDATE " . $this->fFuseactionTable . 
				" SET id = " . $fuseaction->getID() . 
				", name = '" . addslashes($fuseaction->getName()) . 
				"', description = '" . addslashes($fuseaction->getDescription()) . 
				"', responsibility = '" . addslashes($fuseaction->getResponsibility()) . 
				"', sticky_attributes = '" . addslashes($fuseaction->getStickyAttributesList()) .  
				"', is_devonly = " . intval($fuseaction->isDevOnly()) . 
				" WHERE name = '" . addslashes($name) . "'";

 		return $this->fDB->query($sql);
 	}
 	
 	function getFuseactionByID($id){
 		
 		$sql = "SELECT id, name, description, responsibility, sticky_attributes, is_devonly FROM " . $this->fFuseactionTable . " WHERE id = " . intval($id);
 		
 		if($arrFA = $this->fDB->getQueryRecord($sql)){
 			$fuseaction = new Fuseaction($arrFA['id'], $arrFA['name'], $arrFA['description'], $arrFA['responsibility'], $arrFA['sticky_attributes'], (bool) $arrFA['is_devonly']);
 			return $fuseaction;
 		}else{
 			return false;
 		}
 		
 	}
 	
 	function addFuseaction($name, $description = "", $responsibility = "", $stickyattributes = "", $devonly = false){
 		
 		$sql = "INSERT INTO " . $this->fFuseactionTable . " (name, description, responsibility, sticky_attributes, is_devonly) VALUES ('" . addslashes($name) . "', '" . addslashes($description) . "', '" . addslashes($responsibility) . "', '" . addslashes($stickyattributes) . "', " . intval($devonly) . ")";
 		
 		if($this->fDB->query($sql)){
 			return $this->getFuseactionByID($this->fDB->getID());
 		}else{
 			return false;
 		}
 	}
 	
 	function deleteFuseaction($name){
 		
 		$sql = "DELETE FROM " . $this->fFuseactionTable . " WHERE name = '" . addslashes($name) . "'";
 		
 		return $this->fDB->query($sql);
 	}
 	
 	function deleteFuseactionByID($id){
 		
 		if(is_array($id)){
 			$sql = "DELETE FROM " . $this->fFuseactionTable . " WHERE id IN (" . join(",", $id) . ")";
 		}else{
			$sql = "DELETE FROM " . $this->fFuseactionTable . " WHERE id = " . intval($id);
 		}
 		
		return $this->fDB->query($sql);
 	}
 	
 	function getFuseactions($order = "name", $sort = "ASC", $offset = 0, $count = 0){
 	
 		$order = (in_array($order, array('id', 'name', 'description'))) ? $order : "name";
 		$sort = (in_array($sort, array('ASC', 'DESC'))) ? $sort : "ASC";
 		$offset = (int) $offset;
 		$count = (int) $count;
 	
		$sql = "SELECT id, name, description, responsibility, sticky_attributes, is_devonly FROM " . $this->fFuseactionTable . " ORDER BY " . $order . " " . $sort;
		
		if($offset > 0 && $count > 0){
			$sql .= " LIMIT " . $offset . ", " . $count;
		}elseif($count > 0){
			$sql .= " LIMIT " . $count;
		}
			
		$arrFuseactions = array();
		if($arrFuseactionsNames = $this->fDB->getQueryRecordSet($sql)){
			foreach($arrFuseactionsNames as $f){
				$fuseaction = new Fuseaction($f['id'], $f['name'], $f['description'], $f['responsibility'], $f['sticky_attributes'], (bool) $f['is_devonly']);
				$arrFuseactions[] = $fuseaction;
			}
			return $arrFuseactions;
		}else{
			return false;
		}
 	}
 	
 	function getFuseactionsCount(){
 		$sql = "SELECT COUNT(*) AS cnt FROM " . $this->fFuseactionTable;
 		return $this->fDB->getQueryField($sql);
 	}
 	
 	function synchronizeFuseactions(&$fusebox){
  	
 		$arrFuseactions = array();
 		$arrDBFuseactions = array();
 	
	 	foreach($fusebox['circuits'] as $ck => $cv){
	 		foreach($cv['fuseactions'] as $fk => $fv){
	 			$fkey = $ck . "." . $fk;
	 			$arrFuseactions[$fkey]['circuit'] = $ck;
	 			$arrFuseactions[$fkey]['name'] = $fv['xml']['xmlAttributes']['name'];	
	 			if(isset($fv['xml']['xmlAttributes']['description'])){
	 				$arrFuseactions[$fkey]['description'] = $fv['xml']['xmlAttributes']['description'];
	 			}else{
	 				$arrFuseactions[$fkey]['description'] = "";	
	 			}
	 			if (isset($fv['xml']['xmlAttributes']['devonly'])){
	 				$arrFuseactions[$fkey]['devonly'] = (bool) $fv['xml']['xmlAttributes']['devonly'];
	 			}else{
	 				$arrFuseactions[$fkey]['devonly'] = false;
	 			}
	 			if (isset($fv['xml']['xmlAttributes']['stickyattributes'])){
	 				$arrFuseactions[$fkey]['stickyattributes'] = $fv['xml']['xmlAttributes']['stickyattributes'];
	 			}else{
	 				$arrFuseactions[$fkey]['stickyattributes'] = "";
	 			}	 			
	 		}
	 	}

 		$sql = "SELECT name FROM " . $this->fFuseactionTable;
 		$arrDBFuseactions = $this->fDB->getQueryColumn($sql, 'name');

        $no_sync_errors = true;
	 	foreach($arrFuseactions as $k=>$v){
	 		if(!in_array($k, $arrDBFuseactions)){
 				if(!$this->addFuseaction($k, $v['description'], '', $v['stickyattributes'], $v['devonly'])){
 					$no_sync_errors = false;
 				}
	 		}else{
	 			$fuseaction = $this->getFuseaction($k);
	 			$fuseaction->setDescription($v['description']);
	 			$fuseaction->setStickyAttributes($v['stickyattributes']);
	 			$fuseaction->setIsDevOnly($v['devonly']);
	 			if(!$this->setFuseaction($k, $fuseaction)){
	 				$no_sync_errors = false;
	 			}
	 		}
	 	}

	 	foreach($arrDBFuseactions as $f){
	 		if(!in_array($f, array_keys($arrFuseactions))){
				if(!$this->deleteFuseaction($f)){
                    $no_sync_errors = false;
                }
	 		}
	 	}

		return $no_sync_errors;
	}
 	
 }
 
?>
