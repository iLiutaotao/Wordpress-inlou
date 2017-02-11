<?php


//侧栏小工具 ////////////////////////////////////////////////////////
//搜索小工具
add_action ( 'widgets_init', create_function ( '', 'return register_widget("Inlo_Widget_Search");') );
class Inlo_Widget_Search extends WP_Widget {
	function Inlo_Widget_Search() {
		$widget_ops = array (
				'classname' => 'Inlo_Widget_Search',
				'description' => '站内搜索功能'
		);
		$this->__construct ( 'Inlo_Widget_Search', 'INLO-搜索工具', $widget_ops );
	}
	function form($instance) {
		$instance = wp_parse_args ( ( array ) $instance, array (
				'title' =>	'搜索',
		) );
		$title = $instance ['title'];
?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">
		标题：<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
	</label>
</p>
<?php
	}
	function widget($args, $instance) {
	$form = '
		<form class="s-form" action="/?s=">
			<input type="text" name="s" class="s-key" required />
			<input type="submit" value="搜一搜" class="s-sub tra" title="搜索" />
		</form>';
	echo '
		<div class="widget jv-search">
			<h3 class="widget-title">'. $instance['title'] .'</h3>
			<div class="jv-custom inlo-search">
				'.$form.'
			</div>
		</div>';
	}
}

//分类目录小工具
add_action ( 'widgets_init', create_function ( '', 'return register_widget("Inlo_Widget_Category");') );
class Inlo_Widget_Category extends WP_Widget {
	function Inlo_Widget_Category() {
		$widget_ops = array (
				'classname' => 'Inlo_Widget_Category',
				'description' => '显示分类目录'
		);
		$this->__construct ( 'Inlo_Widget_Category', 'INLO-分类目录', $widget_ops );
	}
	function form($instance) {
		$instance = wp_parse_args ( ( array ) $instance, array (
				'title' => '分类目录',				
		) );
		$title = $instance ['title'];
		$column = absint($instance ['column']);
?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">
		标题：<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
	</label>
</p>
<?php
	}
	function update($new_instance, $old_instance) {
		$new_instance ['column'] = absint($new_instance ['column']);
		return $new_instance;
	}
	function widget($args, $instance) {
		$category = get_categories('hierarchical=false');
		if( !empty ( $category ) ){
			$column =' jv-cats';
			echo '<div class="widget'.$column.'">
					<h3 class="widget-title">'. $instance['title'] .'</h3><div class="post-cats">';
			foreach($category as $cate){
				$title = empty($cate->category_description) ? $cate->name : $cate->category_description;
				echo '<a title="'.$title.'" href="'.get_category_link($cate).'" class="tra">'.$cate->name.' <span style="color:#2e5984">['.$cate->count.']</span></a>';
			}
			echo '</div><div class="clear"></div></div>';
		}
	}
}

//自定义内容小工具
add_action ( 'widgets_init', create_function ( '', 'return register_widget("Inlo_Widget_Custom");') );
class Inlo_Widget_Custom extends WP_Widget {
	function Inlo_Widget_Custom() {
		$widget_ops = array (
				'classname' => 'Inlo_Widget_Custom',
				'description' => '自定义内容，广告类'
		);
		$this->__construct ( 'Inlo_Widget_Custom', 'INLO-自定义内容', $widget_ops );
	}
	function form($instance) {
		$instance = wp_parse_args ( ( array ) $instance, array (
				'title' =>	'',
				'content' => ''
		) );
		$content = $instance ['content'];
		$title = $instance ['title'];
?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">
		标题：<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
	</label>
</p>	
<p>
	<label for="<?php echo $this->get_field_id('content'); ?>">
		内容: <textarea class="widefat" rows="15" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo $content; ?></textarea>
	</label>
</p>
<?php
	}
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	function widget($args, $instance) {
		echo '<div class="widget">
					<h3 class="widget-title">'. $instance['title'] .'</h3>
					<div class="jv-custom">'. $instance ['content'] .'</div>
			 </div>';
	}
}

