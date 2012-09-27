<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>{$oSCM->getContentReplaced("Title")} {$ogSCM->getContentReplaced("Title")}</title>
  <meta http-equiv="Content-Type" content="text/html; charset={$oL->getEncoding()}" />
  <meta http-equiv="Content-Language" content="{$oL->getContentLanguage()}" />
  <meta name="keywords" content="{$oSCM->getContentReplaced("Keywords")}{$ogSCM->getContentReplaced("Keywords")}" />
  <meta name="description" content="{$oSCM->getContentReplaced("Description")}{$ogSCM->getContentReplaced("Description")}" />
  <meta name="robots" content="{$oSCM->getContentReplaced("Robots")}{$ogSCM->getContentReplaced("Robots")}" />
  <link rel="shortcut icon" href="{$application.fusebox.urlAssets}favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="{$application.fusebox.urlAssets}styles/style.css" type="text/css" media="screen" />
  <script type="text/javascript" src="{$application.fusebox.urlAssets}scripts/common.js"></script>
  <base href="{$application.fusebox.urlBase}" />
</head>
<body>

<h1>{$ogCM->getContent("SiteTitle", "Clone 4B2 CMS")}</h1>
   <h2>{$ogCM->getContent("Header", "...and may the force be with you.")}</h2>
      {if count($arrHeaderLanguages) gt 1}
      <div id="lang_panel">
        {* $ogCM->getContent("ChooseLanguage", "Choose Language") *}
        {foreach from=$arrHeaderLanguages item=hl}
          {if $oL->getCode() eq $hl->getCode()}
            {$hl->getName()}
          {else}
            <a href="{$here}&amp;language={$hl->getCode()}">{$hl->getName()}</a>
          {/if}
        {/foreach}
      </div>
      {/if}
<ul id="navigation">
  <li><a href="{$oL->getCode()}/{$arrRootArticle.token}.page"><span>{if $ogAM->getTitle($arrRootArticle.token)}{$ogAM->getTitle($arrRootArticle.token)}{elseif $ogAM->getDescription($arrRootArticle.token)}{$ogAM->getDescription($arrRootArticle.token)}{else}{$arrRootArticle.token}{/if}</span></a></li>
  {if !empty($arrArticleFamily[1])}
    {foreach from=$arrArticleFamily[1] item=a}
  <li><a href="{$oL->getCode()}/{$a.token}.page"><span>{if $ogAM->getTitle($a.token)}{$ogAM->getTitle($a.token)}{elseif $ogAM->getDescription($a.token)}{$ogAM->getDescription($a.token)}{else}{$arrRootArticle.token}{/if}</span></a></li>
    {/foreach}
  {/if}
  {if $ogSM->granted("ContactForm")}
  <li><a href="{$myself}home.showContactForm"><span>{$ogCM->getContent("ContactUs", "Contact Us")}</span></a></li>
  {/if}
</ul>

