<?php

	if(!empty($attributes['id'])){
		if(is_numeric($attributes['id'])){
			_log("Removing user with ID " . $attributes['id']);
			if($oSecurityManager->killUsersGroups($attributes['id']) && $oUserManager->removeUsersByID($attributes['id'])){
				_message("MUserRemoved", "User removed successfully");
			}else{
				_warning("WNoSuchUser", "No user with such ID found");
			}
		}elseif(is_array($attributes['id'])){
			_log("Removing users with IDs " . join(", ", $attributes['id']));
			if($oSecurityManager->killUsersGroups($attributes['id']) && $oUserManager->removeUsersByID($attributes['id'])){
				_message("MUsersRemoved", "Users removed successfully");
			}
		}else{
			_error("EInvalidUserID", "Invalid user ID");
		}
	}else{
		_error("ENoUserGiven", "No user given");
	}

	_xfa("{$myself}admin.showUsers");

?>