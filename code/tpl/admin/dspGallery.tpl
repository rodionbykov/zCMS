<h3>Edit gallery {if $ogGaM->getGalleryDescription($attributes.gallery)}{$ogGaM->getGalleryDescription($attributes.gallery)}{else}{$attributes.gallery}{/if}</h3>

<p><a href="{$myself}admin.showGalleries">Back to galleries</a></p>

<table width="100%" border="1">
	<thead>
		<tr>
			<th width="10%">Language</th><th>Title</th><th>Content</th><th width="10%">Edit</th>
		</tr>
	</thead>
	<tbody>
{assign var=haze value=0}
{foreach from=$arrLanguages item=l}		
		{if $haze eq 0}
		{assign var=haze value=1}
		<tr>
		{else}
		{assign var=haze value=0}
		<tr class="haze">
		{/if}
			<td valign="top">{$l->getName()}</td>			
			<td valign="top">{$ogGaM->getGalleryTitleEncoded($attributes.gallery, $l->getEncoding(), $l->getID())}</td>
			<td valign="top">{$ogGaM->getGalleryContentEncoded($attributes.gallery, $l->getEncoding(), $l->getID())}</td>
			<td valign="top" align="center"><a href="{$myself}admin.showGalleryForm&amp;gallery={$attributes.gallery}&amp;languageid={$l->getID()}">Edit</a></td>
		</tr>
{/foreach}
	</tbody>
</table>

<h3>Images of gallery {if $ogGaM->getGalleryDescription($attributes.gallery)}{$ogGaM->getGalleryDescription($attributes.gallery)}{else}{$attributes.gallery}{/if}</h3>


<p><a href="{$myself}admin.showImageForm&amp;gallery={$attributes.gallery}&amp;languageid={$intLanguageID}">Add new image</a></p>

<table width="100%" border="1">
	<thead>
		<tr>
			<th width="10%">Image</th><th>&nbsp;</th><th width="15%">Language</th><th>Title</th><th width="10%">Edit</th>
		</tr>
	</thead>
	<tbody>
{if $arrImages}
{assign var=haze value=0}
{foreach from=$arrImages item=i}
		{if $haze eq 0}
		{assign var=haze value=1}
		<tr>
		{else}
		{assign var=haze value=0}
		<tr class="haze">
		{/if}
			<td	valign="top" rowspan="{$oLM->getLanguagesCount()+1}">{$i.token}</td>
			<td valign="top" align="center" rowspan="{$oLM->getLanguagesCount()+1}">
				<img alt="{$ogGaM->getImageTitleEncoded($attributes.gallery, $i.token)}" src="{$fusebox.urlGalleries}{$attributes.gallery}/{$fusebox.folderThumbs}/{$ogGaM->getImageFileName($attributes.gallery, $i.token)}" width="100">
				<br>
				<a href="javascript:void(0);" onClick="confirmDeleteImage('{$myself}', '{$attributes.gallery}', '{$i.token}')">Delete</a>
			</td>					
			<td></td>
			<td></td>
			<td></td>			
		</tr>
		{foreach from=$arrLanguages item=l}		
		{if $haze eq 1}
		<tr>
		{else}
		<tr class="haze">
		{/if}
			<td valign="top">
			{$l->getName()}
			</td>
			<td valign="top">{$ogGaM->getImageTitleEncoded($attributes.gallery, $i.token, $l->getEncoding(), $l->getID())}</td>	
			<td valign="top" align="center"><a href="{$myself}admin.showImageForm&amp;gallery={$attributes.gallery}&amp;image={$i.token}&amp;languageid={$l->getID()}">Edit</a></td>					
		</tr>
		{/foreach}		
{/foreach}
{else}
	<tr>
		<td colspan="5" align="center">No images in this gallery</td>
	</tr>
{/if}
	</tbody>
</table>