<?php
/*
Template Name: ch_profile
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    get_header()
    ?>
</head>

<body>
    <?php 
    do_action('thongBao_theme', 'edit_success');
    do_action('thongBao_theme', 'edit_fail');
    do_action('thongBao_theme', 'exists_email_or_phone');
    ?>
    <?php get_template_part('template-parts/nav/nav'); ?>
    <?php do_action('profile') ?>
</body>

</html>