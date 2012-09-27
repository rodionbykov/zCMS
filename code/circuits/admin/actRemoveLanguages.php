<?php

	if(empty($attributes['id'])){
		_error("ENoLanguageGiven", "No language given");
	}else{
		if($oLanguageManager->removeLanguagesByID($attributes['id'])){
			_message("MLanguagesRemoved", "Languages removed successfully");
		}else{
			_warning("WLanguageNotRemoved", "Lanugage was not removed");
		}
	}
	
	_xfa($myself . "admin.showLanguages");
	
?>
