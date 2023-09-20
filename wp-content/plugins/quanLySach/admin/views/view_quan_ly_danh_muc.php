<?php
global $hosting;
include_once PLUGIN_DIR . "admin/Model/theLoaiModel.php";
include_once PLUGIN_DIR . "includes/thongBao.php";
$action = isset($_GET['action']) ? $_GET['action'] : '';
$theloai = new theLoaiModel(0, '');
?>

<head>
    <?php include_once PLUGIN_DIR . 'admin/views/head.php' ?>
</head>


<body>
    <div hidden id="spinner" class="spinner-border"></div>
    <div class="title-show">
        <h3>THỂ LOẠI</h3>
    </div>
    <div class="themLoaiSanPham">
        <!-- <button class="btn btn-success"> <a href="#" style="color:white" id="themLoaiSanPham">THÊM DANH MỤC
            </a> </button> -->
        <!-- <form action="?page=quan_ly_sach_category_manager&action=add-category" method="POST"> -->
        <form>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tên thể loại</label>
                <div class="col-sm-10">
                    <input type="text" id="tenTheLoai_them" name="tenTheLoai" minlength="3" maxlength="50" class="form-control" required>
                </div>
            </div>
            <div>
                <button onclick="insert_catrgory()" type="button" name="" class="btn btn-primary">
                    Thêm thể loại
                </button>
            </div>
        </form>

    </div>
    <div class="content-show" style="margin-top: 50px;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã thể loại</th>
                    <th>Tên thể Loại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="show-manager-material-use " style="font-size:16px;font-weight:bold">
                <?php
                // $transients= new quanLySach_transient();
                // $data= $transients->getAllCategory();
                $data = $theloai->getAll();
                if ($data != null) {
                    for ($i = 0; $i < count($data); $i++) {
                        //html
                ?>
                        <tr>
                            <td><?php echo $data[$i]->maTheLoai ?></td>
                            <td><?php echo $data[$i]->tenTheLoai ?></td>
                            <input type="text" hidden name="" id="tenTheLoai<?php echo $i ?>" value="<?php echo $data[$i]->tenTheLoai ?>">
                            <input type="text" hidden name="" id="maTheLoai<?php echo $i ?>" value="<?php echo $data[$i]->maTheLoai ?>">
                            <td>
                                <a onclick="deleteConfirm(<?php echo $data[$i]->maTheLoai ?>,'<?php echo $data[$i]->tenTheLoai ?>')">
                                    <i class="fa-solid fa-trash" style="color:red;cursor: pointer;"></i>
                                </a>
                                <!-- <a href="<?php echo PLUGIN_DIR . 'Controller/theLoaiController.php' ?>&action=delete-category&maTheLoai=<?php echo $data[$i]->maTheLoai ?>">
                                <i class="" style="ont-size:20px;color:red">xóa</i>
                                </a> -->

                                <a style="color: green;cursor: pointer;" onclick="toogle();getValue(<?php echo $i ?>)">
                                    <i class="fa-solid fa-pen-to-square" style="color:green;cursor: pointer;"></i>
                                </a>

                            </td>

                        </tr>
                <?php
                        //end html
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="popup">
        <form>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Mã thể loại</label>
                <div class="col-sm-10">
                    <input type="text" id="maTheLoai_sua" name="maTheLoai_sua" maxlength="50" value="" class="form-control" required>
                </div>

            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tên thể loại</label>
                <div class="col-sm-10">
                    <input type="text" id="tenTheLoai_sua" name="tenTheLoai_sua" maxlength="50" value="" class="form-control" required>
                    <input hidden type="text" id="tenTheLoai_cu" name="tenTheLoai_cu" maxlength="50" value="" class="form-control" required>
                </div>

            </div>
            <div>
                <button onclick="update_category()" type="button" class="btn btn-primary">
                    Sửa
                </button>

            </div>
        </form>
        <button id="btn-close" class="btn btn-danger" onclick="toogle()">
            Đóng
        </button>
    </div>

    <script>
        <?php include_once PLUGIN_DIR . 'admin/js/js.js';  ?>

        function insert_catrgory() {
            var tenTheLoai = document.getElementById('tenTheLoai_them').value;
            if (tenTheLoai === '') return;
            jQuery.ajax({
                url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
                dataType: 'text',
                type: 'POST',
                data: {
                    action: 'insertCategory',
                    tenTheLoai: tenTheLoai
                },
                success: function(response) {
                    console.log(response); // Xử lý kết quả thành công
                    switch (response.trim()) {
                        case 'false':
                            alert('Thất bại')
                            break;
                        case 'err':
                            alert('Lỗi')
                            break;
                        case 'existsCategory':
                            alert('Thể loại đã bị trùng')
                            break;
                        default:
                            location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error); // Xử lý lỗi

                }
            })
        }

        function update_category() {
            var tenTheLoai_sua = document.getElementById('tenTheLoai_sua').value;
            var tenTheLoai_cu = document.getElementById('tenTheLoai_cu').value;
            var maTheLoai_sua = document.getElementById('maTheLoai_sua').value;
            if (tenTheLoai_cu.trim() === tenTheLoai_sua.trim()) return;

            jQuery.ajax({
                url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
                type: 'POST',
                data: {
                    action: 'updateCategory',
                    idCategory: maTheLoai_sua,
                    tenTheLoai_sua: tenTheLoai_sua,
                    tenTheLoai_cu: tenTheLoai_cu,
                },
                success: function(response) {
                    console.log(response);
                    switch (response.trim()) {
                        case 'false':
                            alert("Xóa không thành công ");
                            break;
                        case 'err':
                            alert("Lỗi");
                            break;
                        case 'true':
                            location.reload();
                            break;
                        default:
                            break;
                    }
                },
                error: function(xhr, status, error) {
                    // Xử lý lỗi
                    console.log(error);

                }
            })
        }

        function deleteConfirm(id, name) {
            var result = confirm("TẤT CẢ sản phẩm thuộc thể loại (" + name + ") sẽ bị xóa!! Bạn bạn muốn tiếp tục?");
            if (result) {
                jQuery.ajax({
                    url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
                    type: 'POST',
                    data: {
                        action: 'deleteCategory',
                        idCategory: id
                    },
                    success: function(response) {
                        // Xử lý phản hồi thành công từ máy chủ
                        console.log(response);
                        switch (response.trim()) {
                            case 'false':
                                alert("Xóa không thành công ");
                                break;
                            case 'err':
                                alert("Lỗi");
                                break;
                            default:
                                location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi
                        console.log(error);

                    }
                })
            }

        }
    </script>

</body>