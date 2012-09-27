<?
		if(!empty($attributes['token'])){
			
			$arrLanguages = $oLanguageManager->getLanguages();
			foreach($arrLanguages as $l){
				$tmpFormFieldName = 'content_' . $l->getID();
				if(isset($attributes[$tmpFormFieldName])){
                    $strContent = html_entity_decode($attributes[$tmpFormFieldName], ENT_COMPAT, $l->getEncoding());
                    if($strContent !== false){
    					if(!$ogMailTemplatesManager->pushContent($ogFuseaction->getID(), $l->getID(), $attributes['token'], $strContent)){
    						_warning("WBodyNotStored", "Something happened while storing template body");
    					}
                    }else{
                    	_warning("WBodyCannotBeConverted", "Template body cannot be converted to " . $l->getEncoding());
                    }
                    
				}
				
				$tmpFormFieldName = 'title_' . $l->getID();
				if(isset($attributes[$tmpFormFieldName])){
                    $strTitle = html_entity_decode($attributes[$tmpFormFieldName], ENT_COMPAT, $l->getEncoding());
                    if($strTitle !== false){
    					if(!$ogMailTemplatesManager->pushTitle($ogFuseaction->getID(), $l->getID(), $attributes['token'], $strTitle)){
    						_warning("WSubjectNotStored", "Something happened while storing subject");
    					}
                    }else{
                    	_warning("WTemplateSubjectCannotBeConverted", "Template subject cannot be converted to " . $l->getEncoding());
                    }
				}

			}
			
			$tmpFormFieldName = 'description';
			if(isset($attributes[$tmpFormFieldName])){
				if(!$ogMailTemplatesManager->pushDescription($ogFuseaction->getID(), $attributes['token'], $attributes[$tmpFormFieldName])){
					_warning("WDescriptionNotStored", "Something happened while storing description");
				}
			}
			
		}else{
			_error("ENoMailTemplateTokenGiven", "No mail template token is given");
		}
		
		if(!_gotErrors() && !_gotWarnings()){
			_message("MMailTemplateStored", "Mail template successfully stored");
		}
		
		_xfa($myself . "admin.showMailTemplates");
	
?>