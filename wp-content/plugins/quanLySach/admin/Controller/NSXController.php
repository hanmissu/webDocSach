<?php
add_action('wp_ajax_insertPubliser', 'insertPubliser');
add_action('wp_ajax_nopriv_insertPubliser', 'insertPubliser');
function insertPubliser()
{
    try {
        include_once PLUGIN_DIR . "admin/Model/NSXModel.php";
        $NSX = new NSXModel(0, $_POST['tenNXB']);
        $result = $NSX->getDatabyName($_POST['tenNXB']);

        if ($result == null) {
            if ($NSX->insert()) {
                echo 'true';
                exit;
            } else {
                echo 'false';
                exit;
            }
        } else {
            echo 'exists';
            exit;
        }
    } catch (\Throwable $th) {
        echo 'err';
        exit;
    }
}
add_action('wp_ajax_deletePubliser', 'deletePubliser');
add_action('wp_ajax_nopriv_deletePubliser', 'deletePubliser');
function deletePubliser()
{
    include_once PLUGIN_DIR . "admin/Model/NSXModel.php";
    include_once PLUGIN_DIR . 'admin/Model/danhGiaSanPhamModel.php';
    include_once PLUGIN_DIR . 'admin/Model/sanPhamYeuThichModel.php';
    include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
    $sanpham = new sanPhamModel(0, "", "", "", "", "", "", "", "", $_POST['id'], "");
    $dataByIdCategory = $sanpham->getDatabyIDPubliser();
    for ($i = 0; $i < count($dataByIdCategory); $i++) {
        $danhgia = new danhGiaSanPhamModel(0, "", "", "", "", $dataByIdCategory[$i]->maSanPham, "", "");
        $danhgia->deleteByIdProduct();
        $yeuthich = new sanPhamYeuThichModel(0, "", $dataByIdCategory[$i]->maSanPham, "");
        $yeuthich->deleteByIdProduct();
    }
    $sanpham->deleteByIdPubliser();
    $NSX = new NSXModel($_POST['id'], '');

    if ($NSX->delete()) {
        echo 'true';
        exit;
    } else {
        echo 'false';
        exit;
    }
}

add_action('wp_ajax_updatePubliser', 'updatePubliser');
add_action('wp_ajax_nopriv_updatePubliser', 'updatePubliser');
function updatePubliser()
{
    include_once PLUGIN_DIR . "admin/Model/NSXModel.php";
    $NSX = new NSXModel($_POST['id'], $_POST['tenNSX_sua']);
    $data = $NSX->getDatabyID();
    $result = $NSX->getDatabyName($_POST['tenNSX_sua']);

    if ($result == null || $data[0]->tenNXB == $result[0]->tenNXB) {
        if ($NSX->update()) {
            echo 'true';
            exit;
        } else {
            echo 'false';
            exit;
        }
    } else {
        echo 'exists';
        exit;
    }
}
