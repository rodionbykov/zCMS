<?php

    if(isset($attributes['token'])){
        
        $arrLanguages = array();
        if(isset($attributes['languageid'])){
            $arrLanguages[] = $oLanguageManager->getLanguageByID($attributes['languageid']);
        }else{
            $arrLanguages = $oLanguageManager->getLanguages();
        }
        _assign("arrLanguages", $arrLanguages);
    }else{
        _error("ENoArticeGiven", "No article given to edit");
    }

    _display("admin/dspArticleForm.tpl");
    
?>