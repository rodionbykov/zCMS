<?php

	$attributes['order'] = empty($attributes['order']) ? "moment" : $attributes['order'];
	$attributes['pagesize'] = empty($attributes['pagesize']) ? $oSettingsManager->getValue("AdminTableSize", 100, "INT", "Number of elements in tables of administrator backend") : (int) $attributes['pagesize'];
	
	if(!isset($attributes['sort'])){
		$attributes['sort'] = "DESC";
	}else{
		if(!in_array($attributes['sort'], array("ASC", "DESC"))){
			$attributes['sort'] = "DESC";
		}
	}
	
	$attributes['asort'] = ($attributes['sort'] == "ASC") ? "DESC" : "ASC";
	
	$attributes['page'] = empty($attributes['page']) ? 1 : (int) $attributes['page'];
	
	$oPaging = new Paging($attributes['pagesize'], $oLogManager->getLogCount(), $attributes['page']);
	$oPaging->setLinkFormat($here . "&page=%d");
	
	$arrPageSizes = array(10, 25, 50, 100, 200);
	
	if($arrLog = $oLogManager->getLog($attributes['order'], $attributes['sort'], $oPaging->getOffSet(), $oPaging->getPageSize())){
		_assign("arrLog", $arrLog);
		_assign("arrPages", $oPaging->getPages());
		_assign("arrPageSizes", $arrPageSizes);
	}
	
	_display("admin/dspLog.tpl");

?>