{if $arrLogRecord}
<h3>Log record #{$arrLogRecord.lid}</h3>
<table width="100%">
	<tr>
		<td>Page</td><td>{$arrLogRecord.fuseaction}</td>
	</tr>
	<tr>
		<td>Event</td>
		<td>
			{if $arrLogRecord.logtype eq "E"}<img src="{$application.fusebox.urlAssets}images/error.gif">{/if}
			{if $arrLogRecord.logtype eq "W"}<img src="{$application.fusebox.urlAssets}images/warning.gif">{/if}
			{if $arrLogRecord.logtype eq "M"}<img src="{$application.fusebox.urlAssets}images/message.gif">{/if}
			{if $arrLogRecord.logtype eq "I"}<img src="{$application.fusebox.urlAssets}images/info.gif">{/if}
		    &nbsp;
		    [{$arrLogRecord.logcode}] {$arrLogRecord.logmsg}
		</td>
	</tr>
	<tr>
		<td>User</td>
		<td>{$arrLogRecord.fullname} ({$arrLogRecord.login}) from {$arrLogRecord.ip} at {$arrLogRecord.fmoment}</td>
	</tr>
	{if $arrLogRecord.extmsg}
	<tr>
		<td colspan="2">
			{$arrLogRecord.extmsg}
		</td>
	</tr>
	{/if}
</table>
{/if}
<a href="{$myself}admin.showLog">Go back to log</a>