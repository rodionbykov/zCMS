<?php

    $arrRootNode = $ogArticleTree->getRootNodeInfo();
    $arrArticlesTree = $ogArticleTree->select($arrRootNode['id'], array('token'), NSTREE_AXIS_DESCENDANT_OR_SELF);
    
    _assign("arrArticlesTree", $arrArticlesTree);
    _display("admin/dspArticlesTree.tpl");

?>
