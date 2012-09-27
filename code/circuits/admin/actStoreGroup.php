<?php
	
	$tmpoGroup = new Group();
	
	if(!empty($attributes['id'])){
		if(!($tmpoGroup = $oSecurityManager->getGroupByID($attributes['id']))){
			_error("ENoGroupFound", "No security group with ID={$attributes['id']} found");
		}
	}

	if(isset($attributes['fCode'])){
		if(!$tmpoGroup->setCode($attributes['fCode'])){
			_warning("WEmptyGroupCode", "Group code cannot be empty and may contain only letters and numbers, no spaces");
		}
	}
	
	if(isset($attributes['fName'])){
		$tmpoGroup->setName($attributes['fName']);
	}
	
	if(isset($attributes['fDescription'])){
		$tmpoGroup->setDescription($attributes['fDescription']);
	}
	
	if(isset($attributes['fHomePage'])){
		$tmpoGroup->setHomePage($attributes['fHomePage']);
		if(strlen($attributes['fHomePage']) && !$oFuseManager->getFuseaction($attributes['fHomePage'])){
			_warning("WInvalidHomePage", "Specified home page is not found");
		}
	}
	
	if(!_gotWarnings() && !_gotErrors()){
		if(!empty($attributes['id'])){
			if(!$oSecurityManager->setGroupByID($attributes['id'], $tmpoGroup)){
				_error("ECannotSaveGroup", "Cannot save group \"" . $tmpoGroup->getName() . "\"");
			}else{
				_message("MGroupSaved", "Group saved successfully");
			}
		}else{
			if(!$oSecurityManager->addGroup($tmpoGroup)){
				_error("ECannotAddGroup", "Cannot add group \"" . $tmpoGroup->getName() . "\"");
			}else{
				_message("MGroupAdded", "Group added successfully");
			}
		}
		_xfa("{$myself}admin.showGroups");
	}

?>