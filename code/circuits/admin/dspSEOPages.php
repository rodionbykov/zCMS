<?php

    _assign("arrSEOContentPages", $arrSEOContentPages);
    _assign("arrPageSizes", $arrPageSizes);
    _assign("arrPages", $oPaging->getPages());
    _display("admin/dspSEOContentPages.tpl");

?>
