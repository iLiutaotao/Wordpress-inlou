<?php
/**
 * 禁用后台谷歌字体
 */
function remove_open_sans() {
    wp_deregister_style( 'open-sans' );
    wp_register_style( 'open-sans', false );
    wp_enqueue_style('open-sans','');
}
add_action( 'init', 'remove_open_sans' );
// 头像服务器替换
function inlo_get_avatar($avatar) {
	$avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),"secure.gravatar.com",$avatar);
	return $avatar;
}
add_filter( 'get_avatar', 'inlo_get_avatar', 10, 3 );
/**
 * 修复WordPress升级4.2自定义表情的各种问题
 */
    //修复4.2表情bug
function disable_emoji($plugins) {
    if (is_array($plugins)) {
    return array_diff($plugins, array(
    'wpemoji'
    ));
    } else {
    return array();
    }
    }
    function init_fixsmilie() {
    global $wpsmiliestrans;
    //默认表情文本与表情图片的对应关系(可自定义修改)
    $wpsmiliestrans = array(
    ':mrgreen:' => 'icon_mrgreen.gif',
    ':neutral:' => 'icon_neutral.gif',
    ':twisted:' => 'icon_twisted.gif',
    ':arrow:' => 'icon_arrow.gif',
    ':shock:' => 'icon_eek.gif',
    ':smile:' => 'icon_smile.gif',
    ':???:' => 'icon_confused.gif',
    ':cool:' => 'icon_cool.gif',
    ':evil:' => 'icon_evil.gif',
    ':grin:' => 'icon_biggrin.gif',
    ':idea:' => 'icon_idea.gif',
    ':oops:' => 'icon_redface.gif',
    ':razz:' => 'icon_razz.gif',
    ':roll:' => 'icon_rolleyes.gif',
    ':wink:' => 'icon_wink.gif',
    ':cry:' => 'icon_cry.gif',
    ':eek:' => 'icon_surprised.gif',
    ':lol:' => 'icon_lol.gif',
    ':mad:' => 'icon_mad.gif',
    ':sad:' => 'icon_sad.gif',
    '8-)' => 'icon_cool.gif',
    '8-O' => 'icon_eek.gif',
    ':-(' => 'icon_sad.gif',
    ':-)' => 'icon_smile.gif',
    ':-?' => 'icon_confused.gif',
    ':-D' => 'icon_biggrin.gif',
    ':-P' => 'icon_razz.gif',
    ':-o' => 'icon_surprised.gif',
    ':-x' => 'icon_mad.gif',
    ':-|' => 'icon_neutral.gif',
    ';-)' => 'icon_wink.gif',
    '8O' => 'icon_eek.gif',
    ':(' => 'icon_sad.gif',
    ':)' => 'icon_smile.gif',
    ':?' => 'icon_confused.gif',
    ':D' => 'icon_biggrin.gif',
    ':P' => 'icon_razz.gif',
    ':o' => 'icon_surprised.gif',
    ':x' => 'icon_mad.gif',
    ':|' => 'icon_neutral.gif',
    ';)' => 'icon_wink.gif',
    ':!:' => 'icon_exclaim.gif',
    ':?:' => 'icon_question.gif',
    );
    //移除WordPress4.2版本更新所带来的Emoji钩子同时挂上主题自带的表情路径
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emoji');
}
add_action('init', 'init_fixsmilie', 5); 
	
//wp4.4 移除wp-json
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );	// wp4.4-移除 wp-json
remove_action( 'wp_head','rest_output_link_wp_head' );						// wp4.4-移除 wp-json
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );			// wp4.4-移除 wp-json
remove_action( 'rest_api_init', 'wp_oembed_register_route' );				// wp4.4-移除 REST API 端点
add_filter( 'embed_oembed_discover', '__return_false' );						// wp4.4-禁用 oEmbed 自动发现功能
remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );		// wp4.4-不要过滤 oEmbed 结果
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );			// wp4.4-移除 oEmbed 发现链接
remove_action( 'wp_head', 'wp_oembed_add_host_js' );						// wp4.4-移除 oEmbed 使用的 JavaScript 文件	

/** Refuse Index **/
function newPostRefresh() {
$temp=file_get_contents("https://www.liujiantao.me/?r=y"); //xxxxxx自己替换
}
add_action(‘publish_post’, ‘newPostRefresh’);
add_action(‘edit_post’, ‘newPostRefresh’);
add_action(‘delete_post’, ‘newPostRefresh’);
add_action(‘comment_post’, ‘newPostRefresh’);
add_action(‘edit_comment’, ‘newPostRefresh’);
add_action(‘delete_comment’, ‘newPostRefresh’);
add_action(‘wp_set_comment_status’, ‘newPostRefresh’);
add_action(‘switch_theme’, ‘newPostRefresh’);


