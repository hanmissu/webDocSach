<?php
/*
Template Name: ch_search
*/
$dataSearch = $_SESSION['search'];
// var_dump($dataSearch);
?>
<!DOCTYPE HTML>
<html>

<head>
    <?php
    get_header();
    ?>
</head>

<body>

    <div id="">
        <?php get_template_part('template-parts/nav/nav'); ?>
        <div class="breadcrumbs">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <strong class="bread"><span>Search Results</span> : <span> <?php echo count($dataSearch) ?> </span></strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="colorlib-product">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-xl-3">
                        <?php
                        do_action('sidebar_getAllCategory')
                        ?>
                    </div>
                    <?php do_action('search_pagination') ?>
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