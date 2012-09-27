<h3>Graphics for {$tmpoFuseaction->getDescription()} ({$tmpoFuseaction->getName()})</h3>
<table width="100%" border="1">
{if $arrTokens}
	<thead>
		<tr>
			<th width="10%">Token</th><th width="10%">Language</th><th>Content</th><th>Alternate text</th><th width="10%" colspan="2">Actions</th>
		</tr>
	</thead>
	<tbody>
{assign var=haze value=0}	
{foreach from=$arrTokens item=t}
	{foreach from=$arrLanguages item=l}
	{if $haze eq 0}
		{assign var=haze value=1}
		<tr>
		{else}
		{assign var=haze value=0}
		<tr class="haze">
		{/if}
			<td valign="top">{$t.token}</td>
			<td align="center" valign="top">{$l->getName()}</td>
			<td><img width="100" src="{$fusebox.urlGraphics}{$oGM->pullTitle($tmpoFuseaction->getID(), $l->getID(), $t.token)}"></td>
			<td valign="top" align="center"><a href="{$myself}admin.showGraphicsForm&amp;token={$t.token}&amp;fuseactionid={$tmpoFuseaction->getID()}&amp;languageid={$l->getID()}">Edit</a></td>
			<td valign="top" align="center"><a href="{$myself}admin.deleteGraphicsToken&amp;token={$t.token}&amp;fuseactionid={$tmpoFuseaction->getID()}" onClick="return confirm('Are you sure? This record will be deleted for all available languages and recreated on page request.')">Delete</a></td>
		</tr>
	{/foreach}
{/foreach}
	</tbody>
{else}
	<tr>
		<td align="center">No tokens found for this page</td>
	</tr>
{/if}
</table>