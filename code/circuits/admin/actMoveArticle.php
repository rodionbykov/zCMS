<?php
	
if (isset($attributes['fId']) && isset($attributes['fId'])  
		&& is_numeric($attributes['fId']) 
		&& is_numeric($attributes['fParentId'])
		&& $attributes['fId'] != $attributes['fParentId']) {
	$ogArticleTree->replaceNode($attributes['fId'], $attributes['fParentId']);	
}

?>