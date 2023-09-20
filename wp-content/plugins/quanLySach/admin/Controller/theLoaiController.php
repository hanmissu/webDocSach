<?php
add_action('wp_ajax_insertCategory', 'insertCategory');
add_action('wp_ajax_nopriv_insertCategory', 'insertCategory');
add_action('wp_ajax_updateCategory', 'updateCategory');
add_action('wp_ajax_nopriv_updateCategory', 'updateCategory');
add_action('wp_ajax_deleteCategory', 'deleteCategory');
add_action('wp_ajax_nopriv_deleteCategory', 'deleteCategory');
function insertCategory()
{
    include_once PLUGIN_DIR . 'admin/Model/theLoaiModel.php';
    include_once PLUGIN_DIR . 'includes/the-Loai.php';
    $name = $_POST['tenTheLoai'];
    // print_r($name);
    // exit;
    $theloai = new theLoaiModel(0, $name);
    $result = $theloai->getDatabyName($name);
    if ($result == null) {
        try {
            if ($theloai->insert()) {
                set_transient('add_category_success', 'Thêm thể loại thành công', 30);
            } else {
                echo 'false';
                exit;
            }
        } catch (\Throwable $th) {
            echo "err";
            exit;
        }
    } else {
        echo 'existsCategory';
        exit;
    }
    do_action('create_folder_category', $_POST['tenTheLoai']);
}

function deleteCategory()
{
    include_once PLUGIN_DIR . 'admin/Model/theLoaiModel.php';
    include_once PLUGIN_DIR . 'admin/Model/danhGiaSanPhamModel.php';
    include_once PLUGIN_DIR . 'admin/Model/sanPhamYeuThichModel.php';
    include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
    include_once PLUGIN_DIR . 'includes/the-Loai.php';
    $sanpham = new sanPhamModel(0, "", "", "", "", "", "", "", $_POST['idCategory'], "", "");
    $dataByIdCategory = $sanpham->getDatabyIDCategory();

    for ($i = 0; $i < count($dataByIdCategory); $i++) {
        $danhgia = new danhGiaSanPhamModel(0, "", "", "", "", $dataByIdCategory[$i]->maSanPham, "", "");
        $danhgia->deleteByIdProduct();
        $yeuthich = new sanPhamYeuThichModel(0, "", $dataByIdCategory[$i]->maSanPham, "");
        $yeuthich->deleteByIdProduct();
    }
    $sanpham->deleteByIdCategory();
    try {
        $theloai = new theLoaiModel($_POST['idCategory'], '');
        $result = $theloai->getDatabyID();
        $tenTheLoai = $result[0]->tenTheLoai;
        if ($theloai->delete()) {
            set_transient('delete_category_success', 'Xóa thể loại thành công', 30);
            do_action('delete_folder_category', $tenTheLoai);
        } else {
            echo 'false';
            exit;
        }
    } catch (\Throwable $th) {
        echo "err";
        exit;
    }
}


function updateCategory()
{

    include_once PLUGIN_DIR . 'admin/Model/theLoaiModel.php';
    include_once PLUGIN_DIR . 'includes/the-Loai.php';
    try {
        //code...

        $theloai = new theLoaiModel($_POST['idCategory'], $_POST['tenTheLoai_sua']);
        try {
            if ($theloai->update()) {
                set_transient('update_category_success', 'Sửa thể loại thành công', 30);
                // sửa thư mục tên thể loại cũ thành tên thể loại mới 
                do_action('rename_folder_category', $_POST['tenTheLoai_cu'], $_POST['tenTheLoai_sua']);
                echo 'true';
                exit;
            } else {
                echo 'false';
                exit;
            }
        } catch (\Throwable $th) {
            echo "err";
            exit;
        }
    } catch (\Throwable $th) {
        //throw $th;
    }
}
