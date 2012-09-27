{if $tmpoFuseaction}
<h3>View security tokens for {$tmpoFuseaction->getDescription()} ({$tmpoFuseaction->getName()})</h3>
{/if}
<form action="{$myself}admin.storeTokensAccess" method="post">
<input type="hidden" name="fuseactionid" value="{$tmpoFuseaction->getID()}" />
<table width="100%" border="1">
<thead>
	<tr>
		<th>Token</th><th colspan="{$oSM->getGroupsCount()}">Access to this token for user groups</th>
	</tr>
</thead>
{if $arrTokens and $arrGroups}
	<tr class="haze">
		<td>&nbsp</td>
		{foreach from=$arrGroups item=g}
		<td align="center">{$g->getName()} ({$g->getCode()})</td>
		{/foreach}
	</tr>
	{assign var=haze value=0}
	{foreach from=$arrTokens item=t}
			{if $haze eq 0}
			{assign var=haze value=1}
			<tr>
			{else}
			{assign var=haze value=0}
			<tr class="haze">
			{/if}
			<td>{$t.token}</td>
			{foreach from=$arrGroups item=g}
			{assign var="s_id" value=$oSM->checkGroupAccess($tmpoFuseaction->getID(), $g->getID(), $t.token)}
			{assign var="s_ax" value=$oSM->pullGroupAccessByID($s_id)}
				<td align="center">
					<input type="radio" value="1" name="sq_{$s_id}" {if $s_ax}checked{/if}>Yes
					<input type="radio" value="0" name="sq_{$s_id}" {if !$s_ax}checked{/if}>No
				</td>
			{/foreach}
		</tr>
	{/foreach}
	<tr>
		<td colspan="{$oSM->getGroupsCount()+1}" align="center"><input type="submit" value="Save permissions"></td>
	</tr>
{else}
	<tr>
		<td colspan="2" align="center">No security tokens for this page/action is defined</td>
	</tr>
{/if}
</table>
</form>