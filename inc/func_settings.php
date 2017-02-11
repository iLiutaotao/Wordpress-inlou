<?php

function _option($i){
    $option = get_option('inlo_config');
	
	if (isset ( $option [$i] )) { // 如果该变量数组内的域变量被定义
		$item = $option[$i];
        if (is_array ( $item )) {
            return $item;
        }		
		return stripcslashes ( $item ); // 返回去除反斜杠后的$options变量值
    }
	
    return null; //否则返回空	
}


function inlojv_option_callback(){
    $op = $_POST['inlo_config'];
    update_option('inlo_config', $op);
    exit;
}
add_action('wp_ajax_inlo_setting', 'inlojv_option_callback'); // wp_ajax_inlo_setting 与底部js的inlo_setting对应


function inlojv_setting_enqueue(){
    global $pagenow;
	if( $pagenow == "admin.php" && $_GET['page'] == "func_settings.php" ){ // 浏览器上方链接参数GET过来
		// 上传附件所需js
		if(function_exists( 'wp_enqueue_media' )){
			wp_enqueue_media();
		}else{
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
		}
	}
}
add_action('admin_init', 'inlojv_setting_enqueue');




global $themename;
$themename = wp_get_theme()->get( 'Name' );
function inlojv_theme_options() {
		global $themename;
    	add_menu_page("主题设置", $themename."设置", 'edit_theme_options',basename(__FILE__), 'inlojv_options_page','dashicons-admin-generic',59);
		add_action( 'admin_init', 'inlojv_reg_settings' );
}
add_action('admin_menu', 'inlojv_theme_options');


function inlojv_reg_settings() {
    register_setting( 'inlojv_settings_group', 'inlo_config' );	
}





function inlojv_op_type_switch( $title, $op_name, $des ){
	$switch = _option($op_name) == true ? true : false;
	$switch_class = $switch ? "" : "disabled";
	 echo '
		<div class="box clr">
			<div class="span span1"><label class="op-label" for="inlo_config['.$op_name.']">'.$title.'</label></div>
			<div class="span span2 span2-notes clr">
				<div class="switch '.$switch_class.'">
					<div class="switch-button"></div>
					<input type="hidden" name="inlo_config['.$op_name.']" value="'.$switch.'" />
				</div>
				<div>是否开启</div>
			</div>
			<div class="span span3"><span class="op-span">'.$des.'</span></div>
		</div>
	';
}


function inlojv_op_type_textarea( $title, $op_name, $des ){
	echo '
		<div class="box clr">
			<div class="span span1"><label class="op-label" for="inlo_config['.$op_name.']">'.$title.'</label></div>
			<div class="span span2"><textarea type="textarea" class="op-textaera" name="inlo_config['.$op_name.']">'._option($op_name).'</textarea></div>
			<div class="span span3"><span class="op-span">'.$des.'</span></div>
		</div>
	';
}




