<?php
    if($oUser->isDefaultUser()){
    	if(!_gotErrors() && !_gotWarnings()){
    		_log("Sending registration confirmation to user");
    		$strSubject = $ogMailTemplatesManager->getTitle("UserRegistrationConfirmation");
    		$strBody = $ogMailTemplatesManager->getContentReplaced("UserRegistrationConfirmation", array("{NAME}" => $tmpUser->getFirstName(), "{LOGIN}" => $tmpUser->getLogin()));
    		$oPHPMailer = new PHPMailer();
            $oPHPMailer->IsHTML(true);
            $oPHPMailer->CharSet = $oLanguage->getEncoding();
    		$oPHPMailer->AddAddress($tmpUser->getEmail());
    		$oPHPMailer->Subject = $strSubject;
    		$oPHPMailer->Body = $strBody;
    		$oPHPMailer->Send();
    		unset($oPHPMailer);
    		_message("MRegisteredSuccessfully", "You've been successfully registered, thank you!");
    	}
    }
?>