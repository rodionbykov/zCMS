<?php

	if(isset($attributes['messages'])){
		if(!is_array($attributes['messages'])){
			$attributes['messages'] = explode(",", $attributes['messages']);
		}
		foreach($attributes['messages'] as $m){
			switch($m){
				case "MPropertyDictionaryEntryRemoved": _message("MPropertyDictionaryEntryRemoved", "Property dictionary entry successfully removed");
					break;
				case "MPropertyDictionaryEntryAdded" : _message("MPropertyDictionaryEntryAdded", "Property dictionary entry successfully added");
					break;
				case "MPropertyDictionaryEntryStored" : _message("MPropertyDictionaryEntryStored", "Property dictionary entry successfully stored");
					break;
				case "MPropertySaved" : _message("MPropertySaved", "Property was sucessfully saved");
					break;
				case "MGroupSaved": _message("MGroupSaved", "Group saved successfully");
					break;
				case "MGroupAdded" : _message("MGroupAdded", "Group added successfully");
					break;
				case "MGroupRemoved": _message("MGroupRemoved", "Group successfully removed");
					break;
				case "MGroupsRemoved": _message("MGroupsRemoved", "Selected groups successfully removed");
					break;
				case "MUserSaved": _message("MUserSaved", "User successfully saved");
					break;
				case "MUserAdded": _message("MUserAdded", "User successfully added");
					break;
				case "MUserRemoved": _message("MUserRemoved", "User successfully removed");
					break;
				case "MUsersRemoved": _message("MUsersRemoved", "Selected users successfully removed");
					break;
				case "MRegisteredSuccessfully": _message("MRegisteredSuccessfully", "Thank you for your registration!");
					break;
				case "MUserGroupsStored": _message("MUserGroupsStored", "User groups stored");
					break;
				case "MLanguageAdded": _message("MLanguageAdded", "Language added successfully");
					break;
				case "MLanguageStored": _message("MLanguageStored", "Language stored successfully");
					break;
				case "MLanguagesRemoved": _message("MLanguagesRemoved", "Languages removed successfully");
					break;
				case "MFuseactionStored": _message("MFuseactionStored", "Page/action responsibilities stored successfully");
					break;
				case "MSecurityUpdated": _message("MSecurityUpdated", "Permissions updated");
					break;
				case "MMailTemplateStored": _message("MMailTemplateStored", "Mail template successfully stored");
					break;
				case "MSecurityUpdated": _message("MSecurityUpdated", "Token permissions updated");
					break;
				case "MSettingValueStored": _message("MSettingValueStored", "Setting value stored");
					break;
				case "MSettingStored": _message("MSettingStored", "Setting stored");
					break;
				case "MNewPasswordWasSent": _message("MNewPasswordWasSent", "Password was reset");
					break;
				case "MSiblingArticleAdded" : _message("MSiblingArticleAdded", "Article added in same section");
					break;
				case "MChildArticleAdded" : _message("MChildArticleAdded", "Child article added");
					break;
				case "MArticleStored" : _message("MArticleStored", "Article stored");
					break;
				case "MArticleRemoved" : _message("MArticleRemoved", "Article removed");
					break;
				case "MGalleryAdded" : _message("MGalleryAdded", "Gallery added");
					break;
				case "MGalleryStored" : _message("MGalleryAdded", "Gallery stored");
					break;
				case "MGalleryRemoved" : _message("MGalleryRemoved", "Gallery removed");
					break;
				case "MGalleryImageAdded" : _message("MGalleryImageAdded", "Gallery image added");
					break;
				case "MGalleryImageStored" : _message("MGalleryImageStored", "Gallery image stored");
					break;
				case "MGalleryImageDeleted" : _message("MGalleryImageDeleted", "Gallery image removed");
					break;
				case "MCommentAdded" : _message("MCommentAdded", "Your comment is added");
					break;
				case "MCommentsMuted" : _message("MCommentsMuted", "Article comment(s) muted");
					break;
				case "MContactUsMessageSent": _message("MContactUsMessageSent", "Message sent");
					break;
				case "MTokenDeleted" : _message("MTokenDeleted", "Content record(s) deleted succsessfully");
					break;
				case "MGraphicsTokenDeleted" : _message("MGraphicsTokenDeleted", "Graphics record(s) deleted succsessfully");
					break;
				case "MFuseactionCleared" : _message("MFuseactionCleared", "Page content was removed successfully");
					break;
				case "MFuseactionGraphicsCleared" : _message("MFuseactionGraphicsCleared", "Page graphics was removed successfully");
					break;
				case "MMailTemplateDeleted" : _message("MMailTemplateDeleted", "Mail template deleted successfully");
					break;
				case "MPropertyRemoved" : _message("MPropertyRemoved", "Property was deleted sucessfully");
					break;
				case "MSettingDeleted" : _message("MSettingDeleted", "Setting was deleted sucessfully");
					break;
				case "MSitemapItemAdded" : _message("MSitemapItemAdded", "Sitemap Item added");
					break;
				case "MSitemapItemUpdated" : _message("MSitemapItemUpdated", "Sitemap Item updated");
					break;
				case "MSitemapItemDeleted" : _message("MSitemapItemDeleted", "Sitemap Item removed");
					break;
				default: _message($m, "Got message: " . $m);
			}
		}
	}

?>