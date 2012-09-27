{if !empty($arrBranch)} {foreach from=$arrBranch item=a name=branch_foreach} {if $smarty.foreach.branch_foreach.iteration neq 1}> {/if}<a href="{$oL->getCode()}/{$a.token}.page">{if $ogAM->getTitle($a.token)}{$ogAM->getTitle($a.token)}{else}{$ogAM->getDescription($a.token)}{/if}</a> {/foreach}{/if}

<h3>{if $ogAM->getTitle($attributes.article)}{$ogAM->getTitle($attributes.article)}{else}{if $ogAM->getDescription($attributes.article)}{$ogAM->getDescription($attributes.article)}{else}{$attributes.article}{/if}{/if}</h3>
{if $oAuthor}
<h4>{$oCM->getContent("By", "By")} {$oAuthor->getFullName()}</h4>
{/if}
<p>
{$ogAM->getContent($attributes.article)}
</p>
<h4>{$oCM->getContent("Posted", "Posted")}: {$ogAM->getCreatedDate($attributes.article)}
    {if $ogAM->getRecentUpdate($attributes.article)} | {$oCM->getContent("Updated", "Updated")}: {$ogAM->getUpdatedDate($attributes.article)}
      {if $oEditor} {$oCM->getContent("By", "By")} {$oEditor->getFullName()}{/if}
    {/if}
     | <a href="{$oL->getCode()}/{$attributes.article}.comments">{$oCM->getContent("Comments", "Comments")} ({$intCommentsCount})</a>
</h4>

{if !empty($arrRelatedArticles)}
	<h5>{$oCM->getContent("RelatedArticles", "Related Articles")}</h5>
	{foreach from=$arrRelatedArticles item=a}
	   <p><a href="{$a.token}.page">{if $ogAM->getTitle($a.token)}{$ogAM->getTitle($a.token)}{else}{$ogAM->getDescription($a.token)}{/if}</a></p>
	{/foreach}	
{/if}

{if !empty($arrArticleAttachments)}		
   <h5>{$oCM->getContent("ArticleAttachments", "Attachments")}</h5>
	{foreach from=$arrArticleAttachments item=a}
	   <p><a href="{$myself}util.getArticleAttachment&amp;id={$a.id}">{$a.title}</p>
	{/foreach}
{/if}
