<h3>System Log</h3>
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
			<th width="12%"><a href="{$here}&amp;order=fuseaction&amp;sort={$attributes.asort}">Page</a></th>
			<th width="7%"><a href="{$here}&amp;order=login&amp;sort={$attributes.asort}">User Login</a></th>
			<th width="12%"><a href="{$here}&amp;order=fullname&amp;sort={$attributes.asort}">User Name</a></th>
			<th width="1%"><a href="{$here}&amp;order=logtype&amp;sort={$attributes.asort}">Type</a></th>
			<th width="5%"><a href="{$here}&amp;order=logcode&amp;sort={$attributes.asort}">Code</a></th>
			<th><a href="{$here}&amp;order=logmsg&amp;sort={$attributes.asort}">Message</a></th>
			<th>&nbsp;</th>
			<th width="5%"><a href="{$here}&amp;order=ip&amp;sort={$attributes.asort}">IP</a></th>
			<th width="10%"><a href="{$here}&amp;order=moment&amp;sort={$attributes.asort}">Moment</a></th>
		</tr>
	</thead>
	{if $arrLog}
	<tbody>
		{assign var=haze value=0}
		{foreach from=$arrLog item=l}
		{if $haze eq 0}
		{assign var=haze value=1}
		<tr>
		{else}
		{assign var=haze value=0}
		<tr class="haze">
		{/if}
			<td>{$l.fuseaction}</td>
			<td>{$l.login}</td>
			<td>{$l.fullname}&nbsp;</td>
			<td align="center">
				{if $l.logtype eq "E"}<img src="{$application.fusebox.urlAssets}images/error.gif">{/if}
				{if $l.logtype eq "W"}<img src="{$application.fusebox.urlAssets}images/warning.gif">{/if}
				{if $l.logtype eq "M"}<img src="{$application.fusebox.urlAssets}images/message.gif">{/if}
				{if $l.logtype eq "I"}<img src="{$application.fusebox.urlAssets}images/info.gif">{/if}
			</td>
			<td>{$l.logcode}&nbsp;</td>
			<td>{$l.logmsg}</a></td>
			<td align="center"><a href="{$myself}admin.showLogRecord&amp;id={$l.lid}">View</a></td>
			<td>{$l.ip}</td>
			<td>{$l.fmoment}</td>
		</tr>
		{/foreach}
	{else}
		<tr>
			<td colspan="8" align="center">No log records found</td>
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