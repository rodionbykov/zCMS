<?php
	
	if($arrMailTemplates = $ogMailTemplatesManager->getTokens()){
		_assign("arrMailTemplates", $arrMailTemplates);
	}

	$arrLanguages = $oLanguageManager->getLanguages();
	_assign("arrLanguages", $arrLanguages);
	_display("admin/dspMailTemplates.tpl");

?>