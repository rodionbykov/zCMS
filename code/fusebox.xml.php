<?xml version="1.0" encoding="UTF-8"?>
<fusebox>
	<circuits>
		<circuit alias="home" path="circuits/home/" parent="" />
		<circuit alias="admin" path="circuits/admin/" parent="" />
		<circuit alias="util" path="circuits/util/" parent="" />
	</circuits>

	<parameters>
		<parameter name="fuseactionVariable" value="do" />
		<parameter name="defaultFuseaction" value="home.showArticle" />
		<parameter name="precedenceFormOrUrl" value="form" />
		<parameter name="mode" value="development" />
		<parameter name="password" value="dev" />
		<parameter name="parseWithComments" value="true" />
		<parameter name="scriptLanguage" value="php4" />
		<parameter name="scriptFileDelimiter" value="php" />
		<parameter name="maskedFileDelimiters" value="htm,cfm,cfml,php,php4,asp,aspx" />
		<parameter name="characterEncoding" value="utf-8" />
		<parameter name="parseWithIndentation" value="true" />
		<parameter name="conditionalParse" value="true" />
		<parameter name="allowLexicon" value="true" />
		<parameter name="ignoreBadGrammar" value="true" />
		<parameter name="useAssertions" value="false" />

		<parameter name="developer" value="dev" />
		<parameter name="debug" value="false" />
		<parameter name="filesInitialization" value="mySession.php;myGlobals.php;myMessages.php;myInitialization.php" />
		<parameter name="filesFinalization" value="myFinalization.php" />
		<parameter name="filesLog" value="_log.txt" />
		<parameter name="filesDump" value="_dump.txt" />
		<parameter name="filesServer" value="server.xml.php" />
		<parameter name="pathSmartyTemplates" value="tpl/" />
		<parameter name="pathSmartyTemplatesCompiled" value="_tpl_c/" />
		<parameter name="pathSession" value="_tmp/" />
		<parameter name="pathAssets" value="assets/" />
		<parameter name="pathContent" value="_content/" />
        <parameter name="pathGraphics"  value="_content/graphics/" />
        <parameter name="pathGalleries"  value="_content/galleries/" />
        <parameter name="pathArticleAttachment"  value="_content/article_attachments/" />
		<parameter name="folderThumbs" value="thumbs" />
        <parameter name="dbHost" value="localhost" />
		<parameter name="dbLogin" value="root" />
		<parameter name="dbPassword" value="" />
		<parameter name="dbName" value="cms" />
		<parameter name="dbPort" value="3306" />
		<parameter name="urlBase" value="" />
		<parameter name="tableFuseactions" value="pages" />
		<parameter name="tableLanguages" value="languages" />
		<parameter name="tableContentTokens" value="contenttokens" />
		<parameter name="tableContent" value="content" />
		<parameter name="tableContentComments" value="contentcomments" />
		<parameter name="tableGraphicsTokens" value="graphicstokens" />
		<parameter name="tableGraphics" value="graphics" />
		<parameter name="tableGraphicsComments" value="graphicscomments" />
		<parameter name="tableSEOContentTokens" value="seocontenttokens" />
		<parameter name="tableSEOContent" value="seocontent" />
		<parameter name="tableSEOContentComments" value="seocontentcomments" />
		<parameter name="tableMailTemplatesTokens" value="mailtemplatestokens" />
		<parameter name="tableMailTemplates" value="mailtemplates" />
		<parameter name="tableMailTemplatesComments" value="mailtemplatescomments" />
		<parameter name="tableSettings" value="settings" />
		<parameter name="tableUsers" value="users" />
		<parameter name="tableGroups" value="groups" />
		<parameter name="tableSecurity" value="security" />
		<parameter name="tableUsersGroups" value="users_groups" />
		<parameter name="tableLog" value="syslog" />
		<parameter name="tableProperties" value="properties" />
		<parameter name="tableDictionary" value="dictionary" />
        <parameter name="tableArticlesTree" value="articlestree" />
        <parameter name="tableArticlesTokens" value="articlestokens" />
        <parameter name="tableArticles" value="articles" />
        <parameter name="tableArticlesComments" value="articlescomments" />
        <parameter name="tableArticleAttachments" value="articleattachments" />
        <parameter name="tableGalleriesTokens" value="galleriestokens" />
        <parameter name="tableGalleries" value="galleries" />
        <parameter name="tableGalleriesComments" value="galleriescomments" />
        <parameter name="tableImagesTokens" value="imagestokens" />
        <parameter name="tableImages" value="images" />
        <parameter name="tableImagesComments" value="imagescomments" />
		<parameter name="tableSitemap" value="sitemap" />
		<parameter name="defaultLanguage" value="en" />
		<parameter name="defaultCMSMode" value="VIEW" />
		<parameter name="defaultUser" value="visitor" />
		<parameter name="defaultGroup" value="visitors" />
        <parameter name="defaultRegistrantGroups" value="users" />
        <parameter name="defaultArticleRoot" value="Home" />
        <parameter name="defaultTimeZone" value="America/New_York" />
		<parameter name="xfaLogin" value="home.login" />
		<parameter name="xfaLogout" value="home.logout" />
		<parameter name="xfaAccessDenied" value="home.showAccessDenied" />
		<parameter name="xfaLoginForm" value="home.showLoginForm" />
		<parameter name="globalSecurityMode" value="STRICT" />
		<parameter name="globalFuseaction" value="whole.site" />
		<parameter name="globalStickyAttributes" value="language,cmsmode" />
		<parameter name="logRotatePeriod" value="7" />
		<parameter name="logEvents" value="I,M,W,E" />
        <parameter name="maxArticleTreeLevel" value="2" />
	</parameters>

	<classes>
	</classes>

	<lexicons>
	</lexicons>

	<globalfuseactions>
		<preprocess>
		</preprocess>
		<postprocess>
		</postprocess>
	</globalfuseactions>

	<plugins>
		<phase name="preProcess">
			<plugin name="smarty" template="3rdparty/smarty/Smarty.class.php" />
			<plugin name="phpmailer" template="3rdparty/class.phpmailer.php" />
			<plugin name="db" template="classes/DB.class.php" />
			<plugin name="multipleentity" template="classes/MultipleEntity.class.php" path="" />
			<plugin name="file" template="classes/File.class.php" />
			<plugin name="image" template="classes/Image.class.php" />
			<plugin name="fileManager" template="classes/FileManager.class.php" />
			<plugin name="imageManager" template="classes/ImageManager.class.php" />
			<plugin name="fuseaction" template="classes/Fuseaction.class.php" />
			<plugin name="language" template="classes/Language.class.php" />
			<plugin name="user" template="classes/User.class.php" />
			<plugin name="group" template="classes/Group.class.php" />
			<plugin name="paging" template="classes/Paging.class.php" />
            <plugin name="captcha" template="classes/Captcha.class.php" />
			<plugin name="fusemanager" template="classes/FuseManager.class.php" />
			<plugin name="languagemanager" template="classes/LanguageManager.class.php" />
			<plugin name="contentmanager" template="classes/ContentManager.class.php" />
			<plugin name="settingsmanager" template="classes/SettingsManager.class.php" />
			<plugin name="propertymanager" template="classes/PropertyManager.class.php" />
			<plugin name="usersmanager" template="classes/UserManager.class.php" />
			<plugin name="securitymanager" template="classes/SecurityManager.class.php" />
			<plugin name="logmanager" template="classes/LogManager.class.php" />
            <plugin name="tree" template="classes/NSTree.class.php" />
            <plugin name="gallerymanager" template="classes/GalleryManager.class.php" />
			<plugin name="articleattachmentmanager" template="classes/ArticleAttachmentManager.class.php" />
            <plugin name="feeditem" template="3rdparty/FeedItem.php" />
            <plugin name="feedwriter" template="3rdparty/FeedWriter.php" />
			<plugin name="sitemap" template="classes/SitemapManager.class.php" path="" />
			<plugin name="initialization" template="Initialization.plugin.php" path="" />
			<plugin name="debug" template="ShowDebug.plugin.php" path="" />
		</phase>
		<phase name="preFuseaction">
			<plugin name="securityCheck" template="SecurityCheck.plugin.php" />
		</phase>
		<phase name="fuseactionException">
		</phase>
		<phase name="processError">
		</phase>
		<phase name="postFuseaction">
		</phase>
		<phase name="postProcess">
			<plugin name="finalization" template="Finalization.plugin.php" path="" />
			<plugin name="display" template="Display.plugin.php" path="" />
			<plugin name="debug" template="ShowDebug.plugin.php" path="" />
		</phase>
	</plugins>

</fusebox>
