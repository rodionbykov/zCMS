{if $tmpUser->getID() gt 0}
<h3>Change your profile data</h3>
{else}
<h3>Please enter your registration data</h3>
{/if}
<form action="{$myself}home.storeRegistrant" method="post">
<table width="100%" border="1">
<tr>
	<td width="25%">Login *</td>
	<td><input type="text" name="fLogin" value="{$tmpUser->getLogin()|escape}" /></td>
</tr>
<tr>
	<td>Password *</td>
	<td><input type="password" name="fPwd" value="" /> {if $attributes.id}Please enter only if you wish to change password{/if}</td>
</tr>
<tr>
	<td>Repeat password *</td>
	<td><input type="password" name="fPwd2" value="" /> {if $attributes.id}Please enter only if you wish to change password{/if}</td>
</tr>
<tr>
	<td>Email *</td>
	<td><input type="text" name="fEmail" value="{$tmpUser->getEmail()|escape}" /></td>
</tr>
<tr>
	<td>First Name</td>
	<td><input type="text" name="fFirstName" value="{$tmpUser->getFirstName()|escape}" /></td>
</tr>
<tr>
	<td>Middle Name</td>
	<td><input type="text" name="fMiddleName" value="{$tmpUser->getMiddleName()|escape}" /></td>
</tr>
<tr>
	<td>Last Name</td>
	<td><input type="text" name="fLastName" value="{$tmpUser->getLastName()|escape}" /></td>
</tr>
<tr>
	<td>Birthdate (mm/dd/yyyy)</td>
	<td><input type="text" name="fBirthDate" value="{$tmpUser->getBirthDate('m/d/Y')|escape}" /></td>
</tr>
<tr>
	<td>Phone</td>
	<td><input type="text" name="fPhone" value="{$tmpUser->getPhone()|escape}" /></td>
</tr>
<tr>
	<td>Address</td>
	<td><input type="text" name="fAddress" value="{$tmpUser->getAddress()|escape}" /></td>
</tr>
<tr>
	<td>City</td>
	<td><input type="text" name="fCity" value="{$tmpUser->getCity()|escape}" /></td>
</tr>
<tr>
	<td>State</td>
	<td><input type="text" name="fState" value="{$tmpUser->getState()|escape}" /></td>
</tr>
<tr>
	<td>ZIP/Postal code</td>
	<td><input type="text" name="fPostalCode" value="{$tmpUser->getPostalCode()|escape}" /></td>
</tr>
<tr>
	<td>Country</td>
	<td> 
		<select name="fCountry">
			<option value="0">-Please select-</option>
			{foreach from=$arrCountries item=c}
				<option value="{$c.code}" {if $tmpUser->getCountry() eq $c.code}selected{/if}>{$c.name}</option>
			{/foreach}
		</select>
	</td>
</tr>
{if $tmpUser->getID() eq 0}
<tr><td colspan="2"><img src="{$myself}util.showCaptchaImage" alt="Please enter this string" /></td></tr>
<tr><td colspan="2">
Please enter string you see at the image
<br>
<input type="text" name="fHString" />
</td></tr>
{/if}
{if $tmpUser->getRegisteredDate('m/d/Y')}
<tr><td colspan="2">Registered {$tmpUser->getRegisteredDate('m/d/Y')|escape}</td></tr>
{/if}
</table>
<p><input type="submit" value="{if $tmpUser->getID() gt 0}Store{else}Register{/if}" /></p>
</form>