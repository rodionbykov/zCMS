<?php
	
	$tmpUser = false;
	if(!empty($attributes['fLogin'])){
		if($tmpUser = $oUserManager->getUser($attributes['fLogin'])){
			_log("Changing password for user " . $tmpUser->getLogin());
			$strNewUserPassword = $oUserManager->resetPassword($tmpUser->getLogin());
		}else{
			_warning("WNoSuchUser", "No user with such login exists");
		}
	}else{
		_error("EWrongFormSubmitted", "Wrong form submitted");
	}
	
	_xfa($myself . "home.showPasswordRecoverConfirmation");
	
?>