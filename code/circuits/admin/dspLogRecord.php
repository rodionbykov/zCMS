<?php

	if(!empty($attributes['id'])){
		if(is_numeric($attributes['id'])){
			if($arrLogRecord = $oLogManager->getLogByID($attributes['id'])){
				_assign("arrLogRecord", $arrLogRecord);
			}else{
				_error("ECannotGetLogRecord", "Cannot get log record");
			}
		}else{
			_error("EInvalidLogID", "Invalid log record ID");
		}
	}else{
		_error("ENoLogIDGiven", "No log record ID given");
	}
	
	_display("admin/dspLogRecord.tpl");

?>
