<?php

	$log = "User " . $oUser->getFullName() . " (" . $oUser->getLogin() . ", " . $oUser->getID() . ") logging off... ";
	
	if(!$oUserManager->checkUser($fusebox['defaultUser'])){
	
		$tmpoUser = new User (0, $fusebox['defaultUser']);
		$tmpoUser->setRegisteredDate();
		if($oUserManager->addUser($tmpoUser)){
			if(!($tmpoUser = $oUserManager->getUser($fusebox['defaultUser']))){
				_throw("FStillNoDefaultUser", "No default user found... again! DB corrupted ?");
			}
		}else{
			_throw("FCannotAddDefaultUser", "Cannot add default user");
		}
	}
	 
		
	if($userlogged = $oUserManager->logoutUser()){
		$oUser = $userlogged;
		
		// setting unique name for visitor to track activity
		$oUser->setFirstName(strtoupper($oUser->getLogin()));
		$oUser->setMiddleName(chr(rand(65, 90)));
		$oUser->setLastName(rand(0, 9999999));	
		$oUser->setUserAgent($_SERVER['HTTP_USER_AGENT']);
		$oUser->setCurrentVisitIP($_SERVER['REMOTE_ADDR']);
		$oUser->setCurrentVisitMoment(date('Y-m-d H:i:s'));
		
		$log .= "success!";
		
	}else{
		_error("ENoDefaultUser", "No default user found");
		$log .= "failed.";
	}
	
	_xfa($myself . $fusebox['defaultFuseaction']);
	
	_log($log);
	_log("After logoff user became " . $oUser->getFullName() . " (" . $oUser->getLogin() . ", " . $oUser->getID() . ")");
	
	
?>
