<h3>{if $ogGaM->getGalleryTitle($attributes.gallery)}{$ogGaM->getGalleryTitle($attributes.gallery)}{else}{if $ogGaM->getGalleryDescription($attributes.gallery)}{$ogGaM->getGalleryDescription($attributes.gallery)}{else}{$attributes.gallery}{/if}{/if}:
{if $ogGaM->getImageTitle($attributes.gallery, $attributes.image)}{$ogGaM->getImageTitle($attributes.gallery, $attributes.image)}{else}{$attributes.image}{/if}</h3>
{if $oAuthor}
<h4>{$oCM->getContent("By", "By")} {$oAuthor->getFullName()}</h4>
{/if}
<h4>{$oCM->getContent("Created", "Created")}: {$ogGaM->getImageCreatedDate($attributes.gallery, $attributes.image)}{if $ogGaM->getImageRecentUpdate($attributes.gallery, $attributes.image)} | {$oCM->getContent("Updated", "Updated")}: {$ogGaM->getImageUpdatedDate($attributes.gallery, $attributes.image)}{if $oEditor} {$oCM->getContent("By", "By")} {$oEditor->getFullName()}{/if}{/if}</h4>

<table border="0" cellpadding="3" cellspacing="3" width="100%" style="border: none 0px;">
  <tr>
    <td align="center">
      {if isset($attributes.prev_token)}<a href="{$oL->getCode()}/{$attributes.gallery}.{$attributes.prev_token}.image">{$oCM->getContent("Previous", "&lt;&lt; Previous")}</a>{/if}
      &nbsp;&nbsp;
      <a href="{$oL->getCode()}/{$attributes.gallery}.gallery">{$oCM->getContent("BackToGallery", "Back to gallery")}</a>
      &nbsp;&nbsp;
      {if isset($attributes.next_token)}<a href="{$oL->getCode()}/{$attributes.gallery}.{$attributes.next_token}.image">{$oCM->getContent("Next", "Next &gt;&gt;")}</a>{/if}
    </td>
  </tr>
  <tr valign="center">
    <td align="center"><img alt="{$ogGaM->getImageTitle($attributes.gallery, $attributes.image)}" src="{$fusebox.urlGalleries}{$attributes.gallery}/{$ogGaM->getImageFileName($attributes.gallery, $attributes.image)}"></td>
  </tr>
  <tr>
    <td align="center">{$ogGaM->getImageContent($attributes.gallery, $attributes.image)}</td>
  </tr>
</table>
