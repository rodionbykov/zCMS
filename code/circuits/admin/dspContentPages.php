<?php

    _assign("arrContentPages", $arrContentPages);
    _assign("arrPageSizes", $arrPageSizes);
    _assign("arrPages", $oPaging->getPages());
    _display("admin/dspContentPages.tpl");

?>
