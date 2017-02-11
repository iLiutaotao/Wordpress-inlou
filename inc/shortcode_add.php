<?php
//添加自定义编辑器按钮，注意单个QTags.addButton写入规则时不要回车换行
function inlo_short_code_buttons() {
    ?>
<script type="text/javascript">
    QTags.addButton( 'hr', 'hr', '\n<hr />\n', '' );
    QTags.addButton( 'nextpage', '分页', '<!--nextpage-->', '' );
    QTags.addButton( 'jv_normalbox', '普通高亮', '<span class="jv_normalbox">', '</span>' );
    QTags.addButton( 'jv_bluebox', '蓝底高亮', '<span class="jv_bluebox">', '</span>' );
    QTags.addButton( 'jv_blackbox', '黑底高亮', '<span class="jv_blackbox">', '</span>' );
    QTags.addButton( 'jv_partbox', '段落高亮', '<div class="jv_partbox">', '</div>' );
    QTags.addButton( 'jv_titlebox', '标题高亮', '<div class="jv_titlebox">', '</div>' );
    QTags.addButton( 'jv_dropcaps', '首字下沉', '<p class="jv_dropcaps">', '</p>' );
    QTags.addButton( 'portect', '版权保护', '<span class="portect">', '</span>' );
	QTags.addButton( 'jv_pre', '普通pre', '<pre>','</pre>');
	QTags.addButton( 'jv_h_pre', '高亮pre', '<pre class="brush:bash">','</pre>');
	QTags.addButton( 'jv_h22', '22号小标题', '<p class="jv_h22">','</p>');	
    QTags.addButton( 'jv_download_1', '下载地址', '<div class="jv_download_1"><li><a data-text="点击下载" title="描述" href="填写下载地址url" rel="nofollow" target="_blank">下载地址</a></li></div>', '' );      
</script>
<?php
}
?>