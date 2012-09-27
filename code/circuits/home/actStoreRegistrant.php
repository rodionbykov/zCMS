<?php
	
	if(isset($attributes['fLogin']) && isset($attributes['fPwd']) && isset($attributes['fPwd2']) && isset($attributes['fEmail'])){
	
		$tmpUser = $oUser;
		
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
		$tmpUser->setPhone($attributes['fPhone']);
		$tmpUser->setAddress($attributes['fAddress']);
		$tmpUser->setCity($attributes['fCity']);
		$tmpUser->setState($attributes['fState']);
		$tmpUser->setPostalCode($attributes['fPostalCode']);
		$tmpUser->setCountry($attributes['fCountry']);
		
		if(!$oUser->isDefaultUser()){
			_log("Changing details for " . $tmpUser->getFullName() . " (" . $tmpUser->getLogin() . ")");
			if($attributes['fPwd'] != $attributes['fPwd2']){
				_warning("WPasswordsNotMatch", "Passwords not match");
			}else{
				if(strlen($attributes['fPwd']) > 0){
					$tmpUser->setPassword($attributes['fPwd']);
				}
			}
			if(!_gotWarnings() && !_gotErrors()){
				if($oUserManager->setUserByID($oUser->getID(), $tmpUser)){
					$oUser = $tmpUser;
					_message("MUserSaved", "User successfully saved");
				}else{
					_warning("WNoUserWithThisIDExists", "There is no user with this ID");
				}
			}
		}else{
			_log("Adding new user " . $tmpUser->getFullName() . " (" . $tmpUser->getLogin() . ")");
			if($oUserManager->checkUser($attributes['fLogin'])){
				_warning("WUserExists", "Cannot add user: user with this login already exists");
			}else{
				if($attributes['fPwd'] != $attributes['fPwd2']){
					_warning("WPasswordsNotMatch", "Passwords not match");
				}else{
					if(!$tmpUser->setPassword($attributes['fPwd'])){
						_warning("WInvalidPassword", "Password cannot be empty");
					}
				}
                if(strlen($_SESSION['SecretUserString']) > 0){
                	if(!empty($attributes['fHString'])){
                		if($_SESSION['SecretUserString'] != $attributes['fHString']){
                			_warning("WCaptchaStringNotMatch", "Secret user string not match");
                		}
                	}else{
                		_warning("WCaptchaStringEmpty", "Secret user string is empty");
                	}
                }else{
                	_warning("WCaptchaStringUnknown", "Secret user string is unknown");
                }
				if(!_gotWarnings() && !_gotErrors()){
					$tmpUser->setRegisteredDate();
					if($newuserid = $oUserManager->addUser($tmpUser)){
                        $tmparrRegistrantGroups = explode(",", $fusebox['defaultRegistrantGroups']); 
                        $tmparrRegistrantGroups2 = array(); 
                        if(count($tmparrRegistrantGroups) > 0){
                            foreach($tmparrRegistrantGroups as $g){
                        	   $tmparrRegistrantGroups2[] = $oSecurityManager->getGroup($g);
                            }
                        }
						if($oSecurityManager->pushUserGroups($newuserid, $tmparrRegistrantGroups2)){
							_message("MUserAdded", "User successfully added");
						}else{
							_warning("WGroupNotSetForNewUser", "Cannot set default security group for new user " . $tmpUser->getLogin());
						}
					}else{
						_warning("WUserNotAdded", "User wasn't added");
					}
				}
			}
		}		
	}else{
		_error("EInvalidForm", "Invalid form submitted");
	}
	
	
	if(!_gotWarnings() && !_gotErrors()){
		_xfa("{$myself}home.showRegistrationConfirmation");
	}
	
	
?>