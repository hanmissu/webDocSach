<?php
/*
 * Plugin Name:       hello
 * Plugin URI:        #
 * Description:       
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Chương hân
 * Author URI:        #
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        #
 * Text Domain:       quanLySach
 * Domain Path:       /languages
 */
add_action('admin_menu',  'hello');
function hello()
{
    $menuSlug = 'hello';
    // Thêm menu vào Dashboard
    add_menu_page(
        'hello',   // Tiêu đề của menu
        'hello',   // Tên hiển thị trên menu
        'manage_options',  // Quyền truy cập để xem menu
        $menuSlug,  // Slug của menu
        'hello', // Callback function để hiển thị nội dung của menu
        'dashicons-admin-generic', // Icon của menu (tùy chọn)
        6 // Thứ tự hiển thị của menu trong Dashboard
    );
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        hello
    </body>

    </html>
<?php

}
