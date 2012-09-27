<?php

	if (!empty($attributes['id'])) {
		if (is_numeric($attributes['id'])) {
			$arrAttachment = 
				$ogArticleAttachmentManager->getAttachment($attributes['id']);
			$ogArticleAttachmentManager->removeAttachment($attributes['id']);
			$oFile = new File();
			if ($oFile->initialize($fusebox['pathArticleAttachment'] 
					. $arrAttachment['file'])) {
				$oFileManager->deleteFile($oFile);
			}
		} else {
			_error("EInvalidAttachmentId", "Invalid attachment ID");	
		}
	} else {
		_error("ENoAttachmentGiven", "No attachment is given to delete");
	}
	
?>