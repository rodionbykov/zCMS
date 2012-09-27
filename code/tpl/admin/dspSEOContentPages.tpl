<h3>SEO management</h3>

<p>Click here to edit global SEO content, that is common for all pages of the site: <a href="{$myself}admin.showFuseactionSEOTokens&amp;id=0">Edit Global SEO content</a></p>
<p>Click here to edit sitemap.xml contents: <a href="{$myself}admin.showSitemap">manage sitemap.xml file</a>
{if $arrPageSizes}
<div align="right">
	Show by: 
	{foreach from=$arrPageSizes item=p}
		{if $p eq $attributes.pagesize}
			<span class="title">{$p}<span>
		{else}
			<a href="{$here}&amp;pagesize={$p}">{$p}</a>
		{/if}
	{/foreach}
</div>
{/if}
<table border="1" width="100%">
	<thead>
		<tr>
			<th width="15%"><a href="{$here}&amp;order=name&amp;sort={$attributes.asort}">Name</a></th>
			<th rowspan="2">Description</th>
			<th width="5%">Edit</th>
		</tr>
	</thead>
	<tbody>
		{if $arrSEOContentPages}
		{assign var=haze value=0}
		{foreach from=$arrSEOContentPages item="sp"}
			{if !$sp.is_devonly || $oU->isDev()}	
				{if $haze eq 0}
					{assign var=haze value=1}
					<tr>
				{else}
					{assign var=haze value=0}
					<tr class="haze">
				{/if}
				<td>	
					{if $sp.is_devonly}	
						<span style="color: red;">{$sp.name}</span>
					{else}
						{$sp.name}
					{/if}			
				</td>
				<td>
				{$sp.description}
				</td>
				<td align="center"><a href="{$myself}admin.showFuseactionSEOTokens&amp;id={$sp.id}">Edit</a></td>
			</tr>
			{/if}
		{/foreach}
		{/if}
	</tbody>
</table>
{if $arrPages}
<div align="right">
	Page: 
	{foreach from=$arrPages item=p key=pk}
		{if $pk eq $attributes.page}
			<span class="title">{$pk}<span>
		{else}
			<a href="{$p}">{$pk}</a>
		{/if}
	{/foreach}
</div>
{/if}
</form>