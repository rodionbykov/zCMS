<?

	if(isset($imageFileName)){
		_assign("imageFileName", $imageFileName);
	}else{
		_error("ENoImageFileName", "No image file name given");
	}
	
	_display("util/dspUploadContentResult.tpl");

?>