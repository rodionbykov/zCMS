<h3>Graphics management</h3>

<p>
{if $ogSM->granted("ContentManagement")}
{if $oCM->fEditModeOn}
Site CMS is now in 'Edit Mode'. This mean you may change content fragments straight from front-end. Click here to turn Edit Mode off: <a href="{$here}&amp;cmsmode=VIEW">Turn Edit Mode off</a>
{else}
Here you may enable 'Edit mode' of site CMS - so you may change content fragments straight from front-end. Click here to turn Edit Mode on: <a href="{$here}&amp;cmsmode=EDIT">Turn Edit Mode on</a>
{/if}
{/if}
</p>
<p>Click here to edit global graphics, that is common for all pages of the site: <a href="{$myself}admin.showFuseactionGraphicsTokens&amp;id=0">Edit Global Graphics</a></p>

{if $arrPageSizes}
<div align="right">
	Show by: 
	{foreach from=$arrPageSizes item=p}
		{if $p eq $attributes.pagesize}
			<span class="title">{$p}<span>
		{else}
			<a href="{$here}&amp;pagesize={$p}">{$p}</a>
		{/if}
	{/foreach}
</div>
{/if}
<table border="1" width="100%">
	<thead>
		<tr>
			<th width="15%"><a href="{$here}&amp;order=name&amp;sort={$attributes.asort}">Name</a></th>
			<th rowspan="2">Description</th>
			<th width="10%" colspan="2">Action</th>
		</tr>
	</thead>
	<tbody>
		{if $arrGraphicsPages}
		{assign var=haze value=0}
		{foreach from=$arrGraphicsPages item="gp"}
			{if !$gp.is_devonly || $oU->isDev()}		
				{if $haze eq 0}
					{assign var=haze value=1}
					<tr>
				{else}
					{assign var=haze value=0}
					<tr class="haze">
				{/if}
				<td>					
					{if $gp.is_devonly}	
						<span style="color: red;">{$gp.name}</span>
					{else}
						{$gp.name}
					{/if}		
				</td>
				<td>
				{$gp.description}
				</td>
				<td align="center">
					<a href="{$myself}admin.showFuseactionGraphicsTokens&amp;id={$gp.id}">Edit</a>
				</td>
				<td align="center">
					<a href="{$myself}admin.clearFuseactionGraphics&amp;id={$gp.id}" onClick="return confirm('Are you sure?')">Delete</a>
				</td>
			</tr>
			{/if}
		{/foreach}
		{/if}
	</tbody>
</table>
{if $arrPages}
<div align="right">
	Page: 
	{foreach from=$arrPages item=p key=pk}
		{if $pk eq $attributes.page}
			<span class="title">{$pk}<span>
		{else}
			<a href="{$p}">{$pk}</a>
		{/if}
	{/foreach}
</div>
{/if}
</form>