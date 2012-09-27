<?php

	if($ogArticleManager->muteCommentsByID($attributes['commentid'])){
		_message("MCommentsMuted", "Article comment(s) muted");	
	}else{
		_warning("WCommentsNotMuted", "Something happened while muting comments");
	}


?>
