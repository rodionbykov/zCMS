<?
		if(!empty($attributes['token'])){
			if(!$ogMailTemplatesManager->deleteToken(0, $attributes['token'])){
				_error("ENoTokenFound", "Record not found, perhaps already deleted");
			}
		}else{
			_error("ENoMailTemplateTokenGiven", "No mail template token is given");
		}

		if(!_gotErrors() && !_gotWarnings()){
			_message("MMailTemplateDeleted", "Mail template deleted successfully");

			_xfa($myself . "admin.showMailTemplates");
		}

?>