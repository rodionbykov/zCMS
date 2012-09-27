<?php

    $arrLanguages = array();

    if ($isNewImage = empty($attributes['image'])) {
      if(!empty($attributes['gallery'])){
        $attributes['image'] = $attributes['gallery'] . "_Image" . date("His");
      }else{
        $attributes['image'] = date("Y_m_d_") . "Image" . date("His");
      }
    }

    if (!empty($attributes['languageid'])) {
        $arrLanguages[] =
          $oLanguageManager->getLanguageByID($attributes['languageid']);
    }else{
        $arrLanguages = $oLanguageManager->getLanguages();
    }

    $arrDimensions['image']['width'] =
      $oSettingsManager->getValue("MaxImageWidth", 600, "INT",
      "Maximum width of gallery image");
    $arrDimensions['image']['height'] =
      $oSettingsManager->getValue("MaxImageHeight", 400, "INT",
      "Maximum height of gallery image");
    $arrDimensions['thumb']['width'] =
      $oSettingsManager->getValue("MaxThumbWidth", 100, "INT",
      "Maximum width of gallery image thumb");
    $arrDimensions['thumb']['height'] =
      $oSettingsManager->getValue("MaxThumbHeight", 100, "INT",
      "Maximum height of gallery image thumb");
    _assign('isNewImage', $isNewImage);
    _assign("arrDimensions", $arrDimensions);
    _assign("arrLanguages", $arrLanguages);
    _display("admin/dspImageForm.tpl");

?>
