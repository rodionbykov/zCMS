<h3>Edit {$arrProperty.name} property</h3>
<form action="{$myself}admin.storeProperty" method="post">
<input type="hidden" name="fCode" value="{$arrProperty.code|escape}" />
	<table width="100%" border="1">
		<tr>
			<td width="15%">Code</td>
			<td>{$arrProperty.code}</td>
		</tr>
		<tr>
			<td>Name</td>
			<td><input type="text" name="fName" value="{$arrProperty.name|escape}"></td>
		</tr>
	</table>
<p><input type="submit" value="Save"></p>
</form>