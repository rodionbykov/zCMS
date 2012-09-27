<?php

	if(isset($attributes['fuseactionid']) && is_numeric($attributes['fuseactionid'])){
		if(!empty($attributes['token'])){
			
			$arrLanguages = $oLanguageManager->getLanguages();
			foreach($arrLanguages as $l){
				$tmpFormFieldName = 'content_' . $l->getID();
				if(isset($attributes[$tmpFormFieldName])){
                    $strContent = html_entity_decode($attributes[$tmpFormFieldName], ENT_COMPAT, $l->getEncoding());
                    if($strContent !== false){
    					if(!$oSEOContentManager->pushContent($attributes['fuseactionid'], $l->getID(), $attributes['token'], $strContent)){
    						_warning("WSEOContentNotStored", "Something happened while storing SEO content");
    					}
                    }else{
                    	_warning("WSEOContentCannotBeConverted", "SEO content cannot be converted to " . $l->getEncoding());
                    }
				}
			}
			
		}else{
			_error("ENoSEOTokenGiven", "No SEO token is given");
		}
	}else{
		_error("ENoFuseactionGiven", "No page is given");
	}

	_xfa($myself . "admin.showFuseactionSEOTokens&id=" . $attributes['fuseactionid']);
?>
