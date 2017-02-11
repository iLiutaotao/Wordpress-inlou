<?php
/**
 * 
 * @Theme INLOU
 * @Theme Author INLOJV
 * @Version 1.1.6
 * @Author URI http://www.inlojv.com
 * @特别说明：若您需要添加自定义的功能请往inc文件夹里面丢，效果和加在这里是一样的，这样可以保持原文件的整洁。
 */

// 添加RSS
add_theme_support( 'automatic-feed-links' );

// 定义菜单
	register_nav_menus(
		array(
			'primary' => __('顶部导航菜单')
		)
	);
	
// 用wp_head加载css以及js
// 加载自定义的CSS以及JS
add_action('init', 'inlo_scripts');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link' );
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );//rel=shortlink 
remove_action('wp_head', 'rel_canonical' ); 
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // 上、下篇. 
remove_action('wp_head', 'start_post_rel_link', 10, 0);// 开始篇 
remove_action('wp_head', 'parent_post_rel_link', 10, 0);// 父篇 
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );//rel=pre 
remove_action('wp_head', 'feed_links_extra', 3);// 额外的feed,例如category
remove_action('wp_head', 'index_rel_link');//当前文章的索引 
remove_filter('the_content', 'wptexturize');//禁用半角符号自动转换为全角
function inlo_scripts() {  
	//wp_register_script( 'default', get_template_directory_uri() . '/jquery.js', array(), '' ); 
	wp_register_script( 'baidulibs-jq', '//cdn.liujiantao.me/libs/jquery.min.js' );
	wp_register_script( 'baidulibs-jq-cookies', '//cdn.liujiantao.me/libs/jquery.cookie.min.js' );
	wp_register_style( 'default', get_template_directory_uri() . '/style.css' ); 
    if ( !is_admin() ) { /** Load Scripts and Style on Website Only */
        wp_enqueue_script( 'baidulibs-jq' );  
        wp_enqueue_script( 'baidulibs-jq-cookies' );  
        wp_enqueue_style( 'default' );  
    }  
}  

