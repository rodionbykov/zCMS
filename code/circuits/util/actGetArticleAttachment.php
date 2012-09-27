<?php

if (!empty($attributes['id'])) {
	if ($arrAttachment = 
			$ogArticleAttachmentManager->getAttachment(intval($attributes['id']))) {
		$oFile = new File();
		$oFile->initialize($fusebox['pathArticleAttachment'].$arrAttachment['file'], null, $arrAttachment['title'], $arrAttachment['mime']);
		
		$oFileManager->downloadFile($oFile);
	}
}

?>