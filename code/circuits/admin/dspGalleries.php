<?php

    $arrGalleries = $ogGalleryManager->getGalleries();
    
    _assign("arrGalleries", $arrGalleries);
    _display("admin/dspGalleries.tpl");
    
?>
