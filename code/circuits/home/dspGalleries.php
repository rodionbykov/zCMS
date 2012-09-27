<?php

	$attributes['page_size'] = empty($attributes['page_size']) ? 
		$oSettingsManager->getValue("GalleriesPageSize", 10, "INT", 
		"Number of elements in galleries list") : 
		intval($attributes['page_size']);
		
	$attributes['page'] = 
		empty($attributes['page']) ? 1 : intval($attributes['page']);		

	$oPaging = new Paging($attributes['page_size'], 
		$ogGalleryManager->getGalleriesCount(), $attributes['page']);

	$oPaging->setLinkFormat($here . "&page=%d");

	$arrAllGalleries = $ogGalleryManager->getGalleries("id", "DESC", 
		$oPaging->getOffSet(), $oPaging->getPageSize());
		
	_assign("arrPages", $oPaging->getPages());
	_assign("arrAllGalleries", $arrAllGalleries);
    _display("home/dspGalleries.tpl");

?>
