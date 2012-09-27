<h3>Edit SEO fragment</h3>
{if $tmpoFuseaction->getName() eq $fusebox.globalFuseaction}
<h2>Token "{$attributes.token}"</h2>
{else}
<h2>Token "{$attributes.token}" on {$tmpoFuseaction->getDescription()} ({$tmpoFuseaction->getName()})</h2>
{/if}
<form action="{$myself}admin.storeSEOContent" method="post">
<input type="hidden" name="fuseactionid" value="{$tmpoFuseaction->getID()}">
<input type="hidden" name="token" value="{$attributes.token}">
<table width="100%">
{foreach from=$arrLanguages item=l}
<tr></tr>
		<tr><td><textarea name="content_{$l->getID()}">{$oSCM->pullContentEncoded($tmpoFuseaction->getID(), $l->getID(), $attributes.token, $l->getEncoding())}</textarea></td></tr>
{/foreach}
<tr><td colspan="2"><p>NOTE: this is SEO content in {$l->getName()}. Your changes will not affect content in other languages.</p></td></tr>
<tr><td><input type="Submit" value="Store"></td></tr>
</table>
</form>