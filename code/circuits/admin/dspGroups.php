<?php
		
	$attributes['order'] = empty($attributes['order']) ? "code" : $attributes['order'];
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
	
	$oPaging = new Paging($attributes['pagesize'], $oSecurityManager->getGroupsCount(), $attributes['page']);
	$oPaging->setLinkFormat($here . "&page=%d");
	
	$arrPageSizes = array(10, 25, 50, 100, 200);	
		
		
	if($arrGroups = $oSecurityManager->getGroups($attributes['order'], $attributes['sort'], $oPaging->getOffSet(), $oPaging->getPageSize())){
		_assign("arrGroups", $arrGroups);
		_assign("arrPages", $oPaging->getPages());
		_assign("arrPageSizes", $arrPageSizes);
	}
	
	_display("admin/dspGroups.tpl");

?>