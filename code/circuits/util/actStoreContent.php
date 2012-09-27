<?php

	if(isset($attributes['fuseactionid']) && is_numeric($attributes['fuseactionid'])){
		if(!empty($attributes['token'])){
			            
			$arrLanguages = $oLanguageManager->getLanguages();
			foreach($arrLanguages as $l){
				$tmpFormFieldName = 'content_' . $l->getID();
				if(isset($attributes[$tmpFormFieldName])){
                    $strContent = html_entity_decode($attributes[$tmpFormFieldName], ENT_COMPAT, $l->getEncoding());
                    if($strContent !== false){
    					if(!$oContentManager->pushContent($attributes['fuseactionid'], $l->getID(), $attributes['token'], $strContent)){
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
    					if(!$oContentManager->pushTitle($attributes['fuseactionid'], $l->getID(), $attributes['token'], $strTitle)){
    						_warning("WTitleNotStored", "Something happened while storing title");
    					}
                    }else{
                    	_warning("WContentCannotBeConverted", "Title cannot be converted to " . $l->getEncoding());
                    }
    			}
			}
			
			$tmpFormFieldName = 'description';
			if(isset($attributes[$tmpFormFieldName])){
				if(!$oContentManager->pushDescription($attributes['fuseactionid'], $attributes['token'], $attributes[$tmpFormFieldName])){
					_warning("WDescriptionNotStored", "Something happened while storing description");
				}
			}
			
		}else{
			_error("ENoTokenGiven", "No token is given");
		}
	}else{
		_error("ENoFuseactionGiven", "No page is given");
	}
	
    echo "<script>window.opener.location.reload(); window.close();</script>";
?>