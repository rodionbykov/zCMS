<?php

    if(!empty($attributes['node'])){
    	if($arrNode = $ogArticleTree->getNodeInfo($attributes['node'])){
    		$sql = "DELETE FROM " . $fusebox['tableArticles'] . " WHERE id_token = " . $arrNode['data_id'];
            if ($oDB->query($sql) && $ogArticleTree->removeNodes($attributes['node'])){
            	_message("MArticleRemoved", "Article removed");
            }
    	}else{
    		_error("EArticleNodeNotExists", "Article node not exists");
    	}
    }else{
    	_error("ENoArticleNodeGiven", "No article node given");
    }
    
    _xfa($myself . "admin.showArticlesTree");

?>
