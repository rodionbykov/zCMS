<h3>{if $ogGaM->getGalleryTitle($attributes.gallery)}{$ogGaM->getGalleryTitle($attributes.gallery)}{else}{if $ogGaM->getGalleryDescription($attributes.gallery)}{$ogGaM->getGalleryDescription($attributes.gallery)}{else}{$attributes.gallery}{/if}{/if}</h3>
{if $oAuthor}
<h4>{$oCM->getContent("By", "By")} {$oAuthor->getFullName()}</h4>
{/if}
<p>
{$ogGaM->getGalleryContent($attributes.gallery)}
</p>
<h4>{$oCM->getContent("Created", "Created")}: {$ogGaM->getGalleryCreatedDate($attributes.gallery)}{if $ogGaM->getGalleryRecentUpdate($attributes.gallery)} | {$oCM->getContent("Updated", "Updated")}: {$ogGaM->getGalleryUpdatedDate($attributes.gallery)}{if $oEditor} {$oCM->getContent("By", "By")} {$oEditor->getFullName()}{/if}{/if}</h4>
<br>
<table width="100%" style="border: none 0px;">
{assign var=a value=1}
<tr>
  {foreach from=$arrImages item=i}
    <td width="33%" align="center" valign="top">
      <a href="{$oL->getCode()}/{$attributes.gallery}.{$i.token}.image"><img border="0" alt="{$ogGaM->getImageTitle($attributes.gallery, $i.token)}" src="{$fusebox.urlGalleries}{$attributes.gallery}/{$fusebox.folderThumbs}/{$ogGaM->getImageFileName($attributes.gallery, $i.token)}"></a>
      <br>
      <em>{$ogGaM->getImageTitle($attributes.gallery, $i.token)}</em>
    </td>
    {if $a eq 3}
    {assign var=a value=1}
    </tr>
    <tr>
    {else}
    {assign var=a value=$a+1}
    {/if}
  {/foreach}
</tr>
</table>
{if $arrPages}
<div align="right">
  {$oCM->getContent("Page", "Page")}:
  {foreach from=$arrPages item=p key=pk}
    {if $pk eq $attributes.page}<span class="title">{$pk}<span>{else}<a href="{$p}">{$pk}</a>{/if}
  {/foreach}
</div>
{/if}