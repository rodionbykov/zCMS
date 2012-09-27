<?php

	$tmpoLanguage = false;
	
	if(isset($attributes['id']) && (intval($attributes['id']) > 0)){
		$tmpoLanguage = $oLanguageManager->getLanguageByID(intval($attributes['id']));
	}elseif(isset($attributes['key'])){
		$tmpoLanguage = $oLanguageManager->getLanguage($attributes['key']);
	}
	
	$smarty->assign("tmpoLanguage", $tmpoLanguage);
	_display("admin/dspLanguageForm.tpl");

?>
