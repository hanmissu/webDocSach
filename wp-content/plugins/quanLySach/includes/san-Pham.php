<?php
// thêm
add_action("xuLyFileAnh", "xuLyFileAnh", 10, 2);
add_action("xuLyFileSach", "xuLyFileSach", 10, 2);
//xóa
add_action("xuLyXoaAnh_File", "xuLyXoaAnh_File", 10, 3);


function xuLyFileAnh($file, $theLoai)
{

    $upload_dir = wp_upload_dir(); // Lấy thông tin về thư mục tải lên mặc định của WordPress
    $target_dir = PLUGIN_DIR . 'images/' . $theLoai . '/'; // Thay đổi thành đường dẫn thư mục tùy ý bạn muốn lưu tệp tin vào
    if (!file_exists($target_dir)) {
        wp_mkdir_p(PLUGIN_DIR . 'images/' . $theLoai);
        $target_dir = PLUGIN_DIR . 'images/' . $theLoai . '/';
    }
    $file_name = basename($file['name']);
    if ($file['error'] == 1) {
        echo 'ảnh vượt quá kích thước';
    }
    $target_file = $target_dir . $file_name;
    move_uploaded_file($file['tmp_name'], $target_file);
}

function xuLyFileSach($file, $theLoai)
{
    $upload_dir = wp_upload_dir(); // Lấy thông tin về thư mục tải lên mặc định của WordPress
    $target_dir = PLUGIN_DIR . 'Files/' . $theLoai . '/'; // Thay đổi thành đường dẫn thư mục tùy ý bạn muốn lưu tệp tin vào
    if (!file_exists($target_dir)) {
        wp_mkdir_p(PLUGIN_DIR . 'Files/' . $theLoai);
        $target_dir = PLUGIN_DIR . 'Files/' . $theLoai . '/';
    }
    $file_name = basename($file['name']);
    $target_file = $target_dir . $file_name;

    move_uploaded_file($file['tmp_name'], $target_file);
}
function xuLyXoaAnh_File($tenAnh, $tenfile, $theLoai)
{
    $target_img = PLUGIN_DIR . 'images' . '/' . $theLoai . '/' . $tenAnh;
    $target_file = PLUGIN_DIR . 'Files' . '/' . $theLoai . '/' . $tenfile;
    if (!is_dir($target_img) && $tenAnh != '' && file_exists($target_img)) {
        unlink($target_img);
    }
    if (!is_dir($target_file) && $tenfile != ''  && file_exists($target_file)) {
        unlink($target_file);
    }
}
