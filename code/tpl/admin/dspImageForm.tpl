<h3>Edit gallery image</h3>

<form action="{$myself}admin.storeImage" method="post" enctype="multipart/form-data">
<input type="hidden" name="gallery" value="{$attributes.gallery}" />
<input type="hidden" name="image" value="{$attributes.image}" />
<table width="100%">
		{if !$isNewImage}
		<tr>
			<td colspan="2" align="center">
				<img src="{$application.fusebox.urlGalleries}{$attributes.gallery}/{$fusebox.folderThumbs}/{$ogGaM->getImageFileName($attributes.gallery, $attributes.image)}">
			</td>
		</tr>
		{/if}
		<tr>
			<td width="15%">Upload new image:</td>
			<td>
				<input type="file" name="imagefile" size="45">
				<br>
				Image will be resized to {$arrDimensions.image.width}x{$arrDimensions.image.height}<br>
				Thumbnail {$arrDimensions.thumb.width}x{$arrDimensions.thumb.height} will be created automatically
			</td>
		</tr>
{foreach from=$arrLanguages item=l}		
		<tr>
			<td>Title:</td>
			<td><input type="text" name="title_{$l->getID()}" size="55" value="{if !$isNewImage}{$ogGaM->getImageTitleEncoded($attributes.gallery, $attributes.image, $l->getEncoding(), $l->getID())}{/if}" /></td>
		</tr>
		<tr>
			<td>Description:</td>
			<td><textarea name="desc_{$l->getID()}" rows="15" style="width: 400px;">{if !$isNewImage}{$ogGaM->getImageContentEncoded($attributes.gallery, $attributes.image, $l->getEncoding(), $l->getID())}{/if}</textarea></td>
		</tr>
		<tr><td colspan="2"><p>NOTE: this is content for page in {$l->getName()}. Your changes will not affect content in other languages.</p></td></tr>
{/foreach}
		<tr>
			<td>Image token:</td>
			<td>
				<input type="text" name="newimage" value="{$attributes.image}" size="55">
				<br />
				Only English letters and numbers allowed, change token only if you are knowing what you are doing.
			</td>
		</tr>
		<tr><td colspan="2"><input type="Submit" value="Store"></td></tr>			
</table>
</form>