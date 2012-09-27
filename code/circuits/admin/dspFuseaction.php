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
			$smarty->assign("tmpFuseaction", $tmpFuseaction);
			_display("admin/dspFuseaction.tpl");
		}

	}	
	
?>