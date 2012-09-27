<?php

	if(isset($attributes['token'])){
		
		$arrLanguages = array();
		if(isset($attributes['languageid'])){
			$arrLanguages[] = $oLanguageManager->getLanguageByID($attributes['languageid']);
		}else{
			$arrLanguages = $oLanguageManager->getLanguages();
		}
		_assign("arrLanguages", $arrLanguages);
	}else{
		_error("ENoMailTemplateGiven", "No valid mail template given to edit");
	}

	_display("admin/dspMailTemplateForm.tpl");
	
?>