<?php

	if(isset($attributes['token']) && isset($attributes['fuseactionid'])){
		
		$arrLanguages = array();
		if(isset($attributes['languageid'])){
			$arrLanguages[] = $oLanguageManager->getLanguageByID($attributes['languageid']);
		}else{
			$arrLanguages = $oLanguageManager->getLanguages();
		}
		_assign("arrLanguages", $arrLanguages);
		if($attributes['fuseactionid'] == 0){
			$tmpoFuseaction = &$ogFuseaction;
			_assign("tmpoFuseaction", $tmpoFuseaction);
		}elseif(is_numeric($attributes['fuseactionid'])){
			if($tmpoFuseaction = $oFuseManager->getFuseactionByID($attributes['fuseactionid'])){
				_assign("tmpoFuseaction", $tmpoFuseaction);
			}else{
				_error("ECannotGetFuseaction", "Cannot get page or action");
			}
		}else{
			_error("EInvalidFuseaction", "Invalid page/action ID given");
		}
		_display("admin/dspSEOContentForm.tpl");
	}else{
		_error("ENoContentGiven", "No valid content item given to edit");
	}

?>
