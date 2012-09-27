<?xml version="1.0" encoding="UTF-8"?>
<circuit access="public">

	<fuseaction name="main" description="Site Administrator back-end main page">
		<include template="dspMain.php" />
	</fuseaction>

	<fuseaction name="showFuseactions" description="Displaying list of all pages" devonly="true" stickyattributes="page,sort,order,pagesize">
		<include template="dspFuseactions.php" />
	</fuseaction>
	
	<fuseaction name="showFuseaction" description="Displaying one page information" devonly="true">
		<include template="dspFuseaction.php" />
	</fuseaction>

	<fuseaction name="showFuseactionForm" description="Display Fuseaction edit form" devonly="true">
		<include template="dspFuseactionForm.php" />
	</fuseaction>
    
    <fuseaction name="showSpecification" description="Displaying all fuseactions with their responsibilities" devonly="true">
        <include template="dspSpecification.php" />
	</fuseaction>
    
	<fuseaction name="storeFuseaction" description="Storing Fuseaction" devonly="true">
		<include template="actStoreFuseaction.php" />
	</fuseaction>
		
	<fuseaction name="storeFuseactionsAccess" description="Storing access to pages and actions" devonly="true">
		<include template="actStoreFuseactionsAccess.php" />
	</fuseaction>
		
    <fuseaction name="showContentPages" description="Displaying content pages and content options">
        <include template="qryContentPages.php" />
        <include template="dspContentPages.php" />
    </fuseaction>
    
    <fuseaction name="showSEOPages" description="Displaying SEO for pages and SEO options">
        <include template="qrySEOPages.php" />
        <include template="dspSEOPages.php" />
    </fuseaction>

    <fuseaction name="showGraphicsPages" description="Displaying graphic content pages and options">
        <include template="qryGraphicsPages.php" />
        <include template="dspGraphicsPages.php" />
    </fuseaction>
        
	<fuseaction name="showLanguages" description="Displaying languages list" devonly="true" stickyattributes="page,sort,order,pagesize">
		<include template="dspLanguages.php" />
	</fuseaction>

	<fuseaction name="showLanguageForm" description="Displaying language edit form" devonly="true">
		<include template="dspLanguageForm.php" />
	</fuseaction>
	
	<fuseaction name="storeLanguage" description="Storing language" devonly="true">
		<include template="actStoreLanguage.php" />
		<if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspLanguageForm.php" />
			</true>
			<false>
			</false>
		</if>
	</fuseaction>	
		
	<fuseaction name="removeLanguages" description="Removing language" devonly="true">
		<include template="actRemoveLanguages.php" />
	</fuseaction>	

	<fuseaction name="showFuseactionContentTokens" description="Displaying content tokens for given page">
		<include template="dspContentTokens.php" />
	</fuseaction>	
	
	<fuseaction name="showContentForm" description="Displaying content edit form">
		<include template="dspContentForm.php" />
	</fuseaction>

	<fuseaction name="storeContent" description="Storing content in DB">
		<include template="actStoreContent.php" />
	</fuseaction>
	
	<fuseaction name="showMailTemplates" description="Display mail templates">
		<include template="dspMailTemplates.php" />
	</fuseaction>
	
	<fuseaction name="showMailTemplateForm" description="Display mail template edit form">
		<include template="dspMailTemplateForm.php" />
	</fuseaction>
	
	<fuseaction name="storeMailTemplate" description="Storing mail template in DB">
		<include template="actStoreMailTemplate.php" />
	</fuseaction>
		
	<fuseaction name="showFuseactionSEOTokens" description="Displaying SEO features tokens for given page">
		<include template="dspSEOTokens.php" />
	</fuseaction>
	
	<fuseaction name="showSEOContentForm" description="Displaying content edit form">
		<include template="dspSEOContentForm.php" />
	</fuseaction>

	<fuseaction name="storeSEOContent" description="Storing content in DB">
		<include template="actStoreSEOContent.php" />
	</fuseaction>
	
	<fuseaction name="showFuseactionGraphicsTokens" description="Display graphic content tokens for given page">
		<include template="dspGraphicsTokens.php" />
	</fuseaction>
	
	<fuseaction name="showGraphicsForm" description="Displaying graphics edit form">
		<include template="dspGraphicsForm.php" />
	</fuseaction>	
	
	<fuseaction name="storeGraphics" description="Storing graphics content in DB">
		<include template="actStoreGraphics.php" />
	</fuseaction>	
		
	<fuseaction name="showFuseactionSecurityTokens" description="Displaying security tokens for given page" devonly="true">
		<include template="dspSecurityTokens.php" />
	</fuseaction>
	
	<fuseaction name="storeTokensAccess" description="Storing permissions for security tokens action" devonly="true">
		<include template="actStoreTokensAccess.php" />
	</fuseaction>
	
	<fuseaction name="showSettings" description="Displaying site settings" stickyattributes="page,sort,order,pagesize">
		<include template="dspSettings.php" />
	</fuseaction>
	
	<fuseaction name="showSettingForm" description="Displaying setting form to edit the value">
		<include template="dspSettingForm.php" />
	</fuseaction>
	
	<fuseaction name="storeSetting" description="Displaying setting form to edit the value">
		<include template="actStoreSetting.php" />
		<if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspSettingForm.php" />
			</true>
			<false>
			</false>
		</if>
	</fuseaction>
	
	<fuseaction name="showUsers" description="Displaying list of registered users" stickyattributes="page,sort,order,pagesize">
  		<include template="dspUsers.php" />
	</fuseaction>

	<fuseaction name="showUserForm" description="Displaying form to edit user or to add new">
  		<include template="dspUserForm.php" />
	</fuseaction>
	
	<fuseaction name="storeUser" description="Saving user into DB">	
		<include template="actStoreUser.php" />
		<if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspUserForm.php" />
			</true>
			<false>
			</false>
		</if>
	</fuseaction>
	
	<fuseaction name="removeUsers" description="Removing users from DB">
		<include template="actRemoveUsers.php" />
	</fuseaction>
	
	<fuseaction name="showGroups" description="Security groups list page" devonly="true" stickyattributes="page,sort,order,pagesize">
		<include template="dspGroups.php" />
	</fuseaction>	
	
	<fuseaction name="showGroupForm" description="Security group form page" devonly="true">
		<include template="dspGroupForm.php" />
	</fuseaction>
	
	<fuseaction name="storeGroup" description="Security group add or store action" devonly="true">
		<include template="actStoreGroup.php" />
		<if condition="_gotWarnings() or _gotErrors()">
			<true>
				<include template="dspGroupForm.php" />
			</true>
			<false>
			</false>
		</if>
	</fuseaction>
	
	<fuseaction name="removeGroups" description="Remove security groups action" devonly="true">
		<include template="actRemoveGroups.php" />
	</fuseaction>
	
	<fuseaction name="storeUserGroups" description="Saving user group membership action">
		<include template="actStoreUserGroups.php" />
	</fuseaction>
	
	<fuseaction name="showLog" description="Log display page" stickyattributes="page,sort,order,pagesize" devonly="true">
		<include template="dspLog.php" />
	</fuseaction>

	<fuseaction name="showLogRecord" description="Log record display page" devonly="true">
		<include template="dspLogRecord.php" />
	</fuseaction>
	
	<fuseaction name="showProperties" description="Show properties" stickyattributes="page,sort,order,pagesize">
		<include template="dspProperties.php" />
	</fuseaction>

	<fuseaction name="showPropertyForm" description="Show property form" devonly="true">
		<include template="dspPropertyForm.php" />
	</fuseaction>

	<fuseaction name="storeProperty" description="Show property form" devonly="true">
		<include template="actStoreProperty.php" />
		<if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspPropertyForm.php" />
			</true>
			<false>                
			</false>
		</if>
	</fuseaction>
	
	<fuseaction name="showPropertyDictionary" description="Show property dictionary" stickyattributes="page,sort,order,pagesize">
		<include template="dspPropertyDictionary.php" />
	</fuseaction>
	
	<fuseaction name="showPropertyDictionaryEntryForm" description="Show single property dictionary entry form">
		<include template="dspPropertyDictionaryEntryForm.php" />
	</fuseaction>
	
	<fuseaction name="storePropertyDictionaryEntry" description="Saving property dictionary entry">
		<include template="actStorePropertyDictionaryEntry.php" />
		<if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspPropertyDictionaryEntryForm.php" />
			</true>
			<false>                
			</false>
		</if>
	</fuseaction>

	<fuseaction name="removePropertyDictionaryEntry" description="Saving property dictionary entry">
		<include template="actRemovePropertyDictionaryEntry.php" />
	</fuseaction>
    
    <fuseaction name="showArticlesTree" description="Display articles tree">
        <include template="dspArticlesTree.php" />
    </fuseaction>
    
    <fuseaction name="showArticles" description="Display articles for given token">
        <include template="dspArticles.php" />
    </fuseaction>
    
    <fuseaction name="showArticleComments" description="Display comment for given article">
    	<include template="dspArticlesComments.php" />
    </fuseaction>
    
    <fuseaction name="muteArticleComments" description="Display comment for given article">
    	<include template="actMuteArticleComments.php" />
        <if condition="_gotErrors() or _gotWarnings()">
            <true>
                <include template="dspArticlesComments.php" />
            </true>
            <false>
                <xfa name="admin.muteArticleComments" value="{$myself}admin.showArticleComments&amp;token={$attributes['token']}" />
            </false>
        </if>
    </fuseaction>
		
    <fuseaction name="showArticleForm" description="Display article form">
        <include template="dspArticleForm.php" />
    </fuseaction>
    
    <fuseaction name="addArticleNode" description="Add new article">
        <include template="actAddArticleNode.php" />     
        <xfa name="admin.addArticleNode" value="{$myself}admin.showArticleForm&amp;token={$strToken}&amp;languageid={$intLanguageID}" />   
    </fuseaction>
    
    <fuseaction name="storeArticleNode">
        <include template="actStoreArticleNode.php" />
    </fuseaction>
    
    <fuseaction name="deleteArticleNode">
        <include template="actDeleteArticleNode.php" />
    </fuseaction>
    
    <fuseaction name="storeArticle" description="Saving article">
        <include template="actStoreArticle.php" />
        <if condition="_gotErrors() or _gotWarnings()">
            <true>
                <include template="dspArticleForm.php" />
            </true>
            <false>
                <xfa name="admin.storeArticle" value="{$myself}admin.showArticles&amp;token={$attributes['token']}" />
            </false>
        </if>
    </fuseaction>

    <fuseaction name="showGalleries" description="Display galleries">
        <include template="dspGalleries.php" />
    </fuseaction>
    
    <fuseaction name="addGallery" description="Add new gallery">
        <include template="actAddGallery.php" />
        <xfa name="admin.addGallery" value="{$myself}admin.showGallery&amp;gallery={$strGallery}" />
    </fuseaction>
    
    <fuseaction name="storeGallery" description="Saving gallery in DB">
        <include template="actStoreGallery.php" />
        <if condition="_gotErrors() or _gotWarnings()">
            <true>
                <include template="dspGalleryForm.php" />
            </true>
            <false>
                <xfa name="admin.storeGallery" value="{$myself}admin.showGallery&amp;gallery={$attributes['gallery']}" />
            </false>
        </if>
    </fuseaction>
    
    <fuseaction name="deleteGallery" description="Delete a gallery">
        <include template="actDeleteGallery.php" />
        <xfa name="admin.deleteGallery" value="{$myself}admin.showGalleries" />
    </fuseaction>
    
    <fuseaction name="showGallery" description="Show gallery with images">
        <include template="dspGallery.php" />
    </fuseaction>

    <fuseaction name="showGalleryForm" description="Show gallery edit form">
        <include template="dspGalleryForm.php" />
    </fuseaction>    
    
    <fuseaction name="showImageForm">
        <include template="dspImageForm.php" />
    </fuseaction>
    
    <fuseaction name="storeImage">
        <include template="actStoreImage.php" />
        <if condition="_gotErrors() or _gotWarnings()">
            <true>
                <include template="dspImageForm.php" />
            </true>
            <false>
                <xfa name="admin.storeImage" value="{$myself}admin.showGallery&amp;gallery={$attributes['gallery']}" />
            </false>
        </if>
    </fuseaction>

    <fuseaction name="deleteImage" description="Delete an image">
        <include template="actDeleteImage.php" />
        <xfa name="admin.deleteImage" value="{$myself}admin.showGallery&amp;gallery={$attributes['gallery']}" />
    </fuseaction>

    <fuseaction name="showArticleAttachments">
        <include template="dspArticleAttachments.php" />
    </fuseaction>

    <fuseaction name="storeArticleAttachment">
        <include template="actStoreArticleAttachment.php" />
		<if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspArticleAttachments.php" />
			</true>
			<false>
				<xfa name="admin.storeArticleAttachment" value="{$myself}admin.showArticleAttachments&amp;token={$attributes['token']}" />
			</false>
		</if>        
    </fuseaction>

    <fuseaction name="removeArticleAttachment">
        <include template="actRemoveArticleAttachment.php" />
        <xfa name="admin.removeArticleAttachment" value="{$myself}admin.showArticleAttachments&amp;token={$attributes['token']}" />
    </fuseaction>
    
    <fuseaction name="moveArticle">
        <include template="actMoveArticle.php" />
        <xfa name="admin.moveArticle" value="{$myself}admin.showArticlesTree" />
    </fuseaction>    
    
	<fuseaction name="deleteContentToken" description="Removing content record from DB">
		<include template="actDeleteContentToken.php" />
	</fuseaction>

	<fuseaction name="deleteGraphicsToken" description="Removing graphics content record from DB">
		<include template="actDeleteGraphicsToken.php" />
	</fuseaction>

	<fuseaction name="clearFuseactionContent" description="Removing fuseaction's content records from DB">
		<include template="actClearFuseactionContent.php" />
	</fuseaction>

	<fuseaction name="clearFuseactionGraphics" description="Removing fuseaction's graphics records from DB">
		<include template="actClearFuseactionGraphics.php" />
	</fuseaction>
	
	<fuseaction name="deleteMailTemplate" description="Removing mail template record from DB">
		<include template="actDeleteMailTemplate.php" />
	</fuseaction>

	<fuseaction name="deleteProperty" description="Delete property">
		<include template="actDeleteProperty.php" />
	</fuseaction>

	<fuseaction name="deleteSetting" description="Delete setting">
		<include template="actDeleteSetting.php" />
	</fuseaction>
	
	<fuseaction name="showSitemap" description="Show sitemap">
		<include template="dspSitemap.php" />
	</fuseaction>

	<fuseaction name="showSitemapItemForm" description="Show add/edit sitemap item form">
		<include template="dspSitemapItemForm.php" />
	</fuseaction>

	<fuseaction name="storeSitemapItem" description="Saving sitemap item">
		<include template="actStoreSitemapItem.php" />
		<if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspSitemapItemForm.php" />
			</true>
			<false>
			</false>
		</if>
	</fuseaction>

	<fuseaction name="deleteSitemapItem" description="Delete sitemap item">
		<include template="actDeleteSitemapItem.php" />
		<if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspSitemap.php" />
			</true>
			<false>
			</false>
		</if>
	</fuseaction>

	<prefuseaction callsuper="true">
		<include template="layHeader.php" />
	</prefuseaction>

	<postfuseaction callsuper="true">
		<include template="layFooter.php" />
	</postfuseaction>
	
</circuit>