<?php

add_action('category_Product', 'category_Product', 10, 1);
function category_Product($idCategory)
{
    include_once THEME_DIR . '/includes/Model/theLoaiModel.php';
    $theloai = new theLoaiModel($idCategory, '');
    $dataTheLoai = $theloai->getDatabyID();
?>
    <div id="">
        <?php get_template_part('template-parts/nav/nav'); ?>

        <div class="breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <p class="bread"><span><a href="<?php echo home_url() ?>">Home</a></span> / <span>Category</span>/<span><?php echo $dataTheLoai[0]->tenTheLoai ?></span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="colorlib-product">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3">
                        <?php do_action('sidebar_getAllCategory') ?>
                    </div>
                    <div class="col-lg-9 col-xl-9">

                        <div class="row row-pb-md">
                            <?php do_action('getAllProduct', $idCategory) ?>
                        </div>
                        <!-- pagination -->
                        <?php do_action('pagination', $idCategory) ?>
                        <!-- end pagination -->
                    </div>
                </div>
            </div>
        </div>

        <?php get_footer() ?>
    </div>
<?php
}
