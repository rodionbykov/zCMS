<?php

	// fusebox initialization core file
	
	// define some useful functions
	
	function _display($template){
		global $application;
		
		return $application['globalDisplayQueue'][] = $template;
	}
	
	function _getDisplay(){
		global $application;
		
		return $application['globalDisplayQueue'];
	}
	
	function _assign($variable, $value){
		global $application;
		
		return $application['globalAssignVariables'][$variable] = $value;
	}
	
	function _assign_by_ref($variable, &$value){
		global $application;
		
		return $application['globalAssignVariables'][$variable] = $value;
	}
	
	function _getAssign(){
		global $application;
		
		return $application['globalAssignVariables'];
	}

	function _throw($errorCode, $errorText){
		_bye("FATAL ERROR [" . $errorCode . "] " . $errorText);
		return __cfthrow(array(
			  "type"=>"runtime.fatalError",
			  "message"=>"$errorCode: $errorText",
			  "detail"=>"Halted: $errorText ($errorCode)"
          ));
	}
	
	function _xfa($xfa, $fuseaction = ""){
		global $attributes;
		global $XFA;
		
		if($fuseaction == ""){
			return $XFA[ $attributes['fuseaction'] ] = $xfa;
		}else{
			return $XFA[ $fuseaction ] = $xfa;
		}
	}
	
	function _getxfa($fuseaction = "", $clean = true){
		global $attributes;
		global $XFA;
		
		$xfa = "";
		if($fuseaction == ""){
			$fuseaction = $attributes['fuseaction'];
		}
		if(array_key_exists($fuseaction, $XFA) && (strlen($XFA[ $fuseaction ]) > 0)){
			$xfa = $XFA[ $fuseaction ];
		}
		if($clean){
			unset($XFA[ $fuseaction ]);
		}
		return $xfa;
	}
	
	function _gotxfa($fuseaction = ""){
		global $attributes;
		global $XFA;

		if($fuseaction == ""){
			$fuseaction = $attributes['fuseaction'];
		}
		
		return array_key_exists($fuseaction, $XFA) && (strlen($XFA[ $fuseaction ]) > 0);
	}
	
	function _error($errorCode, $errorText){
		global $application;

		_log($errorText, $errorCode, "E");
		return $application['globalErrorsQueue'][$errorCode] = $errorText;
	}
	
	function _getErrors(){
		global $application;
		
		return $application['globalErrorsQueue'];
	}
	
	function _gotErrors(){
		global $application;
	
		return (bool) count($application['globalErrorsQueue']);
	}
	
	function _gotError($error){
		global $application;
	
		return array_key_exists($error, $application['globalErrorsQueue']);
	}
	
	function _warning($warnCode, $warnText){
		global $application;

		_log($warnText, $warnCode, "W");
		return $application['globalWarningsQueue'][$warnCode] = $warnText;
	}

	function _getWarnings(){
		global $application;
		
		return $application['globalWarningsQueue'];
	}
		
	function _gotWarnings(){
		global $application;
		
		return (bool) count($application['globalWarningsQueue']);
	}

	function _gotWarning($warning){
		global $application;
		
		return array_key_exists($warning, $application['globalWarningsQueue']);
	}
	
	function _message($msgCode, $msgText){
		global $application;

		_log($msgText, $msgCode, "M");
		return $application['globalMessagesQueue'][$msgCode] = $msgText;
	}
	
	function _getMessages(){
		global $application;
		
		return $application['globalMessagesQueue'];
	}
	
	function _gotMessages(){
		global $application;
		
		return (bool) count($application['globalMessagesQueue']);
	}
	
	function _gotMessage($message){
		global $application;
		
		return array_key_exists($message, $application['globalMessagesQueue']);
	}
	
	function _debug($file, $mode, $caption = ""){
		global $application;
		global $attributes;
		global $oDB;
		global $oUser;
		global $XFA;
		global $oSettingsManager;
        global $oFuseaction;

		ob_start();
		echo $caption . ": " . date("m/d/Y H:i:s") . "\n";
        echo "Executed in " . $oFuseaction->getLifeTime() . " sec\n\n";
		echo "Attributes: ";
		print_r($attributes);
		echo "Settings: ";
		print_r($oSettingsManager->getSettings());
		echo "Session: ";
		print_r($_SESSION);
		echo "User: ";
		print_r($oUser);
		echo "Queries: ";
		print_r($oDB->getDump());	
		echo "Errors: ";
		print_r(_getErrors());	
		echo "Warnings: ";
		print_r(_getWarnings());	
		echo "Messages: ";
		print_r(_getMessages());	
		echo "XFA: ";
		print_r($XFA);				
		$debug = ob_get_contents();
		ob_end_clean();
		
		if($f = fopen($file, $mode)){
			fwrite($f, $debug);
			fclose($f);
		}
		return true;
	}
	
	function _log($msg, $code = "", $type = "I", $extmsg = ""){
		global $oLogManager;
		
		return $oLogManager->log($msg, $code, $type, $extmsg);
	}
	
	function _bye($caption){
		global $application;
		global $attributes;

			
		$log = date("m/d/Y H:i:s") . ", " . $attributes['fuseaction'] . ": " . $caption . " \n";		
		
		$f = false;

		if($f = fopen($application['fusebox']['filesLog'], "a")){
			fwrite($f, $log);
			fclose($f);
			return true;
		}else{
			return false;
		}
	}

	function unescapeAttributes(){
		global $attributes;	
	
		foreach($attributes as $k=>$v){
			if (!is_array($attributes[$k])){
				if (get_magic_quotes_gpc()){
					$attributes[$k] = stripslashes($v);
				}
			}else{
				$attrArray = &$attributes[$k];
				foreach($attrArray as $kk => $vv){
					if (get_magic_quotes_gpc()){
						$attrArray[$kk] = stripslashes($vv);
					}
				}
			}
		}
	}
	
	
	function serializeAttributes($exceptAttributes){
		global $attributes;	
	
		$arrAttString = array();
		foreach($attributes as $k=>$a)
		{
			if(!in_array($k, $exceptAttributes)){
				if (!is_array($attributes[$k])){
						$arrAttString[] = $k . "=" . $a;
					}
				}	
		}
		
		return join("&", $arrAttString);
	}
	
	function getServerParameters($serverfile){
		global $application;
		$parameters = array();
		$meta = array();
		if(file_exists($serverfile)){
			$fileParameters = join("", file($serverfile));
			$xmlParser = xml_parser_create();
			xml_parser_set_option($xmlParser, XML_OPTION_CASE_FOLDING, 0);	
			xml_parser_set_option($xmlParser, XML_OPTION_SKIP_WHITE, 1);
			xml_parse_into_struct($xmlParser, $fileParameters, $parameters, $meta);
			xml_parser_free($xmlParser);
			foreach($parameters as $v){
				if($v['tag'] == "parameter" && $v['level'] == 2 && $v['type'] == 'complete' && array_key_exists($v['attributes']['name'], $application['fusebox'])){
					$application['fusebox'][ $v['attributes']['name'] ] = $v['attributes']['value'];
				}
			}
		}else{
			return false;
		}
	}
	
	function getStickyAttributes($fuseaction, $stickyattrs){
		global $attributes;
		
		if(is_array($stickyattrs)){
			foreach($stickyattrs as $a){
				if(!array_key_exists($a, $attributes) && array_key_exists($a, $_SESSION['globalStickyAttributesArray'][ $fuseaction ])){
					$attributes[ $a ] = $_SESSION['globalStickyAttributesArray'][ $fuseaction ][ $a ];
				}
			}
		}else{
			return false;
		}
	}
	
	function setStickyAttributes($fuseaction, $stickyattrs){
		global $attributes;
		
		if(is_array($stickyattrs)){
			foreach($stickyattrs as $a){
				if(array_key_exists($a, $attributes)){
					 $_SESSION['globalStickyAttributesArray'][ $fuseaction ][ $a ] = $attributes[ $a ];
				}
			}
		}else{
			return false;
		}
	}
	
	// variable to identify the application entry point
	$self = "index.php";
	
	// variable to identify the application entry point plus fuseaction var
	$myself = $self . "?" . $application["fusebox"]["fuseactionVariable"] . "=";	
	
	// getting rid of magic quotes
	unescapeAttributes();
	
	// variable to store all fusebox things (just a shortcut)
	$fusebox = &$application['fusebox'];	
	
	// gettings server-specific parameters from file
	getServerParameters($fusebox['filesServer']);
	
	// making absolute URLs that will be used in templates
    $fusebox['urlBase'] = strlen($fusebox['urlBase']) ? $fusebox['urlBase'] : "http://" . $_SERVER['HTTP_HOST'] . str_replace($self, "", $_SERVER["PHP_SELF"]);
	$fusebox['urlAssets'] = $fusebox['urlBase'] . $fusebox['pathAssets'];
	$fusebox['urlContent'] = $fusebox['urlBase'] . $fusebox['pathContent'];
	$fusebox['urlGraphics'] = $fusebox['urlBase'] . $fusebox['pathGraphics'];
    $fusebox['urlGalleries'] = $fusebox['urlBase'] . $fusebox['pathGalleries'];
    $fusebox['urlArticleAttachment'] = $fusebox['urlBase'] . $fusebox['pathArticleAttachment']; 
    
	// making paths absolute for future use
	$fusebox['pathSmartyTemplates'] = $fusebox['approotdirectory'] . $fusebox['pathSmartyTemplates'];
	$fusebox['pathSmartyTemplatesCompiled'] = $fusebox['approotdirectory'] . $fusebox['pathSmartyTemplatesCompiled'];
	$fusebox['pathSession'] = $fusebox['approotdirectory'] . $fusebox['pathSession'];
	$fusebox['pathContent'] = $fusebox['approotdirectory'] . $fusebox['pathContent'];
    $fusebox['pathAssets'] = $fusebox['approotdirectory'] . $fusebox['pathAssets'];
    $fusebox['pathGraphics'] = $fusebox['approotdirectory'] . $fusebox['pathGraphics'];
    $fusebox['pathGalleries'] = $fusebox['approotdirectory'] . $fusebox['pathGalleries'];    
	$fusebox['pathArticleAttachment'] = $fusebox['approotdirectory'] . $fusebox['pathArticleAttachment'];
    
    // checking for some necessary parameters
    if(!$fusebox['defaultTimeZone']){
    	$fusebox['defaultTimeZone'] = "UTC";
    }
    
	// creating directories if they not exist
	if(!is_dir($fusebox['pathSmartyTemplatesCompiled'])){
		if(!@mkdir($fusebox['pathSmartyTemplatesCompiled'], 0777)){
			_throw("FNoSmartyTemplatesFolder", "There is no Smarty compiled templates folder and I cannot create it...");
		}
	}
	
	if(!is_dir($fusebox['pathSession'])){
		if(!@mkdir($fusebox['pathSession'], 0777)){		
		  _throw("FNoSessionFolder", "There is no folder for storing session and I cannot make it...");
		}
	}

	if(!is_dir($fusebox['pathContent'])){
		if(!@mkdir($fusebox['pathContent'], 0777)){		
		  _throw("FNoContentFolder", "There is no folder for storing content files and I cannot make it...");
		}
	}
    
    if(!is_dir($fusebox['pathGraphics'])){
        if(!@mkdir($fusebox['pathGraphics'], 0777)){     
          _throw("FNoGraphicsFolder", "There is no folder for storing graphic files and I cannot make it...");
        }
    }
	
    if(!is_dir($fusebox['pathGalleries'])){
        if(!@mkdir($fusebox['pathGalleries'], 0777)){     
          _throw("FNoGraphicsFolder", "There is no folder for storing gallery images and I cannot make it...");
        }
    }

    if(!is_dir($fusebox['pathArticleAttachment'])){
        if(!@mkdir($fusebox['pathArticleAttachment'], 0777)){     
          _throw("FNoArticleAttachmentsFolder", "There is no folder for storing article attachments images and I cannot make it...");
        }
    }
    
    
	// display queue 
	$application['globalDisplayQueue']  = array();
	
	// errors queue  
	$application['globalErrorsQueue']  = array();
	
	// warnings queue
	$application['globalWarningsQueue']  = array();
	
	// messages queue
	$application['globalMessagesQueue']  = array();
	
	// assigned variables
	$application['globalAssignVariables'] = array();
	
	// global exit fuseaction array
	$XFA = array();

?>