//用户登录小工具
add_action('widgets_init', 'jv_loginwidget_init');
function jv_loginwidget_init() {
    register_widget('jv_loginwidget');
}
class jv_loginwidget extends WP_Widget {
    function jv_loginwidget() {
        $widget_ops = array('description' => '用户登录小工具');
        $this->__construct('jv_loginwidget', 'INLO-用户登录', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
?>
<div class="widget jv-login">
<?php
    global $user_ID, $user_identity, $user_email, $user_login;
    wp_get_current_user();
    if (!$user_ID) {
?>
<h3 class="widget-title">用户登录</h3>
<div class="jv-custom">
<form class="jv-login-custom" action="<?php echo get_option('siteurl'); ?>/wp-login.php" method="post">
<p><label><span class="glyphicon glyphicon-user"></span> 用户名：<input class="text" type="text" name="log" id="log" value="" size="14" placeholder="输入用户名..."/></label></p>
<p><label><span class="glyphicon glyphicon-log-in"></span> 密　码：<input class="text" type="password" name="pwd" id="pwd" value="" size="14" placeholder="输入密码..."/></label></p>
<p><input class="login_btn" type="submit" name="submit" value="登　录" />　<a class="l-url" href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=register" target="_blank" rel="nofollow">注 册</a> | <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=lostpassword" target="_blank" class="l-url" rel="nofollow">忘记密码？</a></p>
</form>
</div>
<?php } else { ?>
<h3 class="widget-title">后台管理</h3>
<div class="jv-custom jv-login-custom">
<div class="jv_avatar">
<?php echo get_avatar( get_the_author_meta('ID'), '65' ); ?>
</div>
<div class="jv_li">
    <li><a class="l-url" href="<?php bloginfo('url') ?>/wp-admin/post-new.php" rel="nofollow" target="_blank"><span class="glyphicon glyphicon-edit"></span> 撰写文章</a></li>
    <li><a class="l-url" href="<?php bloginfo('url') ?>/wp-admin/edit-comments.php" rel="nofollow" target="_blank"><span class="glyphicon glyphicon-comment"></span> 管理评论</a></li>
    <li><a class="l-url" href="<?php bloginfo('url') ?>/wp-admin/" rel="nofollow" target="_blank"><span class="glyphicon glyphicon-cog"></span> 控制面板</a></li>
    <li><a class="l-url" href="<?php $current_url = home_url(add_query_arg(array())); echo wp_logout_url( $current_url ); ?>" rel="nofollow" target="_blank"><span class="glyphicon glyphicon-log-out"></span> 注销登录</a></li>
</div>
</div>
<?php } ?>
</div>
<?php	
    }
    function form($instance) {
        global $wpdb;
?>
    <p>此工具无需设置</p>
<?php
    }
}


//友情链接小工具
add_filter ( 'pre_option_link_manager_enabled', '__return_true' );
add_action ( 'widgets_init', create_function ( '', 'return register_widget("Inlo_Widget_Links");') );
class Inlo_Widget_Links extends WP_Widget {
	function Inlo_Widget_Links() {
		$widget_ops = array (
				'classname' => 'Inlo_Widget_Links',
				'description' => '在后台链接处添加友链'
		);
		$this->__construct ( 'Inlo_Widget_Links', 'INLO-友情链接', $widget_ops );
	}
	function form($instance) {
		$instance = wp_parse_args ( ( array ) $instance, array (
				'title' => '友情链接'
		) );
		$title = $instance ['title'];
?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">
		标题：<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
	</label>
</p>
<?php 

	}
	function update($new_instance, $old_instance) {
		return $new_instance;
	}
	function widget($args, $instance) { 
		$bookmarks = get_bookmarks('hide_invisible=0');
		if($bookmarks){ 
?>
<div class="widget jv-links">
	<h3 class="widget-title"><?php echo $instance ['title']; ?></h3>
	<div class="jv-bookmarks">
	<?php foreach( $bookmarks as $bs ){ if ( $bs->link_rel ==  'contact' || ( !is_home() && $bs->link_rel == 'acquaintance' )  ) { continue; } ?>
		<a class="tra<?php echo $bs->link_visible == 'N' ? ' bs-hide' : null; ?>" href="<?php echo $bs->link_url;?>" title="<?php echo $bs->link_description; ?>" target="<?php echo $bs->link_target == '' ? '_target' : $bs->link_target; ?>"> 	<i class="glyphicon glyphicon-user"></i> <?php echo $bs->link_name; ?></a>
	<?php }?>
		<div class="clear"></div>
	</div>
</div>
<?php }
	}
}



//最新评论小工具
add_action('widgets_init', 'Inlo_Widget_Rcomments_init');
function Inlo_Widget_Rcomments_init() {
    register_widget('Inlo_Widget_Rcomments');
}
class Inlo_Widget_Rcomments extends WP_Widget {
    function Inlo_Widget_Rcomments() {
        $widget_ops = array('description' => '最新评论小工具');
        $this->__construct('Inlo_Widget_Rcomments', 'INLO-最新评论', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
		global $wpdb;
        $rcnum = strip_tags($instance['rcnum']);
		$rctitle = strip_tags($instance['rctitle']);
        echo '<div class="widget jv-rcomments">';
?>
	<h3 class="widget-title"><?php echo $rctitle; ?></h3>
	<div class="rcomments-content">
	<?php
	$limit_num = $rcnum; //这里定义显示的评论数量
	$my_email = "'" . get_bloginfo ('admin_email') . "'"; //这里是自动检测博主的邮件，实现博主的评论不显示
	$rc_comms = $wpdb->get_results("
	 SELECT ID, post_title, comment_ID, comment_author, comment_author_email, comment_content
	 FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts
	 ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID)
	 WHERE comment_approved = '1'
	 AND comment_type = ''
	 AND post_password = ''
	 AND comment_author_email != $my_email
	 ORDER BY comment_date_gmt
	 DESC LIMIT $limit_num
	 ");
	$rc_comments = '';
	foreach ($rc_comms as $rc_comm) {
	$rcavatar = get_avatar ( $rc_comm->comment_author_email, 16 );
	$rc_comments .= '<li>'.$rcavatar.'<span>'.$rc_comm->comment_author.': </span><a class="tra" href="'. get_permalink($rc_comm->ID).'#comment-'.$rc_comm->comment_ID.'" title="查看《'.$rc_comm->post_title. '》上的评论" rel="nofollow">'.preg_replace("/\[private\].+?\[\/private\]/","@鹳狸猿",wp_trim_words(strip_tags($rc_comm->comment_content)))."</a></li>\n";
	}
	$rc_comments = convert_smilies($rc_comments);
	echo '<ul>';
	echo $rc_comments;
	echo '</ul>';   
	?>
	</div>
<?php	
        echo "</div>\n";
    }
	
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['rcnum'] = strip_tags($new_instance['rcnum']);
		$instance['rctitle'] = strip_tags($new_instance['rctitle']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('rcnum' => '10','rctitle' => '最新评论'));
        $rcnum = strip_tags($instance['rcnum']);
		$rctitle = strip_tags($instance['rctitle']);
?>        
        <p><label for="<?php echo $this->get_field_id('rcnum'); ?>">显示数量：<input id="<?php echo $this->get_field_id('rcnum'); ?>" name="<?php echo $this->get_field_name('rcnum'); ?>" type="text" value="<?php echo $rcnum; ?>" /></label></p>
		 <p><label for="<?php echo $this->get_field_id('rctitle'); ?>">自定义标题：<input id="<?php echo $this->get_field_id('rctitle'); ?>" name="<?php echo $this->get_field_name('rctitle'); ?>" type="text" value="<?php echo $rctitle; ?>" /></label></p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}


//聚合面板小工具
add_action('widgets_init', 'Inlo_randomwidget_init');
function Inlo_randomwidget_init() {
    register_widget('Inlo_randomwidget');
}
class Inlo_randomwidget extends WP_Widget {
    function Inlo_randomwidget() {
        $widget_ops = array('description' => '显示最新、热评、随机文章小工具');
        $this->__construct('Inlo_randomwidget', 'INLO-聚合面板', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
		global $wpdb;
		$newtitle = strip_tags($instance['newtitle']);
		$hottitle = strip_tags($instance['hottitle']);
		$randtitle = strip_tags($instance['randtitle']);
		$num = strip_tags($instance['num']);
		$days = strip_tags($instance['days']);
		$sticky = get_option( 'sticky_posts' );
		echo '<div class="widget jv-tab" id="inlo_panel" style="overflow: hidden;">';
?>
<ul class="tab-title"><span class="selected"><?php echo $newtitle; ?></span><span><?php echo $hottitle; ?></span><span><?php echo $randtitle; ?></span></ul>
<div class="tab-content">
        <ul><?php $posts = query_posts(array('orderby' =>'date','showposts'=>$num,'post__not_in' =>$sticky)); while(have_posts()) : the_post(); ?> 
            <li><a class="sb-border" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo wp_trim_words(get_the_title()); ?></a></li><?php endwhile; wp_reset_query(); ?>
        </ul>
        <ul class="hide">
		<?php
			$hotsql = "SELECT ID , post_title , comment_count FROM $wpdb->posts WHERE post_type = 'post' AND TO_DAYS(now()) - TO_DAYS(post_date) < $days AND ($wpdb->posts.`post_status` = 'publish' OR $wpdb->posts.`post_status` = 'inherit') ORDER BY comment_count DESC LIMIT 0 , $num ";
			$hotposts = $wpdb->get_results($hotsql);
			$hotoutput = "";
			foreach ($hotposts as $post){
			$hotoutput .= "\n<li><a class=\"sb-border\" href= \"".get_permalink($post->ID)."\" rel=\"bookmark\" title=\"".$post->post_title." (".$post->comment_count."条评论)\" >". wp_trim_words($post->post_title)."</a></li>";
			}
			echo $hotoutput;
		 ?>
	</ul>
		<ul class="hide"><?php $posts = query_posts(array('orderby' =>'rand','showposts'=>$num,'post__not_in' =>$sticky)); while(have_posts()) : the_post(); ?> 
            <li><a  class="sb-border" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo wp_trim_words(get_the_title()); ?></a></li><?php endwhile; wp_reset_query(); ?>
        </ul>
    </div>
<?php	
		echo "</div>\n";
    }
     function update($new_instance, $old_instance) {
         if (!isset($new_instance['submit'])) {
             return false;
         }
         $instance = $old_instance;
         $instance['newtitle'] = strip_tags($new_instance['newtitle']);
		 $instance['hottitle'] = strip_tags($new_instance['hottitle']);
		 $instance['randtitle'] = strip_tags($new_instance['randtitle']);
		 $instance['num'] = strip_tags($new_instance['num']);
		 $instance['days'] = strip_tags($new_instance['days']);
         return $instance;
     }
    function form($instance) {
        global $wpdb;
		$instance = wp_parse_args((array) $instance, array('newtitle' => '最新文章','hottitle' => '热评文章','randtitle' => '随机文章','num' => '5','days' => '14'));
        $newtitle = strip_tags($instance['newtitle']);
		$hottitle = strip_tags($instance['hottitle']);
		$randtitle = strip_tags($instance['randtitle']);
		$num = strip_tags($instance['num']);
		$days = strip_tags($instance['days']);
?>
 <p><label for="<?php echo $this->get_field_id('newtitle'); ?>">最新文章标题：<input class="widefat" id="<?php echo $this->get_field_id('newtitle'); ?>" name="<?php echo $this->get_field_name('newtitle'); ?>" type="text" value="<?php echo $newtitle; ?>" /></label></p>
 <p><label for="<?php echo $this->get_field_id('hottitle'); ?>">热评文章标题：<input class="widefat" id="<?php echo $this->get_field_id('hottitle'); ?>" name="<?php echo $this->get_field_name('hottitle'); ?>" type="text" value="<?php echo $hottitle; ?>" /></label></p>
 <p><label for="<?php echo $this->get_field_id('randtitle'); ?>">随机文章标题：<input class="widefat" id="<?php echo $this->get_field_id('randtitle'); ?>" name="<?php echo $this->get_field_name('randtitle'); ?>" type="text" value="<?php echo $randtitle; ?>" /></label></p>
 <p><label for="<?php echo $this->get_field_id('num'); ?>">显示数量：<input class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" type="text" value="<?php echo $num; ?>" /></label></p>
 <p><label for="<?php echo $this->get_field_id('days'); ?>">热评文章控制天数：<input class="widefat" id="<?php echo $this->get_field_id('days'); ?>" name="<?php echo $this->get_field_name('days'); ?>" type="text" value="<?php echo $days; ?>" /></label></p>
         <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}

//标签云小工具
add_action ( 'widgets_init', create_function ( '', 'return register_widget("Inlo_Widget_Tags");') );
class Inlo_Widget_Tags extends WP_Widget {
	function Inlo_Widget_Tags() {
		$widget_ops = array (
				'classname' => 'Inlo_Widget_Tags',
				'description' => '显示标签云'
		);
		$this->__construct ( 'Inlo_Widget_Tags', 'INLO-标签云', $widget_ops );
	}
	function form($instance) {
		$instance = wp_parse_args ( ( array ) $instance, array (
				'title' => '热门标签',
				'count' => 32
		) );
		$title = $instance ['title'];
		$count = $instance ['count'];
?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">
		标题：<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
	</label>
</p>
<p>
	<label for="<?php echo $this->get_field_id('count'); ?>">
		显示数量: <input type="text" size="3" maxlength="2" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" value="<?php echo absint($count); ?>" />
	</label>
</p>
<?php 
	}
	function update($new_instance, $old_instance) {
		$new_instance ['count'] = absint( $new_instance ['count'] );
		return $new_instance;
	}
	function widget($args, $instance) { 
?>
<div class="widget">
	<h3 class="widget-title"><?php echo $instance ['title']; ?></h3>
	<div class="jv-tags-wrap jv-border" id="jv-tags">
		<?php wp_tag_cloud('smallest=13&largest=13&number=20&unit=px&orderby=count&order=DESC'); ?>
	</div>
</div>
<?php 
	}
}

//网站统计小工具
add_action('widgets_init', create_function('', 'return register_widget("widget_tongji");'));
class widget_tongji extends WP_Widget {
	function widget_tongji() {
		$option = array('classname' => 'jv-tongji', 'description' => '网站统计' );
		$this->__construct(false, 'INLO-网站统计', $option);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '网站统计' : apply_filters('widget_title', $instance['title']);
		$time = empty($instance['time']) ? '建站日期' : apply_filters('widget_count', $instance['time']);

		echo '<h3 class="widget-title">' .$title. '</h3>';
		echo '<ul class="tongji" style=" border-top: none;padding-bottom:10px">';?>
			<li style="color: #6E7173;line-height: 20px;display: block;border-bottom: 1px solid #eee;padding: 5px 15px;">文章总数：<?php $count_posts = wp_count_posts();echo $published_posts = $count_posts->publish;?>篇</li>
            <li style="color: #6E7173;line-height: 20px;display: block;border-bottom: 1px solid #eee;padding: 5px 15px;">评论总数：<?php $count_comments = get_comment_count();echo $count_comments['approved'];?>条</li>
            <li style="color: #6E7173;line-height: 20px;display: block;border-bottom: 1px solid #eee;padding: 5px 15px;">页面总数：<?php $count_pages = wp_count_posts('page'); echo $page_posts = $count_pages->publish; ?> 个</li>
            <li style="color: #6E7173;line-height: 20px;display: block;border-bottom: 1px solid #eee;padding: 5px 15px;">分类总数：<?php echo $count_categories = wp_count_terms('category'); ?>个</li>
            <li style="color: #6E7173;line-height: 20px;display: block;border-bottom: 1px solid #eee;padding: 5px 15px;">标签总数：<?php echo $count_tags = wp_count_terms('post_tag'); ?>个</li>
            <li style="color: #6E7173;line-height: 20px;display: block;border-bottom: 1px solid #eee;padding: 5px 15px;">运行天数：<?php echo floor((time()-strtotime($time))/86400); ?> 天</li>
		<?php 
		echo '</ul>';
		echo $after_widget;
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['time'] = strip_tags($new_instance['time']);
		return $instance;
	}
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => '' ) );
		$title = strip_tags($instance['title']);
		$time = strip_tags($instance['time']);

		echo '<p><label>标题：<input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.attribute_escape($title).'" size="24" /></label></p>';
		echo '<p><label>建站日期：<input id="'.$this->get_field_id('time').'" name="'.$this->get_field_name('time').'" type="text" value="'.attribute_escape($time).'" size="24" /></label></p>';
	}
}
?>