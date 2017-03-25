<?php
require_once(dirname(dirname(__FILE__)).'/wp-load.php');
// 投稿を取得
$arr = array(
	'posts_per_page' => 5,
	'post_status' => 'publish',
	'orderby' => 'date',
	'order' => 'desc'
);
$target_posts = get_posts($arr);
?>

<ul>
<?php if($target_posts): ?>
<?php foreach($target_posts as $post): ?>
<?php
	// 著者
	$author = get_user_by('id', $post->post_author);
	// カテゴリ
	$catgories = get_the_category($post->ID);
?>
<li><?php echo $post->post_title; ?>
	<ul>
	<li>著者：<?php echo $author->display_name; ?></li>
	<li>更新日：<?php echo date('Y/m/d', strtotime($post->post_date)); ?></li>
	<li>概要：<?php echo mb_substr(strip_tags($post->post_content), 0, 100, 'UTF-8'); ?></li>
	<li>カテゴリ：
	<?php
		if($catgories){
			foreach($catgories as $category){
				echo '<a href="'.get_category_link($category->term_id).'">'.$category->name.'</a>　';
			}
		}
	?>
	</li>
	</ul>
</li>
<?php endforeach; ?>
<?php endif; ?>
</ul>