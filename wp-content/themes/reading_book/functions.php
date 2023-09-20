<?php
add_filter('the_content', 'do_shortcode');
session_start();
global $theme_prefix, $pagination_limit, $pagination_offset, $pagination_page, $hosting;
$hosting = 'http://localhost/wordpress/';
$theme_prefix = 'reading_book';
$pagination_limit = 6;
$pagination_page = 1;
$pagination_offset = ($pagination_page - 1) * $pagination_limit;

define('THEME_DIR', get_template_directory());
define('THEME_URL', get_template_directory_uri());
define('PLUGIN_QUANLYSACH_IMG', plugins_url() . '/quanLySach/images');
define('PLUGIN_QUANLYSACH_FILE', plugins_url() . '/quanLySach/Files');
// thư viện hiệu ứng lật sách PDF
//include_once ABSPATH . 'wp-content/plugins/3d-flipbook-dflip-lite/3d-flipbook-dflip-lite.php';

// đăng ký các thành phần hỗ trợ theme
include_once THEME_DIR . '/includes/support/reading_book_support.php';
// đăng ký style cho theme
include_once THEME_DIR . '/includes/support/register_style.php';
//content
include_once THEME_DIR . '/includes/Views/content/allProduct.php';
include_once THEME_DIR . '/includes/Views/content/getAllProduct_Popular.php';
//pagination
include_once THEME_DIR . '/includes/Views/pagination/pagination.php';
include_once THEME_DIR . '/includes/Views/pagination/pagination-search.php';
include_once THEME_DIR . '/includes/Views/pagination/pagination-cmt.php';
//single-page
include_once THEME_DIR . '/includes/Views/single-page/single-page-product.php';
//sidebar
include_once THEME_DIR . '/includes/Views/sidebar/single-sidebar.php';
include_once THEME_DIR . '/includes/Views/sidebar/sidebar-category.php';

// category
include_once THEME_DIR . '/includes/Views/category/allCategory.php';
include_once THEME_DIR . '/includes/Views/category/category_Product.php';

// action
include_once THEME_DIR . '/includes/inc-san-Pham.php';

//search
include_once THEME_DIR . '/includes/Views/search/search.php';

// sortcode
include_once THEME_DIR . '/includes/inc-shortcode.php';

include_once THEME_DIR . '/includes/inc-thongBao.php';

// verify
include_once THEME_DIR . '/includes/inc-verify_account.php';
// send mail
include_once THEME_DIR . '/includes/inc-sendMail.php';

include_once THEME_DIR . '/includes/Views/profile/profile.php';
//ajax
include_once THEME_DIR . '/includes/Controller/danhGiaSanPhamController.php';
include_once THEME_DIR . '/includes/Controller/sanPhamYeuThichController.php';
include_once THEME_DIR . '/includes/Controller/khachHangController.php';

add_action('wp_ajax_themLuotDoc', 'themLuotDoc');
add_action('wp_ajax_nopriv_themLuotDoc', 'themLuotDoc');
function themLuotDoc()
{
    include_once THEME_DIR . '/includes/Model/sanPhamModel.php';
    $sanpham = new sanPhamModel($_POST['product_id'], '', '', '', '', '', '', '', '', '', '', "");
    $luotDoc = $sanpham->getDatabyID()[0]->luotDoc;
    if ($sanpham->updateView($luotDoc + 1)) {
        echo 'true';
        exit;
    } else {
        echo 'false';
        exit;
    }
}

add_action('wp_ajax_search', 'search');
add_action('wp_ajax_nopriv_search', 'search');
function search()
{
    if (isset($_SESSION['search'])) unset($_SESSION['search']);
    print_r($_POST);
    include_once THEME_DIR . '/includes/Model/sanPhamModel.php';
    $sanpham = new sanPhamModel(0, '', '', '', '', '', '', '', '', '', '');
    $dataSearch = $sanpham->searchProduct($_POST['key_search']);
    $_SESSION['search'] = $dataSearch;
}
