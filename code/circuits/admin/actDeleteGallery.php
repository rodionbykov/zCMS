<?php

    $galleryPath = $fusebox['pathGalleries'] . $attributes['gallery'] . "/";
    $thumbsPath = $galleryPath . $fusebox['folderThumbs'] . "/";
    
    if(!empty($attributes['gallery'])){
        
        if($ogGalleryManager->checkGallery($attributes['gallery'])){
        
            $arrGalleryImages = $ogGalleryManager->getImages($attributes['gallery']);
        
            foreach($arrGalleryImages as $gi){
            	if($strImageFileName = $ogGalleryManager->getImageFileName($attributes['gallery'], $gi['token'])){
                    if(file_exists($galleryPath . $strImageFileName)){
                        @unlink($galleryPath . $strImageFileName);
                    }
                    if(file_exists($thumbsPath . $strImageFileName)){
                        @unlink($thumbsPath . $strImageFileName);
                    }                                         
                }
            }
            
            if(file_exists($thumbsPath)){
                @rmdir($thumbsPath);
            }                       
            if(file_exists($galleryPath)){
                @rmdir($galleryPath);
            }   
            
        	if($ogGalleryManager->deleteGallery($attributes['gallery'])){
        		_message("MGalleryRemoved", "Gallery deleted");
        	}else{
        		_warning("WCannotRemoveGallery", "Cannot remove gallery");
        	}
            
        }else{
        	_error("EGalleryNotExists", "Gallery not exists");
        }      
        
    }else{
    	_error("ENoGalleryGiven", "No gallery given");
    }

?>
