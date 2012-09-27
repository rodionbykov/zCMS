{if $arrEntry}
<h3>Edit {$arrEntry.name} entry</h3>
{else}
<h3>Adding new dictionary entry</h3>
{/if}
<form method="post" action="{$myself}admin.storePropertyDictionaryEntry">
	{if $arrEntry}
		<input type="hidden" name="entryid" value="{$arrEntry.id}">
	{/if}
	{if $arrProperty}
		<input type="hidden" name="propertycode" value="{$arrProperty.code|escape}">
	{/if}
	<table width="100%" cellpadding="2" border="1">
		<tr>
			<td>Code</td>
			<td><input type="text" name="fCode" value="{if $arrEntry}{$arrEntry.code|escape}{/if}"></td>
		</tr>
		<tr>
			<td>External Code</td>
			<td><input type="text" name="fXCode" value="{if $arrEntry}{$arrEntry.xcode|escape}{/if}"></td>
		</tr>
		<tr>
			<td>Name or Label</td>
			<td><input type="text" name="fName" value="{if $arrEntry}{$arrEntry.name|escape}{/if}" size="45"></td>
		</tr>
		<tr>
			<td>Position</td>
			<td><input type="text" name="fPos" value="{if $arrEntry}{$arrEntry.pos}{/if}" size="7"></td>
		</tr>
	</table>
<p><input type="submit" value="{if $arrEntry}Save entry{else}Add this entry{/if}"></p>
</form>