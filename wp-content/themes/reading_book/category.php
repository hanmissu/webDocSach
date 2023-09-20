<!DOCTYPE HTML>
<html>

<head>

	<?php
/*
Template Name: ch_category
*/
	get_header();
	$maTheLoai = !empty($_GET['id']) ? $_GET['id'] : '';
	?>

</head>

<body>
	<?php
	// hiển thị danh sách các thể loại
	if ($_GET == null) {
		//html
	?>
		<!-- category -->
		<?php do_action('category_getAllCategory') ?>

	<?php
		//end html
	}
	// hiển thị danh dách thuộc thể loại idCategory
	else {
		do_action('category_Product',$maTheLoai);
	}
	?>
	<?php get_template_part('template-parts/script'); ?>

</body>

</html>