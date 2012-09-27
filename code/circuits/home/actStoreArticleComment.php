<?php
if(empty($attributes['token']) && !empty($attributes['article'])){	
	$attributes['token'] = $attributes['article'];	
}else if(empty($attributes['article']) && !empty($attributes['token'])){
	$attributes['article'] = $attributes['token'];	
}

if(!empty($attributes['token']) && !empty($attributes['fName']) && !empty($attributes['fComment'])){
	
	if(strlen($_SESSION['SecretUserString']) > 0){
    	if(!empty($attributes['fHString'])){
    		if($_SESSION['SecretUserString'] != $attributes['fHString']){
    			_warning("WCaptchaStringNotMatch", "Secret user string not match");
    		}else{
   				if($ogArticleManager->storeComment($attributes['token'], $attributes['fName'], $attributes['fComment'])){
					_message("MCommentAdded", "Your comment is added");		
					_xfa($myself . "home.showArticleComments&article=" . $attributes['token']);
				}else{
					_warning("WErrorSavingComment", "Error happened while saving comment, please try again");
				}
    		}
    	}else{
    		_warning("WCaptchaStringEmpty", "Secret user string is empty");
    	}
    }else{
    	_warning("WCaptchaStringUnknown", "Secret user string is unknown");
    }
                

	
}else{
	_warning("WEnterComment", "Please enter your name and your comment");
}
 
 
?>
