</div>
<div class="clear"></div>
<div id="roll-top" class="tra"><a href="javascript:scroll(0,0)" title="返回顶部"></a></div>
<div id="footer">
	<div class="container">
		<div class="copyright">
			版权所有 &copy; <?php echo date('Y'); ?> <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> <?php echo _option('footer_text'); ?>	
		</div>
		<div class="themeauthor">Powered by <a href="http://www.wordpress.org/" target="_blank" rel="license">WordPress</a> Theme by <a href="http://www.inlojv.com/" id="author" target="_blank" rel="license">INLOJV</a>
		</div>
	</div>
</div>
<?php wp_footer();?>
<script>
var home_url = '<?php echo get_bloginfo('url');?>';
</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/syntaxhighlighter/scripts/lighterCode.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/base.js"></script>
<div style="display:none"><?php echo _option('footer_code'); ?></div>
</body>
</html>