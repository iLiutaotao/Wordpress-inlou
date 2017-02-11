<?php get_header(); ?>
<?php $ajx=!empty($_GET['ajx']) ? $_GET['ajx'] : null; if( $ajx != 'comts') { ?>
<div id="main">
	<div class="wrap">
		<div class="breadcrumb"><?php echo get_breadcrumbs();?></div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); inlo_set_view ( get_the_ID() );?>
			<div class="post">
				<h1 class="post-title"><?php the_title() ?></h1>
				<ul class="post-meta">
					<li>发表于：<?php the_time('Y.m.j'); ?></li>
					<span style="font-size:12px;position:relative;top:-1px"><?php edit_post_link('[编辑]'); ?></span>
					<li class="comment-count"><?php comments_popup_link('0 条评论', ' 1 条评论', '% 条评论'); ?></li>
				</ul>
				<div class="main-content">
					<?php the_content(); ?>
				</div>
				<div class="p-authorinfo">
					<div class="p-copyright">						
	<p><strong>转载请注明出处 : </strong><a href="<?php bloginfo('url'); ?>" rel="bookmark" title="作者 <?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>  	&raquo; <a href="<?php the_permalink() ?>" rel="bookmark" title="本文固定链接 <?php the_permalink() ?>"><?php the_title() ?></a></p>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="related_acticles">
				<h2 class="related-title">相关文章</h2>
				<div class="acticles">
					<?php echo inlo_related_acticles( get_the_ID() ); ?>
					<div class="clear"></div>
				</div>
				<div class="r-pn-post">
					<?php echo inlo_pn_post( get_the_ID() ); ?>
					<?php echo inlo_pn_post( get_the_ID(), false ); ?>
					<div class="clear"></div>
				</div>
			</div>			
		<?php endwhile; endif;?>	
<?php } ?>
		<?php comments_template(); ?>
<?php $ajx=!empty($_GET['ajx']) ? $_GET['ajx'] : null; if( $ajx != 'comts') { ?>
	</div>
</div>
<?php } ?>
<?php $ajx=!empty($_GET['ajx']) ? $_GET['ajx'] : null; if( $ajx != 'container') { ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php } ?>