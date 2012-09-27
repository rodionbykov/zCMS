<?php
        if(!empty($attributes['token'])){
            
            $arrLanguages = $oLanguageManager->getLanguages();
            foreach($arrLanguages as $l){
            	
            	$ogArticleManager->pushUpdatedDate($ogFuseaction->getID(), $l->getID(), $attributes['token']);
            	$ogArticleManager->pushEditorID($ogFuseaction->getID(), $l->getID(), $attributes['token'], $oUser->getID());            	
            
                $tmpFormFieldName = 'content_' . $l->getID();
                if(isset($attributes[$tmpFormFieldName])){
                    $strContent = html_entity_decode($attributes[$tmpFormFieldName], ENT_COMPAT, $l->getEncoding());
                    if($strContent !== false){
                        if(!$ogArticleManager->pushContent($ogFuseaction->getID(), $l->getID(), $attributes['token'], $strContent)){
                            _warning("WArticleBodyNotStored", "Something happened while storing article body");
                        }
                    }else{
                        _warning("WArticleBodyCannotBeConverted", "Article body cannot be converted to " . $l->getEncoding());
                    }
                    
                }
                
                $tmpFormFieldName = 'title_' . $l->getID();
                if(isset($attributes[$tmpFormFieldName])){
                    $strTitle = html_entity_decode($attributes[$tmpFormFieldName], ENT_COMPAT, $l->getEncoding());
                    if($strTitle !== false){
                        if(!$ogArticleManager->pushTitle($ogFuseaction->getID(), $l->getID(), $attributes['token'], $strTitle)){
                            _warning("WArticleTitleNotStored", "Something happened while storing title");
                        }
                    }else{
                        _warning("WArticleTitleCannotBeConverted", "Article title cannot be converted to " . $l->getEncoding());
                    }
                }

            }
            
            $tmpFormFieldName = 'description';
            if(!empty($attributes[$tmpFormFieldName])){
                if(!$ogArticleManager->pushDescription($ogFuseaction->getID(), $attributes['token'], $attributes[$tmpFormFieldName])){
                    _warning("WArticleDescriptionNotStored", "Something happened while storing article description");
                }
            }else{
            	_warning("WArticleDescriptionCannotBeEmpty", "Article description cannot be empty");
            }
            
            $tmpFormFieldName = 'newtoken';
            if(!empty($attributes[$tmpFormFieldName])){
                $attributes[$tmpFormFieldName] = preg_replace("/[^a-zA-Z0-9\_\.]/", "_", $attributes[$tmpFormFieldName]);
                if(!$ogArticleManager->pushToken($ogFuseaction->getID(), $attributes['token'], $ogFuseaction->getID(), $attributes[$tmpFormFieldName])){
                    _warning("WArticleTokenNotStored", "Something happened while storing article token");
                }else{
                	$attributes['token'] = $attributes[$tmpFormFieldName];
                }
            }else{
                _warning("WArticleTokenCannotBeEmpty", "Article token cannot be empty");
            }            
            
        }else{
            _error("ENoArticleTokenGiven", "No article token is given");
        }
        
        if(!_gotErrors() && !_gotWarnings()){
            _message("MArticleStored", "Article successfully stored");
        }
               
?>