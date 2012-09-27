<?php

	
	$tmpoLanguage = false;
	
	if(empty($attributes['id']) && empty($attributes['key'])){
		$tmpoLanguage = new Language();
		if(!$tmpoLanguage->setCode($attributes['fCode'])){
			_warning("WInvalidCode", "Language code is empty or invalid");
		}
		$tmpoLanguage->setName($attributes['fName']);
		$tmpoLanguage->setEncoding($attributes['fEncoding']);
		$tmpoLanguage->setContentLanguage($attributes['fContentLanguage']);
		$tmpoLanguage->setDirection($attributes['fDirection']);
		if(!_gotErrors() && !_gotWarnings()){
			if($newLanguageID = $oLanguageManager->addLanguage($tmpoLanguage)){
				_message("MLanguageAdded", "Language added successfully");
				_xfa($myself . "admin.showLanguages");
			}else{
				_warning("WLanguageNotAdded", "Language not added");
			}
		}
	}else{
		
		if(isset($attributes['id']) && (intval($attributes['id']) > 0)){
			if(!($tmpoLanguage = $oLanguageManager->getLanguageByID(intval($attributes['id'])))){
				_warning("WNoSuchLanguage", "No language found");
			}
		}elseif(isset($attributes['key'])){
			if(!($tmpoLanguage = $oLanguageManager->getLanguage($attributes['key']))){
				_warning("WNoSuchLanguage", "No language found");
			}
		}else{
			_error("ENoValidLanguageGiven", "No valid language is given");
		}
		
		if(!$tmpoLanguage){
			_error("ENoLanguageFound", "No such language found in DB");
		}else{
			$language_code = $tmpoLanguage->getCode();
			if(!$tmpoLanguage->setCode($attributes['fCode'])){
				_warning("WInvalidCode", "Language code is empty or invalid");
			}
			$tmpoLanguage->setName($attributes['fName']);
			$tmpoLanguage->setEncoding($attributes['fEncoding']);
			$tmpoLanguage->setContentLanguage($attributes['fContentLanguage']);
			$tmpoLanguage->setDirection($attributes['fDirection']);
			if(!_gotErrors() && !_gotWarnings()){
				if($oLanguageManager->setLanguage($language_code, $tmpoLanguage)){
					_message("MLanguageStored", "Language stored successfully");
					_xfa($myself . "admin.showLanguages");
				}else{
					_warning("WLanguageNotStored", "Language not stored");
				}
			}
		}
		
	}

?>
