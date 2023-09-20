<?php
class admin
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_custom_menu_page'));
        wp_enqueue_style('style.css', PLUGIN_URL . 'admin/css/style.css', array(), '1.0', 'all');
    }
    function add_custom_menu_page()
    {
        $menuSlug = 'quan_ly_sach';
        // Thêm menu vào Dashboard
        add_menu_page(
            'Quản lý sách',   // Tiêu đề của menu
            'Quản lý sách',   // Tên hiển thị trên menu
            'manage_options',  // Quyền truy cập để xem menu
            $menuSlug,  // Slug của menu
            array($this, 'quan_ly_sach'), // Callback function để hiển thị nội dung của menu
            'dashicons-admin-generic', // Icon của menu (tùy chọn)
            6 // Thứ tự hiển thị của menu trong Dashboard
        );
        add_submenu_page($menuSlug, 'Quản lý sản phẩm', 'Quản lý sản phẩm', 'manage_options', $menuSlug . '_product_manager', array($this, 'quan_ly_san_pham'));
        add_submenu_page($menuSlug, 'Thêm sản phẩm', 'Thêm sản phẩm', 'manage_options', $menuSlug . '_add_prouct', array($this, 'themSanPham'));
        add_submenu_page($menuSlug, 'Quản lý danh mục sản phẩm', 'Quản lý danh mục sản phẩm', 'manage_options', $menuSlug . '_category_manager', array($this, 'quan_ly_danh_muc'));
        add_submenu_page($menuSlug, 'Quản lý nhà xuất bản', 'Quản lý nhà xuất bản', 'manage_options', $menuSlug . '_Publisher', array($this, 'quan_ly_NSX'));
        add_submenu_page($menuSlug, 'Sửa sản phẩm', 'Sửa sản phẩm', 'manage_options', $menuSlug . '_edit_prouct', array($this, 'suaSanPham'));
        add_submenu_page($menuSlug, 'Quản lý khách hàng', 'Quản lý khách hàng', 'manage_options', $menuSlug . '_accout', array($this, 'quan_ly_khach_hang'));
        add_submenu_page($menuSlug, 'Quản lý bình luận', 'Quản lý bình luận', 'manage_options', $menuSlug . '_cmt', array($this, 'quan_ly_binh_luan'));
    }
    function quan_ly_sach()
    {
        // Đặt nội dung của trang menu tại đây
        require_once(PLUGIN_DIR . '/admin/views/view_quan_ly_sach.php');
    }

    function quan_ly_san_pham()
    {

        require_once(PLUGIN_DIR . '/admin/views/view_quan_ly_san_pham.php');
    }
    function quan_ly_danh_muc()
    {

        require_once(PLUGIN_DIR . '/admin/views/view_quan_ly_danh_muc.php');
    }
    function quan_ly_NSX()
    {
        require_once(PLUGIN_DIR . '/admin/views/view_quan_ly_NSX.php');
    }
    function themSanPham()
    {
        require_once(PLUGIN_DIR . '/admin/views/view_them_san_pham.php');
    }
    function suaSanPham()
    {
        require_once(PLUGIN_DIR . '/admin/views/view_sua_san_pham.php');
    }
    function quan_ly_khach_hang()
    {
        require_once(PLUGIN_DIR . '/admin/views/view_quan_ly_khach_hang.php');
    }
    function quan_ly_binh_luan()
    {
        require_once(PLUGIN_DIR . '/admin/views/view_quan_ly_binh_luan.php');
    }
}
