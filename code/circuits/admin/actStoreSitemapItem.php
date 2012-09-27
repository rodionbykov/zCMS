<?php	function prepareString($string='', $maxLength = 0) {		if(!isset($string) || strlen($string)==0) return '';		return ($maxLength>0)?substr(trim($string), 0, $maxLength):$string;	}	//prepare attributes
	$attributes['id'] = isset($attributes['id'])?intval($attributes['id']):0;
	$attributes['url'] = prepareString($attributes['url'], 1000);	$attributes['last_modified'] = prepareString($attributes['last_modified'], 10);
	$attributes['change_freq'] = prepareString($attributes['change_freq'], 10);	$attributes['priority'] = prepareString($attributes['priority'], 255);	$attributes['priority'] = str_replace(',', '.', $attributes['priority']);
	//validate
	if($attributes['id'] > 0){		$oldItem = $oSitemap->getItemByID($attributes['id']);
		if(empty($oldItem)){			_warning("WItemNotFound", "Item not found, probably deleted");		}	}

	if(strlen($attributes['url']) == 0){		_warning("WEmptyLocation", $oContentManager->getCleanTitle("MessageEmptyLocation"));	}	else{		if(!preg_match("/^http(s)?:\/\/.*/", $attributes['url'])){			$attributes['url'] = 'http://'.$attributes['url'];		}	}	if(strlen($attributes['last_modified']) == 0){		$attributes['last_modified'] = date('Y-m-d');	}	if(strlen($attributes['change_freq']) == 0){		_warning("MessageEmptyChangeFreq", $oContentManager->getCleanTitle("MessageEmptyChangeFreq"));	}	if(strlen($attributes['priority']) == 0){		$attributes['priority'] = 0.5;	}	else{		$attributes['priority'] = floatval($attributes['priority']);	}
if(!_gotWarnings() && !_gotErrors()) {

	$newItem=array();	$newItem['url']=$attributes['url'];	$newItem['last_modified']=$attributes['last_modified'];
	$newItem['change_freq']=$attributes['change_freq'];
	$newItem['priority']=$attributes['priority'];	if($attributes['id'] > 0){
		if($oSitemap->updateItemByID($attributes['id'], $newItem)) {			_message("MSitemapItemUpdated", "Sitemap Item updated successfully");		}
		else {
			_warning("WCannotUpdateSitemapItem", $oSitemap->getLastError());		}
	}
	else{
		if($oSitemap->addItem($newItem)){			_message("MSitemapItemAdded", "Sitemap Item added successfully");		}
		else {
			_warning("WCannotAddSitemapItem", $oSitemap->getLastError());
		}
	}

	_xfa($myself."admin.showSitemap");
}
?>