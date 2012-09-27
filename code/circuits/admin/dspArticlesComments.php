<?php

	$arrArticleComments = $ogArticleManager->getComments($attributes['token']);
	
	_assign('arrArticleComments', $arrArticleComments);
	_display("admin/dspArticlesComments.tpl");

?>
