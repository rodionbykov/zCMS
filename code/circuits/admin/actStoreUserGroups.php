<?php

	foreach($attributes as $key=>$val){
		$tmpoUser = false;
		$arrGroups = array();
		if(strpos($key, "u_") !== false){
			if(is_array($val)){
				foreach($val as $gid){
					$arrGroups[] = $oSecurityManager->getGroupByID($gid);
				}
				list($u, $id) = explode("_", $key);
				if($tmpoUser = $oUserManager->getUserByID($id)){
					$oSecurityManager->pushUserGroups($tmpoUser->getID(), $arrGroups);
				}
			}
		}
	}

	
	
	
	_message("MUserGroupsStored", "User groups stored");
	_xfa($myself . "admin.showUsers");

?>
