<?php

    $attributes['order'] = empty($attributes['order']) ? "relevance" : $attributes['order'];

	if(!isset($attributes['sort']) || !in_array($attributes['sort'], array("ASC", "DESC"))){			
		if($attributes['order'] == "title"){
			$attributes['sort'] = "ASC";
		}else{
            $attributes['sort'] = "DESC";
        }
	}

	$attributes['page'] = empty($attributes['page']) ? 1 : intval($attributes['page']);		

    $attributes['page_size'] = empty($attributes['page_size']) ?
		$oSettingsManager->getValue("SearchResultsPageSize", 10, "INT",
		"Number of elements in search results") :
		intval($attributes['page_size']);
        
    $attributes['asort'] = ($attributes['sort'] == "ASC") ? "DESC" : "ASC";

	$oPaging = new Paging($attributes['page_size'], $ogArticleManager->getSearchCount($attributes['fSearch']), $attributes['page']);

	$oPaging->setLinkFormat($here . "&page=%d");
		
	$arrSearchResults = $ogArticleManager->searchContent($attributes['fSearch'], true, $attributes['order'], $attributes['sort'], $oPaging->getOffSet(), $oPaging->getPageSize());

	_assign("arrPages", $oPaging->getPages());
	_assign("arrSearchResults", $arrSearchResults);
	_display("home/dspSearchResults.tpl");

?>