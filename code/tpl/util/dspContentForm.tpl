<html>
<head>
	<link rel="shortcut icon" href="{$application.fusebox.urlAssets}favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="{$application.fusebox.urlAssets}styles/clone.css" type="text/css" />
</head>
<body>
{literal}
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="{/literal}{$application.fusebox.urlAssets}{literal}scripts/tiny_mce/tiny_mce_gzip.php"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",

	    elements: "ta",

		theme_advanced_path_location : "bottom",
		plugins : "directionality,table,style,insertdatetime,preview,searchreplace,print,paste,noneditable,ibrowser,emotions,simage",
		content_css : "{/literal}{$application.fusebox.urlAssets}{literal}styles/clone.css",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_resize_horizontal : false,
		theme_advanced_resizing : true,
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "ibrowser,separator,insertdate,inserttime,preview,separator,forecolor,backcolor,separator,simage",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",

 		convert_urls : false,
 		apply_source_formatting : true,

 		plugin_simage_action: "{/literal}{$application.fusebox.urlBase}{$myself}{literal}util.showContentUploadForm", // fuseaction to execute to upload
 		plugin_simage_path: "{/literal}{$application.fusebox.urlContent}{literal}", // path to store images

		editor_selector : "mce"

	});
</script>
<!-- /tinyMCE -->
{/literal}
<div id="main">
<div id="leftside">
<h2>Edit content fragment</h2>
	<form action="{$myself}util.storeContent" method="post">
		<input type="hidden" name="fuseactionid" value="{$tmpoFuseaction->getID()}">
		<input type="hidden" name="token" value="{$attributes.token}">		
		<table>
			{if $oU->isDev()}
			<tr><td>Description: <input type="text" size="55" name="description" value="{$oCM->pullDescription($tmpoFuseaction->getID(), $attributes.token)|escape}"></td></tr>
			{/if}
			{foreach from=$arrLanguages item=l}
			<tr>
				{if $attributes.formdisplaymode eq 0 or $attributes.formdisplaymode eq 1}
					<td>Title: <input type="text" size="55" name="title_{$l->getID()}" value="{$oCM->pullTitleEncoded($tmpoFuseaction->getID(), $l->getID(), $attributes.token, $l->getEncoding(), "", false)}"></td>
				{/if}
				{if $attributes.formdisplaymode eq 0 or $attributes.formdisplaymode eq 2}
					<td><textarea name="content_{$l->getID()}" class="mce" style="width:50%" rows="20">{$oCM->pullContentEncoded($tmpoFuseaction->getID(), $l->getID(), $attributes.token, $l->getEncoding(), "", false)}</textarea></td>
				{/if}
			</tr>
			{/foreach}
		</table>
	<input type="Submit" value="Store content">
	<br>
	NOTE: this is content for token "{$attributes.token}" on {$tmpoFuseaction->getDescription()} ({$tmpoFuseaction->getName()}) in {$l->getName()}. Your changes will not affect content for other pages and in other languages.
	</form>
</div>
</div>
</body>
</html>