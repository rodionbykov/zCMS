<h2>Languages</h2>
{if $ogSM->granted("AddLanguage")}
<a href="{$myself}admin.showLanguageForm">Add new language</a>
{/if}

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

<form action="{$myself}admin.removeLanguages" method="post">
<table border="1" width="100%">
	<thead>
		<tr>
			<th width="2%">&nbsp;</th>
			<th width="5%"><a href="{$here}&amp;sort={$attributes.asort}&amp;order=code">Code</a></th>
			<th><a href="{$here}&amp;sort={$attributes.asort}&amp;order=name">Name</a></th>
			<th><a href="{$here}&amp;sort={$attributes.asort}&amp;order=encoding">Encoding</a></th>
			<th><a href="{$here}&amp;sort={$attributes.asort}&amp;order=contentlanguage">Content Language</a></th>
			<th><a href="{$here}&amp;sort={$attributes.asort}&amp;order=direction">Text Direction</a></th>
			<th width="5%">Edit</th>
			<th width="5%">Remove</th>
		</tr>
	</thead>
	<tbody>
	{if $arrLanguages}
		{assign var=haze value=0}
		{foreach from=$arrLanguages item="l"}
		{if $haze eq 0}
		{assign var=haze value=1}
		<tr>
		{else}
		{assign var=haze value=0}
		<tr class="haze">
		{/if}
			<td><input type="checkbox" name="id[]" value="{$l->getID()}"></td>
			<td>{$l->getCode()}</td>
			<td>{$l->getName()}&nbsp;</td>
			<td>{$l->getEncoding()}&nbsp;</td>
			<td>{$l->getContentLanguage()}&nbsp;</td>
			<td>{if $l->getDirection()=='rtl'}right-to-left{else}left-to-right{/if}</td>
			<td align="center"><a href="{$myself}admin.showLanguageForm&amp;id={$l->getID()}">Edit</a></td>
			<td align="center"><a href="{$myself}admin.removeLanguages&amp;id={$l->getID()}">X</a></td>
		</tr>
		{/foreach}
	{else}
		<tr>
			<td colspan="7" align="center">No lanugages defined</td>
		</tr>
	{/if}
	</tbody>
</table>
<input type="submit" value="Remove checked">
</form>
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