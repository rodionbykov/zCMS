<h3>Edit gallery {if $ogGaM->getGalleryDescription($attributes.gallery)}{$ogGaM->getGalleryDescription($attributes.gallery)}{else}{$attributes.gallery}{/if}</h3>

<form action="{$myself}admin.storeGallery" method="post">
<input type="hidden" name="gallery" value="{$attributes.gallery}">
{foreach from=$arrLanguages item=l}
<input type="hidden" name="languageid" value="{$l->getID()}">
{/foreach}
<table width="100%" border="1">
<tr>
	<td width="10%">Gallery description:</td>
	<td>
		<input type="text" name="description" size="45" value="{$ogGaM->getGalleryDescription($attributes.gallery)}">
		<br />
		Description is shown in gallery list and cannot be empty.
	</td>
</tr>
{foreach from=$arrLanguages item=l}
	<tr>
		<td width="10%">Gallery title:</td>
		<td>
			<input type="text" name="title_{$l->getID()}" value="{$ogGaM->getGalleryTitleEncoded($attributes.gallery, $l->getEncoding(), $l->getID())}" size="45">
			<br />
			Gallery should have title that will be shown on front of site.
		</td>
	</tr>
	<tr>
		<td colspan="2">Gallery description (optional):</td>
	</tr>
	<tr>
		<td colspan="2">
			<textarea name="content_{$l->getID()}" rows="15">{$ogGaM->getGalleryContentEncoded($attributes.gallery, $l->getEncoding(), $l->getID())}</textarea>
		</td>
	</tr>
	<tr>
		<td width="10%">Gallery token:</td>
		<td>
			<input type="text" name="newgallery" value="{$attributes.gallery}" size="45">
			<br />
			Only English letters and numbers allowed, change token only if you are knowing what you are doing.
		</td>
	</tr>		
	<tr>
		<td colspan="2">
			NOTE: This is gallery in {$l->getName()}. Your changes will not affect other articles or this article in different language.
		</td>
	</tr>
{/foreach}
<tr><td colspan="2"><input type="Submit" value="Store"></td></tr>
</table>
</form>