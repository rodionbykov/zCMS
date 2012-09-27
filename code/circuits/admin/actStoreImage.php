<?php

if (empty($attributes['gallery'])) {
	_error("ENoGalleryGiven", "No gallery is given");
} elseif (!$ogGalleryManager->checkGallery($attributes['gallery'])) {
	_error("EGalleryNotExists", "Gallery not exists");
}

if (empty($attributes['newimage'])) {
	_warning("WImageTokenIsEmpty", "Image token is emply");
}

if (empty($attributes['image']) && empty($_FILES['imagefile'])) {
	_warning("WNoImageGiven", "No image is given");
}

if (!empty($attributes['image'])) {
	$oldImageName = $ogGalleryManager->getImageFileName($attributes['gallery'], 
		$attributes['image']);
}

if (!_gotErrors() && !_gotWarnings()) {
	/*
	 * upload image
	 */
	if (isset($_FILES['imagefile']) && ($_FILES['imagefile']['name'] != "")) {
		$imageFileName = preg_replace("/[^a-zA-Z0-9\_\.]/", "_", 
	        strtolower($_FILES['imagefile']['name']));
        $galleryPath = $fusebox['pathGalleries'].$attributes['gallery']."/";
        $thumbsPath = $galleryPath.$fusebox['folderThumbs']."/";
		if ($oImage = $oImageManager->uploadFile('imagefile', 
	             $galleryPath, $imageFileName)) {
	
	        if ($oThumbImage = $oImageManager->copyFile($oImage, $thumbsPath)) {
	        	if (!$oImageManager->resizeImage($oThumbImage, 
						$oSettingsManager->getValue("MaxThumbWidth"), 
						$oSettingsManager->getValue("MaxThumbHeight"))) {
	          		_warning("WCannotResizeThumbImage", 
	          			"Cannot resize thumb image");
				}
           	} else {
           		_warning("WCannotCreateThumbImage", 
           		"Cannot create thumb image");
           	}
	        
           	if (!$oImageManager->resizeImage($oImage, 
	           		$oSettingsManager->getValue("MaxImageWidth"), 
	           		$oSettingsManager->getValue("MaxImageHeight"))) {
          		_warning("WCannotResizeImage", "Cannot resize image");
           	}
           	
        } else {
          	_warning("WCannotUploadContentFile", "Cannot upload content file ");
	    }        
	}
}

if (!_gotErrors() && !_gotWarnings()) {
	
	if (empty($attributes['image'])) {
		/*
		 * add new image
		 */
        if ($ogGalleryManager->addImage($attributes['gallery'], 
        		$attributes['newimage'], $oImage->getFileName())) {
        	$ogGalleryManager->setGalleryUpdatedDate($attributes['gallery']);            	
            _message("MGalleryImageAdded", "Gallery image added");
            $attributes['image'] = $attributes['newimage'];
        } else {
            _error("EImageExists", "Image already exists or I cannot add it...");
        }
	} else {
		/*
		 * update existed image
		 */
		if (!empty($oImage)) {
            if (!$ogGalleryManager->setImageFileName($attributes['gallery'],
            		$attributes['image'],$oImage->getFileName())) {
	            _warning("WGalleryImageNotStored", 
	                "Something happened while storing graphics");
	        } 
		}
		        
        if (!empty($attributes['newimage'])) {
            $attributes['newimage'] = preg_replace("/[^a-zA-Z0-9\_\.]/", "_", 
            	$attributes['newimage']);
            if ($ogGalleryManager->setImageToken($attributes['gallery'], 
            		$attributes['image'], $attributes['newimage'])) {	            	
            	$attributes['image'] = $attributes['newimage'];	            	             
            } else {
            	_warning("WImageTokenNotStored", "
					Something happened while storing image token");            
            }
        } else {
            _warning("WImageTokenCannotBeEmpty", "Image token cannot be empty");
        }		
		
	}
	
}

if (!_gotErrors() && !_gotWarnings()) {
	/*
	 * update description and title
	 */
    $arrLanguages = $oLanguageManager->getLanguages();
    foreach($arrLanguages as $l){
          	
        // setting image title
          	            
        $tmpFormFieldName = 'title_' . $l->getID();
        if (isset($attributes[$tmpFormFieldName])) {
            $strTitle = html_entity_decode($attributes[$tmpFormFieldName], 
            	ENT_COMPAT, $l->getEncoding());
            if (!$ogGalleryManager->setImageTitle($attributes['gallery'], 
            		$attributes['image'], $strTitle, $l->getID())) {
                _warning("WAltNotStored", 
                	"Something happened while storing image title");
            }
        }                
              
        // setting image description
              
        $tmpFormFieldName = 'desc_' . $l->getID();
        if (isset($attributes[$tmpFormFieldName])) {       
            $strDescription = html_entity_decode($attributes[$tmpFormFieldName], 
            	ENT_COMPAT, $l->getEncoding());                       
            if (!$ogGalleryManager->setImageContent($attributes['gallery'], 
            		$attributes['image'], $strDescription, $l->getID())) {
                _warning("WDescriptionNotStored", 
                	"Something happened while storing description");
            }
        }
    }
    $ogGalleryManager->setImageUpdatedDate($attributes['gallery'], 
    	$attributes['image']);  
    $ogGalleryManager->setImageEditorID($attributes['gallery'], 
    	$attributes['image'], $l->getID(), $oUser->getID());               
}
/*
 * delete old image was updated and delete new image 
 * if we have errors or warnings 
 */
if (isset($_FILES['imagefile'])) {
	if (!_gotErrors() && !_gotWarnings()) {
		if (isset($oldImageName)) {
			@unlink($galleryPath.$oldImageName);
			@unlink($thumbsPath.$oldImageName);
		}
	} else {
		if (!empty($oImage)) {
			$oImageManager->deleteFile($oImage);	
		}
		if (!empty($oThumbImage)) {
			$oImageManager->deleteFile($oThumbImage);
		}
	}
}
if (!_gotErrors() && !_gotWarnings()) {
	_message("MGalleryImageStored", "Gallery image stored");
}
    
?>