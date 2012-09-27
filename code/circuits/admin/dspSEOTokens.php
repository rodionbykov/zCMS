<?php
	
	$tmpoFuseaction = false;
	
	if(isset($attributes['key'])){
		if(!($tmpoFuseaction = $oFuseManager->getFuseaction($attributes['key']))){
			_error("ECannotGetFuseaction", "No fuseaction found");
		}
	}elseif(isset($attributes['id'])){
		if(is_numeric($attributes['id'])){
			if($attributes['id'] == 0){
				$tmpoFuseaction = &$ogFuseaction;
			}elseif(!($tmpoFuseaction = $oFuseManager->getFuseactionByID($attributes['id']))){
				_error("ECannotGetFuseaction", "No fuseaction found");
			}
		}else{
			_error("EInvalidFuseactionID", "Invalid Fuseaction ID");
		}
	}else{
		_error("ENoFuseactionGiven", "No page given");
	}
	
	if($tmpoFuseaction){
		$tmpoSEOContentManager = new ContentManager($oDB, $tmpoFuseaction, $tmpoLanguage, $fusebox['tableSEOContentTokens'], $fusebox['tableSEOContent'], false);
		
		$arrTokens = $tmpoSEOContentManager->getTokens();
		$arrLanguages = $oLanguageManager->getLanguages();
		$smarty->assign("tmpoFuseaction", $tmpoFuseaction);
		$smarty->assign("tmpoSEOContentManager", $tmpoSEOContentManager);
		$smarty->assign("arrTokens", $arrTokens);
		$smarty->assign("arrLanguages", $arrLanguages);
	}
	
	_display("admin/dspSEOContentTokens.tpl");
	
?>
