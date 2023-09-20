<?php global $hosting; ?>
<nav class="colorlib-nav" role="navigation">
	<div class="top-menu">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-8">
					<div id="colorlib-logo"><a href="index.php">CHƯƠNG HÂN </a></div>
				</div>
				<?php do_action('docSach_search'); ?>
				<?php
				if (isset($_SESSION['isLogin'])) {
				?>
					<div class="col-sm-1 col-md-1">
						<a href="<?php echo $hosting . 'profile/' ?>">
							<button class="btn btn-primary profile-button" type="button">
								<i class="icon ion-ios-person"></i>
							</button>
						</a>

					</div>
				<?php
				}
				?>

			</div>
			<div class="row">
				<div class="col-sm-12 text-left">
					<?php
					//var_dump(get_transient('isLogin'));
					if (isset($_SESSION['isLogin'])) {
						wp_nav_menu([
							'theme_location' => 'login',
							'menu_class' => 'menu-wapper',
							'container_class' => 'colorlib-nav',
							'containet' => true,
							'item_wrap' => '<ul class="%2$s" id="primary-menu-ul">%3$s</ul>',
							'fallback_cb' => false
						]);
					} else {
						wp_nav_menu([
							'theme_location' => 'primary',
							'menu_class' => 'menu-wapper',
							'container_class' => 'colorlib-nav',
							'containet' => true,
							'item_wrap' => '<ul class="%2$s" id="primary-menu-ul">%3$s</ul>',
							'fallback_cb' => false
						]);
					}
					?>
				</div>
			</div>
		</div>
	</div>
</nav>