<?php
    
    $arrLanguages = $oLanguageManager->getLanguages();
    $arrImages = $ogGalleryManager->getImages($attributes['gallery']);
    
    $intLanguageID = $oLanguage->getID();
    
    _assign("intLanguageID", $intLanguageID);
    _assign("arrImages", $arrImages);
    _assign("arrLanguages", $arrLanguages);
    
    if(!empty($attributes['gallery'])){
        if($ogGalleryManager->checkGallery($attributes['gallery'])){
            _display("admin/dspGallery.tpl");	
        }else{
        	_error("EGalleryNotExists", "Gallery not exists");
        }    	        
    }else{
    	_error("EGalleryNotGiven", "Gallery not given");
    }

?>
