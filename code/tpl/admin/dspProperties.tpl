<h3>Properties</h3>
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
<table width="100%" border="1">
	<thead>
		<tr>
			<th width="20%"><a href="{$here}&amp;order=code&amp;sort={$attributes.asort}">Property Code</a></th>
			<th><a href="{$here}&amp;order=name&amp;sort={$attributes.asort}">Description</a></th>
			<th width="15%" colspan="{if $oU->isDev()}3{else}2{/if}">Actions</th>
		</tr>
	</thead>
	<tbody>
	{if $arrProperties}
		{assign var=haze value=0}
		{foreach from=$arrProperties item=p}
			{if $haze eq 0}
			{assign var=haze value=1}
			<tr>
			{else}
			{assign var=haze value=0}
			<tr class="haze">
			{/if}
			<td>{$p.code}</td>
			<td>{$p.name}&nbsp;</td>
			<td align="center"><a href="{$myself}admin.showPropertyDictionary&amp;code={$p.code}">Dictionary</a></td>
			{if $oU->isDev()}
			<td align="center"><a href="{$myself}admin.showPropertyForm&amp;code={$p.code}">Edit</a></td>
			{/if}
			<td align="center"><a href="{$myself}admin.deleteProperty&amp;code={$p.code}" onClick="return confirm('Are you sure? Dictionary entries will be lost.')">Delete</a></td>
		</tr>
		{/foreach}
	{else}
		<tr>
			<td colspan="3" align="center">No properties found</td>
		</tr>
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