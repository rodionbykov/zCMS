<?php

define("SECURITYMODE_STRICT", 1);
define("SECURITYMODE_LOOSE", 0);
// TODO getDeniedGroups getGrantedGroups

class SecurityManager {

	var $fDB;
	var $fUser;
	var $fFuseaction;
	var $fSecurityTable;
	var $fGroupsTable;
	var $fUsersGroupsTable;
	var $fDefaultGroup;
	var $fSecurityMode;
	var $fSecurity;
	var $fDefaultAccess;
	
    function SecurityManager(&$db, &$user, &$fuseaction, $securitytable, $groupstable, $usersgroupstable, $defaultgroup, $securitymode = SECURITYMODE_STRICT, $default_access = false) {
    
    	$this->fDB = &$db;
    	$this->fUser = &$user;
    	$this->fFuseaction = &$fuseaction;
    	$this->fSecurityTable = (string) $securitytable;
    	$this->fGroupsTable = (string) $groupstable;
    	$this->fUsersGroupsTable = (string) $usersgroupstable;
    	$this->fDefaultGroup = (string) $defaultgroup;
    	$this->fSecurityMode = $securitymode;
    	$this->fDefaultAccess = (bool) $default_access;
    	$this->fSecurity = array();
    	
    }
    
    function initialize(){
    	$sql1 = "SELECT id, code, name, description, homepage FROM " . $this->fGroupsTable . " WHERE 1 = 2";
    	$sql2 = "SELECT id, id_fuseaction, id_group, token, access FROM " . $this->fSecurityTable . " WHERE 1 = 2";
    	$sql3 = "SELECT id, id_user, id_group FROM " . $this->fUsersGroupsTable . " WHERE 1 = 2";
    	
    	$result = $this->fDB->query($sql1) && $this->fDB->query($sql2) && $this->fDB->query($sql3);
		$this->getUserGroups();
		
		return $result;
    }
    
    function synchronizeSecurity($arrFuseactions){
    	
    	$arrGroups = $this->getGroups();

		// adding default access for all fuseactions of the site
	 	foreach($arrFuseactions as $f){
			foreach($arrGroups as $g){
				$this->checkGroupAccess($f->getID(), $g->getID(), $f->getName());
			}
	 	}

		/* TODO remove non-existent fuseactions from security table 
		$sql = "SELECT s.id FROM " . $this->fSecurityTable . " s LEFT JOIN " . $fusebox['tableFuseactions'] . " p ON p.id = s.id_fuseaction WHERE p.id IS NULL";		
		if($arrNFuseactions = $this->fDB->getQueryColumn($sql, "id")){
			$sql = "DELETE FROM " . $this->fSecurityTable . " WHERE id IN (" . join(", ", $arrNFuseactions) . ")";
			$this->fDB->query($sql);
		}
		*/
		return true;
		// TODO error handling here
    	
    }
    
    function cacheSecurity(){
    	
    	$sql =  "SELECT token, access FROM " . $this->fSecurityTable . 
				" s INNER JOIN users_groups ug ON ug.id_group = s.id_group WHERE s.id_fuseaction = " . $this->fFuseaction->getID() . 
				" AND ug.id_user = " . $this->fUser->getID();
    	 
    	if($arrSecurity = $this->fDB->getQueryRecordSet($sql)){
    		foreach($arrSecurity as $s){
    			$this->fSecurity[ $s['token'] ] = (bool) $s['access'];
    		}
    		return true;
    	}else{
    		return false;
    	}
    }
       
    function &getGroup($code){
    	$id = 0;
    	if($id = $this->checkGroup($code)){
    		return $this->getGroupByID($id);
    	}else{
    		return false;
    	}
    }
    
