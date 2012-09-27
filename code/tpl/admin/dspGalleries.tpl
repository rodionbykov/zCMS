<h3>Image Galleries</h3>
   <p><a href="javascript:void(0);" onClick="promptGalleryDescription()">Add gallery</a></p>

<table width="100%" border="1">
{if $arrGalleries}
	<thead>
		<tr>
			<th width="10%">Token</th><th>Description</th><th width="10%">View</th><th width="10%">Delete</th>
		</tr>
	</thead>
	<tbody>
{assign var=haze value=0}
{foreach from=$arrGalleries item=g}		
		{if $haze eq 0}
		{assign var=haze value=1}
		<tr>
		{else}
		{assign var=haze value=0}
		<tr class="haze">
		{/if}
			<td valign="top">{$g.token}</td>			
			<td>{$g.description}</td>
			<td valign="top" align="center"><a href="{$myself}admin.showGallery&amp;gallery={$g.token}">View</a></td>
			<td valign="top" align="center"><a href="javascript:void(0);" onClick="confirmDeleteGallery('{$myself}', '{$g.token}')">Delete</a></td>
		</tr>
{/foreach}
	</tbody>
{else}
	<tr>
		<td align="center">No galleries found</td>
	</tr>
{/if}
</table>

<form action="{$self}" method="post" name="newgalleryform">
	<input type="hidden" name="do" value="admin.addGallery" />
	<input type="hidden" name="description" value="" />
</form>