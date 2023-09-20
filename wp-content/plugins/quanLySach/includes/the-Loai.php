<?php


add_action("create_folder_category", "create_folder_category", 10, 1);

add_action("rename_folder_category", "rename_folder_category", 10, 2);

add_action("delete_folder_category", "delete_folder_category", 10, 1);


function create_folder_category($name)
{
    $folder_image = PLUGIN_DIR . 'images/' . $name;
    $folder_file = PLUGIN_DIR . 'Files/' . $name;
    if (!file_exists($folder_image)) {
        wp_mkdir_p(PLUGIN_DIR . 'images/' . $name);
    }
    if (!file_exists($folder_file)) {
        wp_mkdir_p(PLUGIN_DIR . 'Files/' . $name);
    }
}

function rename_folder_category($old_name, $new_name)
{
    // Đường dẫn đến thư mục cũ
    $old_path_to_file = PLUGIN_DIR . 'Files/' . $old_name;
    $old_path_to_img = PLUGIN_DIR . 'images/' . $old_name;
    // Đường dẫn đến thư mục mới
    $new_path_to_file = PLUGIN_DIR . 'Files/' . $new_name;
    $new_path_to_img = PLUGIN_DIR . 'images/' . $new_name;
    // Kiểm tra xem đường dẫn có tồn tại hay không
    if (file_exists($old_path_to_file) && is_dir($old_path_to_file)) {
        rename($old_path_to_file, $new_path_to_file);
    }
    if (file_exists($old_path_to_img) && is_dir($old_path_to_img)) {
        rename($old_path_to_img, $new_path_to_img);
    } else {
        echo 'Đường dẫn không tồn tại.';
    }
}

function delete_folder_category($name)
{
    // Đường dẫn đến thư mục hoặc tệp tin bạn muốn xóa
    $path_to_delete_img = PLUGIN_DIR . 'images/' . $name;
    $path_to_delete_file = PLUGIN_DIR . 'Files/' . $name;
    // Kiểm tra xem đường dẫn có tồn tại hay không

    $files_img = glob($path_to_delete_img . '/*');
    foreach ($files_img as $file) {
        if (is_file($file)) {
            unlink($file); // Xóa tệp tin
        }
    }
    $files_file = glob($path_to_delete_file . '/*');
    foreach ($files_file as $file) {
        if (is_file($file)) {
            unlink($file); // Xóa tệp tin
        }
    }

    if (file_exists($path_to_delete_img)) {
        rmdir($path_to_delete_img);
    }
    if (file_exists($path_to_delete_file)) {
        rmdir($path_to_delete_file);
    } else {
        echo 'Đường dẫn không tồn tại.';
    }
}