    function &getGroupByID($id){
    
    	$arrGroup = false;
    	$group = false;
    	if(is_numeric($id)){
    		$sql = "SELECT id, code, name, description, homepage, IF(code = '" . $this->fDefaultGroup . "', 1, 0) AS is_defaultgroup FROM " . $this->fGroupsTable . " WHERE id = " . $id;
    		if($arrGroup = $this->fDB->getQueryRecord($sql)){
    			$group = new Group ($arrGroup['id'], $arrGroup['code'], $arrGroup['name'], $arrGroup['description'], $arrGroup['homepage']);
    			$group->setIsDefaultGroup($arrGroup['is_defaultgroup']);
    			return $group;
    		}
    	}else{
    		return false;
    	}
    }
    
    function getGroupsByID($id, $sort="name"){
    
        $sort = (string) $sort;
    	$sort = (in_array($sort, array('id', 'code', 'name', 'homepage'))) ? $sort : "name";
    
    	$arrGroups = false;
    	$group = false;
    	$groups = array();
    	if(is_array($id)){
    		$sql = "SELECT id, code, name, description, homepage, IF(code = '" . $this->fDefaultGroup . "', 1, 0) AS is_defaultgroup FROM " . $this->fGroupsTable . " WHERE id IN (" . join(", ", $id) . ") ORDER BY " . $sort;
    		if($arrGroups = $this->fDB->getQueryRecordSet($sql)){
    			foreach($arrGroups as $g){
    				$group = new Group ($g['id'], $g['code'], $g['name'], $g['description'], $g['homepage']);
    				$group->setIsDefaultGroup($g['is_defaultgroup']);
    				$groups[] = $group;
    			}
    			return $groups;
    		}
    	}else{
    		return false;
    	}
    }
    
    function checkGroup($code){
    	
    	$code = (string) $code;
    	$id = 0;
    	$sql = "SELECT id FROM " . $this->fGroupsTable . " WHERE code = '" . addslashes($code) . "'";
    	if($id = $this->fDB->getQueryRecord($sql)){
    		return (int) $id['id'];
    	}else{
    		return false;
    	}
    }
    
    function checkGroupByID($id){
    	
    	if(is_numeric($id)){
    	$sql = "SELECT id FROM " . $this->fGroupsTable . " WHERE id = " . $id;
	    	if($id = $this->fDB->getQueryRecord($sql)){
	    		return (int) $id['id'];
	    	}else{
	    		return false;
	    	}
    	}else{
    		return false;
    	}
    }
    
    function getGroups($order = "code", $sort = "ASC", $offset = 0, $count = 0, $filter = array()){
    	
    	$order = (string) $order;
    	$order = (in_array($order, array('id', 'code', 'name', 'homepage'))) ? $order : "code";
    	
    	$sort = (string) $sort;
    	$sort = (in_array($sort, array('ASC', 'DESC')) ? $sort : "ASC");
    	
    	$arrGroups = array();
    	$groups = array();
    	$group = false;
    	
    	$sql = "SELECT id, code, name, description, homepage, IF(code = '" . $this->fDefaultGroup . "', 1, 0) AS is_defaultgroup FROM " . 
    			$this->fGroupsTable . " ORDER BY " . $order . " " . $sort;
    	
    	if($count > 0 && $offset > 0){
    		$sql .= " LIMIT " . (int) $offset. ", " . (int) $count;
    	}elseif($count > 0){
    		$sql .= " LIMIT " . (int) $count;
    	}
    	
    	if($arrGroups = $this->fDB->getQueryRecordSet($sql)){
    		foreach($arrGroups as $g){
    			$group = new Group($g['id'], $g['code'], $g['name'], $g['description'], $g['homepage']);
    			$group->setIsDefaultGroup($g['is_defaultgroup']);
    			$groups[] = $group;
    		}
    		return $groups;
    	}else{
    		return false;		
    	}
    }
    
    function getGroupsCount(){
    	$sql = "SELECT COUNT(*) AS cnt FROM ". $this->fGroupsTable;
    	return $this->fDB->getQueryField($sql);
    }
    
    function setGroup($code, &$group){
    	$id = 0;
    	if($id = $this->checkGroup($code)){
    		return $this->setGroupByID($id, $group);
    	}else{
    		return false;
    	}
    }
    
