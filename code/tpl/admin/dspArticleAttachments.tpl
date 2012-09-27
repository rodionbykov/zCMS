<h3>Edit article attachments</h3>
{if $arrArticleAttachments}
<table width="100%" border="1">
<tr><td colspan="3">Article attachments list</td></tr>
{foreach from=$arrArticleAttachments item=a}
	<tr>
		<td>{$a.title}</td>
		<td width="10%"><a href="{$myself}admin.showArticleAttachments&amp;token={$attributes.token}&amp;id={$a.id}">Edit</a></td>
		<td width="10%"><a href="javascript:void(0);" onclick="confirmDeleteArticleAttachment('{$myself}', '{$attributes.token}', {$a.id});">Delete</a></td>
	</tr>
{/foreach}
</table>
<br>
<br>
{/if}
<form action="{$myself}admin.storeArticleAttachment&amp;token={$attributes.token}" method="post" enctype="multipart/form-data">
<table width="100%" border="1">
<thead>
		<tr>
			<th colspan="2">{if !empty($arrAttachment.id)}Edit attachment{else}Add new attachment{/if}</th>
		</tr>
	</thead>
	<tbody>
<tr>
	<td>Attachment Title</td>
	<td><input type="text" name="title" value="{if !empty($arrAttachment)}{$arrAttachment.title}{/if}"></td>
</tr>
<tr>
	<td>Attachment File</td>
	<td>{if !empty($arrAttachment.file)}{$arrAttachment.file}<br>{/if}<input type="file" name="file"></td>
</tr>
<tr>
	<td colspan="2">
		{if !empty($arrAttachment.id)}<input type="hidden" name="id" value="{$arrAttachment.id}">{/if}
		{if !empty($arrAttachment.id)}<input type="Submit" value="Store">{else}<input type="Submit" value="Add">{/if}
	</td>
</tr>
</tbody>	
</table>
</form>