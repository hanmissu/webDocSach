<!DOCTYPE HTML>
<html>

<head>
    <?php
    /*
Template Name: ch_Popular 
*/
    get_header()
    ?>
</head>

<body>

    <div id="">
        <?php get_template_part('template-parts/nav/nav'); ?>
        <?php
        do_action('thongBao_theme', 'register_success');
        do_action('thongBao_theme', 'login_success');
        ?>
        <div class="colorlib-product">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3">
                        <?php do_action('sidebar_getAllCategory') ?>
                    </div>
                    <div class="col-lg-9 col-xl-9">
                        <div class="row row-pb-md">
                            <?php do_action('getAllProduct_Popular') ?>
                        </div>
                        <!-- pagination -->
                        <?php //do_action('pagination') ?>
                        <!-- end pagination -->
                    </div>
                </div>
            </div>
        </div>

        <?php get_footer() ?>
    </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="ion-ios-arrow-up"></i></a>
    </div>
    <?php get_template_part('template-parts/script'); ?>


</body>

</html>