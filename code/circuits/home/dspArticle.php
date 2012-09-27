<?php

    $attributes['article'] = empty($attributes['article']) ? $arrRootArticle['token'] : $attributes['article'];

  if (!$ogArticleManager->checkToken($ogFuseaction->getID(), $attributes['article'], "", false)){
    $attributes['article'] = $arrRootArticle['token'];
  }
  if (isset($article_id)) {
  	$arrRelatedArticles = $ogArticleTree->getChildNodes($article_id, array('token'));
  	$arrBranch = $ogArticleTree->getBranch($node_id, array('token'));
  	_assign('arrBranch', $arrBranch);
  	_assign('arrRelatedArticles', $arrRelatedArticles);
  }

  if (!empty($attributes['article'])) {
    $arrArticleAttachments =  $ogArticleAttachmentManager->getAttachments($attributes['article']);
    _assign('arrArticleAttachments', $arrArticleAttachments);
    
    $intCommentsCount = $ogArticleManager->getCommentsCount($attributes['article']);
    _assign('intCommentsCount', $intCommentsCount);
  }

  
  
  
  $intAuthorID = $ogArticleManager->getAuthorID($attributes['article']);
  $intEditorID = $ogArticleManager->getEditorID($attributes['article']);
  
  $oAuthor = false;
  $oEditor = false;
  if($intAuthorID){
    $oAuthor = $oUserManager->getUserByID($intAuthorID);
  }
  if($intEditorID){
    $oEditor = $oUserManager->getUserByID($intEditorID);
  }
  
  
  
  if($oAuthor){
    _assign('oAuthor', $oAuthor);
  }
  if($oEditor){
    _assign('oEditor', $oEditor);
  }
    _display("home/dspArticle.tpl");

?>
