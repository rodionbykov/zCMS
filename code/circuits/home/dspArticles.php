<?php

	$attributes['page_size'] = empty($attributes['page_size']) ? 
		$oSettingsManager->getValue("ArticlesPageSize", 10, "INT", 
		"Number of elements in galleries list") : 
		intval($attributes['page_size']);
		
	$attributes['page'] = 
		empty($attributes['page']) ? 1 : intval($attributes['page']);		

	$oPaging = new Paging($attributes['page_size'], 
		$ogArticleManager->getTokensCount(0), $attributes['page']);

	$oPaging->setLinkFormat($here . "&page=%d");
		
	$arrAllArticles = $ogArticleManager->pullTokens(0, "", "id", "DESC", 
		$oPaging->getOffSet(), $oPaging->getPageSize());

	_assign("arrPages", $oPaging->getPages());
	_assign("arrAllArticles", $arrAllArticles);
	_display("home/dspArticles.tpl");

?>
