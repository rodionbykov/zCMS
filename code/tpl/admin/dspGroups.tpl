<h2>{$oDCM->getTitle("PageTitle", "User Groups")}</h2>
<a href="{$myself}admin.showGroupForm">Add new group</a>
{if $arrPageSizes}
<div align="right">
	{$ogDCM->getTitle("ShowBy", "Show by")}: 
	{foreach from=$arrPageSizes item=p}
		{if $p eq $attributes.pagesize}
			<span class="title">{$p}<span>
		{else}
			<a href="{$here}&amp;pagesize={$p}">{$p}</a>
		{/if}
	{/foreach}
</div>
{/if}
<form action="{$myself}admin.removeGroups" method="post">
<table width="100%" border="1">
	<thead>
		<tr>
			<th width="2%">&nbsp;</th>
			<th width="25%"><a href="{$here}&amp;sort={$attributes.asort}&amp;order=code">{$oDCM->getTitle("Code", "Code")}</a></th>
			<th width="25%"><a href="{$here}&amp;sort={$attributes.asort}&amp;order=name">{$oDCM->getTitle("Name", "Name")}</a></th>
			<th>{$oDCM->getTitle("Description", "Description")}</th>
			<th width="25%"><a href="{$here}&amp;sort={$attributes.asort}&amp;order=homepage">{$oDCM->getTitle("HomePage", "Home Page")}</a></th>
			<th width="5%">{$oDCM->getTitle("Edit", "Edit")}</th>
			<th width="5%">{$oDCM->getTitle("Remove", "Remove")}</th>
		</tr>
	</thead>
	<tbody>
	{if $arrGroups}
		{assign var=haze value=0}
		{foreach from=$arrGroups item=g}
		{if $g->isDefaultGroup()}
			{if $oU->isDev()}
			<tr class="haze">
				<td>&nbsp;</td>
				<td>{$g->getCode()|escape}</td>
				<td colspan="5">{$oDCM->getTitle("DefaultSecurityGroup", "This is default security group and it cannot be changed")}</td>
			</tr>		
			{/if}
		{else}
		{if $haze eq 0}
		{assign var=haze value=1}
		<tr>
		{else}
		{assign var=haze value=0}
		<tr class="haze">
		{/if}
			<td><input type="checkbox" name="id[]" value="{$g->getID()}"></td>
			<td>{$g->getCode()|escape}</td>
			<td>{$g->getName()|escape}&nbsp;</td>
			<td>{$g->getDescription()|escape}&nbsp;</td>
			<td>{$g->getHomePage()|escape}&nbsp;</td>
			<td align="center"><a href="{$myself}admin.showGroupForm&amp;id={$g->getID()}">{$oDCM->getTitle("Edit", "Edit")}</a></td>
			<td align="center"><a href="{$myself}admin.removeGroups&amp;id={$g->getID()}">X</a></td>
		</tr>
		{/if}
		{/foreach}
	{else}
		<tr>
			<td colspan="6" align="center">{$oDCM->getTitle("NoGroupsDefined", "No groups defined")}</td>
		</tr>
	{/if}
	</tbody>
</table>
<input type="submit" value="Remove checked" />
</form>
{if $arrPages}
<div align="right">
	{$ogDCM->getTitle("Page", "Page")}: 
	{foreach from=$arrPages item=p key=pk}
		{if $pk eq $attributes.page}
			<span class="title">{$pk}<span>
		{else}
			<a href="{$p}">{$pk}</a>
		{/if}
	{/foreach}
</div>
{/if}