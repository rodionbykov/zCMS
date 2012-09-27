<h3>Edit setting: {$attributes.key}</h3>
<form action="{$myself}admin.storeSetting" method="post">
<input type="hidden" name="key" value="{$attributes.key}" />
<table width="100%" border="1">
{if $oU->isDev()}
<tr>
	<td>Description</td>
	<td><input type="text" name="fDescription" value="{$arrSetting.description}" size="45" /></td>
</tr>
<tr>
	<td>Type</td>
	<td><select name="fDataType">
<option value="STRING" {if $arrSetting.datatype eq 'STRING'}selected{/if}>String</option>
<option value="INT" {if $arrSetting.datatype eq 'INT'}selected{/if}>Ordinal Number</option>
<option value="FLOAT" {if $arrSetting.datatype eq 'FLOAT'}selected{/if}>Real Number</option>
<option value="BOOL" {if $arrSetting.datatype eq 'BOOL'}selected{/if}>Yes/No</option>
</select>
</td>
</tr>
{else}
<tr>
	<td colspan="2">{$arrSetting.description}</td>
</tr>
{/if}
<tr>
	<td>Value</td>
{if $arrSetting.datatype eq 'BOOL'}
	<td><input type="radio" name="fValue" value="0" {if $arrSetting.value eq false}checked{/if} /> No &nbsp; <input type="radio" name="fValue" value="1" {if $arrSetting.value eq true}checked{/if} /> Yes</td> 
{else}
	<td><input type="text" name="fValue" value="{$arrSetting.value|escape}" /></td> 
{/if}
</tr>
</table>
<p><input type="submit" value="Save" /></p>
</form> 