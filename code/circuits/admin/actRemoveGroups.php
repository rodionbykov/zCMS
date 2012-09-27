<?php
	
	if(!empty($attributes['id'])){
		if(is_numeric($attributes['id'])){
			if($oSecurityManager->checkGroupByID($attributes['id'])){
				if($oSecurityManager->removeGroupsByID($attributes['id'])){
					_message("MGroupRemoved", "Group removed");
				}
			}else{
				_warning("WNoSuchGroup", "No such group found");
			}
		}elseif(is_array($attributes['id'])){
			if($oSecurityManager->removeGroupsByID($attributes['id'])){
				_message("MGroupsRemoved", "Groups removed");
			}
		}else{
			_error("EInvalidGroupID", "Invalid group ID");
		}
	}else{
		_error("ENoGroupGiven", "No security group is given to delete");
	}
	
	_xfa($myself . "admin.showGroups");

?>
