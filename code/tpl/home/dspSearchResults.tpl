<div id="welcome">
  <h3>{$oCM->getTitle("SearchResults", "Search Results")}</h3>
  <p>{$oCM->getContent("SearchResults")} {$attributes.fSearch|escape}</p>
</div>

<div align="right">
    {$oCM->getContent("OrderBy", "Order by:")} {if $attributes.order eq "relevance"}relevance{else}<a href="{$here}&amp;order=relevance">{$oCM->getContent("Relevance", "relevance")}</a>{/if}
    {if $attributes.order eq "title"}title{else}<a href="{$here}&amp;order=title">{$oCM->getContent("Title", "title")}</a>{/if}
    {if $attributes.order eq "moment"}date{else}<a href="{$here}&amp;order=moment">{$oCM->getContent("Date", "date")}</a>{/if}
</div>

{if $arrSearchResults}
  {foreach from=$arrSearchResults item=a}
  <h3>{$ogAM->getCreatedDate($a.token)} <a href="{$oL->getCode()}/{$a.token}.page">{if $ogAM->getTitle($a.token)}{$ogAM->getTitle($a.token)}{else}{if $a.description}{$a.description}{else}{$a.token}{/if}{/if}</a></h3>
  <p>{$ogAM->getContent($a.token)|strip_tags|truncate:300} <a href="{$oL->getCode()}/{$a.token}.page">{$oCM->getContent("ReadMore", "Read more")}</a></p>
  {/foreach}
{else}
    <p>{$oCM->getContent("SorryNothingFound", "Sorry, nothing was found per your request.")}</p>
{/if}

{if $arrPages}
<div align="right">
  {$oCM->getContent("Page", "Page")}:
  {foreach from=$arrPages item=p key=pk}
    {if $pk eq $attributes.page}<span class="title">{$pk}<span>{else}<a href="{$p}">{$pk}</a>{/if}
  {/foreach}
</div>
{/if}