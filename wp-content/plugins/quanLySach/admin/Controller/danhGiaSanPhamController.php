<?php
add_action('wp_ajax_deleteCmt', 'deleteCmt');
add_action('wp_ajax_nopriv_deleteCmt', 'deleteCmt');
function deleteCmt()
{
    include_once(PLUGIN_DIR . 'admin/Model/danhGiaSanPhamModel.php');
    $danhgia = new danhGiaSanPhamModel($_POST['idCmt'], "", "", "", "", "", "", "");
    if ($danhgia->delete()) {
        echo 'true';
        exit;
    } else {
        echo 'false';
        exit;
    }
}
add_action('wp_ajax_duyetCmt', 'duyetCmt');
add_action('wp_ajax_nopriv_duyetCmt', 'duyetCmt');
function duyetCmt()
{
    include_once(PLUGIN_DIR . 'admin/Model/danhGiaSanPhamModel.php');
    $idcmt = $_POST['idCmt'];
    $danhgia = new danhGiaSanPhamModel($_POST['idCmt'], "", "", "", "", "", "", 1);
    if ($danhgia->updateStatus()) {
        $response = array(
            'success' => true,
            'html1' => '<td id="trangThai-' . $_POST['idCmt'] . '">Đã duyệt</td>',
            'html2' => "<td id='thaoTac-$idcmt']>
                            <a onclick='showAlert($idcmt)'>
                                <i  style='ont-size:20px;color:red;cursor: pointer;'>xóa</i>
                            </a>
                        </td>"
        );
        echo json_encode($response);
        exit;
    } else {
        $response = array(
            'success' => true,
        );
        echo json_encode($response);
        exit;
    }
}
