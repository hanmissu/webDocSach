<?php
add_action('wp_ajax_deleteProduct', 'deleteProduct');
add_action('wp_ajax_nopriv_deleteProduct', 'deleteProduct');
function deleteProduct()
{
    include_once PLUGIN_DIR . 'admin/Model/theLoaiModel.php';
    include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
    include_once PLUGIN_DIR . "admin/Model/danhGiaSanPhamModel.php";
    include_once PLUGIN_DIR . "admin/Model/sanPhamYeuThichModel.php";
    $maSanPham = isset($_POST['idProduct']) ? $_POST['idProduct'] : '';
    include_once PLUGIN_DIR . "includes/san-Pham.php";
    //
    $sanpham = new sanPhamModel($maSanPham, '', '', '', '', '', '', '', '', '', '');
    $dataSanPham = $sanpham->getDatabyID();
    $tenAnh = $dataSanPham[0]->anhDaiDien;
    $tenFile = $dataSanPham[0]->tenFile;
    //
    $theloai = new theLoaiModel($dataSanPham[0]->maTheLoai, '');
    $dataTheLoai = $theloai->getDatabyID();
    $tenTheLoai = $dataTheLoai[0]->tenTheLoai;
    //

    $sanpham = new sanPhamModel($maSanPham, '', '', '', '', '', '', '', '', '', '');
    $danhgia = new danhGiaSanPhamModel(0, '', '', '', '', $maSanPham, '', '');
    $yeuthich = new sanPhamYeuThichModel(0, '', $maSanPham, '');
    try {
        $danhgia->deleteByIdProduct();
        $yeuthich->deleteByIdProduct();
        if ($sanpham->delete()) {
            set_transient('delete_product_success', 'Xóa sản phẩm thành công', 30);
            do_action('xuLyXoaAnh_File', $tenAnh, $tenFile, $tenTheLoai);
        } else {
            echo 'false';
        }
    } catch (\Throwable $th) {
        //throw $th;
    }
}
add_action('wp_ajax_insertProduct', 'insertProduct');
add_action('wp_ajax_nopriv_insertProduct', 'insertProduct');
function insertProduct()
{
    include_once PLUGIN_DIR . 'admin/Model/theLoaiModel.php';
    include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
    $tenSP = isset($_POST['tenSanPham']) ? sanitize_text_field($_POST['tenSanPham']) : '';
    $tacGia = isset($_POST['tacGia']) ? sanitize_text_field($_POST['tacGia']) : '';
    $dichGia = isset($_POST['dichGia']) ? sanitize_text_field($_POST['dichGia']) : '';
    $namSanXuat = isset($_POST['namSX']) ? sanitize_text_field($_POST['namSX']) : '';
    $gioiThieu = isset($_POST['gioiThieu']) ? $_POST['gioiThieu'] : '';
    $maTheLoai = isset($_POST['maTheLoai']) ? sanitize_text_field($_POST['maTheLoai']) : '';
    $maNSX = isset($_POST['maNSX']) ? sanitize_text_field($_POST['maNSX']) : '';
    $anh = isset($_FILES['anhDaiDien']['name']) ? $_FILES['anhDaiDien']['name'] : '';
    $tenFile = isset($_FILES['tenFile']['name']) ? $_FILES['tenFile']['name'] : '';

    try {
        include_once PLUGIN_DIR . "includes/san-Pham.php";
        $sanpham = new sanPhamModel(0, $tenSP, $tacGia, $dichGia, $namSanXuat, $tenFile, $anh, $gioiThieu, $maTheLoai, $maNSX, '');
        $result = $sanpham->getDatabyName();
        $getFile = $sanpham->getDatabyFile();
        $getImg = $sanpham->getDataByImg();

        if ($getFile != null) {
            echo 'File_exists';
            exit;
        }
        if ($getImg != null) {
            echo 'Img_exists';
            exit;
        }
        // var_dump($result);die;
        if (empty($result)) {
            try {
                if ($sanpham->insert()) {
                    set_transient('add_product_success', 'Thêm sản phẩm thành công', 30);
                    //
                    $theloai = new theLoaiModel($maTheLoai, '');
                    $dataTheLoai = $theloai->getDatabyID();
                    $tenTheLoai = $dataTheLoai[0]->tenTheLoai;
                    //
                    do_action("xuLyFileAnh", $_FILES['anhDaiDien'], $tenTheLoai);
                    do_action("xuLyFileSach", $_FILES['tenFile'], $tenTheLoai);
                    exit;
                } else {
                    echo 'false';
                    exit;
                }
            } catch (\Throwable $th) {
                echo "err";
            }
        } else {
            echo 'exists';
            exit;
        }
    } catch (\Throwable $th) {
        echo 'false';
    }
}
add_action('wp_ajax_updateProduct', 'updateProduct');
add_action('wp_ajax_nopriv_updateProduct', 'updateProduct');
function updateProduct()
{

    include_once PLUGIN_DIR . 'admin/Model/theLoaiModel.php';
    include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
    $maSP = isset($_POST['maSanPham']) ? sanitize_text_field($_POST['maSanPham']) : '';
    $tenSP = isset($_POST['tenSanPham']) ? sanitize_text_field($_POST['tenSanPham']) : '';
    $tacGia = isset($_POST['tacGia']) ? sanitize_text_field($_POST['tacGia']) : '';
    $dichGia = isset($_POST['dichGia']) ? sanitize_text_field($_POST['dichGia']) : '';
    $namSanXuat = isset($_POST['namSX']) ? sanitize_text_field($_POST['namSX']) : '';
    $gioiThieu = isset($_POST['gioiThieu']) ? $_POST['gioiThieu'] : '';
    $maTheLoai = isset($_POST['maTheLoai']) ? sanitize_text_field($_POST['maTheLoai']) : '';
    $maNSX = isset($_POST['maNSX']) ? sanitize_text_field($_POST['maNSX']) : '';

    $anhDaiDien_moi = isset($_FILES['anhDaiDien_moi']['name']) ? $_FILES['anhDaiDien_moi']['name'] : '';
    $tenFile_moi = isset($_FILES['tenFile_moi']['name']) ? $_FILES['tenFile_moi']['name'] : '';

    $anhDaiDien_cu = isset($_POST['anhDaiDien_cu']) ? $_POST['anhDaiDien_cu'] : '';
    $tenFile_cu = isset($_POST['tenFile_cu']) ? $_POST['tenFile_cu'] : '';

    if ($anhDaiDien_moi == 'undefined' || $anhDaiDien_moi == '') {
        $anhDaiDien_moi = $anhDaiDien_cu;
    }
    if ($tenFile_moi == 'undefined' || $tenFile_moi == '') {
        $tenFile_moi = $tenFile_cu;
    }

    try {
        include_once PLUGIN_DIR . "includes/san-Pham.php";
        include_once PLUGIN_DIR . "admin/Model/sanPhamModel.php";
        $sanpham = new sanPhamModel($maSP, $tenSP, $tacGia, $dichGia, $namSanXuat, $tenFile_moi, $anhDaiDien_moi, $gioiThieu, $maTheLoai, $maNSX, "");
        $dataProduct = $sanpham->getDatabyID();
        $result = $sanpham->getDatabyName();
        $getFile = $sanpham->getDatabyFile();
        $getImg = $sanpham->getDataByImg();
        // print_r($sanpham);
        // print_r($getFile);
        // print_r($getImg);
        // exit;
        if ($getFile != null && $getFile[0]->tenFile != $dataProduct[0]->tenFile) {
            echo 'File_exists';
            exit;
        }
        if ($getImg != null && $getImg[0]->anhDaiDien != $dataProduct[0]->anhDaiDien) {
            echo 'Img_exists';
            exit;
        }
        //
        $theloai = new theLoaiModel($maTheLoai, '');
        $dataTheLoai = $theloai->getDatabyID();
        $tenTheLoai = $dataTheLoai[0]->tenTheLoai;
        //

        if ($result == null || $dataProduct[0]->tenSanPham == $tenSP) {
            try {
                if ($sanpham->update()) {
                    set_transient('update_product_success', 'Sửa sản phẩm thành công', 30);
                    if ($anhDaiDien_moi == '') {
                        $anhDaiDien_moi = $anhDaiDien_cu;
                    } else {
                        do_action('xuLyXoaAnh_File', $_FILES['anhDaiDien_moi'], '', $tenTheLoai);
                        do_action("xuLyFileAnh", $_FILES['anhDaiDien_moi'], $tenTheLoai);
                    }
                    if ($tenFile_moi == '') {
                        $tenFile_moi = $tenFile_cu;
                    } else {
                        do_action('xuLyXoaAnh_File', '', $_FILES['tenFile_moi'], $tenTheLoai);
                        do_action("xuLyFileSach", $_FILES['tenFile_moi'], $tenTheLoai);
                    }
                } else {
                    echo 'false';
                    exit;
                }
            } catch (\Throwable $th) {
                echo "err";
                exit;
            }
        } else {
            echo 'exists';
            exit;
        }
    } catch (\Throwable $th) {
        echo 'false';
        exit;
    }
}
