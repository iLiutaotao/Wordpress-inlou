<?php get_header(); ?>
<?php if( $_GET['ajx'] != 'comts') { ?>
<div id="main">
	<div class="wrap">
		<div class="breadcrumb"><?php echo get_breadcrumbs();?></div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="post">
				<h1 class="post-title"><?php the_title() ?></h1>
				<ul class="post-meta">
					<li>发表于：<?php the_time('Y-m-j'); ?></li>
					<li class="comment-count"><?php comments_popup_link('0 条评论', ' 1 条评论', '% 条评论'); ?></li>
				</ul>
				<div class="main-content">
					<?php the_content(); ?>
				</div>
			</div>
		<?php endwhile; endif;?>
<?php } ?>
		<?php comments_template(); ?>
<?php if( $_GET['ajx'] != 'comts') { ?>
	</div>
</div>
<?php } ?>
<?php if($_GET['ajx'] != 'container' && $_GET['ajx'] != 'comts') { ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php } ?>