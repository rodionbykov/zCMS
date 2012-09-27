<?php

	$attributes['order'] = empty($attributes['order']) ? "name" : $attributes['order'];
	$attributes['pagesize'] = empty($attributes['pagesize']) ? $oSettingsManager->getValue("AdminTableSize", 25, "INT", "Number of elements in tables of administrator backend") : (int) $attributes['pagesize'];
	$attributes['page'] = empty($attributes['page']) ? 1 : (int) $attributes['page'];
	
	if(!isset($attributes['sort'])){
		$attributes['sort'] = "DESC";
	}else{
		if(!in_array($attributes['sort'], array("ASC", "DESC"))){
			$attributes['sort'] = "DESC";
		}
	}
	
	$attributes['asort'] = ($attributes['sort'] == "ASC") ? "DESC" : "ASC";
	
	$oPaging = new Paging($attributes['pagesize'], $oFuseManager->getFuseactionsCount(), $attributes['page']);
	$oPaging->setLinkFormat($here . "&page=%d");
	
	$arrPageSizes = array(10, 25, 50, 100, 200);

	if($arrFuseactions = $oFuseManager->getFuseactions($attributes['order'], $attributes['sort'], $oPaging->getOffSet(), $oPaging->getPageSize())){
		_assign("arrFuseactions", $arrFuseactions);
		_assign("arrPages", $oPaging->getPages());
		_assign("arrPageSizes", $arrPageSizes);
	}else{
		_error("ECannotGetFuseactions", "Cannot retrieve fuseactions from DB");
	}
	if($arrGroups = $oSecurityManager->getGroups()){
		_assign("arrGroups", $arrGroups);
	}else{
		_error("ECannotGetGroups", "Cannot retrieve security groups from DB");
	}
	
	_display("admin/dspFuseactions.tpl");
	
?>
