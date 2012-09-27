<?php
 
	if(!isset($attributes['name']) || strlen($attributes['name']) == 0){
		_warning("WEmptyName", $oContentManager->getTitle("WEmptyName", "Please enter your name"));
	}else{
		if(!isset($attributes['email']) || strlen($attributes['email']) == 0){
			_warning("WEmptyEmail", $oContentManager->getTitle("WEmptyEmail", "Please enter your email"));
		}else{
			if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $attributes['email']) == 0){
				_warning("WInvalidEmail", $oContentManager->getTitle("WInvalidEmail", "Please enter valid email"));
			}else{
			 	if($_SESSION['SecretUserString'] != $attributes['captcha']){
					_warning("WInvalidCaptcha", $oContentManager->getTitle("WInvalidCaptcha", "Security string is not correct"));
			 	}else{
					$replaceFrom = array("{TEXT}");
					$replaceTo = array($attributes['text']);
					$subject = str_replace($replaceFrom, $replaceTo, $ogMailTemplatesManager->getTitle("ContactUs", "Message from site visitor"));
					$body = str_replace($replaceFrom, $replaceTo, $ogMailTemplatesManager->getContent("ContactUs", "{TEXT}"));
	
					$oPHPMailer = new PHPMailer();
					$oPHPMailer->IsHTML(true);
					$oPHPMailer->From = stripslashes($attributes['email']);
					$oPHPMailer->FromName = stripslashes($attributes['name']);
			
					$oPHPMailer->CharSet = $oLanguage->getEncoding();
					$oPHPMailer->AddAddress($oSettingsManager->getValue("ContactUsEmail", 'postmaster@' . $_SERVER['HTTP_HOST'] , "STRING", "Contact Us email address"));
					$oPHPMailer->Subject = stripslashes($subject);
					$oPHPMailer->Body = stripslashes($body);
					$oPHPMailer->Send();
	
					unset($oPHPMailer);
					
					_message("MContactUsMessageSent", "Message sent");
					
			 	}
		 	}
		}
	}
	
	if(!_gotWarnings() && !_gotErrors()){
		_xfa("{$myself}home.showContactForm");
	}
 
?>
