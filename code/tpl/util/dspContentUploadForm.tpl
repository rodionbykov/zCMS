<html>
<head>
	<title>Image upload</title>
	<script language="javascript" type="text/javascript" src="{$application.fusebox.urlAssets}scripts/tiny_mce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="{$application.fusebox.urlAssets}scripts/tiny_mce/plugins/simage/jscripts/functions.js"></script>
	{literal}
	<style type="text/css">
	.simage_panel {
		border: 1px solid #919B9C;
		padding: 10px;
		padding-top: 5px;
		clear: both;
		background-color: white;
	}
	.file {
		height: 20px;
		width: 250px;
		margin-top: 3px;
		margin-bottom: 3px;
		padding-bottom: 3px;
		background-color: #FFFFFF;
		border: #ccc 1px solid;
	}
	.process {
		border: 1px solid #919B9C;
		text-align: center;
		padding-top: 38px;
		padding-bottom: 37px;
		clear: both;
		background-color: white;
	}
	</style>
	{/literal}
</head>
<body>



<form method="post" action="{$myself}util.uploadContent" id="UploadForm" name="UploadForm"  enctype="multipart/form-data">

	<div class="simage_panel">
		<div id="uplDiv">
     <table border="0" cellpadding="3" cellspacing="0">
	     <tr>
	       <td nowrap="nowrap">Select file to upload</td>
	       <td><input id="fname" name="fname" type="file"></td>
	     </tr>
	     <tr>
	       <td nowrap="nowrap">Image alt and title</td>
	       <td><input name="imagetitle" type="text" id="imagetitle" value="" size="34"></td>
	     </tr>
     </table>
		</div>
	</div>

	<input name="upload" type="hidden" value="none">

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="insert" name="insert" value="Insert" onclick="JavaScript:checkUpload();" />
		</div>

		<div style="float: right">
			<input type="button" id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close();" />
		</div>
	</div>

</form>

</body>
</html>