// 移除 WordPress 加载的JS和CSS链接中的版本号
function remove_cssjs_ver( $src ) {
	if( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 999 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 999 );


// 编辑器按钮扩展
if (current_user_can ( 'edit_posts' )) {
	add_action ( 'admin_print_footer_scripts', 'inlo_short_code_buttons', 100 );		
}	
	
// 注销WP自带小工具
add_action ( 'widgets_init', 'inlojv_remove_calendar_widget' );
	function inlojv_remove_calendar_widget() {
		unregister_widget ( 'WP_Widget_Calendar' );
		unregister_widget ( 'WP_Widget_Pages' );
		unregister_widget ( 'WP_Widget_Archives' );
		unregister_widget ( 'WP_Widget_Links' );
		unregister_widget ( 'WP_Widget_Meta' );
		unregister_widget ( 'WP_Widget_Search' );
		unregister_widget ( 'WP_Widget_Text' );
		unregister_widget ( 'WP_Widget_Categories' );
		unregister_widget ( 'WP_Widget_Recent_Posts' );
		unregister_widget ( 'WP_Widget_Recent_Comments' );
		unregister_widget ( 'WP_Widget_RSS' );
		unregister_widget ( 'WP_Widget_Tag_Cloud' );
		unregister_widget ( 'WP_Nav_Menu_Widget' );
	}

// INLOU's 全站侧栏/跟随侧栏
function inlo_widgets() {
	register_sidebar(array(
			'name' => '全站侧栏',
			'description' => __('全站侧栏，所有页面均显示'),
			'id' =>  'sidebar-1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
	));
	register_sidebar(array(
        'name' => '滚动跟随侧栏',
		'description' => __('固定跟随滚动，可放置广告'),
        'id' => 'inlo_widget_follow'
	));
}
	add_action( 'widgets_init', 'inlo_widgets' );    

// 判断文章类型
/*
 * 抽调，误删
 */

// 定义字符串长度
/*
 * 抽调，误删
 */

// 首页/归档分页导航
function inlo_pagenavi( $p = 5 ) {
		if ( is_singular() ) return;
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return;
		echo '<div class="page-navigator">';

		if ( empty( $paged ) ) $paged = 1;
		if ( $paged > 1 ) p_link( $paged - 1, '&laquo; 上一页', '&laquo; 上一页' );
		if ( $paged > $p + 2 ) echo '<li><span>...</span></li>';
		for( $i = $paged - $p; $i <= $paged + $p; $i++ ) {
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class='current'><span>{$i}</span></li>" : p_link( $i );
		}
		if ( $paged < $max_page - $p - 1 ) echo '<li><span>...</span></li>';
		if ( $paged < $max_page ) p_link( $paged + 1,'下一页 &raquo;', '下一页 &raquo;' );

		echo '</div>';
}
function p_link( $i, $title = '', $linktype = '' ) {
		if ( $title == '' ) $title = "第 {$i} 页";
		if ( $linktype == '' ) { $linktext = $i; } else { $linktext = $linktype; }
		echo "<li><a href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$linktext}</a></li>";
}
	
// 加载头部SEO
function inlo_head() {
?>
<?php if ( is_home() ) : ?><title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
<?php elseif ( is_search() ) : ?><title><?php echo $_GET['s']; ?>的搜索结果 | <?php bloginfo('name'); ?></title>
<?php elseif ( is_single() ) : ?><title><?php echo trim(wp_title('', false)); ?> | <?php bloginfo('name'); ?></title>
<?php elseif ( is_page() ) : ?><title><?php echo trim(wp_title('', false)); ?> | <?php bloginfo('name'); ?></title>
<?php elseif ( is_category() ): ?><title><?php single_cat_title(); ?> | <?php bloginfo('name'); ?></title>
<?php elseif ( is_year() ) : ?><title><?php the_time('Y年'); ?>发布的内容 | <?php bloginfo('name'); ?></title>
<?php elseif ( is_month() ) : ?><title><?php the_time('Y年n月'); ?>发布的内容 | <?php bloginfo('name'); ?></title>
<?php elseif ( is_day() ) : ?><title><?php the_time('Y年n月j日'); ?>发布的内容 | <?php bloginfo('name'); ?></title>
<?php elseif ( is_tag() ) : ?><title><?php  single_tag_title("", true); ?> | <?php bloginfo('name'); ?></title>
<?php elseif ( is_author() ):?><title><?php wp_title(''); ?>发布的所有内容 | <?php bloginfo('name'); ?></title>
<?php endif;?>
<?php 
	$keywords = _option('keyword');
	$keywords = $keywords ? $keywords : get_bloginfo('name');
	$description = _option('description');
	$description = $description ? $description : get_bloginfo('description');
?>
<?php if(is_single()):?>
<?php 
	$keywords = strip_tags( get_the_tag_list( '',',','') );
	$post = get_post();
	if ($post->post_excerpt) {
		$post_desc = trim( strip_tags( $post->post_excerpt ) );
		$description = inlo_substr( $post_desc, 420, '' );
	} else {
		$description = $post->post_title;
	}
?>
<?php elseif (is_category() ): ?>
<?php 
	$keywords =  single_cat_title( '', false ) ;
	$cate_desc = category_description();
	$description = $cate_desc ? strip_tags( category_description() ) . ',' . $description : $description;
?>
<?php elseif (is_tag() ): ?>
<?php 
	$keywords = single_tag_title( '', false ) ;
?>
<?php elseif (is_page() ): ?>
<?php 
	$p_title = trim ( wp_title('', false) );
	$keywords = "{$p_title}";
?>
<?php endif; ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo trim($description); ?>" />
<meta name="theme-color" content="#399aca">
<?php wp_head();?>
<?php 
}

//获取文章缩略图
/*
 * 抽调，误删
 */

// 初始化AJax请求以及ajax请求处理
add_action ( 'init', 'inlo_ajax' );
function inlo_ajax() {
	if (! empty ( $_GET ['inlo_action'] )) {
		switch ($_GET ['inlo_action']) {
			// 更新阅读人数
			case 'inlo_set_view' :
				if ($_GET ['post_id']) {
					inlo_set_view ( absint ( $_GET ['post_id'] ) );
				}
				break;
		}
		die ( 'Bad Request' );
	}
}

// 获取阅读人数
function inlo_get_view($post_id) {
	$count_key = 'views';
	$count = get_post_meta ( $post_id, $count_key, true );
	return $count == '' ? "0" : $count;
}
// 更新阅读人数
function inlo_set_view($post_id) {
	$count_key = 'views';
	$count = get_post_meta ( $post_id, $count_key, true );
	if ($count == '') {
		delete_post_meta ( $post_id, $count_key );
		add_post_meta ( $post_id, $count_key, '0' );
	}
	$count ++;
	return update_post_meta ( $post_id, $count_key, $count );
}

// 获取评论数 
function inlo_comts_count($post_id, $type = null) {
	global $wpdb;
	$sql = "SELECT count(comment_ID) FROM {$wpdb->comments}
				WHERE comment_type = '{$type}'
				AND comment_approved = 1
				AND comment_post_ID = {$post_id}";
	$res = $wpdb->get_var ( $sql );
	return empty ( $res ) ? 0 : $res;
}

//相关文章
function inlo_related_acticles($post_id = 0) {
	$posts = $terms = array ();
	$args = array (
			'post_status' => 'publish',
			'post__not_in' => array ( $post_id ),
			'ignore_sticky_posts' => 1,
			'orderby' => 'rand',
			'posts_per_page' => 6 
	);
	$post_terms = wp_get_post_terms ( $post_id, 'post_tag' );
	if (! empty ( $post_terms )) {
		foreach ( $post_terms as $term ) {
			$terms [] = $term->term_id;
		}
		$args ['tag__in'] = $terms;
		$posts = query_posts ( $args );
		wp_reset_query ();
	}
	if ( empty($posts) ) {
		unset ( $args ['tag__in'] );
		$post_terms = wp_get_post_terms ( $post_id, 'category' );
		if (! empty ( $post_terms )) {
			foreach ( $post_terms as $term ) {
				$terms [] = $term->term_id;
			}
			$args ['category__in'] = $terms;
			$posts = query_posts ( $args );
			wp_reset_query ();
		}
	}
	$count = count ( $posts );
	if ( $count < 6 ) {
		$post_not_in = array();
		if( !empty($posts) ) {
			foreach ($posts as $post) {
				$post_not_in[] = $post->ID;
			}
		}
		$args = array ( // 再定义一遍数组，如果不定义就无法获取随机文章了
			'post__not_in' => array ( $post_id ), //排除的文章，采用id形式
			'orderby' => 'rand', // 随机文章
		);
		unset ( $args ['category__in'] );
		$args ['posts_per_page'] = 6 -$count;
		$args ['post__not_in'] = $post_not_in;
		$rand_posts = query_posts( $args );
		$posts = array_merge($posts, $rand_posts);
		wp_reset_query ();
	}
	$count = count ( $posts );
	$str = '';
	foreach ( $posts as $k => $p ) {
		$max_width = ($count == 1 || $count == 5) && $k == $count - 1 ? ' max' : null;
		$str .= '
<div class="r-post ' . $max_width . '">
	<a title="' . $p->post_title . '" href="' . get_permalink ( $p->ID ) . '" rel="bookmark">
		<p> 	<i class="glyphicon glyphicon-minus" style="color:#aaa"></i>　' . inlo_substr ( $p->post_title, 600 ) . '</p>		
		<div class="clear"></div>
	</a>
</div>';
	}
	return $str;
}

//文章页上下篇
function inlo_pn_post($post_id = 0, $prev = 'prev') {
	if ($prev == 'prev') {
		$post = get_previous_post ();
		if (! empty ( $post )) {
			return '<a title="' . $post->post_title . '" href="' . get_permalink ( $post->ID ) . '" class="prev_p"><span><i class="glyphicon glyphicon-chevron-up" style="top:3px;color:#aaa"></i> 上一篇 : </span>' . $post->post_title . '</a>';
		}
	} else {
		$post = get_next_post ();
		if (! empty ( $post )) {
			return '<a title="' . $post->post_title . '" href="' . get_permalink ( $post->ID ) . '" class="next_p"><span><i class="glyphicon glyphicon-chevron-down" style="top:3px;color:#aaa"></i> 下一篇 : </span>' . $post->post_title . '</a>';
		}
	}
}

//文章面包屑
function get_breadcrumbs() {
	$str = '<span><a href="' . home_url () . '"><i class="glyphicon glyphicon-home"></i>&nbsp;首页</a>&nbsp;<i class="glyphicon glyphicon-hand-right"></i>&nbsp;';
	if (is_single ()) {
		global $post;
		$cates = get_the_category ( $post->ID );
		$cate_str = '';
		foreach ( $cates as $cate ) {
			$cate_str .= '<a href="' . get_category_link ( $cate ) . '">' . $cate->name . '</a>, ';
		}
		$cate_str = rtrim ( $cate_str, ', ' );
		$str .= $cate_str . '&nbsp;<i class="glyphicon glyphicon-hand-right"></i>&nbsp;<a href="' . get_permalink () . '">' . get_the_title () . '</a>';
	} elseif (is_page ()) {
		$str .= '<a href="' . get_permalink () . '">' . get_the_title () . '</a>';
	} elseif (is_search ()) {
		$str .= '<a href="' . home_url ( '?s=' . $_GET ['s'] ) . '">' . $_GET ['s'] . '的搜索结果</a>';
	} elseif (is_category ()) {
		$str .= '<a href="' . get_category_link ( get_query_var ( 'cat' ) ) . '">' . single_cat_title ( '', false ) . '</a>';
	} elseif (is_tag ()) {
		$str .= '<a href="' . get_tag_link ( get_query_var ( 'tag_id' ) ) . '">' . single_tag_title ( '', false ) . '</a>';
	} elseif (is_year ()) {
		$year = get_the_time ( 'Y' );
		$str .= '<a href="' . get_year_link ( $year ) . '">' . get_the_time ( 'Y年' ) . '</a>';
	} elseif (is_month ()) {
		$year = get_the_time ( 'Y' );
		$month = get_the_time ( 'm' );
		$str .= '<a href="' . get_month_link ( $year, $month ) . '">' . get_the_time ( 'Y年n月' ) . '</a>';
	} elseif (is_day ()) {
		$year = get_the_time ( 'Y' );
		$month = get_the_time ( 'm' );
		$day = get_the_time ( 'd' );
		$str .= '<a href="' . get_day_link ( $year, $month, $day ) . '">' . get_the_time ( 'Y年n月j日' ) . '</a>';
	} elseif (is_author ()) {
		$str .= get_the_author_nickname () . ' 发布的所有文章';
	}
	echo $str . '</span>';
}

//评论列表模块
function inlo_comment($comment, $args, $depth) {
  $avatar = get_avatar ( $comment->comment_author_email, 36 );
  echo '<li '; comment_class(); echo ' id="comment-'.get_comment_ID().'">';

  //头像
  echo '<div class="cl-avatar">';
    echo    $avatar;
  echo '</div>';
  //评论主体
  echo '<div class="cl-main" id="div-comment-'.get_comment_ID().'">';	
    //信息
    echo '<div class="cl-meta">';
            if ($comment->comment_type == '') {
    $author_link = empty ( $comment->comment_author_url ) ? null : ' href="' . $comment->comment_author_url . '"';    
    $author = $comment->comment_author;    
        echo <<<EOF
        <span class="cl-author"><a title="{$author}" rel="external nofollow" target="_blank" class="cl-author-url"{$author_link}>{$author}</a></span>        
EOF;
    }
        echo get_comment_time ( 'Y-n-j H:i' ); 
        if ($comment->comment_approved !== '0'){ 
            echo comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
        echo edit_comment_link(__('( 编辑 )'),' - ','');
      } 
    echo '</div>';
	//内容
    echo '<div class="cl-content" >';
    echo convert_smilies(get_comment_text());
    if ($comment->comment_approved == '0'){
      echo '<span class="cl-approved">（您的评论需要审核后才能显示！）</span><br />';
    }
    echo '</div>';	
  echo '</div>';
}



// 用户自定义扩展功能，放入inc文件夹
define('functions', TEMPLATEPATH.'/inc');
IncludeAll( functions );
function IncludeAll($dir){
    $dir = realpath($dir);
    if($dir){
        $files = scandir($dir);
        sort($files);
        foreach($files as $file){
            if($file == '.' || $file == '..'){
                continue;
            }elseif(preg_match('/.php$/i', $file)){
                include_once $dir.'/'.$file;
            }
        }
    }
} 


?>