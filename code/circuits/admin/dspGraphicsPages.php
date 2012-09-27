<?php

    _assign("arrGraphicsPages", $arrGraphicsPages);
    _assign("arrPageSizes", $arrPageSizes);
    _assign("arrPages", $oPaging->getPages());
    _display("admin/dspGraphicsPages.tpl");

?>
