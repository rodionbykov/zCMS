<h3>Edit articles</h3>

<p><a href="{$myself}admin.showArticlesTree">Go back to articles tree</a></p>

{if $arrArticles}
<table width="100%" border="1">
	<thead>
		<tr>
			<th width="20%">Article</th>
			<th width="10%">Language</th>
			<th>Title</th>			
			<th width="10%">Edit</th>
			<th width="10%">Attach</th>
			<th width="10%">Comments</th>
		</tr>
	</thead>
	<tbody>
    	{assign var=haze value=0}
		{foreach from=$arrArticles item=a}
			{foreach from=$arrLanguages item=l}
				{if $haze eq 0}
				{assign var=haze value=1}
				<tr>
				{else}
				{assign var=haze value=0}
				<tr class="haze">
				{/if}
					<td>{$a.token}</td>
					<td>{$l->getName()}</td>
					<td>{$ogAM->pullTitleEncoded($ogF->getID(), $l->getID(), $a.token, $l->getEncoding(), "", false)}&nbsp;</td>
                    <td align="center"><a href="{$myself}admin.showArticleForm&amp;token={$a.token}&amp;languageid={$l->getID()}">Edit</a></td>
					<td align="center"><a href="{$myself}admin.showArticleAttachments&amp;token={$a.token}">Edit</a></td>
					<td align="center"><a href="{$myself}admin.showArticleComments&amp;token={$a.token}">Edit</a></td>
				</tr>
			{/foreach}
		{/foreach}
	</tbody>
</table>
{else}
<table width="100%" border="1">
	<thead>
		<tr>
			<th width="20%">Article</th>
			<th width="10%">Language</th>
			<th>Title</th>
			<th width="15%">Attachment</th>
			<th width="10%">Edit</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="2" align="center">No articles found</td>
		</tr>
	</tbody>
</table>
{/if}
