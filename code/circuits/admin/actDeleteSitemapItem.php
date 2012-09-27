<?php


	$itemID = isset($attributes['id'])?intval($attributes['id']):0;
	if($itemID > 0){

		//check that document exists
		$itemToDelete = $oSitemap->getItemByID($itemID);
		if(empty($itemToDelete)){
			_warning("WSitemapItemNotFound", "Sitemap Item not found, probably already deleted");
		}
		else {

			if($oSitemap->deleteItemByID($itemID)) {
				_message("MSitemapItemDeleted", "Sitemap Item deleted successfully");
			}
			else {
				_warning("WCannotDeleteSitemapItem", "Cannot delete Sitemap Item, DB error");
			}

			_xfa("{$myself}admin.showSitemap");
		}
	}
	else {
		_warning("WEmptySitemapItemID", "No Sitemap Item ID(s) specified");
	}
?>
