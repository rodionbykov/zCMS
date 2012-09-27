<?php

	if(isset($attributes['fCode']) && isset($attributes['fXCode']) && isset($attributes['fName']) && isset($attributes['fPos'])){
		
		if(strlen($attributes['fCode']) > 0){
			if(isset($attributes['entryid'])){
				if(!$oPropertyManager->setDictionaryEntryByID($attributes['entryid'], array('code' => $attributes['fCode'], 'xcode' => $attributes['fXCode'], 'name' => $attributes['fName'], 'pos' => $attributes['fPos']))){
					_warning("WPropertyDictionaryEntryNotStored", "Something happened while saving property dictionary entry to DB, probably another entry exists with same code or no entry with such ID (already) exists");
				}else{
					_message("MPropertyDictionaryEntryStored", "Property dictionary entry successfully stored");
				}
			}elseif(isset($attributes['propertycode'])){
				if(!$oPropertyManager->addDictionaryEntry($attributes['propertycode'], array('code' => $attributes['fCode'], 'xcode' => $attributes['fXCode'], 'name' => $attributes['fName'], 'pos' => $attributes['fPos']))){
					_warning("WPropertyDictionaryEntryNotAdded", "Something happened while adding property dictionary entry to DB, probably entry with such code already exists");
				}else{
					_message("MPropertyDictionaryEntryAdded", "Property dictionary entry successfully added");
				}
			}else{
				_error("ENoPropertyOrEntryFound", "No property or dictionary entry given");
			}
		}else{
			_warning("WPropertyDictionaryEntryCodeCannotBeEmpty", "Property dictionary entry code cannot be empty");
		}
	}else{
		_error("EWrongEntryFormSubmitted", "Invalid property dictionary form submitted");
	}
	
	_xfa($myself . "admin.showPropertyDictionary&code=" . $attributes['propertycode']);

?>