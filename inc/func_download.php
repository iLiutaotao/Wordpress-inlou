<?php

/** 
 * Name	: 			INLOJV - Independent download page tool box
 * Description:	Add download metabox to the bottom of article content and Jump to an independent download page while the button is clicked.
 * Author: 			INLOJV
 * Author URI: 	http://www.inlojv.com
 * QQ group:		QQ群 - 536469565 
 */



/** 
 * Build download meta box
 * QQ群 - 536469565 
 */


// add_meta_box
add_action( 'admin_menu', 'inlojv_dl_meta_box' );
function inlojv_dl_meta_box() {
	add_meta_box( 'add-dl-metabox-html','文章独立下载页面设置', 'inlojv_dl_metabox_html', 'post', 'normal', 'high' );
}
// meta_box_arr
function inlojv_dl_meta_arr() {
	$meta_box_arr = array(
		array( 'title'=>'是否启用',			'name'=>'dl_enable',			'type'=>'checkbox',	'attr'=>'string'	),
		array( 'title'=>'文件名称',			'name'=>'dl_name',				'type'=>'text',			'attr'=>'string'	),
		array( 'title'=>'文件大小',			'name'=>'dl_size',				'type'=>'text',			'attr'=>'string'	),
		array( 'title'=>'更新时间',			'name'=>'dl_date',				'type'=>'text',			'attr'=>'string' 	),
		array( 'title'=>'文件作者',			'name'=>'dl_author',			'type'=>'text',			'attr'=>'string' 	),
		array( 'title'=>'解压密码',			'name'=>'dl_upzip_code',		'type'=>'text',			'attr'=>'string' 	),
		array( 'title'=>'演示地址',			'name'=>'dl_demo',				'type'=>'text',			'attr'=>'link' 		),
		array( 'title'=>'百度云盘',			'name'=>'dl_bd_url',			'type'=>'text',			'attr'=>'link' 		),
		array( 'title'=>'百度云盘提取码',	'name'=>'dl_bd_url_code',	'type'=>'text',			'attr'=>'string'	),
		array( 'title'=>'360云盘',			'name'=>'dl_360_url',			'type'=>'text',			'attr'=>'link' 		),
		array( 'title'=>'360云盘提取码',	'name'=>'dl_360_url_code',	'type'=>'text',			'attr'=>'string'	),
		array( 'title'=>'城通网盘',			'name'=>'dl_tc_url',  			'type'=>'text',			'attr'=>'link' 		),
		array( 'title'=>'其他网盘',			'name'=>'dl_other_url',		'type'=>'text',			'attr'=>'link' 		),
		array( 'title'=>'推荐下载地址',	'name'=>'dl_normal_url',  	'type'=>'text',			'attr'=>'link' 		)
	);	
	return apply_filters( 'dl_metabox_array', $meta_box_arr );
}

// Main of dl metabox html
function inlojv_dl_metabox_html() {
?>
<style>
	.inlojv-table th{width:15%}
	.inlojv-table .cb-des{top:2px;position:relative}
	.inlojv-table .input-checkbox{width:auto}
	.inlojv-table .input-text{width:100%}
</style>
<table class='form-table inlojv-table'>
	<?php 
	global $post;
	$meta_box_arr = inlojv_dl_meta_arr();
	foreach ( $meta_box_arr as $meta_tr ){
		$meta_value = get_post_meta( $post->ID, $meta_tr['name'], true );
		if ( $meta_tr['type'] == 'checkbox' ){
	?>			
		<tr>
			<th>
				<label for="<?php echo $meta_tr['name']; ?>"><?php echo $meta_tr['title']; ?></label>
			</th>
			<td>
				<input class="input-checkbox" type="checkbox" name="<?php echo $meta_tr['name']; ?>" id="<?php echo $name; ?>" value="enable" <?php if ( htmlentities( $meta_value, 1 ) == 'enable' ) echo ' checked="checked" '; ?> />
				<span class="cb-des"><?php echo _('勾选则启用');?></span>
				<input type="hidden" name="<?php echo $meta_tr['name']; ?>_dl_name" id="<?php echo $name; ?>_dl_name" value="<?php echo wp_create_nonce( $meta_tr['name'] ); ?>" />
			</td>
		</tr>
	<?php
		}elseif ( $meta_tr['type'] == 'text' ){		
		$is_attr_value = $meta_tr['attr']=='link' ? esc_url( wp_specialchars( $meta_value, 1 ) ) : wp_specialchars( $meta_value, 1 );
	?>
		<tr>
			<th>
				<label for="<?php echo $meta_tr['name']; ?>"><?php echo $meta_tr['title']; ?></label>
			</th>
			<td>
				<input class="input-text" type="text" name="<?php echo $meta_tr['name']; ?>" id="<?php echo $meta_tr['name']; ?>" value="<?php echo $is_attr_value; ?>" size="30" tabindex="30" />
				<input type="hidden" name="<?php echo $meta_tr['name']; ?>_dl_name" id="<?php echo $meta_tr['name']; ?>_dl_name" value="<?php echo wp_create_nonce( $meta_tr['name'] ); ?>" />
			</td>
		</tr>
	<?php
		}
	}
	?>
</table>
<?php
}

