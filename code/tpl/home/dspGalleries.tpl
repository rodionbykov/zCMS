<div id="welcome">
  <h3>{$oCM->getTitle("Galleries", "Galleries")}</h3>
    <p>{$oCM->getContent("Galleries")}</p>
</div>

{if $arrAllGalleries}
  {foreach from=$arrAllGalleries item=g}
    <h3>{$ogGaM->getGalleryCreatedDate($g.token)}: <a href="{$oL->getCode()}/{$g.token}.gallery">{if $ogGaM->getGalleryTitle($g.token)}{$ogGaM->getGalleryTitle($g.token)}{else}{if $g.description}{$g.description}{else}{$g.token}{/if}{/if}</a></h3>
    {if $ogGaM->getGalleryContent($g.token)}
    <p>{$ogGaM->getGalleryContent($g.token)}</p>
    {/if}
  {/foreach}
{/if}
{if $arrPages}
<div align="right">
  {$oCM->getContent("Page", "Page")}:
  {foreach from=$arrPages item=p key=pk}
    {if $pk eq $attributes.page}<span class="title">{$pk}<span>{else}<a href="{$p}">{$pk}</a>{/if}
  {/foreach}
</div>
{/if}