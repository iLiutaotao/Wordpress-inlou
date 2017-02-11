<?php if (is_home() || is_front_page()) { ?>
<?php if( _option('is_banner') ) { ?>
<div class="notice">
	<div class="n_banner"><img src="<?php bloginfo('template_directory'); ?>/img/<?php echo _option('banner');?>" /><h2 class="n_title tra" style="display:<?php echo _option('is_notice') ? "block" : "none";?>"><span><?php echo _option('notice');?></span></h2></div>
</div>
<?php } ?>
<?php } ?>
<div class="post-warp">
<?php if ( have_posts() ) { ?>
<?php while ( have_posts() ) { the_post(); global $post; ?>
	<div class="post-box">	    	
	    	<?php if ( post_password_required( $post->ID ) ) { ?>
	    	<div class="password-post-content">
	    		<?php echo get_the_password_form( $post->ID ); ?>
	    	</div>
	    	<?php } else { ?>
			<ul class="post-tags">				
				<li class="views" title="访问人数"><i class="glyphicon glyphicon-eye-open"></i><a>Views/<?php echo inlo_get_view( $post->ID ); ?></a></li>
				<li class="comments" title="评论数"><i class="glyphicon glyphicon-comment"></i><a>Comments/<?php echo inlo_comts_count( $post->ID ); ?></a></li>
				<li class="podate" title="发布时间"><i class="glyphicon glyphicon-time"></i><a>Date/<?php the_time('Y.n.j'); ?></a></li>
			</ul>
			<div class="post-thumb">
				<a href="<?php echo get_permalink(); ?>"><?php echo inlo_get_thumb( $post->ID, $post->post_title, $post->post_content, true ); ?></a>
				<i class="post-light"></i>
				<div class="hover-post">
					<a href="<?php the_permalink()?>"><?php echo 'Read More';?></a>
				</div>
			</div>
	    	<div class="post-content">		
	    		<div class="post-header">
					<h3 class="post-title tra"><a href="<?php the_permalink(); ?>" class="tra"><?php the_title(); ?></a></h3>
				</div>
	    	<?php
	    		$desc = has_excerpt();
	    		if ( ! $desc ) {
	    			// 去掉表情 和 回复可见内容
	    			$post_content = preg_replace( '/(\s\:.*\:\s)|(<\!--inlo_hide_start-->([\s\S]*)<\!--inlo_hide_end-->)/i', '', get_the_content() );
	    			echo inlo_substr( strip_tags( $post_content ), 360, '<span class="read-more" style="margin-left:5px;color:#aaa">...</span>' ) ;
	    		} else {
	    			the_excerpt();
	    		}
	    	?>
	    	</div>
	    	<div class="clear"></div>	
	    	<?php } ?>
	</div>
<?php  } ?>
<?php } ?>
</div>
<?php echo inlo_pagenavi(); ?>