    function setGroupByID($id, &$group){
    	
    	if(is_numeric($id) && is_a($group, "Group")){
    		if($id = $this->checkGroupByID($id)){
    			$sql = 	"UPDATE " . $this->fGroupsTable . 
						" SET code = '" . addslashes($group->getCode()) . 
						"', name = '" . addslashes($group->getName()) . 
						"', description = '" . addslashes($group->getDescription()) .
						"', homepage = '" . addslashes($group->getHomePage()) .  
						"' WHERE id = " . $id;
    			return $this->fDB->query($sql);
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}	
    }
    
    function addGroup(&$group){
    	if(is_a($group, "Group")){
			$sql = 	"INSERT INTO " . $this->fGroupsTable . " (code, name, description, homepage) VALUES (" .
					"'" . addslashes($group->getCode()) . 
					"', '" . addslashes($group->getName()) . 
					"', '" . addslashes($group->getDescription()) . 
					"', '" . addslashes($group->getHomePage()) . 
					"')";
			if($this->fDB->query($sql)){
				return $this->fDB->getID();
			}else{
				return false;
			}
    	}else{
    		return false;
    	}	
    }
	
	function removeGroup($code){
		
    	$id = 0;
    	if($id = $this->checkGroup($code)){
    		return $this->removeGroupsByID($id);
    	}else{
    		return false;
    	}
		
	}
 
 	function removeGroupsByID($id){
 		
 		if(is_array($id)){
 			
 			$arrID = array();
 			foreach($id as $i){
 				if(is_numeric($i)){ $arrID[] = (int) $i; }
 			}
 			$sql1 = "DELETE FROM " . $this->fGroupsTable . " WHERE id IN (" . join(", ", $arrID) . ")";
 			$sql2 = "DELETE FROM " . $this->fSecurityTable . " WHERE id_group IN (" . join(", ", $arrID) . ")";
 			$sql3 = "DELETE FROM " . $this->fUsersGroupsTable . " WHERE id_group IN (" . join(", ", $arrID) . ")";
 			return $this->fDB->query($sql1) && $this->fDB->query($sql2) && $this->fDB->query($sql3);
 		}elseif(is_numeric($id)){
 			$sql1 = "DELETE FROM " . $this->fGroupsTable . " WHERE id = " . $id;
 			$sql2 = "DELETE FROM " . $this->fSecurityTable . " WHERE id_group = " . $id;
 			$sql3 = "DELETE FROM " . $this->fUsersGroupsTable . " WHERE id_group = " . $id;
 			return $this->fDB->query($sql1) && $this->fDB->query($sql2) && $this->fDB->query($sql3);
 		}else{
 			return false;
 		}
 		
 	}
 
 
   /**
    * Getting array of security groups for current user and assign them to current user implicitly
	* @return Array of Group objects
	*/
    function getUserGroups(){   	
    	return $this->fUser->setGroups($this->pullUserGroups($this->fUser->getID()));
    } 
    
   /**
    * Pushing array of security groups into DB for current user and assign them to current user implicitly
	* @return Array of Group objects
	*/    
    function setUserGroups($groups){
    	if(is_array($groups)){
  			if($this->pushUserGroups($this->fUser->getID(), $groups)){
    			return $this->getUserGroups();
  			}else{
  				return false;
  			}
    	}else{
    		return false;
    	}
    }
    
    /** Removing current user's group association
     * 
     * @return bool
     */
    function removeUserGroups(){
    	
    	return $this->pushUserGroups($this->fUser->getID(), array());
    	
    }
    
    /**
    * Getting array of security groups for user given as ID
	* @return Array of Group objects
	*/   
    function pullUserGroups($userid, $sort = 'name'){
    	
    	$sort = (string) $sort;
    	$sort = (in_array($sort, array('id', 'code', 'name', 'homepage'))) ? $sort : "name";
    	
    	$arrGroups = array();
    	$groups = array();
    	$group = false;
    	
    	if (is_numeric($userid)){
	    	$sql = 	"SELECT g.id, g.code, g.name, g.description, g.homepage FROM " . $this->fGroupsTable . " g " . 
					" INNER JOIN " . $this->fUsersGroupsTable . " ug ON ug.id_group = g.id WHERE ug.id_user = " . $userid . 
					" ORDER BY " . $sort;
	    	
	    	if($arrGroups = $this->fDB->getQueryRecordSet($sql)){
	    		foreach($arrGroups as $g){
	    			$group = new Group($g['id'], $g['code'], $g['name'], $g['description'], $g['homepage']);
	    			$groups[] = $group;
	    		}
	    		return $groups;
	    	}else{
	    		return false;		
	    	}
    	}else{
    		return false;
    	}
    	
    }
    
    
    /**
    * Saving array of security groups for user given as ID
	* @return bool
	*/  
    function pushUserGroups($userid, $groups){
    	
    	if(is_numeric($userid) && is_array($groups) && $this->killUsersGroups($userid)){
    		$result = true;
    		foreach($groups as $g){
    			if(is_a($g, "Group")){
	    			$sql = "INSERT INTO " . $this->fUsersGroupsTable . " (id_user, id_group) VALUES (" . $userid . ", " . $g->getID() . ")";
	    			if(!$this->fDB->query($sql)){
	    				$result = false;
	    			}
    			}
    		}
    		return $result;
    	}else{
    		return false;
    	}
    	
    }
        
    /** Removing given user's group association
     * 
     * @return bool
     */   
    function killUsersGroups($userid){
    	if(is_numeric($userid)){
    		$sql = "DELETE FROM " . $this->fUsersGroupsTable . " WHERE id_user = " . (int) $userid;
    		return $this->fDB->query($sql);
    	}elseif(is_array($userid)){
    		$arrID = array();
			foreach($userid as $i){
				if(is_numeric($i)){
					$arrID[] = (int) $i;
				}
			}
    		$sql = "DELETE FROM " . $this->fUsersGroupsTable . " WHERE id_user IN (" . join(",", $arrID) . ")";
    		return $this->fDB->query($sql);
    	}else{	
    		return false;
    	}
    }   
       
   /**
    * Getting access status to given security token for current user
	* @return bool Access is granted or not. When in doubt, remember, if security mode is STRICT - DENY wins, if LOOSE - GRANT access wins
	*/    
    function getUserAccess($token){
    	if(strlen($token) > 0){
    		
    		// early check if user is dev or not
    		if($this->fFuseaction->isDevOnly() && !$this->fUser->isDev()){
	    		// regular user is not allowed to be on 'developer only' pages
	    		return false;
	    	}elseif($this->fUser->isDev()){
	    		// developer is granted everywhere
	    		return true;
	    	}
    		
	    	// adding security if there is no security records yet
	    	if($arrGroups = $this->getUserGroups()){
		    	foreach($arrGroups as $ug){
		    		$this->checkGroupAccess($this->fFuseaction->getID(), $ug->getID(), $token);
		    	}
	    	}else{
	    		return false;
	    	}
	    	
	    	if(count($this->fSecurity) > 0 && array_key_exists($token, $this->fSecurity)){
	    		// use cached value
	    		return $this->fSecurity[ $token ];
	    	}else{
	    		// pull value from DB
	    		return $this->pullUserAccess($this->fUser->getID(), $this->fFuseaction->getID(), $token);
	    	}
    	
    	}else{
    		return false;
    	}
    }
    
    /**
     * Alias of getUserAccess()
     * @return bool Access is granted or not.
     */
    function granted($token){
    	return $this->getUserAccess($token);
    }
    
    /**
    * Getting access status to given security token for user
	* @return bool Access is granted or not. When in doubt, remember, if security mode is STRICT - DENY wins, if LOOSE - GRANT access wins
	*/    
    function pullUserAccess($userid, $fuseactionid, $token){
    	 
    	$arrSecurity = array(); 
    	
    	if(is_numeric($userid) && is_numeric($fuseactionid)){
    		$sql = "SELECT s.access FROM " . $this->fSecurityTable . " s " . 
					"INNER JOIN " . $this->fUsersGroupsTable . " ug " .
						"ON ug.id_group = s.id_group " . 
					"WHERE ug.id_user = " . $userid . " AND s.id_fuseaction = " . $fuseactionid . " AND token = '" . addslashes($token) . "'"; 
					
			if($arrSecurity = $this->fDB->getQueryColumn($sql, 'access')){
				if($this->fSecurityMode == SECURITYMODE_STRICT){
					return !in_array(0, $arrSecurity);
    			}else{
    				return in_array(1, $arrSecurity);
    			}
			}else{
				return false;
			}
    	}else{
    		return false;
    	}
    	 
    }   
	
    function pullGroupAccess($idfuseaction, $idgroup, $token){
    	
    	$id = 0;
    	
    	if(is_numeric($idfuseaction) && is_numeric($idgroup)){
    		
    		if($id = $this->checkGroupAccess($idfuseaction, $idgroup, $token)){
    			return $this->pullGroupAccessByID($id);
    		}else{
				return false;
    		}
    	}else{
    		return false;
    	}
    	
    }
    
    function pullGroupAccessByID($id){
    	$arrAccess = false;
    	if(is_numeric($id)){
    		$sql = "SELECT access FROM " . $this->fSecurityTable . " WHERE id = " . $id;
    		if($arrAccess = $this->fDB->getQueryRecord($sql)){
    			return (bool) $arrAccess['access'];
    		}else{
				return false;
    		}
    	}else{
    		return false;
    	}
    }
    
    function checkGroupAccess($idfuseaction, $idgroup, $token){
    	   
    	    $id = 0; 
    	    if(is_numeric($idfuseaction) && is_numeric($idgroup)){
	    		$sql =  "SELECT id FROM " . $this->fSecurityTable . 
						" WHERE id_fuseaction = " . $idfuseaction .
	    				" AND id_group = " . $idgroup . 
	    				" AND token = '" . addslashes($token) . "'";
	    		if($id = $this->fDB->getQueryRecord($sql)){
	    			return $id['id'];
	    		}else{
	    			$sql =  "INSERT INTO " . $this->fSecurityTable . " (id_fuseaction, id_group, token, access) VALUES (" . 
	    				$idfuseaction . ", " . $idgroup . ", '" . addslashes($token) . "', " . (int) $this->fDefaultAccess . ")";
	    			if($this->fDB->query($sql)){
	    				return $this->fDB->getID();
	    			}else{
	    				return false;
	    			}
	    		}
    	    }else{
    	    	return false;
    	    }
    }
    
    
    function pushGroupAccess($idfuseaction, $idgroup, $token, $access){
    	
    	if(is_numeric($idfuseaction) && is_numeric($idgroup) && is_numeric($access)){
    		$id = 0; 			
    		if($id = $this->checkGroupAccess($idfuseaction, $idgroup, $token)){
    			return $this->pushGroupAccessByID($id, $access);
    		}
    	}else{
    		return false;
    	}
    	
    }
    
    function pushGroupAccessByID($id, $access){
    	if(is_numeric($id) && is_numeric($access)){
    		$sql = "UPDATE " . $this->fSecurityTable . " SET access = " . (int) $access . " WHERE id = " . $id;
    		return $this->fDB->query($sql);
    	}
    }
    
	function pullTokens($fuseactionid){
		$arrTokens = array();
		if(is_numeric($fuseactionid)){
			$sql = "SELECT DISTINCT token FROM " . $this->fSecurityTable . " WHERE id_fuseaction = " . $fuseactionid;
			if($arrTokens = $this->fDB->getQueryRecordSet($sql)){
				return $arrTokens;
			}else{
				return false;
			}
		}else{
			return false;
		}
		
	}
	
}
?>