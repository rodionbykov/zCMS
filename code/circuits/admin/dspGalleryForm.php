<?php
    
    $arrLanguages = array();
    if(isset($attributes['languageid'])){
        $arrLanguages[] = $oLanguageManager->getLanguageByID($attributes['languageid']);
    }else{
        $arrLanguages = $oLanguageManager->getLanguages();
    }     
    _assign("arrLanguages", $arrLanguages);
    _display("admin/dspGalleryForm.tpl");

?>
