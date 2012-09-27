<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>{$oF->getDescription()}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="Content-Language" content="en-US">
  <link rel="shortcut icon" href="{$application.fusebox.urlAssets}favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="{$application.fusebox.urlAssets}styles/style.css" type="text/css" />
  <link rel="StyleSheet" href="{$application.fusebox.urlAssets}styles/dtree.css" type="text/css" />
  <link rel="StyleSheet" href="{$application.fusebox.urlAssets}styles/ui.theme.css" type="text/css" />
  <script type="text/javascript" src="{$application.fusebox.urlAssets}scripts/common.js"></script>
  <script type="text/javascript" src="{$application.fusebox.urlAssets}scripts/admin.js"></script>
  <script type="text/javascript" src="{$application.fusebox.urlAssets}scripts/dtree.js"></script>
  <script type="text/javascript" src="{$application.fusebox.urlAssets}scripts/jquery.js"></script>
  

  <script type="text/javascript" src="{$application.fusebox.urlAssets}scripts/jquery-ui.js"></script>
  <base href="{$application.fusebox.urlBase}" />
</head>
<body>

<h1>Administrator&rsquo;s back-end</h1>
   <h2>Dark side of the site</h2>

<ul id="navigation">
   <li><a href="{$myself}{$fusebox.defaultFuseaction}" title="Home"><span>Home</span></a></li>
</ul>

<div id="side-col">
    {if $ogSM->granted("MENUMyProfile")}
      <h2>My profile</h2>
        <ul id="services">
          <li><a href="{$myself}home.showRegistrationForm" title="My Profile">My Profile</a><br />
          {if $ogSM->granted("LoginName")}
          {$oU->getFullName()} ({$oU->getLogin()})<br />
          {/if}
          {if $ogSM->granted("MENULogout")}
          <a href="{$myself}{$application.fusebox.xfaLogout}">Log out</a></li>
          {/if}
        </ul>
    {/if}
    {if $ogSM->granted("MENUAdministrator")}
      <h2>Administrator</h2>
        <ul id="services">
          <li><a href="{$myself}admin.showUsers">Users</a><br />
          <a href="{$myself}admin.showSettings">Settings</a><br />
          <a href="{$myself}admin.showProperties">Properties</a></li>
        </ul>
    {/if}
    {if $ogSM->granted("MENUContent")}
      <h2>Content manager</h2>
        <ul id="services">
          <li><a href="{$myself}admin.showArticlesTree">Articles</a><br />
          <a href="{$myself}admin.showGalleries">Galleries</a><br />
          <a href="{$myself}admin.showContentPages">Content</a><br />
          <a href="{$myself}admin.showGraphicsPages">Graphics</a><br />
          <a href="{$myself}admin.showMailTemplates">Mails</a><br />
          <a href="{$myself}admin.showSEOPages">SEO</a><br />
          Fast edit:
            {if $attributes.cmsmode eq "EDIT"}
              On (<a href="{$here}&amp;cmsmode=VIEW">Turn Off</a>)
            {else}
              Off (<a href="{$here}&amp;cmsmode=EDIT">Turn On</a>)
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









