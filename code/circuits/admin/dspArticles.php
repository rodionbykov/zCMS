<?php

    $attributes['token'] = empty($attributes['token']) ? "" : $attributes['token'];
    
    if($arrArticles = $ogArticleManager->getTokens($attributes['token'])){
        _assign("arrArticles", $arrArticles);
    }

    $arrLanguages = $oLanguageManager->getLanguages();
    _assign("arrLanguages", $arrLanguages);
    _display("admin/dspArticles.tpl");
    
?>
