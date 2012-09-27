<h3>Page: {$tmpFuseaction->getName()}</h3>
<table border="1" width="100%">
	<tbody>
		<tr>
			<td width="10%">Description:</td><td>{$tmpFuseaction->getDescription()}&nbsp;</td>
		</tr>
		<tr>
			<td>Sticky Attributes:</td><td>{$tmpFuseaction->getStickyAttributesList()}&nbsp;</td>
		</tr>
		<tr>
			<td valign="top">Responsibility:</td><td>{$tmpFuseaction->getResponsibility()}&nbsp;</td>
		</tr>
	</tbody>
</table>
<a href="{$myself}admin.showFuseactionForm&amp;id={$tmpFuseaction->getID()}">Edit</a> | <a href="{$myself}admin.showFuseactions">Go back to Pages and Actions list</a>