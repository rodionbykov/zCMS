<h3>Edit graphics fragment</h3>

{if $tmpoFuseaction->getName() eq $fusebox.globalFuseaction}
<p>Token "{$attributes.token}"</p>
{else}
<p>Token "{$attributes.token}" on {$tmpoFuseaction->getDescription()} ({$tmpoFuseaction->getName()})</p>
{/if}

<form action="{$myself}admin.storeGraphics" method="post" enctype="multipart/form-data">
<input type="hidden" name="fuseactionid" value="{$tmpoFuseaction->getID()}">
<input type="hidden" name="token" value="{$attributes.token}">
<table width="100%">
{if $oU->isDev()}
<tr><td width="10%">Description:</td><td><input type="text" size="55" name="description" value="{$oGM->pullDescription($tmpoFuseaction->getID(), $attributes.token)|escape}"></td></tr>
{/if}
{foreach from=$arrLanguages item=l}
		<tr>
			<td colspan="2">
				<img src="{$application.fusebox.urlGraphics}{$oGM->pullTitle($tmpoFuseaction->getID(), $l->getID(), $attributes.token)}" alt="{$oGM->pullContent($tmpoFuseaction->getID(), $l->getID(), $attributes.token)}">
			</td>
		</tr>
		<tr>
			<td width="15%">Upload new image:</td>
			<td><input type="file" name="graphics_{$l->getID()}" size="45"></td>
		</tr>
		<tr>
			<td>Alternate text:</td>
			<td><input type="text" name="alt_{$l->getID()}" size="55" value="{$oGM->pullContent($tmpoFuseaction->getID(), $l->getID(), $attributes.token)}" /></td>
		</tr>
<tr><td colspan="2"><p>NOTE: this is content for page in {$l->getName()}. Your changes will not affect content in other languages.</p></td></tr>
<tr><td colspan="2"><input type="Submit" value="Store"></td></tr>
{/foreach}
</table>
</form>