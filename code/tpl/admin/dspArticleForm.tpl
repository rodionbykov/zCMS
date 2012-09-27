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
		theme_advanced_buttons2_add : "insertdate,inserttime,preview,separator,forecolor,backcolor,separator,simage",
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

<h3>Edit article</h3>

<p>Article "{$attributes.token}": {$ogAM->pullDescription($ogF->getID(), $attributes.token)}</p>
<form action="{$myself}admin.storeArticle" method="post">
<input type="hidden" name="token" value="{$attributes.token}">
{foreach from=$arrLanguages item=l}
<input type="hidden" name="languageid" value="{$l->getID()}">
{/foreach}
<table width="100%" border="1">
<tr>
	<td width="10%">Article description:</td>
	<td>
		<input type="text" name="description" size="45" value="{$ogAM->pullDescription($ogF->getID(), $attributes.token)}">
		<br />
		Description is shown in article tree and cannot be empty.
	</td>
</tr>
{foreach from=$arrLanguages item=l}
	<tr>
		<td width="10%">Article title:</td>
		<td>
			<input type="text" name="title_{$l->getID()}" value="{$ogAM->pullTitleEncoded($ogF->getID(), $l->getID(), $attributes.token, $l->getEncoding(), "", false)}" size="45">
			<br />
			Article should have title and body that will be shown on front of site.
		</td>
	</tr>
	<tr>
		<td colspan="2">Article body:</td>
	</tr>
	<tr>
		<td colspan="2">
			<textarea name="content_{$l->getID()}" class="mce" style="width:50%" rows="30">{$ogAM->pullContentEncoded($ogF->getID(), $l->getID(), $attributes.token, $l->getEncoding(), "", false)}</textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			NOTE: This is article in {$l->getName()}. Your changes will not affect other articles or this article in different language.
		</td>
	</tr>
{/foreach}
<tr>
	<td width="10%">Article token:</td>
	<td>
		<input type="text" name="newtoken" value="{$attributes.token}" size="45">
		<br />
		Only English letters and numbers allowed, change token only if you are knowing what you are doing.
	</td>
</tr>	
<tr><td colspan="2"><input type="Submit" value="Store"></td></tr>
</table>
</form>