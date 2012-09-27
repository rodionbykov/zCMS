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
		theme_advanced_buttons2_add : "insertdate,inserttime,preview,separator,forecolor,backcolor",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",

 		convert_urls : false,
 		apply_source_formatting : true,
 		verify_html : false,

 		plugin_simage_action: "{/literal}{$application.fusebox.urlBase}{$myself}{literal}util.showContentUploadForm", // fuseaction to execute to upload
 		plugin_simage_path: "{/literal}{$application.fusebox.urlContent}{literal}", // path to store images

		editor_selector : "mce"

	});
</script>
<!-- /tinyMCE -->
{/literal}

<h3>Edit mail template</h3>

<p>Template "{$attributes.token}": {$ogMTM->pullDescription($ogF->getID(), $attributes.token)} </p>
<form action="{$myself}admin.storeMailTemplate" method="post">
<input type="hidden" name="token" value="{$attributes.token}">
<table width="100%" border="1">
{if $oU->isDev()}
<tr>
	<td width="10%">Template description:</td>
	<td><input type="text" name="description" size="45" value="{$ogMTM->pullDescription($ogF->getID(), $attributes.token)|escape}"></td>
</tr>
{/if}
{foreach from=$arrLanguages item=l}
	<tr>
		<td width="10%">Mail subject:</td>
		<td><input type="text" name="title_{$l->getID()}" value="{$ogMTM->pullTitleEncoded($ogF->getID(), $l->getID(), $attributes.token, $l->getEncoding(), "", false)}" size="45"></td>
	</tr>
	<tr>
		<td colspan="2">Mail body:</td>
	</tr>
	<tr>
		<td colspan="2">
			<textarea name="content_{$l->getID()}" class="mce" style="width:50%" rows="20" rows="20">{$ogMTM->pullContentEncoded($ogF->getID(), $l->getID(), $attributes.token, $l->getEncoding(), "", false)}</textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			NOTE: This is mail template in {$l->getName()}. Your changes will not affect other mail templates or this mail template in different language.
		</td>
	</tr>
{/foreach}
<tr><td colspan="2"><input type="Submit" value="Store"></td></tr>
</table>
</form>