<?php

	if(!$oUser->isDefaultUser()){
		$tmpUser = $oUser;
	}else{
		$tmpUser = new User();
	
		if(isset($attributes['fLogin']) && isset($attributes['fPwd']) && isset($attributes['fPwd2']) && isset($attributes['fEmail'])){
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
	}
    
    $oCaptcha = new Captcha($fusebox['pathAssets'] . "fonts");
    
    if(!$oCaptcha->initialize()){
    	_warning("WCaptchaNotInitialized", "Captcha not initialized");
    }
    
	_assign("arrCountries", $oPropertyManager->getDictionary("fCountry"));
	_assign("tmpUser", $tmpUser);
	_display("home/dspRegistrationForm.tpl");

?>