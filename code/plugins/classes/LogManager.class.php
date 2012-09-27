<?php

class LogManager {

	var $fDB;
	var $fFuseaction;
	var $fUser;
	var $fLogTable;
	var $fLogPeriod;
	var $fLogEvents;
	var $fDateFormat;

    function LogManager(&$db, &$fuseaction, &$user, $logtable, $logperiod = 0, $logevents = "I,M,W,E") {
    	
    	$this->fDB = &$db;
    	$this->fFuseaction = &$fuseaction;
    	$this->fUser = &$user;
    	$this->fLogTable = $logtable;
    	$this->fDateFormat = "%m/%d/%Y %H:%i:%s";
    	$this->fLogPeriod = intval($logperiod);
    	$this->fLogEvents = explode(",", $logevents);
    	
    }
    
    function initialize(){
    	$sql = "SELECT id, id_fuseaction, id_user, fullname, logtype, logcode, logmsg, extmsg, ip, moment FROM " . $this->fLogTable . " WHERE 1=2";

   		return $this->fDB->query($sql) && $this->cleanLog();
    }
    
    // types I - info, M - message, W - warning, E - error
    function log($logmsg, $code = "", $type = "I", $extmsg = ""){
    	$type = in_array($type, array("I", "M", "W", "E")) ? $type : "I";

    	if(strlen(trim($logmsg)) > 0 && in_array($type, $this->fLogEvents)){
	    	$sql =  "INSERT INTO " . $this->fLogTable . " (id_fuseaction, id_user, fullname, logtype, logcode, logmsg, extmsg, ip, moment) VALUES (" .
	    			$this->fFuseaction->getID() . ", " . 
	    			$this->fUser->getID() . ", '" . 
	    			$this->fUser->getFullName() . "', '" . 
	    			$type . "', '" . 
	    			addslashes($code) . "', '" . 
	    			addslashes($logmsg) . "', '" . 
	    			$extmsg . "', INET_ATON('" . $_SERVER['REMOTE_ADDR'] . "'), NOW())";
	    	return $this->fDB->query($sql);
    	}else{
    		return false;
    	}
    }
    
    // TODO filtered out
    function getLog($order = "lid", $sort = "DESC", $offset = 0, $count = 0, $filter = array()){
    	$order = in_array($order, array("lid", "login", "fuseaction", "fullname", "logtype", "logcode", "logmsg", "moment", "ip")) ? $order : "moment";
    	$sort = in_array($sort, array("ASC", "DESC")) ? $sort : "ASC";
    	
    	$sql = "SELECT l.id AS lid, f.name as fuseaction, u.login, fullname, l.logtype, l.logcode, l.logmsg, l.extmsg, INET_NTOA(l.ip) AS ip, DATE_FORMAT(l.moment, '" . $this->fDateFormat . "') AS fmoment";
    	$sql .= " FROM " . $this->fLogTable . " l INNER JOIN users u ON u.id = l.id_user INNER JOIN pages f ON f.id = l.id_fuseaction";
    	$sql .= " ORDER BY " . $order . " " . $sort;
    	
    	if($count > 0 && $offset > 0){
    		$sql .= " LIMIT " . (int) $offset. ", " . (int) $count;
    	}elseif($count > 0){
    		$sql .= " LIMIT " . (int) $count;
    	}
    	
    	return $this->fDB->getQueryRecordSet($sql);
    }
    
    function getLogByID($id){
    	if(is_numeric($id)){
    		$sql = "SELECT l.id AS lid, f.name as fuseaction, u.login, fullname, l.logtype, l.logcode, l.logmsg, l.extmsg, INET_NTOA(l.ip) AS ip, DATE_FORMAT(l.moment, '" . $this->fDateFormat . "') AS fmoment";
    		$sql .= " FROM " . $this->fLogTable . " l INNER JOIN users u ON u.id = l.id_user INNER JOIN pages f ON f.id = l.id_fuseaction";
    		$sql .= " WHERE l.id = " . (int) $id;
    		
    		return $this->fDB->getQueryRecord($sql);
    	}else{
    		return false;
    	}
    }
    
    // TODO filtered count
    function getLogCount($filter = array()){
    	$sql = "SELECT COUNT(*) AS cnt FROM " . $this->fLogTable;
 		return $this->fDB->getQueryField($sql);
    }
    
    function cleanLog($period = 0){
    	$period = ($period == 0) ? $this->fLogPeriod : intval($period);
    	if ($period > 0){
    		$sql = "DELETE FROM " . $this->fLogTable . " WHERE DATE_ADD(moment, INTERVAL " . $period . " DAY) < NOW()";
    		return $this->fDB->query($sql);
    	}else{
    		return true;
    	}
    }
    
}
?>