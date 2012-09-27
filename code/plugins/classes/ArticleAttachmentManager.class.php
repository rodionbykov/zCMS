<?php

class ArticleAttachmentManager {
	
	var $fDB;
	var $fArticleManager;
	var $fFuseaction;
	
	var $fAttachmentTable;	
	
	function ArticleAttachmentManager(&$db, $articleManager, $attachmenttable) {
    	$this->fDB = &$db;
    	$this->fArticleManager = $articleManager;
    	$this->fAttachmentTable = (string) $attachmenttable;
    	$this->fFuseaction = new Fuseaction(0, "");
	}
	
    function initialize(){
    	$sql = "SELECT 
					id, 
					data_id, 
					title, 
					file 
				FROM ".
    				$this->fAttachmentTable.
    		  " WHERE 1 = 2";
    	return $this->fDB->query($sql);
    }	
	
	function getAttachments($article) {
		if ($id = $this->fArticleManager->checkToken(
				$this->fFuseaction->getID(), $article, '', false)) {
			return $this->getAttachmentsByID($id);
		} else {
			return false;
		}
	}
	
	function getAttachmentsByID($id) {
		$sql = "SELECT 
					* 
				FROM ".
					$this->fAttachmentTable.
				" WHERE data_id = ".intval($id);
		return $this->fDB->getQueryRecordSet($sql);
	}
	
	function getAttachment($id) {
		$sql = "SELECT 
					* 
				FROM ".
					$this->fAttachmentTable.
				" WHERE id = ".intval($id);
		return $this->fDB->getQueryRecord($sql);
	}
	
	function removeAttachment($id) {
		$sql = "DELETE FROM ".
					$this->fAttachmentTable.
				" WHERE id = ".intval($id);
		return $this->fDB->query($sql); 
	}
	
	function addAttachment($article, $params) {
		if (!array_key_exists('title', $params) ||
				!array_key_exists('file', $params) ||
				!array_key_exists('mime', $params)) {
			return false;
		}

		if (!$id = $this->fArticleManager->checkToken(
				$this->fFuseaction->getID(), $article, '', false)) {
			return false;			
		}
		
		$sql = "INSERT INTO ".$this->fAttachmentTable."
					(data_id, 
					title, 
					file,
					mime) 
				VALUES (".
					intval($id).", ".
					"'".addslashes($params['title'])."', ".
					"'".addslashes($params['file'])."', ".
					"'".addslashes($params['mime'])."'".
				")";
				
   		if ($this->fDB->query($sql)) {
   			return $this->fDB->getID();
   		} else {
   			return false;
   		}				
	}

	function updateAttachment($id, $params) {
		if (!array_key_exists('title', $params)) {
			return false;
		}
		
		$sql = "UPDATE ".$this->fAttachmentTable." SET
					title = '".addslashes($params['title'])."'";
		if (array_key_exists('file', $params) 
				&& array_key_exists('mime', $params)) {
			$sql .= ", file = '".addslashes($params['file'])."'";
			$sql .= ", mime = '".addslashes($params['mime'])."'";
		}

		$sql .= " WHERE id = ".intval($id);
		
   		if ($this->fDB->query($sql)) {
   			return true;
   		} else {
   			return false;
   		}		
	}
}

?>