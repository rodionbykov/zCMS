
<h2>{$oCM->getContent("LabelPasswordRecoveryHeader", "Recover password")}</h2>

	<form action="{$application.fusebox.urlBase}{$myself}home.sendRecoverLink" method="post">
		<table border="0" style="width:350px">

			<tr><Td  height="10" colspan="2"></Td></tr>
			<tr>
				<td  width="20%"  nowrap="nowrap">
					{$oCM->getContent("YourLogin", "Your Login:")}&nbsp;&nbsp;
				</td>
				<td width="60%" align="left">
					<input type="text" name="login" value="{$attributes.login|escape}"/>
				</td>
				<td align="left" width="20%" >
					<input type="submit" value="{$oCM->getContent("LabelRecoverButton", "Send Recover Link")}" />
				</td>
			</tr>

			<tr><Td  height="10" colspan="2"></Td></tr>
		</table>
	</form>

