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
 		verify_html : false,

 		plugin_simage_action: "{/literal}{$application.fusebox.urlBase}{$myself}{literal}util.showContentUploadForm", // fuseaction to execute to upload
 		plugin_simage_path: "{/literal}{$application.fusebox.urlContent}{literal}", // path to store images

		editor_selector : "mce"

	});
</script>
<!-- /tinyMCE -->
{/literal}

<h3>Edit content fragment</h3>
{if $tmpoFuseaction->getName() eq $fusebox.globalFuseaction}
<p>Token "{$attributes.token}"</p>
{else}
<p>Token "{$attributes.token}" on {$tmpoFuseaction->getDescription()} ({$tmpoFuseaction->getName()})</p>
{/if}

<form action="{$myself}admin.storeContent" method="post">
<input type="hidden" name="fuseactionid" value="{$tmpoFuseaction->getID()}">
<input type="hidden" name="token" value="{$attributes.token}">
<table width="100%" style="border: 0px">
{if $oU->isDev()}
<tr><td width="10%">Description:</td><td><input type="text" size="55" name="description" value="{$oCM->pullDescription($tmpoFuseaction->getID(), $attributes.token)|escape}"></td></tr>
{/if}
{foreach from=$arrLanguages item=l}
	{if $attributes.formdisplaymode eq 0 or $attributes.formdisplaymode eq 1}
		<tr>
			<td>Title:</td>
			<td>
				<input size="55" type="text" name="title_{$l->getID()}" value="{$oCM->pullTitleEncoded($tmpoFuseaction->getID(), $l->getID(), $attributes.token, $l->getEncoding(), "", false)}">
				Fill if applicable
			</td>
		</tr>
	{/if}
	{if $attributes.formdisplaymode eq 0 or $attributes.formdisplaymode eq 2}
		<tr><td colspan="2">Content:</td></tr>
		<tr><td colspan="2"><textarea name="content_{$l->getID()}" class="mce" style="width:50%" rows="20">{$oCM->pullContentEncoded($tmpoFuseaction->getID(), $l->getID(), $attributes.token, $l->getEncoding(), "", false)}</textarea></td></tr>
	{/if}
	<tr><td colspan="2"><p>NOTE: this is content for page in {$l->getName()}. Your changes will not affect content in other languages.</p></td></tr>
{/foreach}
<tr><td colspan="2"><input type="Submit" value="Store"></td></tr>
</table>
</form>