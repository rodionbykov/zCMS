<?php

	$attributes['order'] = empty($attributes['order']) ? "description" : $attributes['order'];
	$attributes['sort'] = empty($attributes['sort']) ? "ASC" : $attributes['sort'];
	$attributes['pagesize'] = empty($attributes['pagesize']) ? $oSettingsManager->getValue("AdminTableSize", 25, "INT", "Number of elements in tables of administrator backend") : (int) $attributes['pagesize'];
	$attributes['asort'] = ($attributes['sort'] == "ASC") ? "DESC" : "ASC";
	
	$attributes['page'] = empty($attributes['page']) ? 1 : (int) $attributes['page'];

	$oPaging = new Paging($attributes['pagesize'], $oSettingsManager->getSettingsCount(), $attributes['page']);
	$oPaging->setLinkFormat($here . "&page=%d");

	$arrPageSizes = array(10, 25, 50, 100, 200);

	if($arrSettings = $oSettingsManager->getSettings($attributes['order'], $attributes['sort'], $oPaging->getOffSet(), $oPaging->getPageSize())){
		_assign("arrSettings", $arrSettings);
		_assign("arrPages", $oPaging->getPages());
		_assign("arrPageSizes", $arrPageSizes);
	}
	
	_display("admin/dspSettings.tpl");

?>