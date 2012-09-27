<?php
	
	if(strlen($application['fusebox']['filesInitialization']) > 0){
		
		$filenames = explode(";", $application['fusebox']['filesInitialization']);
	
		foreach($filenames as $filename){
			if (file_exists($filename)){
				include($filename);
			}else{
				die("The required initialization file $filename is missing. Cannot continue. Have a nice day!");
			}
		}
		
	}
	
?>