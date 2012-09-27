<h2>sitemap.xml</h2>

<a href="{$myself}admin.showSitemapItemForm">Add new Item</a>


<pre>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"&gt;
{if !empty($arrItems)}
{foreach from=$arrItems item=item}
	&lt;url&gt; <a href="{$myself}admin.showSitemapItemForm&id={$item.id}">edit</a> | <a class="deletelink" href="{$myself}admin.deleteSitemapItem&id={$item.id}" onClick="return confirm('Are you sure?')">X</a>
		&lt;loc&gt;<a href="{$item.url}">{$item.url}</a>&lt;/loc&gt;
		&lt;lastmod&gt;{$item.last_modified|date_format:"%Y-%m-%d"}&lt;/lastmod&gt;
		&lt;changefreq&gt;{$item.change_freq}&lt;/changefreq&gt;
		&lt;priority&gt;{$item.priority}&lt;/priority&gt;
	&lt;/url&gt;
{/foreach}
{/if}
&lt;/urlset&gt; 
</pre>
