<?php

    $strToken = empty($attributes['token']) ? date("Y_m_d_") . "Article" . date("His") : $attributes['token'];
    $strDescription = empty($attributes['description']) ? "Article of " . date("d.m.Y H:i:s") : $attributes['description'];
    $intLanguageID = $oLanguage->getID();
    $isSibling = empty($attributes['issibling']) ? false : true;
    
    if($arrParentNode = empty($attributes['parent']) ? $ogArticleTree->getRootNodeInfo() : $ogArticleTree->getNodeInfo($attributes['parent'])){    	
		if($isSibling){
            if($ogArticleTree->appendSibling($arrParentNode['id'], array('token' => $strToken, 'description' => $strDescription, 'id_author' => $oUser->getID(), 'moment' => date("Y-m-d H:i:s")), false)){
                if($ogArticleManager->checkToken($ogFuseaction->getID(), $strToken, $strDescription, false)){
                    _message("MSiblingArticleAdded", "Article added in same section");   
                }else{
                	_error("ETokenNotExists", "Article token not exists and I cannot add it...");
                }
            }else{
            	_error("ECannotAppendArticle", "Article cannot be added to tree");
            }    			
		}else{
			if($arrParentNode['level'] < $fusebox['maxArticleTreeLevel']){    		
	            if($ogArticleTree->appendChild($arrParentNode['id'], array('token' => $strToken, 'description' => $strDescription, 'id_author' => $oUser->getID(), 'moment' => date("Y-m-d H:i:s")), false)){
	                if($ogArticleManager->checkToken($ogFuseaction->getID(), $strToken, $strDescription, false)){
	                    _message("MChildArticleAdded", "Child article added");   
	                }else{
	                	_error("ETokenNotExists", "Article token not exists and I cannot add it...");
	                }
	            }else{
	            	_error("ECannotAppendArticle", "Article cannot be added to tree");
	            }
            }else{
	        	_error("EMaxTreeLevelReached", "Cannot add article note at this level");
	        }
		}        
    }else{
    	_error("EInvalidArticleTreeNode", "Invalid article tree node given");
    }
    
?>
