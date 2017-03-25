<?php
$site_url = 'サイトURL';
$params = '?per_page=5&status=publish&orderby=date&order=desc';

// 投稿取得
$posts_json = file_get_contents("{$site_url}/wp-json/wp/v2/posts{$params}");
$target_posts = json_decode($posts_json, true);
?>

<ul>
<?php if($target_posts): ?>
<?php foreach($target_posts as $post): ?>
	<?php
		// 著者
		$user_json = file_get_contents($post['_links']['author'][0]['href']);
		$author = json_decode($user_json, true);
		// カテゴリ
		$categories = $post['categories'];
	?>
	<li><?php echo $post['title']['rendered']; ?>
	<ul>
	<li>著者：<?php echo $author['name']; ?></li>
	<li>更新日：<?php echo date('Y/m/d', strtotime($post['date'])); ?></li>
	<li>概要：<?php echo mb_substr(strip_tags($post['content']['rendered']), 0, 100, 'UTF-8'); ?></li>
	<li>カテゴリ：
	<?php
		if($categories){
			foreach($categories as $category){
				$cat_json = file_get_contents("{$site_url}/wp-json/wp/v2/categories/{$category}");
				$cat = json_decode($cat_json, true);
				echo '<a href="'.$cat['link'].'">'.$cat['name'].'</a>　';
			}
		}
	?>
	</li>
	</ul>
<?php endforeach; ?>
<?php endif; ?>
</ul>