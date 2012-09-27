<?php
	
	$attributes['xcode'] = array_key_exists("xcode", $attributes) ? $attributes['xcode'] : "";
	
	$attributes['order'] = empty($attributes['order']) ? "pos" : $attributes['order'];
	$attributes['sort'] = empty($attributes['sort']) ? "DESC" : $attributes['sort'];
	$attributes['pagesize'] = empty($attributes['pagesize']) ? $oSettingsManager->getValue("AdminTableSize", 25, "INT", "Number of elements in tables of administrator backend") : (int) $attributes['pagesize'];
	$attributes['asort'] = ($attributes['sort'] == "ASC") ? "DESC" : "ASC";
	
	$attributes['page'] = empty($attributes['page']) ? 1 : (int) $attributes['page'];
	
	if(!empty($attributes['code'])){
		
		$oPaging = new Paging($attributes['pagesize'], $oPropertyManager->getDictionaryCount($attributes['code'], $attributes['xcode']), $attributes['page']);
		$oPaging->setLinkFormat($here . "&page=%d");
	
		$arrPageSizes = array(10, 25, 50, 100, 200);
		
		if($arrProperty = $oPropertyManager->getProperty($attributes['code'])){
			_assign("arrProperty", $arrProperty);
		}
		if($arrPropertyDictionary = $oPropertyManager->getDictionary($attributes['code'], $attributes['xcode'], $attributes['order'], $attributes['sort'], $oPaging->getOffSet(), $oPaging->getPageSize())){
			_assign("arrPages", $oPaging->getPages());
			_assign("arrPageSizes", $arrPageSizes);
			_assign("arrPropertyDictionary", $arrPropertyDictionary);
		}
	}else{
		_error("ENoPropertyFound", "No property found");
	}

	_display("admin/dspPropertyDictionary.tpl");

?>
