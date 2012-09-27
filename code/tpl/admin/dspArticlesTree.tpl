<h3>Articles management</h3>

{literal}
<script type="text/javascript">
	<!--
	window.onload = function() {
		setMoveFormPosition();
	}
	//-->
</script>
{/literal}

<div id="moveFormContainer">
<form action="{$myself}admin.moveArticle" method="post" name="movenodeform">
	Move article to:<br>
	
	<input type="hidden" name="fId" value="">
	
	<select name="fParentId" onclick="document.forms.movenodeform.fSubmit.disabled = this.value == '' ? true : false">
		<option value="">-- Select New Parent --</option>
		{foreach from=$arrArticlesTree item=a}
		{if $a.level < $fusebox.maxArticleTreeLevel}<option value="{$a.id}">{section name="level" start=1 loop=`$a.level+1` step=1}&nbsp;&nbsp;&nbsp;{/section}{$ogAM->getDescription($a.token)}</option>{/if}
		{/foreach}
	</select>
	
	<input type="submit" name="fSubmit" value="Move" disabled>
	<input type="button" value="Cancel" onclick="hideMoveNodeForm();">
</form>
</div>

<div class="dtree">

	<p><a href="javascript: d.openAll();">open all</a> | <a href="javascript: d.closeAll();">close all</a></p>

	<script type="text/javascript">
		<!--

		d = new dTree('d');		
		{foreach from=$arrArticlesTree item=a}
		{assign var=parent value=$ogAT->getParentNodeInfo($a.id)}
		{if $parent}
			{assign var=parentid value=$parent.id}
		{else}
			{assign var=parentid value=-1}
		{/if}
		d.add({$a.id},{$parentid},'<a class="node" href="{$myself}admin.showArticles&amp;token={$a.token}">{if $ogAM->getDescription($a.token)}{$ogAM->getDescription($a.token)}{else}{$a.token}{/if}</a> {if $a.level > 0}(<a href="javascript:void(0);" onClick="promptSiblingArticleDescription({$a.id})">*</a>){/if}{if $a.level < $fusebox.maxArticleTreeLevel}(<a href="javascript:void(0);" onClick="promptChildArticleDescription({$a.id})">+</a>){/if} (<a href="{$fusebox.urlBase}{$a.token}.page" target="_blank">p</a>) (<a href="javascript:void(0);" onclick="showMoveNodeForm({$a.id});">m</a>) (<a href="javascript:void(0);" onClick="confirmDeleteArticle(\'{$myself}\', {$a.id})">x</a>)');		
		{/foreach}

		document.write(d);

		//-->
	</script>

</div>

<form action="{$self}" method="post" name="newarticleform">
	<input type="hidden" name="do" value="admin.addArticleNode" />
	<input type="hidden" name="issibling" value="0" />
	<input type="hidden" name="parent" value="" />	
	<input type="hidden" name="description" value="" />
</form>
