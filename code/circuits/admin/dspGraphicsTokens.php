<?php
	
	$tmpoFuseaction = false;
	
	if(isset($attributes['key'])){
		if(!($tmpoFuseaction = $oFuseManager->getFuseaction($attributes['key']))){
			_error("EWrongFuseaction", "Wrong page key given");
		}
	}elseif(isset($attributes['id'])){
		if(is_numeric($attributes['id'])){
			if($attributes['id'] == 0){
				$tmpoFuseaction = &$ogFuseaction;
			}elseif(!($tmpoFuseaction = $oFuseManager->getFuseactionByID($attributes['id']))){
				_error("ECannotGetFuseaction", "No fuseaction found with this ID");
			}
		}else{
			_error("EInvalidFuseactionID", "Invalid Fuseaction ID");
		}
	}else{
		_error("ENoFuseactionGiven", "No page given");
	}
	
	if($tmpoFuseaction){
		
		$arrTokens = $oGraphicsManager->pullTokens($tmpoFuseaction->getID());
		$arrLanguages = $oLanguageManager->getLanguages();
		_assign("tmpoFuseaction", $tmpoFuseaction);
		_assign("arrTokens", $arrTokens);
		_assign("arrLanguages", $arrLanguages);
	}
	
	_display("admin/dspGraphicsTokens.tpl");

?>
