<?php

	if(isset($attributes['fuseactionid']) && is_numeric($attributes['fuseactionid'])){
		if(!empty($attributes['token'])){
			if(!$oContentManager->deleteToken($attributes['fuseactionid'], $attributes['token'])){
				_error("ENoTokenFound", "Record not found, perhaps already deleted");
			}
			else{
				_message("MTokenDeleted", "Content record(s) deleted succsessfully");

				_xfa($myself . "admin.showFuseactionContentTokens&id=" . $attributes['fuseactionid']);
			}
		}else{
			_error("ENoTokenGiven", "No token is given");
		}
	}else{
		_error("ENoFuseactionGiven", "No page is given");
	}

	?>