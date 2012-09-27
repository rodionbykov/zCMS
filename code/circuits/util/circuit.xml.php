<?xml version="1.0" encoding="UTF-8"?>
<circuit access="public">
	
    <fuseaction name="showContentForm" description="Content edit form popup window">
        <include template="dspContentForm.php" />
    </fuseaction>
    
    <fuseaction name="storeContent" description="Storing content from popup window">
        <include template="actStoreContent.php" />
    </fuseaction>
    
    <fuseaction name="showGraphicsForm" description="Graphics edit form popup window">
        <include template="dspGraphicsForm.php" />
    </fuseaction>
    
    <fuseaction name="storeGraphics" description="Storing graphics from popup window">
        <include template="actStoreGraphics.php" />
    </fuseaction>
    
    <fuseaction name="showArticleForm" description="Article edit form popup window">
        <include template="dspArticleForm.php" />
    </fuseaction>   
        
    <fuseaction name="storeArticle" description="Storing article from popup window">
        <include template="actStoreArticle.php" />
    </fuseaction>
    
	<fuseaction name="showContentUploadForm" description="File upload form">
		<include template="dspContentUploadForm.php" />
	</fuseaction>
	
	<fuseaction name="uploadContent" description="Uploading file into content directory">
		<include template="actUploadContent.php" />
		<include template="dspUploadContentResult.php" />
	</fuseaction>
    
    <fuseaction name="showCaptchaImage" description="Displaying Captcha image">
        <include template="dspCaptchaImage.php" />
	</fuseaction>
	
    <fuseaction name="getArticleAttachment" description="Displaying Captcha image">
        <include template="actGetArticleAttachment.php" />
	</fuseaction>	
    
    <fuseaction name="generateArticleFeed" description="Generating RSS 2.0 articles feed">
        <include template="xmlArticleFeed.php" />
	</fuseaction>

	<fuseaction name="sitemap" description="Output sitemap.xml">
		<include template="dspSitemap.php" />
	</fuseaction>
</circuit>