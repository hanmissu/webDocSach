<?php
add_action('wp_ajax_deleteAccount', 'deleteAccount');
function deleteAccount()
{
    try {
        include_once PLUGIN_DIR . 'admin/Model/khachHangModel.php';
        include_once PLUGIN_DIR . 'admin/Model/danhGiaSanPhamModel.php';
        include_once PLUGIN_DIR . 'admin/Model/sanPhamYeuThichModel.php';
        $khachhang = new khachHangModel($_POST['idAccount'], "", "", "", "", "", "", "", "", "", "", "", "");
        $danhgia = new danhGiaSanPhamModel(0, "", "", "", "", "", $_POST['idAccount'], "");
        $yeuthich = new sanPhamYeuThichModel(0, "", "", $_POST['idAccount']);
        $danhgia->deleteByIdCustomer();
        $yeuthich->deleteByIdCustomer();
        if ($khachhang->delete()) {
            set_transient('delete_accout_success', 'Xóa tài khoản thành công', 30);
        } else {
            set_transient('delete_accout_fail', 'Xóa tài khoản không thành công', 30);
        }
    } catch (\Throwable $th) {
        echo 'err';
    }
}
