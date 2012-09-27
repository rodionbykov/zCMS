{if $tmpoFuseaction->getName() eq $fusebox.globalFuseaction}
<h3>Global SEO content</h3>
{else}
<h3>SEO content for {$tmpoFuseaction->getDescription()} ({$tmpoFuseaction->getName()})</h3>
{/if}
<table width="100%" border="1">
{if $arrTokens}
	<thead>
		<tr>
			<th>SEO Token</th><th>Language</th><th>Content</th><th>Edit</th>
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
			<td width="10%" valign="top">
				{$t.token}
			</td>
			<td width="10%" align="center" valign="top">
				{$l->getName()}
			</td>
			<td>
				{$tmpoSEOContentManager->pullContentEncoded($tmpoFuseaction->getID(), $l->getID(), $t.token, $l->getEncoding())} 
			</td>
			<td width="10%" align="center">
				<a href="{$myself}admin.showSEOContentForm&amp;token={$t.token}&amp;fuseactionid={$tmpoFuseaction->getID()}&amp;languageid={$l->getID()}">Edit</a>
			</td>
		</tr>
		{/foreach}
{/foreach}
	</tbody>
{else}
	<tr>
		<td align="center">No SEO content tokens found for this page</td>
	</tr>
{/if}
</table>