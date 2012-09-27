<?php

// v.4B1

class DB {

	var $login;
	var $password;
	var $dbname;
	var $host;
	var $port;
	
	var $link;
	
	var $fResult;	
	var $fRowsNumber = -1;
	var $fErrorCode;
	var $fError;
	var $fRecordSet = array();
	var $fQueries = array();

    function DB($login, $password, $dbname, $host, $port) {
    	$this->host = $host;
    	$this->login = $login;
    	$this->password = $password;
    	$this->dbname = $dbname;
    	$this->port = $port;
    }
    
    function connect(){
    	//
    }    	

    function query($sql, $time = 0){
        if($this->fErrorCode == 0){
            array_push($this->fQueries, sprintf("%s (%01.4f sec)", $sql, $time));
        }else{
            array_push($this->fQueries, sprintf("%s (%01.4f sec), server said %s: %s", $sql, $time, $this->fErrorCode, $this->fError));
        }
    }    	
    
    function getRowsCount(){
    	return $this->fRowsNumber;
    }
    
    function getID(){
    	//
    }
    
    function getDump(){    	    	
    	return $this->fQueries;
    }
        	
    function getError(){
    	return $this->fError;
    }
    
    function getErrorCode(){
    	return $this->fErrorCode;
    }
    
}

class DBmysql extends DB {
	
	function DBmysql($login, $password, $dbname, $host, $port = 3306){
		parent::db($login, $password, $dbname, $host, $port);
	}

    function connect(){    		
    	if($this->link = mysqli_connect($this->host, $this->login, $this->password)){
    		if(mysqli_select_db($this->link, $this->dbname)){
    			return true;
    		}else{
    			$this->fError = mysqli_error($this->link);
	    		$this->fErrorCode = mysqli_errno($this->link);	
	    		return false;
    		}
    	}else{
    		$this->fError = "Wrong connection string or server is not running";
	    	$this->fErrorCode = -1;	
 	    	return false;
    	}
    	
    } 	
    
    function query($sql, $time = 0){
    
    	list($t0, $t1) = explode(" ", microtime());
    	$_time0 = $t1+$t0;
    
    	$this->fResult = mysqli_query($this->link, $sql);
    	
    	$this->fError = mysqli_error($this->link);
	    $this->fErrorCode = mysqli_errno($this->link);	
		
		$this->fRowsNumber = mysqli_affected_rows($this->link);

    	list($t0, $t1) = explode(" ", microtime());
    	$_time1 = $t1+$t0;
    	
    	parent::query($sql, $_time1 - $_time0);    	
    	
    	return ($this->getErrorCode() == 0);
    	
    } 
    
   // TODO error handling
    function getQueryCount($sql){
    	$pos = strpos(strtolower($sql), "from");
    	if ($pos === false){
    		return false;
    	}else{
    		$sql2 = "SELECT COUNT(*) AS cnt " . substr($sql, $pos);
    		$res = mysqli_query($this->link, $sql2);  
    		mysqli_data_seek($res, 0);
    		$row = mysqli_fetch_row($res);  		 
    		$this->fRowsNumber = $row[0];
    		parent::query($sql2);
    		return $this->fRowsNumber;
    	}
    }
	
    function getQueryCountNoLimit($sql){
    	$pos = strpos(strtolower($sql), "from");
		$fromclause = substr($sql, $pos);
		$pos2 = strpos(strtolower($fromclause), "limit");
		$clause = substr($fromclause, 0, $pos2);
    	if ($pos === false){
    		return false;
    	}else{
    		$sql2 = "SELECT COUNT(*) AS cnt " . $clause;
			$res = mysqli_query($this->link, $sql2);  
    		mysqli_data_seek($res, 0);
    		$row = mysqli_fetch_row($res);  		 
    		$this->fRowsNumber = $row[0];
    		parent::query($sql2);
    		return $this->fRowsNumber;
    	}
    }

    function getRecord(){
    	$this->fRecordSet = array();
    	if (($this->getRowsCount() > 0)  &&  ($this->getErrorCode() == 0)){
			if($this->fRecordSet = mysqli_fetch_assoc($this->fResult)){
				mysqli_data_seek($this->fResult, 0);   
				return $this->fRecordSet;
			}else{
				$this->fError = mysqli_error($this->link);
	    		$this->fErrorCode = mysqli_errno($this->link);	
	    		return false;
			}
    	}else{
    		return false;
    	}
    }
    
    function getQueryRecord($sql){
    	if($this->query($sql)){
			return $this->getRecord();
    	}else{
    		return false;
    	}
    }
	    
    function getColumn($column){
    	$this->fRecordSet = array();
    	if (($this->getRowsCount() > 0)  &&  ($this->getErrorCode() == 0)){
    		while ($a = mysqli_fetch_assoc($this->fResult)){
    			array_push($this->fRecordSet, $a[$column]);
    		}
    		mysqli_data_seek($this->fResult, 0);
    		return $this->fRecordSet;
    	}elseif($this->getRowsCount() == 0){
    		return $this->fRecordSet;
    	}else{
    		return false;
    	}
    }
    
    function getQueryColumn($sql, $column){	
    	if($this->query($sql)){
	    	return $this->getColumn($column);
    	}else{
    		return false;
    	}
    }    
    
    function getRecordSet(){
    	$this->fRecordSet = array();
    	if (($this->getRowsCount() > 0)  &&  ($this->getErrorCode() == 0)){
    		while ($a = mysqli_fetch_assoc($this->fResult)){    			
    			array_push($this->fRecordSet, $a);
    		}
    		mysqli_data_seek($this->fResult, 0);
    		return $this->fRecordSet;
    	}elseif($this->getRowsCount() == 0){
    		return $this->fRecordSet;
    	}else{
    		return false;
    	}
    }
    
    function getQueryRecordSet($sql){
    	if($this->query($sql)){
	    	return $this->getRecordSet();
    	}else{
    		return false;
    	}
    }   
    
    function getField($row = 0, $col = 0){
    	
    	if (($this->getRowsCount() > 0)  &&  ($this->getErrorCode() == 0)){
    		mysqli_data_seek($this->fResult, $row);
    		$row = mysqli_fetch_row($this->fResult);
    		mysqli_data_seek($this->fResult, 0);
    		return $row[$col];
    	}else{
    		return false;
    	}
    }
    
    
    function getQueryField($sql, $row = 0, $col = 0){
    	if($this->query($sql)){
			return $this->getField($row, $col);
    	}else{
    		return false;
    	}
    }
	
    
    function getID(){    	
    	if ($this->getErrorCode() == 0){
    		return mysqli_insert_id($this->link);
    	}else{
    		return false;
    	}
    }
    
    	
	function MysqlToUnix($timestamp)
	{
		// Accepts a mySQL timestamp - format YYYYMMDDHHMMSS
		// and returns the unix timestamp in seconds since 1970
		$timestamp = (string)$timestamp;
		$yyyy = substr($timestamp, 0, 4);
		$month = substr($timestamp, 4, 2);
		$dd = substr($timestamp, 6, 2);
		$hh = substr($timestamp, 8, 2);
		$mm = substr($timestamp, 10, 2);
		$ss = substr($timestamp, 12, 2);
		$time = mktime($hh, $mm, $ss, $month, $dd, $yyyy);
		return $time;
	}
	
	function UnixToMysql($timestamp)
	{
		// Accepts a unix timestamp in seconds since 1970
		// and returns the mySQL timestamp - format YYYYMMDDHHMMSS
		$time = date('YmdHis', $timestamp);
		return $time;
	} 
}
?>