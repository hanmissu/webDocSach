<!DOCTYPE HTML>
<html>

<head>
	<?php
	/*
Template Name: ch_single-page
*/
	get_header();
	$path = trim($request->request_uri, '/');
	$maSanPham = isset($_GET['id']) ? $_GET['id'] : '';
	if (!is_page('single-page')) {
		unset($_SESSION['datacmtOfPro']);
	}
	?>
</head>

<body>
	<div id="">
		<?php get_template_part('template-parts/nav/nav');
		?>
		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col">
						<p class="bread"><span><a href="<?php echo home_url() ?>">Home</a></span> / <span>Product Details</span></p>
					</div>
				</div>
			</div>
		</div>
		<div class="colorlib-product">
			<div class="container">

				<?php do_action('product_detail', $maSanPham);
				//get_template_part('template-parts/single/single-review');
				?>
			</div>
		</div>

		<?php get_footer() ?>
	</div>

	<?php get_template_part('template-parts/script'); ?>


</body>

</html>