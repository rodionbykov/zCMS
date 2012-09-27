<?php

  $attributes['page_size'] = empty($attributes['page_size']) ?
    $oSettingsManager->getValue("GalleryPicutresOnPage", 12, "INT",
    "Number of pictures in gallery page") :
    intval($attributes['page_size']);

  $attributes['page'] =
    empty($attributes['page']) ? 1 : intval($attributes['page']);

    if (!empty($attributes['gallery'])) {
        if ($ogGalleryManager->checkGallery($attributes['gallery'])) {
            $arrGalleries = $ogGalleryManager->getGalleries();

            $oPaging = new Paging($attributes['page_size'],
              $ogGalleryManager->getImagesCount($attributes['gallery']),
              $attributes['page']);

            $arrImages = $ogGalleryManager->getImages($attributes['gallery'],
              $oPaging->getOffSet(), $oPaging->getPageSize());

            $oPaging->setLinkFormat($attributes['gallery'].'.gallery/'. "%d");

            $intAuthorID = $ogGalleryManager->getGalleryAuthorID($attributes['gallery']);
          $intEditorID = $ogGalleryManager->getGalleryEditorID($attributes['gallery']);
          $oAuthor = false;
          $oEditor = false;
          if($intAuthorID){
            $oAuthor = $oUserManager->getUserByID($intAuthorID);
          }
          if($intEditorID){
            $oEditor = $oUserManager->getUserByID($intEditorID);
          }

          if($oAuthor){
            _assign('oAuthor', $oAuthor);
          }
          if($oEditor){
            _assign('oEditor', $oEditor);
          }

            _assign("arrPages", $oPaging->getPages());
            _assign("arrGalleries", $arrGalleries);
            _assign("arrImages", $arrImages);
            _display("home/dspGallery.tpl");
        } else {
          _error("EGalleryNotExists", "Gallery not exists");
        }
    } else {
      _error("ENoGalleryGiven", "No gallery given");
    }

?>