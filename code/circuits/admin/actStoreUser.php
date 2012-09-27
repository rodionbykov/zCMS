<?php
	
	if(isset($attributes['id']) && isset($attributes['fLogin']) && isset($attributes['fPwd']) && isset($attributes['fPwd2'])){
		
		if(empty($attributes['id'])){
			$tmpUser = new User();
		}else{
			$tmpUser = $oUserManager->getUserByID($attributes['id']);
		}
		
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
		
		if(!empty($attributes['id'])){
			_log("Changing details for " . $tmpUser->getFullName() . " (" . $tmpUser->getLogin() . ")");
			if($attributes['fPwd'] != $attributes['fPwd2']){
				_warning("WPasswordsNotMatch", "Passwords not match");
			}else{
				if(strlen($attributes['fPwd']) > 0){
					$tmpUser->setPassword($attributes['fPwd']);
				}
			}
			if(!_gotWarnings() && !_gotErrors()){
				if($oUserManager->setUserByID($attributes['id'], $tmpUser)){
					_message("MUserSaved", "User saved successfully");
				}else{
					_warning("WNoSuchUserExists", "No user with given ID exists");
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
                
				if(!_gotWarnings() && !_gotErrors()){
					$tmpUser->setRegisteredDate();
					if($newuserid = $oUserManager->addUser($tmpUser)){
						if($oSecurityManager->pushUserGroups($newuserid, array($oSecurityManager->getGroup($fusebox['defaultGroup'])))){
							_message("MUserAdded", "User added successfully");
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
		_xfa("{$myself}admin.showUsers");
	}
?>