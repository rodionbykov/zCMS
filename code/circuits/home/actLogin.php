<?php
	
	if($oUser->isDefaultUser()){
		if(!empty($attributes['fLogin']) && !empty($attributes['fPwd'])){
			$log = "User " . $oUser->getFullName() . " (" . $oUser->getLogin() . ", " . $oUser->getID() . ") tries to log in as '" . $attributes['fLogin'];
			if($oUserManager->checkUser($attributes['fLogin'])){
				if($userlogged = $oUserManager->loginUser($attributes['fLogin'], $attributes['fPwd'])){
					$arrUserGroups = $oSecurityManager->pullUserGroups($userlogged->getID());
					
					$userXFA = $fusebox['defaultFuseaction'];
				
					if($arrUserGroups){
						$userlogged->setGroups($arrUserGroups);
						if(!_gotxfa()){
							//find valid user's home page
							foreach($arrUserGroups as $tmpGroup){
								if($tmpGroup->getHomePage() && $oFuseManager->getFuseaction($tmpGroup->getHomePage())){
									$userXFA = $tmpGroup->getHomePage();
								}
							}
						}						
					}
					
					_xfa($myself . $userXFA);
					
					$oUser = $userlogged;
					$log .= "'... success!";
				}else{
					_warning("WIncorrectPassword", "Password provided for login {$attributes['fLogin']} is incorrect");
					$log .= "'... failed.";
				}
				_log($log);
			}else{
				_warning("WNoSuchUser", "There is no user {$attributes['fLogin']} registered with system");
			}
		}else{
			_warning("WEmptyLoginCredentials", "Cannot log in with empty login or password");
		}
		if(!_gotErrors() && !_gotWarnings()){
			_log("After successful login user became " . $oUser->getFullName() . " (" . $oUser->getLogin() . ", " . $oUser->getID() . ")");
		}
	}
	   
?>