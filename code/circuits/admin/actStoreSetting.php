<?php

	if(!empty($attributes['key']) && isset($attributes['fValue'])){
		if(isset($attributes['fDataType']) && isset($attributes['fDescription'])){
			$tmpSetting = array('value' => $attributes['fValue'], 'datatype' => $attributes['fDataType'], 'description' => $attributes['fDescription']);
			if($oSettingsManager->setSetting($attributes['key'], $tmpSetting)){
				_message("MSettingStored", "Setting stored");
			}else{
				_warning("WSettingNotStored", "Setting not stored, please check type and validity of data");
			}
		}elseif($oSettingsManager->setSettingValue($attributes['key'], $attributes['fValue'])){
			_message("MSettingValueStored", "Setting value stored");
		}else{
			_warning("WSettingValueNotStored", "Value not stored, please check type and validity of data");
		}
	}else{
		_error("ENoSettingGiven", "No setting or value is given");
	}
	
	_xfa($myself . "admin.showSettings");

?>