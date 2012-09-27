<?php

    $strGallery = empty($attributes['gallery']) ? date("Y_m_d_") . "Gallery" . date("His") : $attributes['gallery'];
    $strDescription = empty($attributes['description']) ? "Gallery of " . date("d.m.Y H:i:s") : $attributes['description'];
        
    if($ogGalleryManager->addGallery($strGallery, $strDescription)){
        mkdir($fusebox['pathGalleries'] . $strGallery);
        chmod($fusebox['pathGalleries'] . $strGallery, 0777);
        mkdir($fusebox['pathGalleries'] . $strGallery . "/" . $fusebox['folderThumbs']);
        chmod($fusebox['pathGalleries'] . $strGallery . "/" . $fusebox['folderThumbs'], 0777);        
        _message("MGalleryAdded", "Gallery added");
    }else{
        _error("EGalleryExists", "Gallery already exists or I cannot add it...");
    }

?>
