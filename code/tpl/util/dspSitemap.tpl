<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
{if !empty($arrItems)}
{foreach from=$arrItems item=item}
	<url>
		<loc>{$item.url|escape:"url"}</loc>
		<lastmod>{$item.last_modified|date_format:"%Y-%m-%d"}</lastmod>
		<changefreq>{$item.change_freq}</changefreq>
		<priority>{$item.priority}</priority>
	</url>
{/foreach}
{/if}
</urlset>