<?php

	if(!empty($strNewUserPassword) && $tmpUser !== false){
		_log("Sending new password to user");
		$strSubject = $ogMailTemplatesManager->getTitle("UserNewPassword");
		$strBody = $ogMailTemplatesManager->getContentReplaced("UserNewPassword", array("{NAME}" => $tmpUser->getFirstName(), "{LOGIN}" => $tmpUser->getLogin(), "{PASSWORD}" => $strNewUserPassword));
		$oPHPMailer = new PHPMailer();
        $oPHPMailer->IsHTML(true);
        $oPHPMailer->CharSet = $oLanguage->getEncoding();
		$oPHPMailer->AddAddress($tmpUser->getEmail());
		$oPHPMailer->Subject = $strSubject;
		$oPHPMailer->Body = $strBody;
		$oPHPMailer->Send();
		unset($oPHPMailer);
		_message("MNewPasswordWasSent", "New password was sent to your email address");
	}else{
		_warning("WNoNewPasswordSet", "Password was not recovered or reset");
	}

?>