<h3>View article comments</h3>

<p>
    <a href="{$myself}admin.showArticlesTree">Go back to articles tree</a>
     | 
    <a href="{$myself}admin.showArticles&amp;token={$attributes.token}">Go back to article</a>

</p>

<form method="post" action="{$myself}admin.muteArticleComments">
	<input type="hidden" name="token" value="{$attributes.token}" />
	{if $arrArticleComments}
	<table width="100%" border="1">
	    <thead>
	        <tr>
	            <th width="5%">&nbsp;</th>
	            <th width="20%">Author</th>	            
	            <th>Comment</th>          
	            <th width="15%">Date</th>
	            <th width="10%">Mute</th>
	        </tr>
	    </thead>
	    <tbody>
	       {foreach from=$arrArticleComments item=c}
	       <tr>
	           <td align="center" valign="top">{if $c.ismuted eq 0}<input type="checkbox" name="commentid[]" value="{$c.id}" />{else}M{/if}</td>
	           <td valign="top">{if $c.ismuted eq 0}{$c.author}{else}<s>{$c.author}</s>{/if}</td>
	           <td>{$c.commenttext}</td>
	           <td valign="top">{$c.moment_formatted}</td>
	           <td align="center" valign="top">{if $c.ismuted eq 0}<a href="{$myself}admin.muteArticleComments&amp;token={$attributes.token}&amp;commentid={$c.id}">Mute</a>{/if}</td>
	       </tr>
	       {/foreach}
	    </tbody>
	 </table>	
    <input type="submit" value="Mute selected comments" />
    {else}
    <div>No comments yet for this article</div>
    {/if}
</form>