// Save post & post meta data
add_action( 'save_post', 'inlojv_update_postmeta' );
function inlojv_update_postmeta( $post_id ) {
	$meta_box_arr = inlojv_dl_meta_arr(); 
	foreach ( $meta_box_arr as $meta_tr ){	
		if ( !wp_verify_nonce( $_POST[$meta_tr['name'] . '_dl_name'], $meta_tr['name'] ) ){ return $post_id; }
		if ( 'page' == $_POST['post_type'] && !current_user_can( 'edit_page', $post_id ) ){ return $post_id; }		
		elseif ( 'post' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) ){ return $post_id; }		
		$dl_data = stripslashes( $_POST[$meta_tr['name']] );		
		if ( get_post_meta( $post_id, $meta_tr['name'] ) == '' ){										// 若meta字段值为空 - 添加自定义meta字段		
			add_post_meta( $post_id, $meta_tr['name'], $dl_data, true );			
		}elseif ( $dl_data != get_post_meta( $post_id, $meta_tr['name'], true ) ){			// 若与当前post值不同 - 则更新字段		
			update_post_meta( $post_id, $meta_tr['name'], $dl_data );			
		}elseif ( $dl_data == '' ){																				// 若为空 - 则删除字段		
			delete_post_meta( $post_id, $meta_tr['name'], get_post_meta( $post_id, $meta_tr['name'], true ) );			
		}		
	}
}





/** 
 * Add downloadbox to content
 * QQ群 - 536469565 
 */
 
function inlojv_meta_value( $value ){
	return get_post_meta(get_the_ID(), $value, true);
}
// Add box to article content
add_filter('the_content','inlojv_add_downloadbox');
function inlojv_add_downloadbox($content){
	 $dlbox_enable 	= inlojv_meta_value('dl_enable');
	 $dlbox_name 	= inlojv_meta_value('dl_name');
	 $dlbox_date 		= inlojv_meta_value('dl_date');
	 $dlbox_author 	= inlojv_meta_value('dl_author');
	 $dlbox_size 		= inlojv_meta_value('dl_size');
	 $dlbox_demo 	= inlojv_meta_value('dl_demo');	 
	 $demo_content	= '';
	if($dlbox_demo){
		$site_url 		= get_bloginfo( 'url' );
		$site_name 	= get_bloginfo( 'name' );
		$demo_content .= '<p class="dl-flieurl"><a class="view-demo" rel="external nofollow"   href="'.site_url().'/page-demo.php?postid='.get_the_ID().'&siteurl='.$site_url.'&sitename='.$site_name.'" target="_blank" title="'.$dlbox_name.' ">查看演示</a></p>';		
	}
	if($dlbox_enable) {
	$content .= '<style>
	.inlojv-dl-box{box-sizing:border-box;background:#34495e;position:relative;color:#fff;margin:50px 0 40px;box-sizing:border-box;width:100%;font-size:inherit}
	.inlojv-dl-box .dl-flieurl > a{font-size:inherit;color:#fff;background:none}
	.inlojv-dl-box p{float:left;line-height:30px;padding:10px;15px;border-right:1px solid #666}
	.inlojv-dl-box p span{box-sizing:border-box;color:#666;display:none;position:absolute;top:-50px;left:0;background:#eee;width:100%;line-height:50px;overflow:hidden;padding:0 10px}
	.inlojv-dl-box p:hover{cursor:default;background:#1291ea}
	.inlojv-dl-box p:hover >  span{display:inline-block}
	.inlojv-dl-box p.dl-flieurl{float:right;background:#1291ea;border-left:1px solid #ddd;border-right:0}
	.inlojv-dl-box p.dl-flieurl:hover{background:#2980b9}
	#dl-page{display:none;background:#fff;z-index:99999;position:fixed;border:3px solid #ddd;border-radius:5px;width:100%;max-width:800px;top:10px;left:50%;margin-left:-400px}
	#demo-page{display:none;background:#fff;z-index:99999;position:fixed;border:3px solid #ddd;border-radius:5px;width:98%;left:50%;top:0;margin-left:-49%}
	.dl-mask{position:fixed;width:100%;height:100%;background:rgba(0,0,0,0.3);top:0;left:0;}
	@media screen and (max-width:768px){.dl-filedate,.dl-flieauthor,.dl-fliesize{display:none}}
	</style>';
	$content .= '
	<div class="inlojv-dl-box">
		<div class="dl-content">
			<p class="dl-fliename">文件名称<span>'.$dlbox_name.'</span></p>
			<p class="dl-filedate">更新日期<span>'.$dlbox_date.'</span></p>
			<p class="dl-flieauthor">作者信息<span>'.$dlbox_author.'</span></p>
			<p class="dl-fliesize">文件大小<span>'.$dlbox_size.'</span></p>
			<p class="dl-flieurl"><a class="dl-button" rel="external nofollow" title="'.$dlbox_name.'" href="'.site_url().'/page-download.php?postid='.get_the_ID().'"  target="_blank">点击下载</a></p>
			'.$demo_content.'
		</div>
	<div class="clear"></div>
	</div>';	
	}
	return $content;
}



