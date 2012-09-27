<?php

	if (empty($attributes['id'])){
		_error("ENoFuseactionGiven", "No page or action is given");
	}else{

		$tmpFuseaction = false;
		if(isset($attributes['id']) && (intval($attributes['id']) > 0)){
			$tmpFuseaction = $oFuseManager->getFuseactionByID(intval($attributes['id']));
		}else{
			_error("ENoValidFuseactionGiven", "No valid page or action is given");
		}

		if(!$tmpFuseaction){
			_error("ENoFuseactionFound", "No such page or action found in DB");
		}else{

			if(!$oContentManager->deleteFuseactionTokens($tmpFuseaction->getID())){
				_warning("WFuseactionNotCleared", "Cannot clear page content. DB error.");
			}
			else{
				_message("MFuseactionCleared", "Page content was removed successfully");

				_xfa($myself . "admin.showContentPages");
			}
		}
	}

	if(!_gotxfa()){

	}

?>
