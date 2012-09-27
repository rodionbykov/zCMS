<?php

	if(!empty($attributes['entryid']) && is_numeric($attributes['entryid'])){
		if($arrEntry = $oPropertyManager->getDictionaryEntryByID($attributes['entryid'])){
			_assign("arrEntry", $arrEntry);
		}
	}
	
	if(!empty($attributes['propertycode'])){
		if($arrProperty = $oPropertyManager->getProperty($attributes['propertycode'])){
			_assign("arrProperty", $arrProperty);
		}
	}else{
		_error("ENoPropertyGiven", "No property entry given");
	}
	
	_display("admin/dspPropertyDictionaryEntryForm.tpl");
	
?>