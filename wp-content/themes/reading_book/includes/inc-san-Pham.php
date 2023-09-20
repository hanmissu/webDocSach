<?php
add_action('xuLyTimKiem', 'xuLyTimKiem', 10, 1);
function xuLyTimKiem($key_search)
{
    global $hosting;
    if (isset($_SESSION['search'])) unset($_SESSION['search']);
    include_once THEME_DIR . '/includes/Model/sanPhamModel.php';
    $sanpham = new sanPhamModel(0, '', '', '', '', '', '', '', '', '', '');
    $dataSearch = $sanpham->searchProduct($key_search);
    $_SESSION['search'] = $dataSearch;
    wp_redirect($hosting . '/search');
}
