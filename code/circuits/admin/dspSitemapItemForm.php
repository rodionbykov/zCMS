<?php

	$formvars = $attributes;

	if(isset($attributes['id']) && !_gotWarnings() && !_gotErrors()){
		if($arrItem = $oSitemap->getItemByID($attributes['id'])){
			$formvars=$arrItem;
		}
		else {
			_warning("WSitemapItemNotFound", "Sitemap Item not found, probably deleted");
		}
	}

	if(empty($formvars['url'])) $formvars['url'] = 'http://';
	if(!isset($formvars['priority']) || strlen($formvars['priority']) == 0) $formvars['priority'] = .5;

	_assign("formvars", $formvars);

	_display("admin/dspSitemapItemForm.tpl");

?>
