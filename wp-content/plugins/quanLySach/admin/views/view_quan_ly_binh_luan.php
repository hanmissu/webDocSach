<?php
include_once PLUGIN_DIR . 'admin/Model/danhGiaSanPhamModel.php';
include_once PLUGIN_DIR . 'admin/Model/khachHangModel.php';
include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
global $hosting;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once PLUGIN_DIR . 'admin/views/head.php' ?>
</head>

<body>
    <div hidden id="spinner" class="spinner-border"></div>
    <div class="title-show">
        <h3>QUẢN LÝ BÌNH LUẬN</h3>
    </div>
    <div class="content-show" style="font-weight: bold">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="background-color: #dee2e6">Mã</th>
                    <th>TÊN KHÁCH HÀNG</th>
                    <th>TÊN SÁCH</th>
                    <th>ĐIỂM ĐÁNH GIÁ</th>
                    <th>NỘI DUNG ĐÁNH GIÁ</th>
                    <th>TRẠNG THÁI</th>
                    <th>NGÀY BÌNH LUẬN</th>
                    <th>NGÀY CHỈNH SỬA</th>
                    <th>THAO TÁC</th>
                </tr>
            </thead>
            <tbody style="position: sticky" id="indexpro">
                <?php
                $danhgia = new danhGiaSanPhamModel(0, "", "", "", "", "", "", "");
                $dataCmt = $danhgia->getAll();

                // $transients=new quanLySach_transient();
                // $dataCmt= $transients->getAllProduct();
                for ($i = 0; $i < count($dataCmt); $i++) {
                    //html
                    $khachhang = new khachHangModel($dataCmt[$i]->maKH, "", "", "", "", "", "", "", "", "", "", "", "");
                    $sanpham = new sanPhamModel($dataCmt[$i]->maSanPham, "", "", "", "", "", "", "", "", "", "");

                    $dataKH = $khachhang->getDataByID();
                    $dataSP = $sanpham->getDatabyID();
                ?>
                    <tr>

                        <td><?php echo  $dataCmt[$i]->id ?></td>
                        <td><?php echo  $dataKH[0]->hoTenKH ?></td>
                        <td><?php echo  $dataSP[0]->tenSanPham ?></td>
                        <td>

                            <?php
                            if ($dataCmt[$i]->diemDanhGia == 0) {
                                echo 'unknown';
                            } else {
                                echo  $dataCmt[$i]->diemDanhGia . '/5';
                            }

                            ?>
                        </td>

                        <td><?php echo  $dataCmt[$i]->noiDung ?></td>
                        <td id="trangThai-<?php echo $dataCmt[$i]->id ?>">
                            <?php
                            if ($dataCmt[$i]->trangThai == '0') {
                                echo 'Chưa duyệt';
                            } else {
                                echo 'Đã duyệt';
                            }
                            ?>
                        </td>
                        <td><?php echo  $dataCmt[$i]->ngaybl ?></td>
                        <td><?php echo  $dataCmt[$i]->ngayChinhSua ?></td>
                        <td id="thaoTac-<?php echo $dataCmt[$i]->id ?>">
                            <a onclick="showAlert(<?php echo $dataCmt[$i]->id ?>)">
                                <i class="fa-solid fa-trash" style="color:red;cursor: pointer;"></i>
                            </a>
                            <?php
                            if ($dataCmt[$i]->trangThai == '0') {
                            ?>
                                <a onclick="duyet(<?php echo $dataCmt[$i]->id ?>)">

                                    <i class="fa-solid fa-check fa-beat" style="color:#32e10e;cursor: pointer;"></i>
                                </a>
                            <?php
                            }
                            ?>

                        </td>
                    </tr>
                <?php
                    //end html
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="<?php echo PLUGIN_URL . 'admin/js/js.js' ?>"> </script>
    <script>
        function showAlert(id) {
            var result = confirm("Bạn có chắc chắn muốn tiếp tục không?");
            if (result) {
                jQuery.ajax({
                    url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
                    type: 'POST',
                    data: {
                        action: 'deleteCmt',
                        idCmt: id
                    },
                    success: function(response) {
                        // Xử lý phản hồi thành công từ máy chủ
                        console.log(response);
                        switch (response.trim()) {
                            case 'true':
                                alert("Đã xóa");
                                location.reload();
                                break;
                            case 'false':
                                alert("Thất bại");

                                break;
                            default:
                                break;
                        }
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi
                        console.log(error);
                        //location.reload();
                    }
                })
            }
        }

        function duyet(id) {
            jQuery.ajax({
                url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
                dataType: 'json',
                type: 'POST',
                data: {
                    action: 'duyetCmt',
                    idCmt: id
                },
                success: function(response) {
                    // Xử lý phản hồi thành công từ máy chủ
                    console.log(response);
                    if (response.success == true) {
                        jQuery('#trangThai-' + id).html(response.html1);
                        jQuery('#thaoTac-' + id).html(response.html2);
                    } else {
                        alert("Thất bại");
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi
                    console.log(error);
                    //location.reload();
                }
            })

        }
    </script>
</body>

</html>