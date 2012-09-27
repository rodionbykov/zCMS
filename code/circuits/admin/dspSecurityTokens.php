<?php

	$arrTokens = array();
	$arrGroups = array();
	$tmpoFuseaction = false;
	if(isset($attributes['id'])){
		if(is_numeric($attributes['id'])){
			if($attributes['id'] == 0){
				$tmpoFuseaction = &$ogFuseaction;
			}elseif(!($tmpoFuseaction = $oFuseManager->getFuseactionByID($attributes['id']))){
				_error("ECannotGetFuseaction", "No fuseaction found");
			}
			_assign("tmpoFuseaction", $tmpoFuseaction);
			if($arrGroups = $oSecurityManager->getGroups()){
				$arrTokens = $oSecurityManager->pullTokens($tmpoFuseaction->getID());
				_assign("arrTokens", $arrTokens);
				_assign("arrGroups", $arrGroups);
			}else{
				_error("ECannotGetGroups", "Cannot get security groups");
			}
		}else{
			_error("EInvalidFuseactionID", "Invalid Fuseaction ID");
		}
	}else{
		_error("EFuseactionNotGiven", "Fuseaction not given");
	}
	
	_display("admin/dspSecurityTokens.tpl");

?>
