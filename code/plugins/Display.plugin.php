<?php

	if (!_gotErrors()){
	
		$displayFiles = _getDisplay();
		$assignVars = _getAssign();
		
		// assigning smarty variables
		$smarty->assign($assignVars);
		
		// displaying every template given
		foreach($displayFiles as $d){
			$smarty->display($d);
		}
	
	}else{
		
		// display error template instead of display queue
		$arrErrors = _getErrors();
		__cfthrow(array(
			  "type"=>"runtime.applicationErrors",
			  "message"=>$arrErrors,
			  "detail"=>join("\n", $arrErrors)
        ));
		
	}

?>
