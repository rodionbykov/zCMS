{if !$application.globalMessagesQueue}
{*skip form displaying when password is recovered*}
<fieldset>
	<form action="{$application.fusebox.secureUrlBase}{$myself}home.resetPassword" method="post" onSubmit="return validateForm()">
		<input type="hidden" name="signature" value="{$attributes.signature|escape}">
		<input type="hidden" name="login" value="{$attributes.login|escape}">
		<table border="0" style="width:350px">
			<tr>
				<td colspan="2">
					<h2>{$oCM->getTitle("PasswordRecoveryHeader", "Recover password")}</h2>
				</td>
			</tr>
			<tr>
				<td>
					{$oCM->getTitle("LabelNewPassword", "New Password")}
				</td>
				<td>
					<input type="password" name="password1" />
				</td>
			</tr>
			<tr>
				<td>
					{$oCM->getTitle("LabelConfirmPassword", "Confirm password")}
				</td>
				<td>
					<input type="password" name="password2" />
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;
				</td>
				<td align="left" >
					<input type="submit" value="{$ogCM->getTitle("LabelResetPasswordButton", "Reset Password")}" />
				</td>
			</tr>
		</table>
	</form>
</fieldset>

<script language="javascript">

	var msgEmptyPassword = '{$oCM->getContent("MessageEmptyPassword", "Enter Password, please")|escape:'javascript'}';
	var msgPasswordsDoNotMatch = '{$oCM->getContent("MessagePasswordsDoNotMatch", "Password and Confirmation should be identical")|escape:'javascript'}';
	var msgInvalidPasswordFormat = '{$oCM->getContent("MessageInvalidPasswordFormat", "Password should be at least 6 characters and it should contain digits")|escape:'javascript'}';

{literal}
	function validateForm(){
		if($('input[name=password1]').attr('value') == undefined || $('input[name=password1]').attr('value') == '') {
			alert(msgEmptyPassword);
			return false;
		}

		strPasswordValue = $('input[name=password1]').attr('value');
		if(strPasswordValue.length < 6 || !/.*[0-9].*/.test(strPasswordValue)) {
			alert(msgInvalidPasswordFormat);
			return false;
		}

		if($('input[name=password1]').attr('value') != $('input[name=password2]').attr('value')) {
			alert(msgPasswordsDoNotMatch);
			return false;
		}

		return true;
	}

</script>
{/literal}

{/if}