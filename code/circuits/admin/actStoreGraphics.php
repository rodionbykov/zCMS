<?php

	if(isset($attributes['fuseactionid']) && is_numeric($attributes['fuseactionid'])){
		if(!empty($attributes['token'])){
			
			$arrLanguages = $oLanguageManager->getLanguages();
			foreach($arrLanguages as $l){
				$tmpFormFieldName = 'alt_' . $l->getID();
				if(isset($attributes[$tmpFormFieldName])){
					if(!$oGraphicsManager->pushContent($attributes['fuseactionid'], $l->getID(), $attributes['token'], $attributes[$tmpFormFieldName])){
						_warning("WContentNotStored", "Something happened while storing alternate text");
					}
				}
				
				// start upload
				
				$tmpFormFieldName = 'graphics_' . $l->getID();

				$imageFileName = "";
			
				if (isset($_FILES[$tmpFormFieldName]) && ($_FILES[$tmpFormFieldName]['name'] != "")) {
					
					$imageFileName =  strtolower($_FILES[$tmpFormFieldName]['name']);
					
					if(preg_match("/(gif|jp((e|eg)|(g))|png|tif(f)?|bmp)$/i", $imageFileName)){
						
						$imageFileName = preg_replace("/[^a-zA-Z0-9\_\.]/", "_", $imageFileName);
						
						while(file_exists($fusebox['pathGraphics'] . $imageFileName)){
							$imageFileName = (string) rand(0, 9) . $imageFileName;
						}
						
						if(!move_uploaded_file($_FILES[$tmpFormFieldName]['tmp_name'], $fusebox['pathGraphics'] . $imageFileName)){
							_error("ECannotUploadContentFile", "Cannot upload content file " . $imageFileName);
						}else{
							chmod($fusebox['pathGraphics'] . $imageFileName, 0666);
							
							if($oldFileName = $oGraphicsManager->pullTitle($attributes['fuseactionid'], $l->getID(), $attributes['token'])){
								if($imageFileName != $oldFileName){
									if(file_exists($fusebox['pathGraphics'] . $oldFileName)){
										unlink($fusebox['pathGraphics'] . $oldFileName);
									}
								}
							}
							if(!$oGraphicsManager->pushTitle($attributes['fuseactionid'], $l->getID(), $attributes['token'], $imageFileName)){
								_warning("WTitleNotStored", "Something happened while storing graphics");
							}
						}
					}else{
						_error("EInvalidFileFormat", "Invalid file format - upload allowed only for images");
					}
			
				}
				
				// end upload
			}
			
			$tmpFormFieldName = 'description';
			if(isset($attributes[$tmpFormFieldName])){
				if(!$oGraphicsManager->pushDescription($attributes['fuseactionid'], $attributes['token'], $attributes[$tmpFormFieldName])){
					_warning("WDescriptionNotStored", "Something happened while storing description");
				}
			}
			
		}else{
			_error("ENoTokenGiven", "No token is given");
		}
	}else{
		_error("ENoFuseactionGiven", "No page is given");
	}

	_xfa($myself . "admin.showFuseactionGraphicsTokens&id=" . $attributes['fuseactionid']);
	
?>