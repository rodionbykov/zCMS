<?php

	if (empty($attributes['id']) && empty($attributes['key'])){
		_error("ENoFuseactionGiven", "No page or action is given");
	}else{
				
		$tmpFuseaction = false;
		if(isset($attributes['id']) && (intval($attributes['id']) > 0)){
			$tmpFuseaction = $oFuseManager->getFuseactionByID(intval($attributes['id']));
		}elseif(isset($attributes['key'])){
			$tmpFuseaction = $oFuseManager->getFuseaction($attributes['key']);
		}else{
			_error("ENoValidFuseactionGiven", "No valid page or action is given");
		}
		
		if(!$tmpFuseaction){
			_error("ENoFuseactionFound", "No such page or action found in DB");
		}else{
			$tmpFuseaction->setResponsibility($attributes['fResponsibility']);
			if($oFuseManager->setFuseaction($tmpFuseaction->getName(), $tmpFuseaction)){
				_message("MFuseactionStored", "Page/action responsibilities stored successfully");
			}else{
				_warning("WFuseactionNotStored", "Page/action responsibilities not saved");
			}
		}

	}	
	
	if(!_gotxfa()){
		_xfa($myself . "admin.showFuseaction&id={$attributes['id']}");
	}

?>
