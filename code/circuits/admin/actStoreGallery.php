<?php

    if(!empty($attributes['gallery'])){
                    
        $arrLanguages = $oLanguageManager->getLanguages();
        foreach($arrLanguages as $l){
            $tmpFormFieldName = 'content_' . $l->getID();
            if(isset($attributes[$tmpFormFieldName])){
                $strContent = html_entity_decode($attributes[$tmpFormFieldName], ENT_COMPAT, $l->getEncoding());
                if($strContent !== false){
                    if(!$ogGalleryManager->setGalleryContent($attributes['gallery'], $strContent, $l->getID())){
                        _warning("WContentNotStored", "Something happened while storing content");
                    }
                }else{
                    _warning("WContentCannotBeConverted", "Content cannot be converted to " . $l->getEncoding());
                }
            }
            
            $tmpFormFieldName = 'title_' . $l->getID();
            if(isset($attributes[$tmpFormFieldName])){
                $strTitle = html_entity_decode($attributes[$tmpFormFieldName], ENT_COMPAT, $l->getEncoding());
                if($strTitle !== false){
                    if(!$ogGalleryManager->setGalleryTitle($attributes['gallery'], $strTitle, $l->getID())){
                        _warning("WTitleNotStored", "Something happened while storing title");
                    }
                }else{
                    _warning("WTitleCannotBeConverted", "Title cannot be converted to " . $l->getEncoding());
                }
            }
            
            $ogGalleryManager->setGalleryUpdatedDate($attributes['gallery']);  
            $ogGalleryManager->setGalleryEditorID($attributes['gallery'], $l->getID(), $oUser->getID());     
                              
        }
        
        $tmpFormFieldName = 'description';
        if(isset($attributes[$tmpFormFieldName])){
            if(!$ogGalleryManager->setGalleryDescription($attributes['gallery'], $attributes[$tmpFormFieldName])){
                _warning("WDescriptionNotStored", "Something happened while storing description");
            }
        }
        
        $tmpFormFieldName = 'newgallery';
        if(!empty($attributes[$tmpFormFieldName])){
            $attributes[$tmpFormFieldName] = preg_replace("/[^a-zA-Z0-9\_\.]/", "_", $attributes[$tmpFormFieldName]);
            if($ogGalleryManager->setGalleryToken($attributes['gallery'], $attributes[$tmpFormFieldName])){
            	if(rename($fusebox['pathGalleries'] . $attributes['gallery'], $fusebox['pathGalleries'] . $attributes[$tmpFormFieldName])){
            		$attributes['gallery'] = $attributes[$tmpFormFieldName];              		          		     	
            	}else{
            		if($ogGalleryManager->setGalleryToken($attributes[$tmpFormFieldName], $attributes['gallery'])){
            			_warning("WCannotRenameGalleryFolder", "Cannot rename gallery folder");
            		}else{
            			_error("ECannotRenameGalleryFolder", "Cannot rename gallery folder but gallery already renamed");
            		}
            	}             
            }else{
            	_warning("WGalleryTokenNotStored", "Something happened while storing gallery token");            
            }
        }else{
            _warning("WGalleryTokenCannotBeEmpty", "Gallery token cannot be empty");
        }       
        
    }else{
        _error("ENoGalleryGiven", "No gallery given");
    }              
    
    if(!_gotErrors() && !_gotWarnings()){
    	_message("MGalleryStored", "Gallery stored");
    }
?>