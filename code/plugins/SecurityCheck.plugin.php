<?php
/* 
 * SECURITY FUSEBOX PLUGIN v.4B1
 * (c) Rodion Bykov roddyb@yandex.ru 2005
 * Created on Nov 14, 2005 
 * Last modified on Oct 27, 2006
 * 
 *  Please ask for written permission before redistribute or use this plugin in your project
 *  I give no warranty or support of any kind for this class, neither guarantee its suitability to any purpose
 */

	if (
	($attributes['fuseaction'] == $fusebox['xfaLogin']) 
	|| 
	($attributes['fuseaction'] == $fusebox['xfaLogout'])
	||
	($attributes['fuseaction'] == $fusebox['xfaAccessDenied'])
	||
	($attributes['fuseaction'] == $fusebox['xfaLoginForm'])
	){	
		
		$access = true;
		
	}else{
		
		$access = $oSecurityManager->getUserAccess($attributes['fuseaction']);

	}
		
	if(!$access){
		
		// saving location to go after successful login
		_xfa($here, $fusebox['xfaLogin']);
		
		// saving XFAs to session to pick up next time
		$_SESSION['globalXFA'] = $XFA;
		
		// moving to exit
		Location($fusebox['urlBase'] . $myself . $fusebox['xfaAccessDenied'], 0); // 0 means no PHPSESSID
	}

?>