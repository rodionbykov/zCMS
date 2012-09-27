<?php


	if(!isset($attributes['password1']) || !strlen($attributes['password1'])) {
		_warning("WEmptyPassword", $oContentManager->getTitle("WEmptyPassword", "Enter new password, please"));
	}

	if(!isset($attributes['password2']) || !strlen($attributes['password2'])) {
		_warning("WEmptyConfirmation", $oContentManager->getTitle("WEmptyConfirmation", "Enter password confirmation, please"));
	}

	if(!_gotWarnings()) {
		if($attributes['password1'] != $attributes['password2']) {
			_warning("WPasswordsNotMatch", $oContentManager->getTitle("WPasswordsNotMatch", "Password do not match confirmation"));
		}
	}

	if(!isset($attributes['login']) || !strlen($attributes['login'])) {
		_warning("WInvalidLogin", $oContentManager->getTitle("WInvalidLogin", "Invalid Login, please use link from e-mail"));
	}

	if(!isset($attributes['signature']) || !strlen($attributes['signature'])) {
		_warning("WInvalidSignature", $oContentManager->getTitle("WInvalidSignature", "Invalid Signature, please use link from e-mail"));
	}


	if(!_gotWarnings() && !_gotErrors()) {
		$sql = "SELECT * FROM ".$fusebox['tableUsers']." WHERE login = '".addslashes($attributes['login'])."'";
		$arrTmpUser = $oDB->getRecord($oDB->query($sql));
		if(empty($arrTmpUser)) {
			_warning("WInvalidLogin", $oContentManager->getTitle("WInvalidLogin", "User with specified Login not found, probably User was deleted"));
		}
		else {
			if($arrTmpUser['recoversignature'] == $attributes['signature']) {
				_log("Changing password for user " . $arrTmpUser['login']);
				$sql = "UPDATE ".$fusebox['tableUsers']." SET pwd = MD5('".addslashes($attributes['password1'])."'), recoversignature='' WHERE login = '".addslashes($attributes['login'])."'";
				$oDB->query($sql);
				_message("MPasswordChanged", $oContentManager->getTitle("MPasswordChanged", "Password changed succsessfully"));
			}
			else {
				_warning("WInvalidSignature", $oContentManager->getTitle("WInvalidSignature", "Invalid recovery signature, please use recover link from latest e-mail"));
			}
		}
	}

?>