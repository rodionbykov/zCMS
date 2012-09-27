<?php

	// Database initialization
	$oDB = new DBmysql($fusebox['dbLogin'], $fusebox['dbPassword'], $fusebox['dbName'], $fusebox['dbHost'], $fusebox['dbPort']);
	if(!$oDB){
		_throw("FCannotInstantiateDB", "Cannot instantiate DB class");
	}
	if(!$oDB->connect()){
		_throw("FCannotConnectToDB", "Cannot connect to database server you specified (" . $oDB->getError() . ")");
	}

	// making fake fuseaction for global things
	$ogFuseaction = new Fuseaction(0, $fusebox['globalFuseaction'], "Entire site", "", $fusebox['globalStickyAttributes']);

	// FuseManager initialization
	$oFuseManager = new FuseManager($oDB, $fusebox['tableFuseactions'], false);
	if(!$oFuseManager->initialize()){
		_throw("FNoFuseactionsTable", "There is no fuseactions table called \"{$fusebox['tableFuseactions']}\" present in DB");
	}

	// sync'ing fuseactions
	if($fusebox['mode'] == "development"){
		if(!$oFuseManager->synchronizeFuseactions($fusebox)){
			_throw("FCannotSynchronizeFuseactions", "Error occured while synchronizing fuseactions, check your database");
		}
	}

	// getting current fuseaction
	$oFuseaction = $oFuseManager->getFuseaction($attributes['fuseaction']);
	if(!$oFuseaction){
		_throw("FNoSuchFuseaction", "There is no fuseaction called \"{$attributes['fuseaction']}\" found");
	}

	// loading 'sticky' attributes values from session for entire site
	getStickyAttributes($ogFuseaction->getName(), $ogFuseaction->getStickyAttributes());

	// loading 'sticky' attributes values from session for this fuseaction
	getStickyAttributes($oFuseaction->getName(), $oFuseaction->getStickyAttributes());

	// these attributes are not needed to identify current page
	$exceptAttributes = array_merge($ogFuseaction->getStickyAttributes(), $oFuseaction->getStickyAttributes());
	$exceptAttributes[] = "fusebox.password";
	$exceptAttributes[] = "fuseaction";
	$exceptAttributes[] = "messages";

	// variable to identify current page
	$here = $self . "?" . serializeAttributes($exceptAttributes);

	// LanguageManager initialization
	$oLanguageManager = new LanguageManager($oDB, $fusebox['tableLanguages']);
	if(!$oLanguageManager->initialize()){
		_throw("FNoLanguagesTable", "There is no languages table called \"{$fusebox['tableLanguages']}\" present in DB");
	}

    // trying to get default language, adding it if not exists
    if(!($oLanguage = $oLanguageManager->getLanguage($fusebox['defaultLanguage'], true))){
        _throw("FCannotSetDefaultLanguage", "Cannot set default language \"{$fusebox['defaultLanguage']}\"");
    }

	// setting language of the site content
	if(isset($attributes['language'])){
		// trying to get given language, but not adding it automatically
        if($otmpLanguage = $oLanguageManager->getLanguage($attributes['language'])){
            $oLanguage = $otmpLanguage;
        }else{
        	_bye("ERROR [FCannotSetGivenLanguage] " . "Cannot set given language \"{$attributes['language']}\"");
        }
        unset($otmpLanguage);
	}

	$oContentManager = new ContentManager($oDB, $oFuseaction, $oLanguage, $fusebox['tableContentTokens'], $fusebox['tableContent'], $fusebox['tableContentComments'], false);
	$ogContentManager = new ContentManager($oDB, $ogFuseaction, $oLanguage, $fusebox['tableContentTokens'], $fusebox['tableContent'], $fusebox['tableContentComments'], false);
	if(!$oContentManager->initialize() || !$ogContentManager->initialize()){
		_throw("FNoContentTable", "There is no content table called \"{$fusebox['tableContent']}\" present in DB");
	}

	$oContentManager->fTitleEditLink = "%s&nbsp;<a href=\"javascript:void(0);\" onClick=\"popupContentForm('" . $myself . "util.showContentForm', %d, '%s', %d, 1);\">Edit</a>";
	$oContentManager->fContentEditLink = "%s&nbsp;<a href=\"javascript:void(0);\" onClick=\"popupContentForm('" . $myself . "util.showContentForm', %d, '%s', %d, 2);\">Edit</a>";

	// caching content for current page
	$oContentManager->cacheContent();
	$ogContentManager->cacheContent();

    // creating developer's content manager
    $oDevContentManager = $oContentManager;
    $ogDevContentManager = $ogContentManager;

	// graphics manager initialization
	$oGraphicsManager = new ContentManager($oDB, $oFuseaction, $oLanguage, $fusebox['tableGraphicsTokens'], $fusebox['tableGraphics'], $fusebox['tableGraphicsComments'], false);
	$ogGraphicsManager = new ContentManager($oDB, $ogFuseaction, $oLanguage, $fusebox['tableGraphicsTokens'], $fusebox['tableGraphics'], $fusebox['tableGraphicsComments'], false);
	if(!$oGraphicsManager->initialize() || !$ogGraphicsManager->initialize()){
		_throw("FNoGraphicsTable", "There is no graphics content table called \"{$fusebox['tableGraphics']}\" present in DB");
	}

	$oGraphicsManager->fHTMLFormat = "<img src=\"" . $fusebox['urlGraphics'] . "%s\" alt=\"%s\">";
	$oGraphicsManager->fHTMLEditLink = "<a href=\"javascript:void(0);\" onClick=\"popupContentForm('" . $myself . "util.showGraphicsForm', %d, '%s', %d, 1);\">Edit</a><br><img src=\"" . $fusebox['urlGraphics'] . "%s\">";

	$ogGraphicsManager->fHTMLFormat = "<img src=\"" . $fusebox['urlGraphics'] . "%s\" alt=\"%s\">";
	$ogGraphicsManager->fHTMLEditLink = "<a href=\"javascript:void(0);\" onClick=\"popupContentForm('" . $myself . "util.showGraphicsForm', %d, '%s', %d, 1);\">Edit</a><br><img src=\"" . $fusebox['urlGraphics'] . "%s\">";

	$oGraphicsManager->cacheContent();
	$ogGraphicsManager->cacheContent();

	// seocontent manager initialization
	$oSEOContentManager = new ContentManager($oDB, $oFuseaction, $oLanguage, $fusebox['tableSEOContentTokens'], $fusebox['tableSEOContent'], $fusebox['tableSEOContentComments'], false);
	$ogSEOContentManager = new ContentManager($oDB, $ogFuseaction, $oLanguage, $fusebox['tableSEOContentTokens'], $fusebox['tableSEOContent'], $fusebox['tableSEOContentComments'], false);
	if(!$oSEOContentManager->initialize() || !$ogSEOContentManager->initialize()){
		_throw("FNoSEOContentTable", "There is no seocontent table called \"{$fusebox['tableSEOContent']}\" present in DB");
	}

	// caching seocontent for current page
	$oSEOContentManager->cacheContent();
	$ogSEOContentManager->cacheContent();

	// mail templates initialization
	$ogMailTemplatesManager = new ContentManager($oDB, $ogFuseaction, $oLanguage, $fusebox['tableMailTemplatesTokens'], $fusebox['tableMailTemplates'], $fusebox['tableMailTemplatesComments'], false);

	// checking if all is correct
	if(!$ogMailTemplatesManager->initialize()){
		_throw("FNoMailTemplatesTable", "There is no mail temlates table called \"{$fusebox['tableMailTemplates']}\" present in DB");
	}

	// settings manager initialization
	$oSettingsManager = new SettingsManager($oDB, $fusebox['tableSettings']);
	if(!$oSettingsManager->initialize()){
		_throw("FNoSettingsTable", "There is no settings table called \"{$fusebox['tableSettings']}\" present in DB");
	}

	// retrieving settings
	$oSettingsManager->cacheSettings();

	// set website timezone
	date_default_timezone_set($oSettingsManager->getValue("TimeZone", $fusebox['defaultTimeZone'], "STRING", "Default timezone for website"));

	$oPropertyManager = new PropertyManager($oDB, $fusebox['tableProperties'], $fusebox['tableDictionary']);

	// user manager initialization
	$oUserManager = new UserManager($oDB, $fusebox['tableUsers'], $fusebox['defaultUser'], $fusebox['developer'], $fusebox['password']);
	if(!$oUserManager->initialize()){
		_throw("FNoUsersTable", "There is no users table called \"{$fusebox['tableUsers']}\" present in DB");
	}

	// adding or checking existence of developer, setting developer password to default
	if(!$oUserManager->resetPassword($fusebox['developer'], 0, $fusebox['password'])){
		if(!$oUserManager->checkUser($fusebox['developer'])){
			$oDev = new User (0, $fusebox['developer']);
			$oDev->setRegisteredDate();
			$oDev->setPassword($fusebox['password']);
			if($oUserManager->addUser($oDev)){
				if(!($oDev = $oUserManager->getUser($fusebox['developer']))){
					_throw("FNoDeveloperUserFound", "No developer found... again! DB corrupted ?");
				}
				unset($oDev);
			}else{
				_throw("FCannotAddDeveloper", "Cannot add developer");
			}
		}else{
			_throw("FCannotResetDeveloperPassword", "Cannot reset password for developer");
		}
	}


	// getting user
	$boolFreshUser = false;
	if(!isset($oUser) || !is_a($oUser, "User")){
		if($oUserManager->checkUser($fusebox['defaultUser'])){
			if(!($oUser = $oUserManager->getUser($fusebox['defaultUser']))){
				_throw("FNoDefaultUser", "No default user found");
			}
		}else{
			$oUser = new User (0, $fusebox['defaultUser']);
			$oUser->setRegisteredDate();
			if($oUserManager->addUser($oUser)){
				if(!($oUser = $oUserManager->getUser($fusebox['defaultUser']))){
					_throw("FStillNoDefaultUser", "No default user found... again! DB corrupted ?");
				}
			}else{
				_throw("FCannotAddDefaultUser", "Cannot add default user");
			}
		}
		// setting unique name for visitor to track activity
		$oUser->setFirstName(strtoupper($oUser->getLogin()));
		$oUser->setMiddleName(chr(rand(65, 90)));
		$oUser->setLastName(rand(0, 9999999));
		$oUser->setUserAgent($_SERVER['HTTP_USER_AGENT']);
		$oUser->setCurrentVisitIP($_SERVER['REMOTE_ADDR']);
		$oUser->setCurrentVisitMoment(date('Y-m-d H:i:s'));
		$boolFreshUser = true;
	}


    // planting an article tree
    $ogArticleTree = new NSTree($oDB, $fusebox['tableArticlesTree'], $fusebox['tableArticlesTokens']);
    if(!$ogArticleTree->initialize(array('token' => $fusebox['defaultArticleRoot'], 'id_author' => $oUser->getID(), 'moment' => date("Y-m-d H:i:s")))){
        _throw("FNoArticlesTables", "There is no articles tree table \"{$fusebox['tableArticlesTree']}\" or articles tokens table \"{$fusebox['tableArticlesTokens']}\" present in DB");
    }

    // adding article manager
    $ogArticleManager = new ContentManager($oDB, $ogFuseaction, $oLanguage, $fusebox['tableArticlesTokens'], $fusebox['tableArticles'], $fusebox['tableArticlesComments'], false);

	// setting authorship
	$ogArticleManager->fAuthorID = $oUser->getID();
	$ogArticleManager->fEditorID = $oUser->getID();

    // running dry
    if(!$ogArticleManager->initialize()){
        _throw("FNoArticlesTable", "There is no articles table called \"{$fusebox['tableArticles']}\" present in DB");
    }

    $ogArticleManager->fTitleEditLink = "%s&nbsp;<a href=\"javascript:void(0);\" onClick=\"popupContentForm('" . $myself . "util.showArticleForm', %d, '%s', %d, 1);\">Edit</a>";
    $ogArticleManager->fContentEditLink = "%s&nbsp;<a href=\"javascript:void(0);\" onClick=\"popupContentForm('" . $myself . "util.showArticleForm', %d, '%s', %d, 2);\">Edit</a>";

    $ogArticleAttachmentManager = new ArticleAttachmentManager($oDB, $ogArticleManager, $fusebox['tableArticleAttachments']);

    // creating gallery manager
    $ogGalleryManager = new GalleryManager($oDB, $oLanguage, $fusebox['tableGalleriesTokens'], $fusebox['tableGalleries'], $fusebox['tableImagesTokens'], $fusebox['tableImages'], $fusebox['tableGalleriesComments'], $fusebox['tableImagesComments']);

    // setting authorship
	$ogGalleryManager->fAuthorID = $oUser->getID();
	$ogGalleryManager->fEditorID = $oUser->getID();

    // bringing up
    if(!$ogGalleryManager->initialize()){
    	_throw("FNoGalleryTables", "There is no gallery and images tables present in DB");
    }


	// security managers initialization (for current FA and 'global' for entire site)
	if(($fusebox['mode'] == "development") || $oUser->isDev()){
		$oSecurityManager = new SecurityManager($oDB, $oUser, $oFuseaction, $fusebox['tableSecurity'], $fusebox['tableGroups'], $fusebox['tableUsersGroups'], $fusebox['defaultGroup'], SECURITYMODE_LOOSE, true);
		$ogSecurityManager = new SecurityManager($oDB, $oUser, $ogFuseaction, $fusebox['tableSecurity'], $fusebox['tableGroups'], $fusebox['tableUsersGroups'], $fusebox['defaultGroup'], SECURITYMODE_LOOSE, true);
	}else{
		if($fusebox['globalSecurityMode'] == "STRICT"){
			$oSecurityManager = new SecurityManager($oDB, $oUser, $oFuseaction, $fusebox['tableSecurity'], $fusebox['tableGroups'], $fusebox['tableUsersGroups'], $fusebox['defaultGroup'], SECURITYMODE_STRICT, false);
			$ogSecurityManager = new SecurityManager($oDB, $oUser, $ogFuseaction, $fusebox['tableSecurity'], $fusebox['tableGroups'], $fusebox['tableUsersGroups'], $fusebox['defaultGroup'], SECURITYMODE_STRICT, false);
		}elseif($fusebox['globalSecurityMode'] == "LOOSE"){
			$oSecurityManager = new SecurityManager($oDB, $oUser, $oFuseaction, $fusebox['tableSecurity'], $fusebox['tableGroups'], $fusebox['tableUsersGroups'], $fusebox['defaultGroup'], SECURITYMODE_LOOSE, false);
			$ogSecurityManager = new SecurityManager($oDB, $oUser, $ogFuseaction, $fusebox['tableSecurity'], $fusebox['tableGroups'], $fusebox['tableUsersGroups'], $fusebox['defaultGroup'], SECURITYMODE_LOOSE, false);
		}else{
			_throw("FUncertainSecurityMode", "Security mode is uncertain");
		}
	}

	if(!$oSecurityManager->initialize() || !$ogSecurityManager->initialize()){
		_throw("FNoSecurityTables", "There are no security tables \"{$fusebox['tableGroups']}\" and/or \"{$fusebox['tableSecurity']}\" present in DB");
	}

	// checking that default user group exists and add it if needed
	if(!$oSecurityManager->checkGroup($fusebox['defaultGroup'])){
		$tmpoGroup = new Group(0, $fusebox['defaultGroup']);
		if($oSecurityManager->addGroup($tmpoGroup)){
			unset($tmpoGroup);
		}else{
			_throw("FCannotAddDefaultGroup", "Cannot add default security group");
		}
	}

	// check if user is default user then make him belong to default group only
	if($defaultGroup = $oSecurityManager->getGroup($fusebox['defaultGroup'])){
		if($oUser->isDefaultUser()){
			if(!$oSecurityManager->setUserGroups(array($defaultGroup))){
				_throw("FCannotSetDefaultGroupToDefaultUser", "Cannot make default user belong to default group");
			}
		}
	}else{
		_throw("FNoDefaultGroup", "No default group present");
	}

    // checking if default registrant groups exists and add if needed
    if(strlen($fusebox['defaultRegistrantGroups']) > 0){
        $tmparrRegistrantGroups = explode(",", $fusebox['defaultRegistrantGroups']);
        if(count($tmparrRegistrantGroups) > 0){
        	foreach($tmparrRegistrantGroups as $g){
        		if(!$oSecurityManager->checkGroup($g)){
                    $tmpoGroup = new Group(0, $g);
                    if($oSecurityManager->addGroup($tmpoGroup)){
                        unset($tmpoGroup);
                    }else{
                        _throw("FCannotAddDefaultRegistrantGroup", "Cannot add default registrant security group");
                    }
                }
        	}
        }
    }
    unset($tmparrRegistrantGroups);

	// sync'ing security with db
	if(($fusebox['mode'] == "development") || $oUser->isDev()){
		if(!$oSecurityManager->synchronizeSecurity($oFuseManager->getFuseactions())){
			_throw("FCannotSynchronizeSecurity", "Cannot synchronize security");
		}
	}

	// caching security tokens for better performance
	$oSecurityManager->cacheSecurity();
	$ogSecurityManager->cacheSecurity();

    // set content management mode - just view or direct edit
    $attributes['cmsmode'] = isset($attributes['cmsmode']) ? $attributes['cmsmode'] : $fusebox['defaultCMSMode'];

	// checking if user allowed to edit content
	if($ogSecurityManager->granted("ContentManagement") && ($attributes['cmsmode'] == "EDIT")){
		$oContentManager->fEditModeOn = true;
		$oGraphicsManager->fEditModeOn = true;
        $ogArticleManager->fEditModeOn = true;
	}

	// initializing log manager
	$oLogManager = new LogManager($oDB, $oFuseaction, $oUser, $fusebox['tableLog'], $fusebox['logRotatePeriod'], $fusebox['logEvents']);

	if(!$oLogManager->initialize()){
		_throw("FNoLogTable", "There is no log table \"{$fusebox['tableLog']}\" present in DB");
	}

	// logging new user in
	if($boolFreshUser){
		_log("New visitor " . $oUser->getFullName() . " just came in, welcome !", "INewVisitor");
		_log($oUser->getFullName() . " uses " . $oUser->getUserAgent());
	}
	unset($boolFreshUser);

	$oImageManager = new ImageManager();
	$oFileManager = new FileManager();

	$oSitemap = new SitemapManager($oDB, array('sitemap' => $fusebox['tableSitemap']));
	if(!$oSitemap->initialize()){
		_throw("FCannotInitializeSitemapManager", $oSitemap->getLastError());
	}

	//TODO check if smarty has caching abilities
	// adding Smarty
	$smarty = new Smarty();
	$smarty->template_dir = $fusebox['pathSmartyTemplates'];
	$smarty->compile_dir  = $fusebox['pathSmartyTemplatesCompiled'];
	$smarty->assign("self", $self);
	$smarty->assign("myself", $myself);
	$smarty->assign("here", $here);

    _assign_by_ref("oU", $oUser);
	_assign_by_ref("oF", $oFuseaction);
	_assign_by_ref("ogF", $ogFuseaction);
	_assign_by_ref("oL", $oLanguage);
    _assign_by_ref("oLM", $oLanguageManager);
	_assign_by_ref("oCM", $oContentManager);
	_assign_by_ref("ogCM", $ogContentManager);
	_assign_by_ref("oGM", $oGraphicsManager);
	_assign_by_ref("ogGM", $ogGraphicsManager);
	_assign_by_ref("oSCM", $oSEOContentManager);
	_assign_by_ref("ogSCM", $ogSEOContentManager);
    _assign_by_ref("oDCM", $oDevContentManager);
    _assign_by_ref("ogDCM", $ogDevContentManager);
	_assign_by_ref("oSM", $oSecurityManager);
	_assign_by_ref("ogSM", $ogSecurityManager);
	_assign_by_ref("ogMTM", $ogMailTemplatesManager);
	_assign_by_ref("oPM", $oPropertyManager);
    _assign_by_ref("ogAT", $ogArticleTree);
    _assign_by_ref("ogAM", $ogArticleManager);
    _assign_by_ref("ogGaM", $ogGalleryManager);

	_log($attributes['fuseaction'] . " started", "IFuseactionStarted", "I", $here);


?>