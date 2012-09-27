<?php

	if(!empty($attributes['key'])){
		if($oSettingsManager->removeSetting($attributes['key'])){
			_message("MSettingDeleted", "Setting deleted succsessfully");
			_xfa($myself . "admin.showSettings");
		}else{
			_warning("WSettingNotDeleted", "Something happened when deleting a setting, probably setting with such key already deleted");
		}
	}else{
		_error("ENoSettingGiven", "No setting key is given");
	}



?>