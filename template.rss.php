<?php
  # header('Content-Type: text/xml');
  echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title><?php echo($tumblelog['title']); ?></title>
    <link><?php echo($tumblelog['url']); ?></link>
    <description><?php echo($tumblelog['description']); ?></description>
    <atom:link href="<?php echo($tumblelog['feed-url']); ?>" rel="self" type="application/rss+xml" />
<?php foreach ($tumblelog['posts'] as $post): ?>
    <item>
      <title><?php echo($post['title']); ?></title>
      <description><![CDATA[ <?php echo($post['description']); ?> ]]></description>
      <link><?php echo($post['link']); ?></link>
      <category>format-<?php echo $post['type']; ?></category>
<?php foreach ($post['tags'] as $tag): ?>
      <category><?php echo($tag); ?></category>
<?php endforeach; ?>
      <guid isPermaLink="false"><?php echo($post['title']); ?> <?php echo($post['published-at']); ?></guid>
      <pubDate><?php echo(date('r', $post['published-at'])); ?></pubDate>
    </item>
<?php endforeach; ?>
  </channel>
</rss>
