<div id="welcome">
  <h3>{$oCM->getTitle("Articles", "Articles")}</h3>
    <p>{$oCM->getContent("Articles")}</p>
</div>
{if $arrAllArticles}
  {foreach from=$arrAllArticles item=a}
  <h3>{$ogAM->getCreatedDate($a.token)} <a href="{$oL->getCode()}/{$a.token}.page">{if $ogAM->getTitle($a.token)}{$ogAM->getTitle($a.token)}{else}{if $a.description}{$a.description}{else}{$a.token}{/if}{/if}</a></h3>
  <p>{$ogAM->getContent($a.token)|strip_tags|truncate:300} <a href="{$oL->getCode()}/{$a.token}.page">{$oCM->getContent("ReadMore", "Read more")}</a></p>
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