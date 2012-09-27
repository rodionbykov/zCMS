<h3>Specification</h3>
{if $arrFuseactions}
	{foreach from=$arrFuseactions item=f}
	<p><strong>{$f->getName()|escape}</strong></p>
	<div><em>{$f->getDescription()|escape}</em></div>
	<p>{$f->getResponsibility()|escape}</p>
	{/foreach}
{/if}