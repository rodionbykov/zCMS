<?php

	$attributes['order'] = empty($attributes['order']) ? "login" : $attributes['order'];
	$attributes['pagesize'] = empty($attributes['pagesize']) ? $oSettingsManager->getValue("AdminTableSize", 25, "INT", "Number of elements in tables of administrator backend") : (int) $attributes['pagesize'];
	
	if(!isset($attributes['sort'])){
		$attributes['sort'] = "ASC";
	}else{
		if(!in_array($attributes['sort'], array("ASC", "DESC"))){
			$attributes['sort'] = "ASC";
		}
	}
	
	$attributes['asort'] = ($attributes['sort'] == "ASC") ? "DESC" : "ASC";
	
	$attributes['page'] = empty($attributes['page']) ? 1 : (int) $attributes['page'];
	
	$oPaging = new Paging($attributes['pagesize'], $oUserManager->getUsersCount(), $attributes['page']);
	$oPaging->setLinkFormat($here . "&page=%d");
	
	$arrPageSizes = array(10, 25, 50, 100, 200);
	
	if($arrUsers = $oUserManager->getUsers($attributes['order'], $attributes['sort'], $oPaging->getOffSet(), $oPaging->getPageSize())){
		
		foreach($arrUsers as $k=>$u){
			$arrUsers[$k]->setGroups($oSecurityManager->pullUserGroups($u->getID()));
		}
		
		_assign("arrUsers", $arrUsers);
		_assign("arrPages", $oPaging->getPages());
		_assign("arrPageSizes", $arrPageSizes);
	}
	$arrGroups = $oSecurityManager->getGroups();
	_assign("arrGroups", $arrGroups);
	_display("admin/dspUsers.tpl");
		
?>
