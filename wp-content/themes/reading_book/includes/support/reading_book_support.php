<?php
add_action('after_setup_theme','reading_book_support');
function reading_book_support(){
    // đăng ký menu
    register_nav_menus([
        'primary' => 'Primary menu',
        'vertical'=> 'Vertical menu',
        'login'=> 'Login menu',
    ]);
}