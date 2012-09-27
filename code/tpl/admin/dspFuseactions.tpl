<h3>Fuseactions</h3>
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
<form action="{$myself}admin.storeFuseactionsAccess" method="post">
<table border="1" width="100%">
	<thead>
		<tr>
			<th width="10%" rowspan="2"><a href="{$here}&amp;order=name&amp;sort={$attributes.asort}">Name</a></th>
			<th width="5%" rowspan="2">Content</th>
			<th width="5%" rowspan="2">SEO</th>
			<th width="5%" rowspan="2">Graphics</td>
			<th width="5%" rowspan="2">Security</th>
			<th colspan="{$oSM->getGroupsCount()}" width="30%">Permissions</th>
		</tr>
	</thead>
	<tbody>
		<tr class="haze">
			<td>
			[{$fusebox.globalFuseaction}]
			<br>
			[Use this page to edit side wide global content or permissions]
			</td>
			{if $ogSM->granted("ContentManagement")}
				<td align="center"><a href="{$myself}admin.showFuseactionContentTokens&amp;id=0">Edit</a></td>
				<td align="center"><a href="{$myself}admin.showFuseactionSEOTokens&amp;id=0">Edit</a></td>
			{/if}
				<td align="center"><a href="{$myself}admin.showFuseactionGraphicsTokens&amp;id=0">Edit</a></td>
				<td align="center"><a href="{$myself}admin.showFuseactionSecurityTokens&amp;id=0">Edit</a></td>
				{foreach from=$arrGroups item=g}
				<td align="center">{$g->getName()} ({$g->getCode()})</td>
				{/foreach}
		</tr>
		{if $arrFuseactions}
		{assign var=haze value=0}
		{foreach from=$arrFuseactions item="f"}		
		{if $haze eq 0}
		{assign var=haze value=1}
		<tr>
		{else}
		{assign var=haze value=0}
		<tr class="haze">
		{/if}
			<td>
			{if $f->isDevOnly()}	
				<a style="color: red;" href="{$myself}admin.showFuseaction&amp;id={$f->getID()}">{$f->getName()}</a>
			{else}
				<a href="{$myself}admin.showFuseaction&amp;id={$f->getID()}">{$f->getName()}</a>
			{/if}		
			<br>
			{$f->getDescription()}
			</td>
			<td align="center"><a href="{$myself}admin.showFuseactionContentTokens&amp;id={$f->getID()}">Edit</a></td>
			<td align="center"><a href="{$myself}admin.showFuseactionSEOTokens&amp;id={$f->getID()}">Edit</a></td>
			<td align="center"><a href="{$myself}admin.showFuseactionGraphicsTokens&amp;id={$f->getID()}">Edit</a></td>
			<td align="center"><a href="{$myself}admin.showFuseactionSecurityTokens&amp;id={$f->getID()}">Edit</a></td>
			{if $arrGroups}
				{foreach from=$arrGroups item=g}
					{assign var="s_id" value=$oSM->checkGroupAccess($f->getID(), $g->getID(), $f->getName())}
					{assign var="s_ax" value=$oSM->pullGroupAccessByID($s_id)}
					<td align="center">
						{if $f->isDevOnly()}	
						<span style="color: red;">dev only</span>
						{else}
						<input type="radio" value="1" name="sq_{$s_id}" {if $s_ax}checked{/if}>Yes<br><input type="radio" value="0" name="sq_{$s_id}" {if !$s_ax}checked{/if}>No
						{/if}
					</td>
				{/foreach}
			{/if}
		</tr>
		{/foreach}
		{/if}
		<tr>
			<td>&nbsp;</td>
			<td colspan="4">&nbsp;</td>
			<td colspan="{$oSM->getGroupsCount()}" align="center"><input type="submit" value="Store permissions"></td>
		</tr>
		
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