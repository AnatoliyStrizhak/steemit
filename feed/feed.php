<?php
//https://v2.steemconnect.com/docs/steemjs#api/get_feed

if (isset($_REQUEST["usr"]) && $_REQUEST["usr"]!="")
{
    $usr=$_REQUEST["usr"];
    $limit=10;

    if (isset($_REQUEST["limit"]) && $_REQUEST["limit"]!="")
    {
	$limit=$_REQUEST["limit"];
    }

    function truncate($text, $length) 
    {
	$length = abs((int)$length);
	if(strlen($text) > $length) 
	{
    	    $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
	}
	return($text);
    }


    header('Content-type: text/xml;charset=UTF-8');
    echo '<?xml version="1.0" encoding="UTF-8" ?>'; 
?>

    <rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
    >


    <channel>
	<title>Steemit RSS feed</title>
	<link>http://brehen-sobaken.ru/steemit/feed.php?usr=<?php echo $usr;?></link>
	<atom:link href="http://brehen-sobaken.ru/steemit/feed.php?usr=<?php echo $usr;?>"  rel="self" type="application/rss+xml" />    
	<description>Steemit RSS feed</description>
	<language>en</language>

<?php
    //Get last posts from each author I follow
    $r=file_get_contents("https://api.steemjs.com/get_feed?account=".$usr."&limit=".$limit);
    $res=json_decode($r,$assoc=true);

    foreach($res as $key=>$val)
    {
	$body=strip_tags($val["comment"]["body"],"");
	$link="http://steemit.com/@".$val["comment"]["author"]."/".$val["comment"]["permlink"];
?>

    <item>
    <title><![CDATA[<?php echo $val["comment"]["title"]; ?>]]></title>
    <guid isPermaLink="true"><?php echo $link; ?></guid>
    <dc:creator><![CDATA[<?php echo $val["comment"]["author"]; ?>]]></dc:creator>
    <description><![CDATA[<?php echo $body; ?>]]></description>
    <pubDate><?php echo $val["comment"]["created"]; ?></pubDate>
    </item>    

<?php
    }
?>
    </channel>
    </rss>
<?php
}
else
{
    echo "Dont forget to enter your Steemit login as url parameter. For example ?usr=astrizak<p>By default limit of items in feed set to 10. If you want more just set &limit=20 param to url</p>";
}
?>