<?

if (isset($attributes['upload'])) {

	$imageFileName = "";

	if (isset($_FILES['fname']) && ($_FILES['fname']['name']!="")) {
		
		$imageFileName =  strtolower($_FILES['fname']['name']);
		if(preg_match("/(gif|jp((e|eg)|(g))|png|tif(f)?|bmp)$/i", $imageFileName)){
			
			$imageFileName = preg_replace("/[^a-zA-Z0-9\_\.]/", "_", $imageFileName);
			
			while(file_exists($fusebox['pathContent'] . $imageFileName)){
				$imageFileName = (string) rand(0, 9) . $imageFileName;
			}
			
			if(!move_uploaded_file($_FILES['fname']['tmp_name'], $fusebox['pathContent'] . $imageFileName)){
				_error("ECannotUploadContentFile", "Cannot upload content file " . $imageFileName);
			}else{
				chmod($fusebox['pathContent'] . $imageFileName, 0666);
			}
		}else{
			_error("EInvalidFileFormat", "Invalid file format - upload allowed only for images");
		}

	}

}

?>
