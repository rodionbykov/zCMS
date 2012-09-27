<?php

	if(!empty($attributes['key'])){
		
		if($arrSetting = $oSettingsManager->getSetting($attributes['key'])){
			_assign("arrSetting", $arrSetting);
			_display("admin/dspSettingForm.tpl");
		}else{
			_error("ENoSettingRetrieved", "No setting retrieved from DB");
		}
	}else{
		_error("ENoSettingGiven", "No setting given to edit");
	}


?>
