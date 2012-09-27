<?php

	$result = false;

	if(isset($attributes['fuseactionid']) && is_numeric($attributes['fuseactionid'])){
		$result = true;
		foreach($attributes as $k=>$a){
			if (strpos($k, "sq_") !== false){
				$arrID = explode("_", $k);
				if(!$oSecurityManager->pushGroupAccessByID($arrID[1], $a)){
					$result = false;
				}
			}
		}
	}else{
		_error("ENoFuseactionGiven", "No fuseaction given");
	}
	
	if(!$result){
		_warning("WExceptionSavingSecurity", "Something happened while permissions update performed");
	}else{
		_message("MSecurityUpdated", "Permissions updated");
	}
	
	_xfa($myself . "admin.showFuseactionSecurityTokens&id=" . $attributes['fuseactionid']);

?>
