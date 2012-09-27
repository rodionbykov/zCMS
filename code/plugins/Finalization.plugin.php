<?php

	if(strlen($application['fusebox']['filesFinalization']) > 0){
		
		$filenames = explode(";", $application['fusebox']['filesFinalization']);
	
		foreach($filenames as $filename){
			if (file_exists($filename)){
				include($filename);
			}else{
				die("The required finalization file $filename is missing. Cannot continue. Have a nice day!");
			}
		}
		
	}

?>
