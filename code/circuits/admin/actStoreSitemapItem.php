<?php
	$attributes['id'] = isset($attributes['id'])?intval($attributes['id']):0;
	$attributes['url'] = prepareString($attributes['url'], 1000);
	$attributes['change_freq'] = prepareString($attributes['change_freq'], 10);
	//validate
	if($attributes['id'] > 0){
		if(empty($oldItem)){

	if(strlen($attributes['url']) == 0){
if(!_gotWarnings() && !_gotErrors()) {

	$newItem=array();
	$newItem['change_freq']=$attributes['change_freq'];
	$newItem['priority']=$attributes['priority'];
		if($oSitemap->updateItemByID($attributes['id'], $newItem)) {
		else {
			_warning("WCannotUpdateSitemapItem", $oSitemap->getLastError());
	}
	else{
		if($oSitemap->addItem($newItem)){
		else {
			_warning("WCannotAddSitemapItem", $oSitemap->getLastError());
		}
	}

	_xfa($myself."admin.showSitemap");
}
?>