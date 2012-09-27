<?php

if (empty($attributes['token'])) {
	_error("ENoArticleGiven", "No article is given");
} elseif (!$ogArticleManager->checkToken($ogFuseaction->getID(), 
		$attributes['token'], '', false)) {
	_error("ENoGalleryExist", "Gallery not exists");
}

if (empty($attributes['title'])) {
	_warning("WTitleIsEmpty", "Attachment is emply");
}

if (empty($_FILES['file']['name']) && empty($attributes['id'])) {
	_warning("WNoFileGiven", "No file is given");
}

/*
 * upload file
 */

if (!_gotErrors() && !_gotWarnings() && !empty($_FILES['file']['name'])) {
	if (!$oFile = $oFileManager->uploadFile('file', 
			$fusebox['pathArticleAttachment'])) {
		_warning('WCannotUploadAttachmentFile', 
			"Cannot upload attachment file ");
	}
}

/*
 * storing data
 */

if (!_gotErrors() && !_gotWarnings()) {
	if (empty($attributes['id'])) {
		$params = array(
			"title" => $attributes['title'],
			"file" => $oFile->getFileName(),
			"mime" => $oFile->getFileMimeType()
		);
		if (!$ogArticleAttachmentManager->addAttachment($attributes['token'], 
				$params)) {
			$oFileManager->deleteFile($oFile);
			_warning("WAttachmentNotStored", 
				"Something happened while storing attachment");
		}
	} else {
		$arrAttachment = 
			$ogArticleAttachmentManager->getAttachment(intval($attributes['id']));
		$params = array(
			"title" => $attributes['title']
		);		
		if ($oFile) {
			$params['file'] = $oFile->getFileName();
			$params['mime'] = $oFile->getFileMimeType(); 
		}
		if ($ogArticleAttachmentManager->updateAttachment(intval($attributes['id']), 
				$params)) {
			if ($oFile) {
				@unlink($fusebox['pathArticleAttachment'].$arrAttachment['file']);
			}
		} else {
			if ($oFile) {
				$oFileManager->deleteFile($oFile);
			}
			_warning("WAttachmentNotStored", 
				"Something happened while storing attachment");
		}
			
	}
} else {
	$arrAttachment = $attributes;
}

?>