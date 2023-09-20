<?php
include_once PLUGIN_DIR . "admin/Model/NSXModel.php";
include_once PLUGIN_DIR . "includes/thongBao.php";
global $hosting;
?>

<head>
    <?php include_once PLUGIN_DIR . 'admin/views/head.php' ?>
</head>
<?php

?>

<body>
    <div hidden id="spinner" class="spinner-border"></div>
    <div class="title-show">
        <h3>Nhà xuất bản</h3>
    </div>
    <div class="themLoaiSanPham">
        <!-- <button class="btn btn-success"> <a href="#" style="color:white" id="themLoaiSanPham">THÊM DANH MỤC
            </a> </button> -->

        <form>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tên Nhà xuất bản</label>
                <div class="col-sm-10">
                    <input type="text" id="tenNSX" name="tenNSX" maxlength="50" class="form-control" required>
                </div>
            </div>
            <div>
                <button type="button" onclick="insert_publiser()" name="btn_search" class="btn btn-primary">
                    Thêm Nhà xuất bản
                </button>
            </div>
        </form>

    </div>
    <div class="content-show" style="margin-top: 50px;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã Nhà xuất bản</th>
                    <th>Tên Nhà xuất bản</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="show-manager-material-use " style="font-size:16px;font-weight:bold">
                <?php
                // $transients= new quanLySach_transient();
                // $data= $transients->getAllPublisher();
                // var_dump($data);
                $NSX = new NSXModel(0, "");
                $data = $NSX->getAll();
                // var_dump($data);
                // die;
                if ($data != null) {
                    for ($i = 0; $i < count($data); $i++) {
                        //html
                ?>
                        <tr>
                            <td><?php echo $data[$i]->maNXB ?></td>
                            <td><?php echo $data[$i]->tenNXB ?></td>

                            <input type="text" hidden name="" id="tenNSX<?php echo $i ?>" value="<?php echo $data[$i]->tenNXB ?>">
                            <input type="text" hidden name="" id="maNSX<?php echo $i ?>" value="<?php echo $data[$i]->maNXB ?>">
                            <td>
                                <a onclick="deleteConfirm(<?php echo $data[$i]->maNXB ?>)">
                                    <i class="fa-solid fa-trash" style="color:red;cursor: pointer;"></i>
                                </a>

                                <a style="color: green;cursor: pointer;" class="fa-solid fa-pen-to-square" onclick="toogle();getPublisher(<?php echo $i ?>)"> </a>

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
                <label class="col-sm-2 col-form-label">Mã Nhà xuất bản</label>
                <div class="col-sm-10">
                    <input type="text" id="maNSX_sua" name="maNSX_sua" maxlength="50" class="form-control" required>
                </div>

            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tên Nhà xuất bản</label>
                <div class="col-sm-10">
                    <input type="text" id="tenNSX_sua" name="tenNSX_sua" maxlength="50" value="" class="form-control" required>
                </div>

            </div>

            <div>
                <button onclick="update_publiser()" type="button" class="btn btn-primary">
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

        function insert_publiser() {
            var tenNXB = document.getElementById('tenNSX').value;
            if (tenNXB === '') return;
            jQuery.ajax({
                url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
                dataType: 'text',
                type: 'POST',
                data: {
                    action: 'insertPubliser',
                    tenNXB: tenNXB
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
                        case 'exists':
                            alert('nhà xuất bản đã bị trùng')
                            break;
                        case 'true':
                            alert('Thành công');
                            location.reload();
                            break;
                        default:
                            break;
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error); // Xử lý lỗi

                }
            })
        }

        function deleteConfirm(id) {
            var result = confirm("Bạn bạn muốn tiếp tục?");
            if (result) {
                jQuery.ajax({
                    url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
                    type: 'POST',
                    data: {
                        action: 'deletePubliser',
                        id: id
                    },
                    success: function(response) {
                        // Xử lý phản hồi thành công từ máy chủ
                        console.log(response);
                        switch (response.trim()) {
                            case 'false':
                                alert("Xóa không thành công ");
                                break;
                            case 'true':
                                alert('Thành công');
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

        }

        function update_publiser() {
            var tenNSX_sua = document.getElementById('tenNSX_sua').value;
            var maNSX_sua = document.getElementById('maNSX_sua').value;
            jQuery.ajax({
                url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>',
                type: 'POST',
                data: {
                    action: 'updatePubliser',
                    id: maNSX_sua,
                    tenNSX_sua: tenNSX_sua,
                },
                success: function(response) {
                    console.log(response);
                    switch (response.trim()) {
                        case 'false':
                            alert("Sửa không thành công ");
                            break;
                        case 'err':
                            alert("Lỗi");
                            break;
                        case 'exists':
                            alert("nhà xuất bản đã bị trùng");
                            break;
                        case 'true':
                            alert("Sửa thành công ");
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
    </script>

</body>