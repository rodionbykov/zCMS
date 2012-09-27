<?php

	$tmpoGroup = new Group();
	
	if(!empty($attributes['id'])){
		if(!($tmpoGroup = $oSecurityManager->getGroupByID($attributes['id']))){
			_error("ENoGroupFound", "No security group with ID={$attributes['id']} found");
		}
	}
	
	if(isset($attributes['fCode'])){
		$tmpoGroup->setCode($attributes['fCode']);
	}
	
	if(isset($attributes['fName'])){
		$tmpoGroup->setName($attributes['fName']);
	}
	
	if(isset($attributes['fDescription'])){
		$tmpoGroup->setDescription($attributes['fDescription']);
	}
	
	if(isset($attributes['fHomePage'])){
		$tmpoGroup->setHomePage($attributes['fHomePage']);
	}
	
	_assign("tmpoGroup", $tmpoGroup);
	_display("admin/dspGroupForm.tpl");

?>