   <p id="footer">
      {$ogCM->getContent("Footer", "This is page footer")}
	  {if $oU->isDev()}
		<p>
			<div style="color: red;">
			<strong>This page is </strong> {$oF->getName()|escape} ({$oF->getDescription()|escape})<br/>
			<strong>Responsibility of this page is</strong><br/>
			{$oF->getResponsibility()|nl2br}
			<br />
				(<a style="color: red;" href="{$myself}admin.showFuseactionForm&amp;id={$oF->getID()}">Edit</a>)
			</div>
		</p>			
		{/if}
   </p>
</div>

</body>
</html>

