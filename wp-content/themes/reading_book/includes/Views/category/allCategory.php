<?php

add_action('category_getAllCategory', 'category_getAllCategory');
function category_getAllCategory()
{
    include_once THEME_DIR . '/includes/Model/theLoaiModel.php';
    global $hosting;
    $theloai = new theLoaiModel(0, '');
    $dataTheLoai = $theloai->getAll();
    //html
?>
    <div id="">
        <?php get_template_part('template-parts/nav/nav'); ?>

        <div class="breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <p class="bread"><span><a href="<?php echo home_url() ?>">Home</a></span> / <span>Category</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="colorlib-product">
            <div class="container">
                <!-- category -->
                <div class="row">
                    <?php
                    for ($i = 0; $i < count($dataTheLoai); $i++) {
                    ?>

                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 mb-3">
                            <div class="item_folder">
                                <a href="<?php echo $hosting ?>category?id=<?php echo $dataTheLoai[$i]->maTheLoai  ?>"><i class="icon-book"></i><?php echo $dataTheLoai[$i]->tenTheLoai  ?></a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php get_footer() ?>
    </div>

<?php
    // end html
}
