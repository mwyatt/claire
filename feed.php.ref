<?php

/*
<?xml version="1.0" encoding="ISO-8859-1"?>
<rss version="2.0">
    <channel>
        <title>My RSS feed</title>
        <link>http://www.mywebsite.com/</link>
        <description>This is an example RSS feed</description>
        <language>en-us</language>
        <copyright>Copyright (C) 2009 mywebsite.com</copyright>
        <item>
            <title>My News Story 3</title>
            <description>This is example news item</description>
            <link>http://www.mywebsite.com/news3.html</link>
            <pubDate>Mon, 23 Feb 2009 09:27:16 +0000</pubDate>
        </item>
        <item>
            <title>My News Story 2</title>
            <description>This is example news item</description>
            <link>http://www.mywebsite.com/news2.html</link>
            <pubDate>Wed, 14 Jan 2009 12:00:00 +0000</pubDate>
        </item>
        <item>
            <title>My News Story 1</title>
            <description>This is example news item</description>
            <link>http://www.mywebsite.com/news1.html</link>
            <pubDate>Wed, 05 Jan 2009 15:57:20 +0000</pubDate>
        </item>
    </channel>
</rss>
*/

?>

<?php

/* include db connection here */
/* include query(s) here */

header("Content-Type: application/rss+xml; charset=ISO-8859-1");

$output = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$output .= '<rss version="2.0">';
$output .= '<channel>';
	$output .= '<title>' . $site_title . '</title>';
	$output .= '<link>' . $site_url . '</link>';
	$output .= '<description>' . $site_description . '</description>';
	$output .= '<language>en-uk</language>';
	$output .= '<copyright>Copyright (C) 2009 - 2012 ' . $site_url . '</copyright>';

/* use the query result here */

while($row = mysql_fetch_array($db->result)) {

	// converts associative array into seperate variables, loveley!
	extract($row);

	$output .= '
		<item>
			<title>' . $title . '</title>
			<description>' . $description . '</description>	
			<link>' . $link . '</link>
			<pubDate>' . date("D, d M Y H:i:s O", strtotime($date)) . '</pubDate>
		</item>
	';
	
}

$output .= '</channel>';
$output .= '</rss>';

echo $output;

?>