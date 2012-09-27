<?php

	// output debug info
	if(($fusebox['mode'] == "development") || $oUser->isDev()){
		if(!_debug($fusebox['filesDump'], "w", "End of script")){
			_bye("Cannot debug at end of script");
		}
	}else{
        if(file_exists($fusebox['filesDump'])){
            unlink($fusebox['filesDump']);
        }
    }
	
	// logging end of execution
	_log($attributes['fuseaction'] . " finished", "IFuseactionFinished");
	
?>
