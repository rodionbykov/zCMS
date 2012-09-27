<h3>{$oCM->getContent("LoginHeader", "Login")}</h3>
<form action="{$myself}{$application.fusebox.xfaLogin}" method="post" class="form">
<p><table width="100%" border="1">
<tr>
	<td width="15%">{$oCM->getContent("Login", "Login")}</td>
	<td><input type="text" name="fLogin" size="12" /></td>
</tr>
<tr>
	<td>{$oCM->getContent("Password", "Password")}</td>
	<td><input type="password" name="fPwd" size="12" /></td>
</tr>
</table></p>
<p><input type="submit" value="{$oCM->getCleanContent("LoginButton", "Login")}" /></p>
</form>
<p><a href="{$myself}home.showRecoverPasswordForm">{$oCM->getContent("ForgotPassword", "Forgot password ?")}</a> | <a href="{$myself}home.showRegistrationForm">{$oCM->getContent("RegisterNow", "Register Now!")}</a></p>