function inlojv_options_page() {

	global $themename;
	
    ?>
	<style>
		#inlo-admin{font-family:microsoft yahei;float:left;margin-top:30px;box-shadow:0px 1px 4px 1px #bbb;border-radius:5px;background:#fff;width:950px;overflow:hidden;padding-bottom:30px}
		#inlo-admin hr{border-top:1px solid #aaa}
		h3.op-title{font-size:16px;height:30px;line-height:25px;margin:0;padding:12px;border-bottom:1px solid #EEE}
		.clr:after{clear:both;display:block;visibility:hidden;height:0;content:"";font-size:0;line-height:0}
		.clr{zoom:1}
		#op-nav{width:150px;float:left;margin-bottom:-9999px;padding-bottom:9999px;background:#fff;border-right:1px #eee solid}
		#op-nav ul,#op-cont ul{display:block;margin:0;padding:0}
		#op-nav ul{padding:20px 0}
		#op-nav li{margin:0;border-top:1px solid #ddd}
		#op-nav a{display:block;text-decoration:none;text-align:left;padding:10px 15px;outline:none;color:#666;position:relative}
		#op-nav a:focus{box-shadow:none}
		#op-nav a.current{background:#eee;border-bottom-color:#fff}
		#op-nav a.current:before{border:6px #eee solid;border-right-color:#fff;content:"";position:absolute;right:-1px;top:14px}
		#op-cont{width:750px;display:block;background-color:#fff;float:left;padding-left:20px;margin-bottom:-9999px;padding-bottom:9999px}
		#op-cont li{display:none}
		#op-cont li.current{display:block}
		.box{padding:10px 0 0;margin-bottom:10px;background-color:#fff;position:relative}
		.span{float:left;width:150px}
		.span2{width:580px;line-height:24px}
		.span3{width:580px;margin-left:150px}
		.span .buttons{margin-top:15px;-moz-box-sizing:border-box;cursor:pointer;display:inline-block;font-size:12px;height:26px;line-height:26px;margin:0;padding:0 10px;text-decoration:none;white-space:nowrap;background:#0074A2;color:#fff}
		.span-preview{text-align:center}
		.span-preview img{vertical-align:middle;max-width:200px;height:auto}
		.span1,.span2{font-size:13px}
		.op-label{margin:20px 0 20px 20px;width:150px;display:block;font-size:13px}
		.op-textaera{background:#f3f3f3;width:100%;height:80px;font-size:12px;padding:4px;color:#333;line-height:1.5em;resize:none}
		.op-textaera:focus{background:#fff}
		.op-small{margin:20px 0 20px 20px;width:200px;display:block;font-size:12px;color:#777}
		.op-span{font-size:13px;color:#777}
		.op-span strong{color:#444}
		.op-input{background:#f3f3f3;width:100%;margin-top:15px;font-size:13px;padding:4px;color:#333;line-height:22px}
		input[type="text"]{background:#f3f3f3}
		.op-input:focus{background:#fff}
		.op-input2{width:120px;margin-right:15px}
		.op-gap{padding:5px 0}
		.op-p{padding:0 0 8px 0;margin:0}
		.span2-notes,.span3{padding:15px 0 8px}
		.inlo_submit_form{clear:both;float:right;margin:15px 200px 0 0;display:block}
		.submit-float{position:fixed;left:1010px;bottom:60px;opacity:0.7}
		.inlo_reset_form{float:left;margin:20px 0 0 20px;display:block}
		.inlo_reset_form span{margin:5px 0px 0px 20px;display:inline-block;color:red}
		.op-label,.op-sns .op-small{margin:20px 0 0 20px}
		.inlo_option_wrap{padding:15px 20px}
		.op-text{padding-top:10px}
		.switch{display:inline-block;width:55px;height:24px;position:relative;background:#00CC00;cursor:pointer;float:left;margin-right:10px;border-radius:24px;-webkit-transition:all 0.2s linear;-moz-transition:all 0.2s linear;-mstransition:all 0.2s linear;-o-transition:all 0.2s linear;transition:all 0.2s linear}
		.switch.disabled{background-color:#ccc}
		.switch-button{width:22px;height:22px;top:1px;left:32px;position:absolute;background-color:#fff;border-radius:22px;-webkit-transition:left 0.2s linear;-moz-transition:left 0.2s linear;-ms-transition:left 0.2s linear;-o-transition:left 0.2s linear;transition:left 0.2s linear}
		.switch.disabled .switch-button{left:1px}
		.wp-admin select{margin-top:15px}
		#inlo-logo-preview img{width:90px;height:65px;background:#34495E;border:1px solid #ddd}
		#inlo-favicon-preview img{width:32px;height:32px;border:1px solid #ddd}
		.wp-core-ui .button-primary,.wp-core-ui .button-secondary{text-shadow:none;border:0;box-shadow:none;border-radius:5px;background:#58749c;color:#fff}
		.wp-core-ui .button-secondary{background:#aaa;color:#fff}
		.wp-core-ui .button-primary:focus,.wp-core-ui .button-secondary:focus{border:0;box-shadow:none}
		.wp-core-ui .button-primary:hover,.wp-core-ui .button-secondary:hover{background:#169FE6;border:0;box-shadow:none;color:#fff}
		.skincolor{width:15px;height:15px;position:relative;top:2px;display:inline-block}
		#opsave{padding:20px;line-height:1px;background:#1291ea;color:#fff;text-shadow:none;text-decoration:none;box-shadow:1px 1px 12px #aaa;}
		#opsave:hover{background:#169FE6;}
		.update{color:#fff;margin:0px;padding:5px 10px;background:#248942;font-size:13px;font-weight:normal;top:-2px;position:relative;margin-left:20px}		#ajaxsaved{display:none;position:fixed;left:45%;top:35%;padding:20px;background-color:#1291ea;color:#FFF;font-family:microsoft yahei;box-shadow:1px 1px 12px #aaa;}
		#cats-id{background:#fff;position:fixed;overflow:auto;width:180px;heigth:500px;right:0px;padding:15px;top:59px;color:#777}
		#cats-id h3{margin:0 0 15px}
		#op-cont .show-cats-id li{display:block}
		.grid-font{color:#10841b}
		.cms-font{color:#203ddf}
		span.show-cats-id{display:inline-block}
		.short{width:15%}
		.dashicons{margin:-3px 5px 0 0}
		.op-title i{margin:3px 5px 0 0}
	</style>
	<div class="wrap">
	<form method="post" id="opform">	
	
	<?php settings_fields( 'inlojv_settings_group' ); ?>

	<div id="inlo-admin">
		<h3 class="op-title"><i class="dashicons dashicons-admin-settings"></i><?php echo $themename;?>主题设置
			<?php
				$setting = !empty($_POST['inlo_config']) ? $_POST['inlo_config'] : null ;
				if (! empty ( $_POST ['save'] ) ) { // 保存设置
					$updated = update_option( 'inlo_config', $setting ); 
					if ($updated) { 
						echo '<span class="update">恭喜，保存成功！</span><script>jQuery(function($){$(".update").delay(2000).fadeOut();});</script>';
					} else { 
						echo '<span class="update">没有修改任何设置</span><script>jQuery(function($){$(".update").delay(2000).fadeOut();});</script>';
					}
				}
				if (! empty ( $_POST ['reset'] ) ) { 
					$deldated = delete_option( 'inlo_config'); 
					if ($deldated) { 
						echo '<span class="update">恭喜，恢复成功！</span><script>jQuery(function($){$(".update").delay(2000).fadeOut();});</script>';
					} else {
						echo '<span class="update">没有修改任何设置</span><script>jQuery(function($){$(".update").delay(2000).fadeOut();});</script>';
					}
				}	
			?>	
		<span style="float:right;color:#58749C">作者:INLOJV</span>
		</h3>
		
		<div id="op-nav" class="clr">
			<ul>
				<li><a class="current" href="#"><i class="dashicons dashicons-category"></i>基础设置</a></li>
				<li><a href="#"><i class="dashicons dashicons-category"></i>功能设置</a></li>
			</ul>
		</div>
		
		<div id="op-cont" class="clr">
<ul>
		<li class="current">
			<?php
			$op_cg_1 = array(
				array( 'title'=>'网站关键词','name'=>'keyword','des'=>'输入网站关键词:（用英文逗号隔开，不超过100个字符）' ),
				array( 'title'=>'网站描述','name'=>'description','des'=>'输入网站描述:（不超过200个字符）' ),
				array( 'title'=>'底部文字','name'=>'footer_text','des'=>'加入footer.php的文字' ),
				array( 'title'=>'底部代码','name'=>'footer_code','des'=>'加入footer.php的代码' )
			); 						
			foreach ( $op_cg_1 as $val ){
				inlojv_op_type_textarea(	$val['title'],$val['name'],$val['des']);
			}
			?>
		</li>	
		
		<li><!--功能设置-->
			<?php
			$op_gn_1 = array(
				array( 'title'=>'开启ajax','name'=>'on_ajax','des'=>'开启ajax异步加载' ),
				array( 'title'=>'开启图片灯箱','name'=>'on_fancybox','des'=>'点击图片放大显示' ),
				array( 'title'=>'开启图片延迟加载','name'=>'on_lazyload','des'=>'图片到达可见区域才会加载显示' ),
				array( 'title'=>'显示banner','name'=>'is_banner','des'=>'banner头图(830*230)显示于导航下方' )
			); 						
			foreach ( $op_gn_1 as $val ){
				inlojv_op_type_switch(	$val['title'],$val['name'],$val['des']);
			}
			?>
			<div class="box clr">
				<div class="span span1"><label class="op-label" for="inlo_config[banner]">图片名称</label></div>
				<div class="span span2">
					<input type="text" class="op-favicon op-input short" name="inlo_config[banner]" value="<?php echo _option('banner'); ?>" placeholder="" />
				</div>
				<div class="span span3"><span class="op-span">放入img文件夹的图片名称（加后缀）</span></div>
			</div>		
			<?php 
			
			inlojv_op_type_switch('在banner显示公告','is_notice','如果勾选 请填写站点公告（显示于首页banner处）'); 
			inlojv_op_type_textarea('公告内容','notice','填写公告内容，最多输入180个字');			
			
			?>
		</li>
	
		</ul>
		</div>
	</div>
	
	<div id="inlo_submit_form" class="inlo_submit_form">
		<input type="submit" class="button-primary inlo_submit_form_btn" name="save" value="保存设置" style="display:none"/>
		<input href="javascript:;" type="button" id="opsave" class="button-primary inlo_submit_form_btn" value="AJAX保存设置">
	</div>
	
	<div id="inlo_reset_form" class="inlo_reset_form">
		<input type="submit" name="reset" value="恢复默认" class="button-secondary inlo_reset_form_btn"/><span>此项将恢复主题设置到初始状态，请谨慎操作！</span>
	</div>	
	</form>
	</div>
	
	<div id="ajaxsaved"><span>保存中</span></div>
	
	<script>
	jQuery(document).ready(function($) {
		// 菜单切换
		$("#op-nav ul li a").click(function(B) {
			$(window).resize(); // 触发一次窗口大小调整，用于悬浮提交按钮重新刷新事件
			B.preventDefault();
			B.returnValue = false;
			var L = $(this),
				I = $("#op-nav ul li a").index(L),
				J = $("#op-nav ul li a.current"),
				K = $("#op-cont ul li.current"),
				A = $("#op-cont ul li").eq(I);
			if (L.hasClass("current")) {
				return
			}
			J.removeClass("current");
			L.addClass("current");
			K.removeClass("current");
			A.addClass("current");
			if (window.localStorage) {
				localStorage.currentTab = I
			}
			return false
		});
		if (window.localStorage) {
			var D = localStorage.currentTab;
			if (D) {
				$("#op-nav ul li a").eq(D).click();
			}
		}
		// 开关切换
		$(".switch").click(function(){
			var _this = $(this),
				_input = _this.children("input");
			
			if(_this.hasClass("disabled")){
				_this.removeClass("disabled");
				_input.val(1);
			}else{
				_this.addClass("disabled");
				_input.val(0);
			}
			return false;
		});
		// 上传设置
		$('.inlo-upload').click(function(event){
			var $this = $(this),
				$input = $("#" + $this.attr('data-id')),
				$preview = $("#" + $this.attr('data-id') + "-preview");
			if( wp.media !== "undefined" ){
				/**
				 * 采用 3.5之后的新上传图片方法
				 * 必须加载 wp_enqueue_media() ,否则无法弹出嵌套窗口
				 */
				// 创建文件嵌套窗口
				var file_frame = wp.media.frames.file_frame = wp.media({
					multiple: false  // 是否可以多选
				});	
				// 当图片被选中后，执行下面回调函数
				file_frame.on( 'select', function() {
					// 上面禁用了多选，因为我们只需要一张图片附件
					var attachment = file_frame.state().get('selection').first().toJSON();
					// 获取附件url
					var imgurl = attachment.url;
					// 将url填入input表单 并且 在其下方显示预览（插入img标签）
					$input.val(imgurl);
					$preview.html('<br/><img src="' + imgurl + '"/>');
				});
				// Finally, open the modal
				file_frame.open();
			}else{
				/**
				 * 兼容3.5之前版本上传文件的方法
				 */
				if( typeof(tb_show) !== "undefined" ){
					tb_show("", global.adminurl + "media-upload.php?type=image&amp;TB_iframe=true");	
					window.send_to_editor = function(data) {
						var imgurl = $("img", data).attr("src");
						$preview.html('<img src="' + imgurl + '"/>');
						$input.val(imgurl);
						tb_remove()
					};
				}
			}
		});
		// 清除上传图片
		$('.inlo-clear').click(function(event){
			var $this = $(this);
			$("#" + $this.attr('data-id')).val('');
			$("#" + $this.attr('data-id') + "-preview").html('');
		});
		// 若已经设置有附件图片则显示于预览区
		$inlo_favicon = $('#inlo-favicon');
		if($inlo_favicon.val() != ''){
			$inlo_favicon.siblings('div').html('<br/><img src="' + $inlo_favicon.val() + '"/>');
		}		
		$inlo_logo = $('#inlo-logo');
		if($inlo_logo.val() != ''){
			$inlo_logo.siblings('div').html('<br/><img src="' + $inlo_logo.val() + '"/>');
		}
		// AJAX 主题设置保存
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' );?>',
		is_ajaxed = false,
		$savebtn = $('#opsave'),
		$postform = $('#opform');
	
		$savebtn.click(function(event){	
			if( is_ajaxed ) return;	
			$.ajax({
				url: ajaxurl,
				data: $postform.serialize() + '&action=inlo_setting',
				type: 'POST',
				beforeSend: function(){
					is_ajaxed = true;
					$('#ajaxsaved').html('正在为您保存...').fadeIn();
				},
				success: function(){
					is_ajaxed = false;
					$('#ajaxsaved').html('恭喜，保存成功！').delay(1500).fadeOut();
				},
				timeout:6000,
				error: function(){
					is_ajaxed = false;
					$('#ajaxsaved').html('啊哦，保存失败！请刷新重试！').delay(1500).fadeOut();
				}
			})
		});
		
		inlo_floating_save_button(); // 悬浮保存按钮
		
			
		
		/* 设置数据导出导入 */
		
		$('#exportdata').on('click', function() { // 导出 // ××××××××××××
			window.open( $('#wp-admin-canonical').attr('href') + '&export=true'); // ×××× wp-admin-canonical 是wp自带的<link>节点，不用改
		});

		$('#importdata').on('click', function() { // ××××××××××××
			var url = $('#wp-admin-canonical').attr('href') + '&import=true',
				data = $('#get-importdata').val(), // ××××××××××××  获取粘贴到textarea的数据 
				sure = confirm('警告！操作不可逆，建议先对原设置数据进行备份操作。\n\n您确定要导入数据吗？');
			if( sure === true ) {
			   if ( data.replace(/\s+/g, '') !== '' ){ // 删除前后空格，非贪婪匹配
					$.post(url, {data:data}, function(r){
						if (r) {
							window.location.href = $('#wp-admin-canonical').attr('href');
						} else {
							alert('无效的数据，导入失败');
						}
					});
				} 
			}
		});			
			
		
		
	});
		
		// 判断元素进入底部可视区域内！
		var inlo_resize_timer_id;
		var inlo_distance_to_bottom = 0;
		jQuery(window).resize(function() {			
			clearTimeout(inlo_resize_timer_id);
			inlo_resize_timer_id = setTimeout(inlo_done_resizing, 500);
		});
		function inlo_done_resizing(){
			inlo_distance_to_bottom = jQuery(document).innerHeight() - jQuery(window).height();
			inlo_reposition_the_button();
		}		
		function inlo_reposition_the_button() {
			var distance_to_bottom =  inlo_distance_to_bottom - jQuery(this).scrollTop();
			if (distance_to_bottom <= 30) { // 距离底部小于30px时
				jQuery('#inlo_submit_form').removeClass('submit-float');
			} else { // 大于30px时
				jQuery('#inlo_submit_form').addClass('submit-float');
			}
		}
		function inlo_floating_save_button() {
			    inlo_done_resizing();
			jQuery(window).scroll(function(){
				inlo_reposition_the_button();				
			});
		}		
		
		
		
		
	</script>
	
<?php }