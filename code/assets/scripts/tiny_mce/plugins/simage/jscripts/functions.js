
// path
function GetPath() {
	return tinyMCE.getParam('plugin_simage_path');
}


// inserting image
function insertImage(file_name,title,path) {

	var html = '<img src="' + path + file_name + '" border="0" alt="' + title + '" title="' + title + '" />';

	tinyMCE.execCommand('mceInsertContent', false, html);

	tinyMCEPopup.close();

}

// check whether image file is selected for uploading
function checkUpload() {

	var file = document.getElementById('fname');

	if (Trim(file.value) == '') { // check whether files has been selected for upload
		alert('No file selected!');
		return false;
	}

	document.UploadForm.submit();

}


// Trimming
function Trim(TRIM_VALUE)
{
        if(TRIM_VALUE.length < 1)
        {
                return"";
        }
  TRIM_VALUE = RTrim(TRIM_VALUE);
  TRIM_VALUE = LTrim(TRIM_VALUE);
  if(TRIM_VALUE=="")
  {
    return "";
  }
  else{
    return TRIM_VALUE;
  }
}

<!--RTrim-->
function RTrim(VALUE){
        var w_space = String.fromCharCode(32);
        var v_length = VALUE.length;
        var strTemp = "";
    if(v_length < 0){
      return"";
    }
    var iTemp = v_length -1;
    while(iTemp > -1)
    {
      if(VALUE.charAt(iTemp) == w_space)
      {
      }
      else{
       strTemp = VALUE.substring(0,iTemp +1);
       break;
      }
       iTemp = iTemp-1;
    }
    return strTemp;
}

<!--LTrim-->
function LTrim(VALUE)
{
        var w_space = String.fromCharCode(32);
  if(v_length < 1)
     {
            return"";
     }
  var v_length = VALUE.length;
  var strTemp = "";
  var iTemp = 0;

  while(iTemp < v_length)
  {
   if(VALUE.charAt(iTemp) == w_space){
  }
  else
  {
   strTemp = VALUE.substring(iTemp,v_length);
   break;
  }
   iTemp = iTemp + 1;
  }
  return strTemp;
}