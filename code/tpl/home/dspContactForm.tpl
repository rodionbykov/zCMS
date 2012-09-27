<div id="welcome">
  <h3>{$oCM->getTitle("ContactUs", "Contact Us")}</h3>
    <p>{$oCM->getContent("ContactUs")}</p>
    <form action="{$myself}home.submitContactForm" method="post">
		<table width="100%" border="0">
			<tr>
				<td width="25%">{$oCM->getContent("YourName", "Your name")} *</td>
				<td><input type="text" name="name" value="{$attributes.name}" /></td>
			</tr>
			<tr>
				<td>{$oCM->getContent("YourEmail", "Your email")} *</td>
				<td><input type="text" name="email" value="{$attributes.email}" /></td>
			</tr>
			<tr>
				<td colspan="2">{$oCM->getContent("YourMessage", "Your message")} *</td>
			</tr>
			<tr>
				<td colspan="2"><textarea name="text" cols="50" rows="7">{$attributes.text}</textarea></td>
			</tr>
			<tr>
				<td colspan="2"><img src="{$myself}util.showCaptchaImage" alt="Please enter these letters and numbers" /></td>
			</tr>
			<tr>
				<td colspan="2">{$oCM->getContent("EnterCaptcha", "Please enter letters and numbers you see at the image")}<br><input type="text" name="captcha" /></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="send" value="{$oCM->getCleanContent("Send", "Send")}" /></td>
			</tr>
		</table>
	</form>
</div>
