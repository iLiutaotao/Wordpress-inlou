<?php get_header(); ?>
<div id="main">
<?php include ('posts.php'); ?>
</div>
<?php $ajx=!empty($_GET['ajx']) ? $_GET['ajx'] : null; if( $ajx != 'container') {?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php } ?>