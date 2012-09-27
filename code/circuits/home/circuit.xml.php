<?xml version="1.0" encoding="UTF-8"?>
<circuit access="public">

	<fuseaction name="login" description="Login action">
		<include template="actLogin.php" />
		<if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspLoginForm.php" />
			</true>
			<false>
			</false>
		</if>
	</fuseaction>

	<fuseaction name="logout" description="Logout action">
		<include template="actLogout.php" />
	</fuseaction>

	<fuseaction name="showAccessDenied" description="Displaying Access Denied page to user">
		<include template="dspAccessDenied.php" />
	</fuseaction>

	<fuseaction name="showLoginForm" description="Display login form page">
		<include template="dspLoginForm.php" />
	</fuseaction>

	<fuseaction name="showRegistrationForm" description="Display user registration form page">
		<include template="dspRegistrationForm.php" />
	</fuseaction>

	<fuseaction name="storeRegistrant" description="Storing registrant data to DB action">
		<include template="actStoreRegistrant.php" />
		<if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspRegistrationForm.php" />
			</true>
			<false>
                <include template="actSendRegistrationConfirmation.php" />
				<include template="actLogin.php" />
			</false>
		</if>
	</fuseaction>

	<fuseaction name="showRegistrationConfirmation" description="Displaying succesful registration confirmation page">
		<include template="dspRegistrationConfirmation.php" />
	</fuseaction>

	<fuseaction name="showRecoverPasswordForm" description="Displaying recover password form">
		<include template="dspRecoverPasswordForm.php" />
	</fuseaction>

	<fuseaction name="sendRecoverLink" description="Send recover password link to user">
		<include template="actSendRecoverLink.php" />
		<include template="dspRecoverPasswordForm.php" />
	</fuseaction>

	<fuseaction name="showResetPasswordForm" description="Displaying reset password form">
		<include template="dspResetPasswordForm.php" />
	</fuseaction>

	<fuseaction name="resetPassword" description="Reset password action">
		<include template="actResetPassword.php" />
		<include template="dspResetPasswordForm.php" />
	</fuseaction>

    <fuseaction name="showArticles" description="Display articles" stickyattributes="page">
        <include template="dspArticles.php" />
    </fuseaction>

    <fuseaction name="showSearchResults" description="Display result of search by articles" stickyattributes="page">
        <include template="dspSearchResults.php" />
    </fuseaction>

    <fuseaction name="showArticle" description="Single article page">
		<include template="dspArticle.php" />
    </fuseaction>   
    
    <fuseaction name="showArticleComments" description="Single article page with comments">
		<include template="dspArticleComments.php" />
    </fuseaction>   

    <fuseaction name="storeArticleComment" description="Adding a comment">
		<include template="actStoreArticleComment.php" />         
		<if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspArticleComments.php" />
			</true>
			<false>
			</false>
		</if>
	</fuseaction>              
    
    <fuseaction name="showGalleries" description="Display galleries" stickyattributes="page">
        <include template="dspGalleries.php" />
    </fuseaction>

    <fuseaction name="showGallery" description="Display single gallery" stickyattributes="page">
        <include template="dspGallery.php" />
    </fuseaction>

    <fuseaction name="showGalleryImage" description="Display single gallery image">
        <include template="dspGalleryImage.php" />
    </fuseaction>
    
    
    <fuseaction name="showContactForm" description="Contact form page">
        <include template="dspContactForm.php" />
    </fuseaction>

	<fuseaction name="submitContactForm" description="Send contact message">
        <include template="actSendContactMessage.php" />
        <if condition="_gotErrors() or _gotWarnings()">
			<true>
				<include template="dspContactForm.php" />
			</true>
			<false>
			</false>
		</if>
	</fuseaction>

	<prefuseaction>
		<include template="layHeader.php" />
	</prefuseaction>

	<postfuseaction>
		<include template="layFooter.php" />
	</postfuseaction>

</circuit>