/* SMTP　Ｍail */
add_action('phpmailer_init', 'mail_smtp');
function mail_smtp( $phpmailer ) {
$phpmailer->From = 'noreply@liujiantao.me'; // 邮件里显示出来的发件人邮箱
$phpmailer->FromName = '涛涛的痕迹'; // 发件人昵称
$phpmailer->Host = 'smtp.qq.com';    // SMTP服务器，这里是163的
$phpmailer->Username = 'noreply@liujiantao.me'; // 修改为你的邮箱（该邮箱必须开启SMTP服务，而且要和上面的发件人邮箱相同）
$phpmailer->Password = '99315362401ljt'; // 修改为你的邮箱密码，这里我用*号代替了，注意是在单引号内的。
$phpmailer->Port = 465; // 端口，非加密用25，SSL加密用465
$phpmailer->SMTPSecure = 'ssl'; // 加密方式 ssl 或 tsl（port=25则留空，465为ssl）
$phpmailer->SMTPAuth = true;
$phpmailer->IsSMTP();
}

/* 评论邮件回复通知访客 */
function add_checkbox() {
  echo '<input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked"/>收到回复时通知我';
}

//自动勾选评论回复邮件通知，不想自动勾选则注释掉
add_action('comment_form','add_checkbox');
function comment_mail_notify($comment_id) {
  $admin_notify = '0'; // admin 要不要收回复通知 ( '1'=要 ; '0'=不要 )
  $admin_email = get_bloginfo ('admin_email'); // $admin_email 可改为你指定的 e-mail.
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  global $wpdb;
  if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
    $wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
  if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
    $wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
  $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
  $spam_confirmed = $comment->comment_approved;
  if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
    $wp_email = 'no-reply@' . preg_replace('#^www.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 发出点, no-reply 可改为可用的 e-mail.
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '您在 [' . get_option("blogname") . '] 的留言有了回复';
    $message = '
    <div style="background-color:#fff; font-family: 微软雅黑;border:1px solid #999999; color:#111;border-bottom:8px solid #2279A9; -moz-border-radius:8px; -webkit-border-radius:8px; -khtml-border-radius:8px; border-radius:8px; font-size:13px; width:802px; margin:0 auto; margin-top:10px;">
    <div style="background:#2279A9; width:100%; height:60px; color:white; -moz-border-radius:6px 6px 0 0; -webkit-border-radius:6px 6px 0 0; -khtml-border-radius:6px 6px 0 0; border-radius:6px 6px 0 0; ">
    <span style="height:60px; line-height:60px; margin-left:30px; font-size:16px;"> 您在<a style="text-decoration:none; color:#fff;font-weight:600;"> 【' . get_option("blogname") . '】 </a>上的评论有回复啦！</span></div>
    <div style="width:95%; margin:0 auto">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您在页面　<span style="color:#2279A9;font-weight:bold;">' . get_the_title($comment->comment_post_ID) . '</span>　的评论:<br />
      <p style="background-color: #EEE;border: 1px solid #DDD;padding: 20px;margin: 15px 0;">'. trim(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 给你的回复:<br />
      <p style="background-color: #EEE;border: 1px solid #DDD;padding: 20px;margin: 15px 0;">'. trim($comment->comment_content) . '</p>
      <p>你可以点击　<a href="' . htmlspecialchars(get_comment_link($parent_id, array('type' => 'comment'))) . '">查看完整内容</a></p>
      <p>欢迎再次来访　<a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p>(此邮件由系统自动发出, 请勿回复)</p>
    </div></div>';
         $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
         $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
         wp_mail( $to, $subject, $message, $headers );
  }
}
add_action('comment_post', 'comment_mail_notify');

/** 替换图片URL **/
if ( !is_admin() ) {
	add_action('wp_loaded','c7sky_ob_start');
	function c7sky_ob_start() {
		ob_start('c7sky_qiniu_cdn_replace');
	}
	function c7sky_qiniu_cdn_replace($html) {
		return str_replace('http://cdn.liujiantao.me/', 'https://cdn.liujiantao.me/', $html);
	}
}

/** 开启gzip **/
function gzippy() {
ob_start(‘ob_gzhandler’);
}
if(!stristr($_SERVER['REQUEST_URI'], ‘tinymce’) && !ini_get(‘zlib.output_compression’)) {
add_action(‘init’, ‘gzippy’);
}