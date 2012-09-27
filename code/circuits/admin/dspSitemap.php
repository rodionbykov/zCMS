<?php

	$filter = array();

	_assign('arrItems', $oSitemap->getItems($filter));

	_display("admin/dspSitemap.tpl");

?>
