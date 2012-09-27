<?php

    $galleryPath = $fusebox['pathGalleries'] . $attributes['gallery'] . "/";
    $thumbsPath = $galleryPath . $fusebox['folderThumbs'] . "/";
                    
    if(!empty($attributes['gallery']) && !empty($attributes['image'])){
        if($strImageFileName = $ogGalleryManager->getImageFileName($attributes['gallery'], $attributes['image'])){
            if($ogGalleryManager->deleteImage($attributes['gallery'], $attributes['image'])){            	            	                
                
                if(file_exists($galleryPath . $strImageFileName)){
                    if(!unlink($galleryPath . $strImageFileName)){
                        _message("MGalleryImageFileRemained", "Gallery image file remained on disk");    	
                    }
                }
                if(file_exists($thumbsPath . $strImageFileName)){
                    if(!unlink($thumbsPath . $strImageFileName)){
                    	_message("MGalleryThumbFileRemained", "Gallery image thumbnail file remained on disk");
                    }
                }
                
                $ogGalleryManager->setGalleryUpdatedDate($attributes['gallery']);       
                                                   
				_message("MGalleryImageDeleted", "Gallery image deleted");
				                                                   
            }else{
                _warning("WGalleryImageNotDeleted", "Gallery image not deleted");
            }             
        }else{
        	_warning("WGalleryImageNotFound", "Gallery image not found");
        }
    }else{
    	_error("EGalleryImageNotGiven", "Gallery image not given to delete");
    }    
    
    

?>
