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
</h4>

{if !empty($arrComments)}
    <h5>{$oCM->getContent("ArticleComments", "Article Comments")}</h5>
    {foreach from=$arrComments item=c}       
	       <p>
	           <em>{if $c.ismuted eq 0}{$c.commenttext}{else}{$oCM->getContent("CommentMuted", "(Comment muted by administrator)")}{/if}</em><br />
	           <h4>{if $c.ismuted eq 0}{$c.author}{else}<s>{$c.author}</s>{/if} @ {$c.moment_formatted}</h4>
	       </p>       
    {/foreach}  
{/if}

<h5>{$oCM->getContent("AddComment", "Add Comment")}</h5>
<p>
<form action="{$myself}home.storeArticleComment" method="post">
    <input type="hidden" name="article" value="{$attributes.article}" /> 
    <table width="100%" border="0">
        <tr>
            <td valign="top" width="20%">{$oCM->getContent("YourComment", "Your comment:")}</td>
            <td colspan="2"><textarea type="text" name="fComment" rows="5">{if $attributes.fComment}{$attributes.fComment|escape}{/if}</textarea></td>            
        </tr>
        <tr>
            <td valign="top">{$oCM->getContent("YourName", "Your name, please:")}</td>
            <td><input type="text" name="fName" {if $attributes.fName}value="{$attributes.fName|escape}"{/if} /></td>
            <td rowspan="2"><input type="image" src="{$myself}util.showCaptchaImage" /></td>
        </tr>
        <tr>
            <td valign="top">                        
                {$oCM->getContent("EnterCaptcha", "Enter these symbols and click the image:")}
            </td>
            <td>
                <input type="text" name="fHString" />
            </td>            
        </tr>
    </table>
</form>
</p>

{*
{if !empty($arrRelatedArticles)}
    <h5>{$oCM->getContent("RelatedArticles", "Related Articles")}</h5>
    {foreach from=$arrRelatedArticles item=a}
       <p><a href="{$oL->getCode()}/{$a.token}.page">{if $ogAM->getTitle($a.token)}{$ogAM->getTitle($a.token)}{else}{$ogAM->getDescription($a.token)}{/if}</a></p>
    {/foreach}  
{/if}

{if !empty($arrArticleAttachments)}     
   <h5>{$oCM->getContent("ArticleAttachments", "Attachments")}</h5>
    {foreach from=$arrArticleAttachments item=a}
       <p><a href="{$myself}util.getArticleAttachment&amp;id={$a.id}">{$a.title}</p>
    {/foreach}
{/if}
*}