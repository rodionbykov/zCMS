<?php

	if(!empty($attributes['id'])){
		if(is_numeric($attributes['id'])){
			if(!($tmpUser = $oUserManager->getUserByID($attributes['id']))){
				_error("ENoSuchUser", "There is no user with ID = " . $attributes['id']);
			}
		}else{
			_error("EInvalidUserID", "Invalid user ID");
		}
	}else{
		$attributes['id'] = 0;
		$tmpUser = new User();
	}
	
	if(isset($attributes['id']) && isset($attributes['fLogin']) && isset($attributes['fPwd']) && isset($attributes['fPwd2']) && isset($attributes['fEmail'])){
		$tmpUser->setID($attributes['id']);
		if(!$tmpUser->setLogin($attributes['fLogin'])){
			_warning("WInvalidLogin", "Login is invalid or empty");
		}
		if(!$tmpUser->setEmail($attributes['fEmail'])){
			_warning("WInvalidEmail", "Email address is invalid or empty");
		}
		$tmpUser->setFirstName($attributes['fFirstName']);
		$tmpUser->setMiddleName($attributes['fMiddleName']);
		$tmpUser->setLastName($attributes['fLastName']);
		$tmpUser->setBirthDate($attributes['fBirthDate']);
	}
	_assign("arrCountries", $oPropertyManager->getDictionary("fCountry"));
	_assign("tmpUser", $tmpUser);
	_display("admin/dspUserForm.tpl");

?>