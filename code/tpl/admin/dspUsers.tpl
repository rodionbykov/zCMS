<h3>Users</h3>
<p><a href="{$myself}admin.showUserForm">Add new user</a></p>
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
<form action="{$myself}admin.removeUsers" method="post" name="usersgroups" id="usersgroups">
	<table width="100%" border="1">
		<thead>
			<tr>
				<th width="2%">&nbsp;</th>
				<th width="8%"><a href="{$here}&amp;sort={$attributes.asort}&amp;order=login">Login</a></th>
				<th width="20%"><a href="{$here}&amp;sort={$attributes.asort}&amp;order=fullname">Name</a></th>
				<th width="20%"><a href="{$here}&amp;sort={$attributes.asort}&amp;order=email">Email</a></td>
				{if $ogSM->granted("SecurityManagement")}
					{if $oU->isDev()}
						<th colspan="{$oSM->getGroupsCount()}">Groups</th>
					{else}
						{if $oSM->getGroupsCount() gt 1}
						<th colspan="{$oSM->getGroupsCount()-1}">Groups</th>
						{/if}
					{/if}
				{/if}
				<th width="5%">Edit</th>
				<th width="5%">Remove</th>
			</tr>
		</thead>
		<tbody>
		<tr class="haze">
			<td colspan="4">&nbsp;</td>
			{if $ogSM->granted("SecurityManagement")}
				{foreach from=$arrGroups item=g}
					{if $g->isDefaultGroup()}
						{if $oU->isDev()}
							<td align="center">
								{$g->getName()} ({$g->getCode()})
							</td>
						{/if}
					{else}
						<td align="center">
							{$g->getName()} ({$g->getCode()})
						</td>
					{/if}
				{/foreach}
			{/if}
			<td colspan="2">&nbsp;</td>
		</tr>
		{if $arrUsers and $arrGroups}
			{assign var=haze value=0}
			{foreach from=$arrUsers item=u}
			{if $u->isDefaultUser() or $u->isDev()}
				{if $oU->isDev()}
					{if $haze eq 0}
					{assign var=haze value=1}
					<tr>
					{else}
					{assign var=haze value=0}
					<tr class="haze">
					{/if}
						<td><input type="checkbox" name="id[]" value="{$u->getID()}" /></td>
						<td>{$u->getLogin()|escape}</td>
						<td>{$u->getFullName()|escape}&nbsp;</td>		
						<td>{$u->getEmail()|escape}&nbsp;</td>				
						{foreach from=$arrGroups item=g}
							<td align="center">
								<input type="checkbox" name="u_{$u->getID()}[]" value="{$g->getID()}" {if $u->inGroup($g)}checked{/if} />
							</td>
						{/foreach}						
						<td align="center"><a href="{$myself}admin.showUserForm&amp;id={$u->getID()}">Edit</a></td>
						<td align="center"><a href="{$myself}admin.removeUsers&amp;id={$u->getID()}">X</a></td>
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
					<td><input type="checkbox" name="id[]" value="{$u->getID()}" /></td>
					<td>{$u->getLogin()|escape}</td>
					<td>{$u->getFullName()|escape}&nbsp;</td>
					<td>{$u->getEmail()|escape}&nbsp;</td>
					{if $ogSM->granted("SecurityManagement")}
						{foreach from=$arrGroups item=g}
							{if $g->isDefaultGroup()}
								{if $oU->isDev()}
									<td align="center">
										<input type="checkbox" name="u_{$u->getID()}[]" value="{$g->getID()}" {if $u->inGroup($g)}checked{/if} />
									</td>
								{/if}
							{else}	
								<td align="center">
									<input type="checkbox" name="u_{$u->getID()}[]" value="{$g->getID()}" {if $u->inGroup($g)}checked{/if} />
								</td>
							{/if}
						{/foreach}
					{/if}
					<td align="center"><a href="{$myself}admin.showUserForm&amp;id={$u->getID()}">Edit</a></td>
					<td align="center"><a href="{$myself}admin.removeUsers&amp;id={$u->getID()}">X</a></td>
				</tr>
			{/if}
			{/foreach}
			<tr>
				<td colspan="4">&nbsp;</td>
				{if $ogSM->granted("SecurityManagement")}
					<td colspan="{if $oU->isDev()}{$oSM->getGroupsCount()}{else}{$oSM->getGroupsCount()-1}{/if}" align="center">	
						<input type="button" value="Store user groups" onClick="document.forms.usersgroups.action='{$myself}admin.storeUserGroups';document.forms.usersgroups.submit();" />
					</td>
				{/if}
				<td colspan="2">&nbsp;</td>
			</tr>
		{else}
			<tr>
				<td colspan="6" align="center">No users found</td>
			</tr>
		{/if}
		</tbody>
	</table>
	<input type="submit" value="Remove checked" />
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