<h3>Site settings</h3>

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
			<th width="10%"><a href="{$here}&amp;order=name&amp;sort={$attributes.asort}">Code</a></th>
			<th width="50%"><a href="{$here}&amp;order=description&amp;sort={$attributes.asort}">Description</a></th>
			<th>Value</th>
			<th width="10%" colspan="2">Action</th>
		</tr>
	</thead>
	<tbody>
	{if $arrSettings}
		{assign var=haze value=0}
		{foreach from=$arrSettings item=s key=k}
		{if $haze eq 0}
		{assign var=haze value=1}
		<tr>
		{else}
		{assign var=haze value=0}
		<tr class="haze">
		{/if}
			<td>
				{$k}
			</td>
			<td>{$s.description}&nbsp;</td>
			<td>
			{if $s.datatype eq 'BOOL'}{if $s.value eq 0}No{else}Yes{/if}{else}{$s.value|escape}{/if}
			</td>
			<td align="center"><a href="{$myself}admin.showSettingForm&amp;key={$k}">Edit</a></td>
			<td align="center"><a href="{$myself}admin.deleteSetting&amp;key={$k}" onClick="return confirm('Are you sure?')">Delete</a></td>
		</tr>
		{/foreach}
	{else}
		<tr>
			<td colspan="4" align="center">No settings found</td>
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
