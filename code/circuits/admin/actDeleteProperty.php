<?php

	if(!empty($attributes['code'])){
		if(!$oPropertyManager->removeProperty($attributes['code'])){
			_warning("WPropertyNotRemoved", "Something happened when deleting a property, probably property with such code already deleted");
		}else{
			_message("MPropertyRemoved", "Property was sucessfully deleted");
			_xfa($myself . "admin.showProperties");
		}
	}else{
		_error("EWrongPropertySpecified", "Wrong property code specified.");
	}

?>