<div id="side-col">
      {if !empty($arrArticleFamily[2])}
      <h2>{$ogCM->getContent("Articles", "Articles")}</h2>
        <ul id="services">
            <li id="articles">
            {foreach from=$arrArticleFamily[2] item=a}
              {if !empty($a.is_ancestor_branch)}
          		{if $ogAM->getTitle($a.token)}{$ogAM->getTitle($a.token)}{else}{$ogAM->getDescription($a.token)}{/if}
          	  {else}
            	<div><a href="{$oL->getCode()}/{$a.token}.page">{if $ogAM->getTitle($a.token)}{$ogAM->getTitle($a.token)}{else}{$ogAM->getDescription($a.token)}{/if}</a></div>
          	  {/if}          
            {/foreach}
          </li>
        </ul>
      {/if}
    {if $arrGalleries}
      <h2>{$ogCM->getContent("Galleries", "Galleries")}</h2>
        <ul id="services">
          <li id="galleries">
          {foreach from=$arrGalleries item=g}
          {if isset($attributes.gallery) && $attributes.gallery == $g.token}
          {if $ogGaM->getGalleryTitle($g.token)}{$ogGaM->getGalleryTitle($g.token)}{else}{$ogGaM->getGalleryDescription($g.token)}{/if}
          {else}
          <a href="{$oL->getCode()}/{$g.token}.gallery">{if $ogGaM->getGalleryTitle($g.token)}{$ogGaM->getGalleryTitle($g.token)}{else}{$ogGaM->getGalleryDescription($g.token)}{/if}</a>
          {/if}
          <br />
          {/foreach}
          </li>
        </ul>
    {/if}
    <h2>{$ogCM->getContent("ViewAll", "View all")}</h2>
        <ul id="services">
          <li id="articles"><a href="{$myself}home.showArticles" title="{$ogCM->getContent("MENUArticles", "Articles")}">{$ogCM->getContent("MENUArticles", "Articles")}</a></li>
          <li id="galleries"><a href="{$myself}home.showGalleries" title="{$ogCM->getContent("MENUGalleries", "Galleries")}">{$ogCM->getContent("MENUGalleries", "Galleries")}</a></li>
        </ul>
    <h2>{$ogCM->getContent("Search", "Search")}</h2>
        <form method="post" action="{$myself}home.showSearchResults">
	        <ul id="services">
	            <li><input id="mainsearch" type="text" name="fSearch" {if $attributes.fSearch}value="{$attributes.fSearch}"{/if}/><input id="mainsearchgo" type="submit" value="Go" />
	        </ul>
        </form>
	 <h2>{$ogCM->getContent("Subscribe", "Subscribe")}</h2>
        <ul id="services">
          <li id="rss"><a href="{$myself}util.generateArticleFeed&amp;language={$oL->getCode()}" title="{$ogCM->getContent("MENUArticles", "Articles")}">{$ogCM->getContent("MENUArticles", "Articles")}</a></li>
          {*
          <li id="rss"><a href="{$myself}home.generateGalleryFeed" title="{$ogCM->getContent("MENUGalleries", "Galleries")}">{$ogCM->getContent("MENUGalleries", "Galleries")}</a></li>
          *}
        </ul>
    {if $ogSM->granted("MENUMyProfile")}
    <h2>{$ogCM->getContent("MyProfile", "My Profile")}</h2>
          <ul id="services">
          <li><a href="{$myself}home.showRegistrationForm" title="{$ogCM->getContent("MyProfile", "My Profile")}">{$ogCM->getContent("MyProfile", "My Profile")}</a><br />
          {if $ogSM->granted("LoginName")}
          {$oU->getFullName()} ({$oU->getLogin()})<br />
          {/if}
          {if $ogSM->granted("MENULogout")}
          <a href="{$myself}{$application.fusebox.xfaLogout}">{$ogCM->getContent("LogOut", "Log Out")}</a><br />
          {/if}
          {if $ogSM->granted("MENURegistration")}
          <a href="{$myself}home.showRegistrationForm" title="{$ogCM->getContent("Register", "Register")}">{$ogCM->getContent("Register", "Register")}</a><br />
          {/if}
          {if $ogSM->granted("MENULogin")}
          <a href="{$myself}home.showLoginForm" title="{$ogCM->getContent("Login", "Login")}">{$ogCM->getContent("Login", "Login")}</a></li>
          {/if}
          </ul>
    {/if}
    {if $ogSM->granted("MENUAdministrator")}
      <h2>{$ogCM->getContent("Administrator", "Administrator")}</h2>
        <ul id="services">
          <li><a href="{$myself}admin.showUsers">{$ogCM->getContent("Users", "Users")}</a><br />
          <a href="{$myself}admin.showSettings">{$ogCM->getContent("Settings", "Settings")}</a><br />
          <a href="{$myself}admin.showProperties">{$ogCM->getContent("Properties", "Properties")}</a></li>
        </ul>
    {/if}
        {if $ogSM->granted("MENUContent")}
      <h2>{$ogCM->getContent("ContentManager", "Content Manager")}</h2>
        <ul id="services">
          <li><a href="{$myself}admin.showArticlesTree">{$ogCM->getContent("Articles", "Articles")}</a><br />
          <a href="{$myself}admin.showGalleries">{$ogCM->getContent("Galleries", "Galleries")}</a><br />
          <a href="{$myself}admin.showContentPages">{$ogCM->getContent("Content", "Content")}</a><br />
          <a href="{$myself}admin.showGraphicsPages">{$ogCM->getContent("Graphics", "Graphics")}</a><br />
          <a href="{$myself}admin.showMailTemplates">{$ogCM->getContent("MailTemplates", "Mails")}</a><br />
          <a href="{$myself}admin.showSEOPages">{$ogCM->getContent("SEO", "SEO")}</a><br />

            {$ogCM->getContent("FastEdit", "Fast edit")}:
            {if $attributes.cmsmode eq "EDIT"}
              {$ogCM->getContent("On", "On")} (<a href="{$here}&amp;cmsmode=VIEW">{$ogCM->getContent("TurnOff", "Turn Off")}</a>)
            {else}
              {$ogCM->getContent("Off", "Off")} (<a href="{$here}&amp;cmsmode=EDIT">{$ogCM->getContent("TurnOn", "Turn On")}</a>)
            {/if}
          </li>
        </ul>
    {/if}
    {if $oU->isDev()}
      <h2>Developer</h2>
        <ul id="services">
          <li><a href="{$myself}admin.showFuseactions">Fuseactions</a><br />
          <a href="{$myself}admin.showGroups">Groups</a><br />
          <a href="{$myself}admin.showLanguages">Languages</a><br />
          <a href="{$myself}admin.showSpecification">Spec</a><br />
          <a href="{$myself}admin.showFuseaction&amp;id={$oF->getID()}" target="_blank">This page</a><br />
          <a href="{$myself}admin.showLog">Log</a><br />
          <a href="{$fusebox.filesLog}" target="_blank">Log file</a><br />
          <a href="{$fusebox.filesDump}" target="_blank">Dump file</a></li>
        </ul>
    {/if}
   <h3>{$ogCM->getTitle("HotText", "")}</h3>
   <p>
      {$ogCM->getContent("HotText", "")}
   </p>
   <p id="quote-link">
      {$ogCM->getContent("HotLink", "")}
   </p>
</div>

<div id="main-content">
     {if $application.globalWarningsQueue or $application.globalMessagesQueue}
  <div id="warning">
    {if $application.globalWarningsQueue}
    <h3>Warning</h3>
        {foreach from=$application.globalWarningsQueue item=e key=k}
          <p>{$e}</p>
        {/foreach}
    {/if}
    {if $application.globalMessagesQueue}
    <h3>Message</h3>
        {foreach from=$application.globalMessagesQueue item=e key=k}
          <p>{$e}</p>
        {/foreach}
    {/if}
  </div>
  {/if}










