<?php

    if(isset($attributes['fuseactionid']) && is_numeric($attributes['fuseactionid'])){
        if(!empty($attributes['token'])){
                        
            $arrLanguages = $oLanguageManager->getLanguages();
            foreach($arrLanguages as $l){
                $tmpFormFieldName = 'content_' . $l->getID();
                if(isset($attributes[$tmpFormFieldName])){
                    $strContent = html_entity_decode($attributes[$tmpFormFieldName], ENT_COMPAT, $l->getEncoding());
                    if($strContent !== false){
                        if(!$ogArticleManager->pushContent($attributes['fuseactionid'], $l->getID(), $attributes['token'], $strContent)){
                            _warning("WArticleNotStored", "Something happened while storing article");
                        }
                    }else{
                        _warning("WArticleCannotBeConverted", "Article cannot be converted to " . $l->getEncoding());
                    }
                }
                
                $tmpFormFieldName = 'title_' . $l->getID();
                if(isset($attributes[$tmpFormFieldName])){
                    $strTitle = html_entity_decode($attributes[$tmpFormFieldName], ENT_COMPAT, $l->getEncoding());
                    if($strTitle !== false){
                        if(!$ogArticleManager->pushTitle($attributes['fuseactionid'], $l->getID(), $attributes['token'], $strTitle)){
                            _warning("WArticleTitleNotStored", "Something happened while storing article title");
                        }
                    }else{
                        _warning("WArticleTitleCannotBeConverted", "Article title cannot be converted to " . $l->getEncoding());
                    }
                }
            }
            
            $tmpFormFieldName = 'description';
            if(isset($attributes[$tmpFormFieldName])){
                if(!$ogArticleManager->pushDescription($attributes['fuseactionid'], $attributes['token'], $attributes[$tmpFormFieldName])){
                    _warning("WArticleDescriptionNotStored", "Something happened while storing article description");
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