<h2>{if $formvars.id > 0  && !_gotWarnings() && !_gotErrors()}Edit{else}Add New{/if} Sitemap Item</h2>


<form action="{$myself}admin.storeSitemapItem" id="sitemapItemForm" method="post">
	<input type="hidden" name="id" value="{$formvars.id|escape}">
	<table width="100%">
		<tbody>
			<tr>
				<td style="padding: 2px;" width="180">
					Location *
				</td>
				<td style="padding: 2px;">
					<input type="text" name="url" value="{$formvars.url|escape:"quotes"}"  style="width: 300px;"/> (must be within site domain)
				</td>
			</tr>
			<tr>
				<td style="padding: 2px;" width="120">
					Last Modified Date 
				</td>
				<td style="padding: 2px;">
					<input class="datefield" type="text" name="last_modified" value="{$formvars.last_modified|date_format:"%m/%d/%Y"}" style="width: 100px;"/>
				</td>
			</tr>
			<tr>
				<td style="padding: 2px;">
					Change Frequency *
				</td>
				<td style="padding: 2px;">
					<select name="change_freq">
						<option value="always" {if $formvars.change_freq == 'always'}selected{/if}>always</option>
						<option value="hourly" {if $formvars.change_freq == 'hourly'}selected{/if}>hourly</option>
						<option value="daily" {if $formvars.change_freq == 'daily'}selected{/if}>daily</option>
						<option value="weekly" {if $formvars.change_freq == 'weekly'}selected{/if}>weekly</option>
						<option value="monthly" {if $formvars.change_freq == 'monthly'}selected{/if}>monthly</option>
						<option value="yearly" {if $formvars.change_freq == 'yearly'}selected{/if}>yearly</option>
						<option value="never" {if $formvars.change_freq == 'never'}selected{/if}>never</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="padding: 2px;">
					Priority [between 0 and 1]
				</td>
				<td style="padding: 2px;">
					<input type="text" name="priority" value="{$formvars.priority|escape:"quotes"}"  style="width: 50px;"/>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="submit" name="submit" value="Store Item">
</form>

<script language="javascript">
{literal}
	$(document).ready(function(){
		$(".datefield").datepicker({showOn: 'button', buttonImage: '{/literal}{$application.fusebox.urlAssets}{literal}images/DateChooser.png', buttonImageOnly: true});
	});
{/literal}
</script>

{* form validation *}
<script language="javascript" type="text/javascript">
	var msgEmptyLocation = '{$oCM->getCleanTitle("MessageEmptyLocation", "Enter Location URL, please")|escape:'javascript'}';
	var msgEmptyChangeFreq = '{$oCM->getCleanTitle("MessageEmptyChangeFreq", "Select Change Frequency, please")|escape:'javascript'}';
	
	{literal}
		function validateForm(){
			errors = '';

			locationValue = $('input[name=url]').attr('value');
			if((locationValue == undefined) || (locationValue.length < 1)){
				errors += msgEmptyLocation + '\n';
			}
			
			changefreqValue = $('select[name=change_freq]').attr('value');
			if((changefreqValue == undefined) || (changefreqValue.length < 1)){
				errors += msgEmptyChangeFreq + '\n';
			}		
			if(errors.length > 0){
				alert(errors);
				return false;
			}
			
			return true;  
		}
	
		$(document).ready(function(){
			$('#sitemapItemForm').bind('submit', validateForm);
		})
		
	{/literal}
	
</script>