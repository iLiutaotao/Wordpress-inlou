<?php $ajx=!empty($_GET['ajx']) ? $_GET['ajx'] : null; if($ajx != 'container' && $ajx != 'comts') { ?>
<!DOCTYPE HTML>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php } ?>
<?php inlo_head(); ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/js/syntaxhighlighter/styles/shCore.css" />
<?php $ajx=!empty($_GET['ajx']) ? $_GET['ajx'] : null; if($ajx != 'container' && $ajx != 'comts') { ?>
<!--[if IE]>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory'); ?>/style_ie.css" />
<![endif]-->
</head>
<body>
<div id="header">
<div class="inlo-header">
	<div class="site-name tra">
        <a id="logo" class="tra" href="<?php bloginfo('url'); ?>">
            <span class="blog-name"><?php bloginfo('name'); ?></span><span class="blog-des"> - <?php bloginfo('description'); ?></span>
        </a>
    </div>
    <div class="header-nav">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container'=> false ,'menu_class' => 'nav-menu'));?>
		<ul class="mobile-nav nav-menu">
			<li><a href="<?php echo home_url(); ?>">主页</a></li>
			<li><span href="javascript:;" id="mobile_nav">聚合菜单</span>
				<ul class="sub-menu" id="mobile_nav_list">
				<?php 
					$category = get_categories('hierarchical=false');
					if( !empty ( $category ) ){
						foreach($category as $cate){
							echo '<li><a href="'.get_category_link($cate).'">'.$cate->name.'</a></li>';
						}
					}
				?>
				</ul>
			</li>
		</ul>
    </div>
</div>
</div>
<script type="text/javascript">
	var on_ajax = <?php echo _option('on_ajax') ?   "'Y'" :  "'N'"; ?>;
	var on_fancybox = <?php echo _option('on_fancybox') ?   "'Y'" :  "'N'"; ?>;
</script>
<div id="container">
<?php } ?>