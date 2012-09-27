<?php

	if(!empty($attributes['propertycode']) && (!empty($attributes['entryid']) || !empty($attributes['entrycode']))){
		if(!empty($attributes['entryid'])){
			if(!$oPropertyManager->removeDictionaryEntryByID($attributes['entryid'])){
				_warning("WCannotRemoveDictionaryEntryByID", "Cannot remove property dictionary entry with given ID");	
			}else{
				_message("MPropertyDictionaryEntryRemoved", "Property dictionary entry successfully removed");
			}
		}elseif(!empty($attributes['entrycode'])){
			if(!$oPropertyManager->removeDictionaryEntry($attributes['propertycode'], $attributes['entrycode'])){
				_warning("WCannotRemoveDictionaryEntry", "Cannot remove property dictionary entry with given code");	
			}else{
				_message("MPropertyDictionaryEntryRemoved", "Property dictionary entry successfully removed");
			}
		}
	}else{
		_error("ENoEntryGiven", "No property dictionary entry given");
	}
	
	_xfa($myself . "admin.showPropertyDictionary&code=" . $attributes['propertycode']);

?>