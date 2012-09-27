<?php

	if(!isset($attributes['login']) || strlen($attributes['login']) == 0){
		_warning("WEmptyLogin", $oContentManager->getTitle("WEmptyLogin", "Please enter your Login"));
	}
	else if(!$UserID = $oUserManager->checkUser($attributes['login'])){
		_warning("WUserNotFound", $oContentManager->getTitle("WUserNotFound", "User with specified Login is not exists"));
	}
	else {
		//set recover signature and send reset link to user
		_log("Sending reset password link to user");


		//for php versions < 4.2
		list($usec, $sec) = explode(' ', microtime());
		srand((float) $sec + ((float) $usec * 100000));

		$recoverSignature = md5(rand(1111111, 9999999));

		$recUser = $oUserManager->getUser($attributes['login']);

		$sql = "UPDATE " . $fusebox['tableUsers'] . " SET recoversignature = '".addslashes($recoverSignature)."' WHERE id = ".intval($recUser->getID());
		$oDB->query($sql);


		$strSubject = $ogMailTemplatesManager->getTitle("ResetPassword");
		$strBody = $ogMailTemplatesManager->getContentReplaced("ResetPassword", array("{LINK}" => $fusebox['urlBase'].$myself."home.showResetPasswordForm&signature=".$recoverSignature."&login=".urlencode($recUser->getLogin()), "{LOGIN}" => $recUser->getLogin()));
		$oPHPMailer = new PHPMailer();
		$oPHPMailer->IsHTML(true);
		$oPHPMailer->From = $oSettingsManager->getValue("MailerEmail", 'root@localhost', "STRING", "Mailer E-mail");
		$oPHPMailer->FromName = $oSettingsManager->getValue("MailerName", 'Mail Robot', "STRING", "Mailer Name");

		$oPHPMailer->CharSet = $oLanguage->getEncoding();
		$oPHPMailer->AddAddress($recUser->getEmail());
		$oPHPMailer->Subject = $strSubject;
		$oPHPMailer->Body = $strBody;
		$oPHPMailer->Send();
		unset($oPHPMailer);
		_message("MResetLinkSent", $oContentManager->getTitle("MResetLinkSent", "Reset password link was sent to your email address"));
	}

?>