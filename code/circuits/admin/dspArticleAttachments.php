<?php

if (!empty($attributes['token'])) {
	$arrArticleAttachments = 
		$ogArticleAttachmentManager->getAttachments($attributes['token']);
	_assign('arrArticleAttachments', $arrArticleAttachments);
}

if (!empty($attributes['id'])) {
	$arrAttachment = 
		$ogArticleAttachmentManager->getAttachment(intval($attributes['id']));
}

if (isset($arrAttachment)) {
	_assign('arrAttachment', $arrAttachment);
}

_display('admin/dspArticleAttachments.tpl');

?>