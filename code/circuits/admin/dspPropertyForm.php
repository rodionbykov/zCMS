<?php

	if(isset($attributes['code'])){
		if($arrProperty = $oPropertyManager->getProperty($attributes['code'])){
			_assign("arrProperty", $arrProperty);
		}else{
			_error("ENoPropertyFound", "No property found with this code");
		}
	}else{
		_error("ENoPropertyGiven", "No property given to edit");
	}
	
	_display("admin/dspPropertyForm.tpl");
	
?>