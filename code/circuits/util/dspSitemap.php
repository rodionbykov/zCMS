<?php

	$filter = array();

	_assign('arrItems', $oSitemap->getItems($filter));

	header("Content-Type: text/xml; charset=" . $oLanguage->getEncoding());

	_display("util/dspSitemap.tpl");

?>
