<html>
{if $imageFileName}
	<head>
		<script language="javascript" type="text/javascript" src="{$application.fusebox.urlAssets}scripts/tiny_mce/tiny_mce_popup.js"></script>
		<script language="javascript" type="text/javascript" src="{$application.fusebox.urlAssets}scripts/tiny_mce/plugins/simage/jscripts/functions.js"></script>
		<script language="javascript" type="text/javascript">insertImage('{$imageFileName}','{$attributes.imagetitle}','{$application.fusebox.urlContent}');</script>
	</head>
{/if}
</html>