<?php

	if (empty($attributes['id'])){
		_error("ENoFuseactionGiven", "No page or action is given");
	}else{

		$tmpFuseaction = false;
		if(isset($attributes['id']) && (intval($attributes['id']) > 0)){
			$tmpFuseaction = $oFuseManager->getFuseactionByID(intval($attributes['id']));
		}else{
			_error("ENoValidFuseactionGiven", "No valid page or action is given");
		}

		if(!$tmpFuseaction){
			_error("ENoFuseactionFound", "No such page or action found in DB");
		}else{
			$arrLanguages = $oLanguageManager->getLanguages();
			$arrTokens = $oGraphicsManager->pullTokens($tmpFuseaction->getID());

			foreach($arrTokens as $tmpToken){
				foreach($arrLanguages as $tmpLanguage){
					$tmpFileName = $oGraphicsManager->pullTitle($tmpFuseaction->getID(), $tmpLanguage->getID(), $tmpToken['token']);
					$tmpFilePath = $fusebox['pathGraphics'].$tmpFileName;

					if($tmpFileName != '' && !strpos($tmpFileName, '/') && file_exists($tmpFilePath) && !is_dir($tmpFilePath)){
						@unlink($tmpFilePath);
					}
				}
			}

			if(!$oGraphicsManager->deleteFuseactionTokens($tmpFuseaction->getID())){
				_warning("WFuseactionGraphicsNotCleared", "Cannot clear page graphics. DB error.");
			}
			else{
				_message("MFuseactionGraphicsCleared", "Page graphics was removed successfully");

				_xfa($myself . "admin.showGraphicsPages");
			}
		}
	}

?>
