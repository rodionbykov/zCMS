<?php

	$result = true;
	foreach($attributes as $k=>$a){
		if (strpos($k, "sq_") !== false){
			$arrID = explode("_", $k);
			if(!$oSecurityManager->pushGroupAccessByID($arrID[1], $a)){
				$result = false;
			}
		}
	}
	
	if(!$result){
		_warning("WExceptionSavingSecurity", "Something happened while permissions update performed");
	}else{
		_message("MSecurityUpdated", "Permissions updated");
	}
	
	_xfa($myself . "admin.showFuseactions");

?>
