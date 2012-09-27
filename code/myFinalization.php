<?php
	
	// saving objects to session to pick up next time
	$_SESSION['oUser'] = $oUser;
	
	// saving global 'sticky' attributes values to session
	setStickyAttributes($ogFuseaction->getName(), $ogFuseaction->getStickyAttributes());
	
	// saving 'sticky' attributes values to session
	setStickyAttributes($oFuseaction->getName(), $oFuseaction->getStickyAttributes());
	
	// assigning variables before display
	_assign_by_ref("application", $application);
	_assign_by_ref("fusebox", $fusebox);
	_assign_by_ref("attributes", $attributes);
	
	// relocating if exit fuseaction exists and no error or warning to show... messages appended to XFA URL
	if(_gotxfa() && !_gotErrors() && !_gotWarnings()){

		// appending messages to URL to allow processing messages on 'landing' page
		$xfa = _getxfa();

		// saving XFAs to session to pick up next time
		$_SESSION['globalXFA'] = $XFA;
		
		if(_gotMessages()){
			$tmparrMsgs = _getMessages();
			$tmparrMsgs = array_keys($tmparrMsgs);
			$xfa .= "&messages=" . join(",", $tmparrMsgs);
		}			
		
		// moving to exit
		Location($xfa, 0); // 0 means no PHPSESSID
		
	}else{
		// saving XFAs to session to pick up next time
		$_SESSION['globalXFA'] = $XFA;		
	}
	
?>