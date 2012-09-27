<h3>Mail Templates</h3>

{if $arrMailTemplates}
<table width="100%" border="1">
	<thead>
		<tr>
			<th width="20%">Template</th>
			<th width="10%">Language</th>
			<th>Description</th>
			<th width="10%" colspan="2">Action</th>
		</tr>
	</thead>
	<tbody>
		{assign var=haze value=0}
		{foreach from=$arrMailTemplates item=mt}
			{foreach from=$arrLanguages item=l}
				{if $haze eq 0}
				{assign var=haze value=1}
				<tr>
				{else}
				{assign var=haze value=0}
				<tr class="haze">
				{/if}
					<td>{$mt.token}</td>
					<td>{$l->getName()}</td>
					<td>{$mt.description}&nbsp;</td>
					<td align="center"><a href="{$myself}admin.showMailTemplateForm&amp;token={$mt.token}&amp;languageid={$l->getID()}">Edit</a></td>
					<td align="center"><a href="{$myself}admin.deleteMailTemplate&amp;token={$mt.token}" onClick="return confirm('Are you sure?')">Delete</a></td>
				</tr>
			{/foreach}
		{/foreach}
	</tbody>
</table>
{else}
<table width="100%" border="1">
	<thead>
		<th width="20%">Template</th>
		<th>Description</th>
	</thead>
	<tbody>
		<tr>
			<td colspan="2" align="center">No mail templates found</td>
		</tr>
	</tbody>
</table>
{/if}
