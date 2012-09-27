<?php
	
    // sending content headers
    header("Content-Type: text/html; charset=" . $oLanguage->getEncoding());
    header("Content-Language: " . $oLanguage->getCode());

  	$arrHeaderLanguages = $oLanguageManager->getLanguages();
  	_assign("arrHeaderLanguages", $arrHeaderLanguages);

  	$arrRootArticle = $ogArticleTree->getRootNode(array('token'));

  	if (isset($attributes['article']) && ($attributes['article'] != $arrRootArticle['token'])) {
    	$article_id = $ogArticleManager->checkToken($ogFuseaction->getID(), $attributes['article'], "", false);
    	
    	$sql = "SELECT id, level FROM " . $fusebox['tableArticlesTree'] . " WHERE data_id = " . $article_id;
    	$node_id = $oDB->getQueryField($sql,0,0);
    	
		$arrArticleFamily = $ogArticleTree->getNodeFamily($node_id, array('token'));
		
	} else {
		$arrArticleFamily = $ogArticleTree->getNodeFamily(0, array('token'));
	}

  	_assign("arrRootArticle", $arrRootArticle);
  	_assign("arrArticleFamily", $arrArticleFamily);
  	_display("home/layHeader.tpl");

?>