<?php
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
    do_action('thongBao', 'add_product_success');
    do_action('thongBao', 'update_product_success');
    do_action('thongBao', 'delete_product_success');
    do_action('thongBao', 'delete_product_fail');
    do_action('thongBao', 'add_product_fail');
    do_action('thongBao', 'update_product_fail');
    do_action('thongBao', 'product_exists');
    ?>
    <div class="title-show">
        <h3>SẢN PHẨM</h3>
    </div>
    <div class="add-material">
        <span><a href="?page=quan_ly_sach_add_prouct" class="btn btn-success">THÊM SẢN PHẨM</a></span>

        <span>
            <select class="select" id="select">
                <option value="sach">Tên sách</option>
                <option value="tacgia">Tác giả</option>
            </select>
            <input name="keysearh" id="keysearh" type="search" placeholder="Search" required>
            <button onclick="search()" class="btn btn-primary submit-search text-center" type="button">
                <i class="fa-solid fa-magnifying-glass" style="color: #43da0b;"></i>
            </button>

        </span>
    </div>
    <div class="content-show" style="font-weight: bold">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="background-color: #dee2e6">Mã</th>
                    <th>TÊN SẢN PHẨM</th>
                    <th>TÁC GIẢ</th>
                    <th>DỊCH GIẢ</th>
                    <th>NĂM SẢN XUẤT</th>
                    <th>ẢNH</th>
                    <th>GIỚI THIỆU SẢN PHẨM</th>
                    <th>THỂ LOẠI</th>
                    <th>NHÀ XUẤT BẢN</th>
                    <th>THAO TÁC</th>
                </tr>
            </thead>
            <tbody style="position: sticky" id="indexpro">
                <?php
                $sanpham = new sanPhamModel(0, '', '', '', '', '', '', '', '', '', '');
                $allSanPham = $sanpham->getAll();
                //  var_dump($allSanPham);
                // $transients=new quanLySach_transient();
                // $allSanPham= $transients->getAllProduct();
                for ($i = 0; $i < count($allSanPham); $i++) {

                    $theloai = new theLoaiModel($allSanPham[$i]->maTheLoai, '');
                    // lấy tên thể loại
                    $dataTheLoai = $theloai->getDatabyID();
                    $tenTheLoai = $dataTheLoai[0]->tenTheLoai;

                    // lấy tên nhà sản xuất
                    $NSX = new NSXModel($allSanPham[$i]->maNSX, '');
                    $dataNSX = $NSX->getDatabyID();
                    $tenNSX = $dataNSX[0]->tenNXB;
                    //html
                ?>
                    <tr>
                        <td><?php echo  $allSanPham[$i]->maSanPham ?></td>
                        <td><?php echo  $allSanPham[$i]->tenSanPham ?></td>
                        <td><?php echo  $allSanPham[$i]->tacGia ?></td>
                        <td><?php echo  $allSanPham[$i]->dichGia ?></td>
                        <td><?php echo  $allSanPham[$i]->namSanXuat ?></td>
                        <td><img style="widtd:100px;height:150px" src="<?php echo PLUGIN_URL . 'images/' . $tenTheLoai . '/' . $allSanPham[$i]->anhDaiDien ?>">
                        </td>
                        <td><span class="line-5"><?php echo mb_substr($allSanPham[$i]->gioiThieu, 0, 500, "UTF-8") . ' ... ';   ?></span></td>
                        <td>
                            <?php
                            echo  $tenTheLoai
                            ?>
                        </td>
                        <td>
                            <?php

                            echo  $tenNSX

                            ?>

                        </td>
                        <td>
                            <a onclick="showAlert(<?php echo $allSanPham[$i]->maSanPham  ?>)">

                                <i class="fa-solid fa-trash" style="color:red;cursor: pointer;"></i>

                            </a>
                            <a href="<?php echo esc_url(add_query_arg(array('maSanPham' => $allSanPham[$i]->maSanPham), admin_url('admin.php?page=quan_ly_sach_edit_prouct'))); ?>"><i class="fa-solid fa-pen-to-square" style="font-size:20px;color:green"></i></a>
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
                        action: 'deleteProduct',
                        idProduct: id
                    },
                    success: function(response) {
                        // Xử lý phản hồi thành công từ máy chủ
                        console.log(response);
                        switch (response.trim()) {
                            case 'false':
                                alert('Thất bại');
                                break;
                            default:
                                location.reload();
                        }
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi
                        console.log(error);
                        // location.reload();
                    }
                })
            }
        }

        function search() {
            var select = document.getElementById('select').value;
            var keysearh = document.getElementById('keysearh').value;
            if (keysearh == '') return;
            jQuery.ajax({
                url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
                type: 'POST',
                dataType: 'html',
                data: {
                    action: 'Adminsearch',
                    select: select.trim(),
                    keysearh: keysearh.trim(),
                },
                success: function(response) {
                    // Xử lý phản hồi thành công từ máy chủ
                    console.log(response);
                    jQuery('#indexpro').html(response);
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi
                    console.log(error);
                    // location.reload();
                }
            })
        }
    </script>
</body>

</html>