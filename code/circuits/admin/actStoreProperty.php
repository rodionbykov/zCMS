<?php
	
	if(!empty($attributes['fCode']) && isset($attributes['fName'])){
		if(!$oPropertyManager->setProperty($attributes['fCode'], array('code' => $attributes['fCode'], 'name' => $attributes['fName']))){
			_warning("WPropertyNotSaved", "Something happened when storing property, probably property with such code already exists");
		}else{
			_message("MPropertySaved", "Property was sucessfully saved");
		}
	}else{
		_error("EWrongFormSubmitted", "Wrong form submitted, or else...");
	}
	
	_xfa($myself . "admin.showProperties");
	
?>
