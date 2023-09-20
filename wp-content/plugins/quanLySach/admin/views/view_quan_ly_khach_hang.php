<?php
include_once PLUGIN_DIR . 'admin/Model/khachHangModel.php';
include_once PLUGIN_DIR . 'admin/Model/theLoaiModel.php';
include_once PLUGIN_DIR . 'admin/Model/NSXModel.php';
include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
include_once PLUGIN_DIR . "includes/thongBao.php";
global $hosting;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once PLUGIN_DIR . 'admin/views/head.php' ?>
</head>

<body>
    <div hidden id="spinner" class="spinner-border"></div>
    <?php
    do_action('thongBao', 'delete_accout_success');
    do_action('thongBao', 'delete_accout_fail');
    ?>
    <div class="title-show">
        <h3>QUẢN LÝ KHÁCH HÀNG</h3>
    </div>
    <div class="content-show" style="font-weight: bold">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="background-color: #dee2e6">Mã</th>
                    <th>TÊN KHÁCH HÀNG</th>
                    <th>SỐ ĐIỆN THOẠI</th>
                    <th>EMAIL</th>
                    <th>TRANG THÁI</th>
                    <th>THAO TÁC</th>
                </tr>
            </thead>
            <tbody style="position: sticky" id="indexpro">
                <?php
                $khachhang = new khachHangModel(0, "", "", "", "", "", "", "", "", "", "", "", "");
                $dataKH = $khachhang->getAll();
                //  var_dump($dataKH);
                // $transients=new quanLySach_transient();
                // $dataKH= $transients->getAllProduct();
                for ($i = 0; $i < count($dataKH); $i++) {
                    //html
                ?>
                    <tr>

                        <td><?php echo  $dataKH[$i]->maKH ?></td>
                        <td><?php echo  $dataKH[$i]->hoTenKH ?></td>
                        <td><?php echo  $dataKH[$i]->SDT ?></td>
                        <td><?php echo  $dataKH[$i]->email ?></td>
                        <td><?php if ($dataKH[$i]->trangThai == 1) echo 'Đã xác thực';
                            else echo 'Chưa xác thực'; ?></td>
                        <td>
                            <a onclick="showAlert(<?php echo $dataKH[$i]->maKH ?>)">
                                <i class="fa-solid fa-trash" style="color:red;cursor: pointer;"></i>
                            </a>
                        </td>

                    </tr>

                <?php
                    //end html
                }
                ?>
            </tbody>
        </table>
    </div>


    <script>
        <?php include_once PLUGIN_DIR . 'admin/js/js.js';  ?>

        function showAlert(id) {
            var result = confirm("Bạn có chắc chắn muốn tiếp tục không?");
            if (result) {
                jQuery.ajax({
                    url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
                    type: 'POST',
                    data: {
                        action: 'deleteAccount',
                        idAccount: id
                    },
                    success: function(response) {
                        // Xử lý phản hồi thành công từ máy chủ
                        console.log(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi
                        console.log(error);
                        location.reload();
                    }
                })
            }
        }
    </script>
</body>

</html>