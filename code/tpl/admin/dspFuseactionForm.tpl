<h3>Edit Page: {$tmpFuseaction->getName()}</h3>
<form action="{$myself}admin.storeFuseaction" method="post">
<input type="hidden" name="id" value="{$tmpFuseaction->getID()}" />
<table border="1" width="100%">
	<tbody>
		<tr>
			<td width="10%">Description:</td><td>{$tmpFuseaction->getDescription()}&nbsp;</td>
		</tr>
		<tr>
			<td valign="top">Responsibility:</td><td><textarea cols="70" rows="4" name="fResponsibility">{$tmpFuseaction->getResponsibility()|escape}</textarea></td>
		</tr>
		<tr>
			<td colspan="2"><input type="Submit" value="Store" /></td>
		</tr>
	</tbody>
</table>
</form>

<a href="{$myself}admin.showFuseactions">Go back to Pages and Actions list</a>