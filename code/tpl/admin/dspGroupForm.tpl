<h2>{if $tmpoGroup->getID() neq 0}{$oDCM->getTitle("EditGroup", "Edit Group")} {$tmpoGroup->getName()} ({$tmpoGroup->getCode()}) {else}{$oDCM->getTitle("AddNewGroup", "Add new group")}{/if}</h2>
<form method="post" action="{$myself}admin.storeGroup">
<input type="hidden" name="id" value="{$tmpoGroup->getID()}" />
<fieldset>
<table width="100%" border="1">
	<tr>
		<td>{$oDCM->getTitle("Code", "Code")}</td><td><input type="text" name="fCode" value="{$tmpoGroup->getCode()|escape}"></td>
	</tr>
	<tr>
		<td>{$oDCM->getTitle("Name", "Name")}</td><td><input type="text" name="fName" value="{$tmpoGroup->getName()|escape}"></td>
	</tr>	
	<tr>
		<td colspan="2">{$oDCM->getTitle("Description", "Description")}</td>
	</tr>
	<tr>
		<td colspan="2"><textarea name="fDescription">{$tmpoGroup->getDescription()|escape}</textarea></td>
	</tr>
	<tr>
		<td>{$oDCM->getTitle("Home Page", "HomePage")}</td><td><input type="text" name="fHomePage" value="{$tmpoGroup->getHomePage()|escape}"></td>
	</tr>
</table>
<input type="submit" value="{if $tmpoGroup->getID() eq 0}{$oDCM->getTitle("AddGroup", "Add group")}{else}{$oDCM->getTitle("SaveGroup", "Save group")}{/if}">
</form>
</fieldset>