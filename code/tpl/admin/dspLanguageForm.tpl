{if $tmpoLanguage}
<h2>Edit Language: {$tmpoLanguage->getName()}</h2>
{else}
<h2>New Language</h2>
{/if}
<form action="{$myself}admin.storeLanguage" method="post">
{if $tmpoLanguage}
<input type="hidden" name="id" value="{$tmpoLanguage->getID()}" />
{else}
<input type="hidden" name="id" value="0" />
{/if}
<fieldset>
<table border="1" width="100%">
	<tbody>
		<tr>
			<td width="20%">Code: *</td><td><input size="10" type="text" name="fCode" value="{if $tmpoLanguage}{$tmpoLanguage->getCode()|escape}{/if}" /></td>
		</tr>
		<tr>
			<td width="20%">Name:</td><td><input size="40" type="text" name="fName" value="{if $tmpoLanguage}{$tmpoLanguage->getName()|escape}{/if}" /></td>
		</tr>
		<tr>
			<td width="20%">Encoding:</td><td><input size="40" type="text" name="fEncoding" value="{if $tmpoLanguage}{$tmpoLanguage->getEncoding()|escape}{/if}" /></td>
		</tr>
		<tr>
			<td width="20%">Content Language:</td><td><input size="40" type="text" name="fContentLanguage" value="{if $tmpoLanguage}{$tmpoLanguage->getContentLanguage()|escape}{/if}" /></td>
		</tr>
		<tr>
			<td width="20%">Text Direction:</td><td>
				<select name="fDirection">
					<option value="ltr" {if $tmpoLanguage && $tmpoLanguage->getDirection()=='ltr'}selected{/if}>Left to right</option>
					<option value="rtl" {if $tmpoLanguage && $tmpoLanguage->getDirection()=='rtl'}selected{/if}>Right to left</option>
				</select>
			</td>
		</tr>
	</tbody>
</table>
<input type="Submit" value="Store" />
</form>
</fieldset>