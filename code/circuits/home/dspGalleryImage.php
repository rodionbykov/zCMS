<?php

    if(!empty($attributes['gallery'])){
        if($ogGalleryManager->checkGallery($attributes['gallery'])){
            if(!empty($attributes['image'])){

              $arrImages =
                $ogGalleryManager->getImages($attributes['gallery']);

              $attributes['next_token'] = null;
              $attributes['prev_token'] = null;

              for ($i = 0; $i < count($arrImages); $i++) {
                 if ($arrImages[$i]['token'] == $attributes['image']) {
                   if ($i != count($arrImages) - 1) {
                     $attributes['next_token'] =
                       $arrImages[$i + 1]['token'];
                   }
                   if ($i != 0) {
                     $attributes['prev_token'] =
                       $arrImages[$i - 1]['token'];
                   }
                   break;
                 }
              }

          $intAuthorID = $ogGalleryManager->getImageAuthorID($attributes['gallery'], $attributes['image']);
          $intEditorID = $ogGalleryManager->getImageEditorID($attributes['gallery'], $attributes['image']);
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

        $arrGalleries = $ogGalleryManager->getGalleries();
        _assign("arrGalleries", $arrGalleries);

                _display("home/dspGalleryImage.tpl");

            }
        }else{
            _error("EGalleryNotExists", "Gallery not exists");
        }
    }else{
        _error("ENoGalleryGiven", "No gallery given");
    }

?>