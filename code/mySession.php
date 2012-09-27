<?php

	// path to store session files
	session_save_path($fusebox['pathSession']);

	// session files to be stored as WDDX packets - suit better for complex variables
    if(extension_loaded("wddx")){
	   ini_set("session.serialize_handler", "wddx");
    }
    
	//starting session
	session_start();
	
	// recovering saved User
	if(isset($_SESSION['oUser'])){
		$oUser = $_SESSION['oUser'];
	}
	
	// recovering stored XFAs
	if(array_key_exists("globalXFA", $_SESSION) && is_array($_SESSION['globalXFA'])){
		$XFA = $_SESSION['globalXFA'];
	}
	
	// checking if sticky attributes variable exists
	if(!array_key_exists("globalStickyAttributesArray", $_SESSION)){
		$_SESSION['globalStickyAttributesArray'] = array();
		$_SESSION['globalStickyAttributesArray'][ $attributes['fuseaction'] ] = array();
		$_SESSION['globalStickyAttributesArray'][ $fusebox['globalFuseaction'] ] = array();
	}
	
	if(!array_key_exists($attributes['fuseaction'], $_SESSION['globalStickyAttributesArray'])){
		$_SESSION['globalStickyAttributesArray'][ $attributes['fuseaction'] ] = array();
	}
	
	if(!array_key_exists($fusebox['globalFuseaction'], $_SESSION['globalStickyAttributesArray'])){
		$_SESSION['globalStickyAttributesArray'][ $fusebox['globalFuseaction'] ] = array();
	}

?>