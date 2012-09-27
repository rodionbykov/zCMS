	function confirmDeleteArticle(idx, id){
		if(confirm("Are you sure you wish to delete article ?")){
			document.location.href = idx + 'admin.deleteArticleNode&node=' + id.toString();
		}
	}

	function confirmDeleteArticleAttachment(idx, article, id){
		if(confirm("Are you sure you wish to delete article attachment?")){
			document.location.href = idx + 'admin.removeArticleAttachment&token=' + article.toString() + '&id=' + id.toString();
		}
	}


	function confirmDeleteGallery(idx, gallery){
		if(confirm("Are you sure you wish to delete gallery ?")){
			document.location.href = idx + 'admin.deleteGallery&gallery=' + gallery;
		}
	}
	
	function confirmDeleteImage(idx, gallery, image){
		if(confirm("Are you sure you wish to delete image ?")){
			document.location.href = idx + 'admin.deleteImage&gallery=' + gallery + '&image=' + image;
		}
	}	
	
	function promptChildArticleDescription(parentid){
		var a;
		if(a = prompt('Please enter article description')){
			document.forms.newarticleform.parent.value = parentid.toString();
			document.forms.newarticleform.description.value = a.toString();
			document.forms.newarticleform.submit();
		}
	}
	
	function promptSiblingArticleDescription(parentid){
		var a; 
		if(a = prompt('Please enter article description')){
			document.forms.newarticleform.issibling.value = '1';
			document.forms.newarticleform.parent.value = parentid.toString();
			document.forms.newarticleform.description.value = a.toString();
			document.forms.newarticleform.submit();
		}
	}

	function promptGalleryDescription(){
		var a;
		if(a = prompt('Please enter gallery description')){
			document.forms.newgalleryform.description.value = a.toString();
			document.forms.newgalleryform.submit();
		}
	}	
	
	
	function getPageOffsetLeft (el) {
	    var ol = el.offsetLeft;
	    while ((el = el.offsetParent) != null) {
	        ol += el.offsetLeft;
	    }
	    return ol;
	}
	
	function getPageOffsetTop (el) {
	    var ot = el.offsetTop;
	    while ((el = el.offsetParent) != null) {
	    	ot += el.offsetTop;
	    }
	    return ot;
	}
	
	function hideMoveNodeForm() {
		document.getElementById('moveFormContainer').style.display = 'none';
	}
	
	function showMoveNodeForm(id) {
		document.forms.movenodeform.fId.value = id.toString();
		oSelect = document.forms.movenodeform.fParentId;
  		for (i = 0; i < oSelect.options.length; i++) {
      		oSelect.options[i].disabled = oSelect.options[i].value == id.toString() ? "disabled" : false;
  		}		
		document.getElementById('moveFormContainer').style.display = 'block';
	}
	
	function setMoveFormPosition() {
		document.getElementById('moveFormContainer').style.top = (document.body.clientHeight / 2) + "px";
		document.getElementById('moveFormContainer').style.left = (document.body.clientWidth / 2 - 50) + "px";
	}