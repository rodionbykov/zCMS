<h3>Dictionary of values for {$arrProperty.name} property</h3>

<a href="{$myself}admin.showPropertyDictionaryEntryForm&amp;propertycode={$arrProperty.code}">Add new</a> | <a href="{$myself}admin.showProperties">Back to properties</a>
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
			<th width="10%"><a href="{$here}&amp;order=code&amp;sort={$attributes.asort}">Code</a></th>
			<th width="10%"><a href="{$here}&amp;order=xcode&amp;sort={$attributes.asort}">Ext. Code</a></th>
			<th><a href="{$here}&amp;order=name&amp;sort={$attributes.asort}">Name/Label</a></th>
			<th width="5%"><a href="{$here}&amp;order=pos&amp;sort={$attributes.asort}">Position</a></th>
			<th width="5%">Edit</th>
			<th width="5%">Remove</th>
		</tr>
	</thead>
	<tbody>
	{if $arrPropertyDictionary}
		{assign var=haze value=0}
		{foreach from=$arrPropertyDictionary item=entry}
			{if $haze eq 0}
			{assign var=haze value=1}
			<tr>
			{else}
			{assign var=haze value=0}
			<tr class="haze">
			{/if}
			<td>{$entry.code}</td>
			<td>{$entry.xcode}&nbsp;</td>
			<td>{$entry.name}&nbsp;</td>
			<td align="center">{$entry.pos}</td>
			<td align="center"><a href="{$myself}admin.showPropertyDictionaryEntryForm&amp;entryid={$entry.id}&amp;propertycode={$arrProperty.code}">Edit</a></td>
			<td align="center"><a href="{$myself}admin.removePropertyDictionaryEntry&amp;entryid={$entry.id}&amp;propertycode={$arrProperty.code}">X</a></td>
		</tr>
		{/foreach}
	{else}
		<tr>
			<td colspan="6" align="center">Dictionary is empty for this property</td>
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
