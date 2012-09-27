<?php

	if(isset($attributes['fuseactionid']) && is_numeric($attributes['fuseactionid'])){
		if(!empty($attributes['token'])){
			$arrLanguages = $oLanguageManager->getLanguages();
			foreach($arrLanguages as $tmpLanguage){
				$tmpFileName = $oGraphicsManager->pullTitle($attributes['fuseactionid'], $tmpLanguage->getID(), $attributes['token']);
				$tmpFilePath = $fusebox['pathGraphics'].$tmpFileName;

				if($tmpFileName != '' && !strpos($tmpFileName, '/') && file_exists($tmpFilePath) && !is_dir($tmpFilePath)){
					@unlink($tmpFilePath);
				}
			}

			if(!$oGraphicsManager->deleteToken($attributes['fuseactionid'], $attributes['token'])){
				_error("ENoTokenFound", "Record not found, perhaps already deleted");
			}
			else{
				_message("MGraphicsTokenDeleted", "Graphics record(s) deleted succsessfully");

				_xfa($myself . "admin.showFuseactionContentTokens&id=" . $attributes['fuseactionid']);
			}
		}else{
			_error("ENoTokenGiven", "No token is given");
		}
	}else{
		_error("ENoFuseactionGiven", "No page is given");
	}

	?>