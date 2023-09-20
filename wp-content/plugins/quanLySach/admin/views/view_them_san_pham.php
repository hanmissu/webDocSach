<?php
include_once PLUGIN_DIR . 'admin/Model/NSXModel.php';
include_once PLUGIN_DIR . 'admin/Model/theLoaiModel.php';
include_once PLUGIN_DIR . "admin/Model/transients.php";
global $hosting;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Edit Product - Dashboard Admin Template</title>
    <?php include_once PLUGIN_DIR . 'admin/views/head.php' ?>
</head>

<body>
    <div hidden id="spinner" class="spinner-border"></div>
    <div class="container tm-mt-big tm-mb-big">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mx-auto">
                <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="tm-block-title d-inline-block">Add Product</h2>
                        </div>
                    </div>
                    <div class="row tm-edit-product-row">
                        <div class="col-xl-8 col-lg-6 col-md-12">
                            <form method="post" enctype="multipart/form-data" class="tm-edit-product-form">
                                <div class="form-group mb-3">
                                    <label for="name">Tên sản phẩm<sup class="sub">*</sup>
                                    </label>
                                    <input type="text" id="tenSanPham" name="tenSanPham" minlength="3" maxlength="255" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Tên tác giả<sup class="sub">*</sup>
                                    </label>
                                    <input type="text" name="tacGia" id="tacGia" maxlength="50" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Tên dịch giả
                                    </label>
                                    <input type="text" class="form-control" id="dichGia" maxlength="50" name="dichGia">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Năm sản xuất
                                    </label>
                                    <input type="number" class="form-control" id="namSX" name="namSX" min="2000" max="2099" step="1">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Giới thiệu sách</label>
                                    <textarea id="textarea_add" name="gioiThieu" class="form-control" maxlength="10000" placeholder="Default textarea"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="category">Thể Loại<sup class="sub">*</sup></label>
                                    <select class="custom-select tm-select-accounts" id="maTheLoai" name="maTheLoai" required>
                                        <?php
                                        $theLoai = new theLoaiModel(0, "");
                                        $dataTheLoai = $theLoai->getAll();
                                        // $dataTheLoai= $transients->getAllCategory();
                                        echo "<option>Please select...</option>";
                                        for ($i = 0; $i < count($dataTheLoai); $i++) {
                                            $maTheLoai = $dataTheLoai[$i]->maTheLoai;
                                            $tenTheLoai = $dataTheLoai[$i]->tenTheLoai;

                                            // sửa
                                            if ($product->maTheLoai == $maTheLoai) {
                                                echo "<option value='$maTheLoai' selected>";
                                            } else {
                                                echo "<option value='$maTheLoai'>";
                                            }

                                            echo "$tenTheLoai</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="category">Nhà sản xuất<sup class="sub">*</sup></label>
                                    <select class="custom-select tm-select-accounts" id="maNSX" name="maNSX" required>
                                        <?php
                                        $NSX = new NSXModel(0, "");
                                        $dataNSX = $NSX->getAll();
                                        //$dataNSX= $transients->getAllPublisher();
                                        echo "<option>Please select...</option>";
                                        for ($i = 0; $i < count($dataNSX); $i++) {
                                            $maNSX = $dataNSX[$i]->maNXB;
                                            $tenNSX = $dataNSX[$i]->tenNXB;

                                            // sửa
                                            if ($product->maNXB == $maNSX) {
                                                echo "<option value='$maNSX' selected>";
                                            } else {
                                                echo "<option value='$maNSX'>";
                                            }

                                            echo "$tenNSX</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-12 mx-auto mb-4">
                            <label class="text-center" for="category">Ảnh đại diện <sup class="sub">*</sup></label>
                            <div class="tm-product-img-edit mx-auto">
                                <img style="width: 200px; height: 200px;" src="" alt="Product image" id="anh" class="img-fluid d-block mx-auto">
                            </div>
                            <div class="custom-file mt-3 mb-3 text-center">
                                <input style="visibility: hidden;" id="anhDaiDien" name="anhDaiDien" type="file" required onclick="selectImage('anh','anhDaiDien')" accept="image/jpeg, image/png, image/gif" />
                                <input type="button" class="btn btn-primary btn-block mx-auto" value="CHỌN ẢNH ĐẠI DIỆN" onclick="document.getElementById('anhDaiDien').click();" />
                            </div>
                            <label class="text-center" for="category">File sách<sup class="sub">*</sup></label>
                            <div class="custom-file mt-3 mb-3 text-center">
                                <input id="tenFile" name="tenFile" type="file" accept=".pdf, .epub" required />
                            </div>
                        </div>
                        <div class="col-12">
                            <button onclick="submit_insert_product()" type="button" class="btn btn-primary btn-block text-uppercase">Add Now</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<script src="<?php echo PLUGIN_URL . 'admin/js/js.js' ?>"></script>
<script>
    tinymce.init({
        selector: 'textarea#textarea_add',
        plugins: [
            'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
            'table', 'emoticons', 'temlate', 'codesample'
        ],
        toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify |' +
            'bullist numlist outdent indent | link image' + 'forecolor backcolor emoticons',
        menu: {
            favs: {
                title: 'menu',
                items: 'code visualaid | searchreplace | emoticons'
            }
        },
        content_style: 'body{font-family: Helvetica, Arial, sans-serif}'
    });

    function submit_insert_product() {
        jQuery('#spinner').show();
        var tenSanPham = document.getElementById('tenSanPham').value;
        var tacGia = document.getElementById('tacGia').value;
        var dichGia = document.getElementById('dichGia').value;
        var namSX = document.getElementById('namSX').value;
        var gioiThieu = tinymce.activeEditor.getContent();
        var maTheLoai = document.getElementById('maTheLoai').value;
        var maNSX = document.getElementById('maNSX').value;
        var anhDaiDien = document.getElementById('anhDaiDien').files[0];
        var tenFile = document.getElementById('tenFile').files[0];
        if (tenSanPham === '' || tacGia === '' || maTheLoai === '' || maNSX === '' || anhDaiDien == null || tenFile == null) {
            alert("Vui lòng điền đầy đủ thông tin");
            return;
        }

        var formData = new FormData();
        formData.append('action', 'insertProduct');
        formData.append('tenSanPham', tenSanPham.trim());
        formData.append('tacGia', tacGia.trim());
        formData.append('dichGia', dichGia.trim());
        formData.append('namSX', namSX.trim());
        formData.append('gioiThieu', gioiThieu.trim());
        formData.append('maTheLoai', maTheLoai.trim());
        formData.append('maNSX', maNSX.trim());
        formData.append('anhDaiDien', anhDaiDien);
        formData.append('tenFile', tenFile);
        jQuery.ajax({
            url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response); // Xử lý kết quả thành công
                switch (response.trim()) {
                    case 'exists':
                        alert("Tên sản phẩm đã tồn tại!! Vui lòng nhập tên khách khác");
                        break;
                    case 'false':
                        alert("Thất bại");
                        break;
                    case 'err':
                        alert("Lỗi");
                        break;
                    case 'File_exists':
                        alert("File đã tồn tại!! Vui lòng nhập file khác");
                        break;
                    case 'Img_exists':
                        alert("Ảnh đã tồn tại!! Vui lòng nhập ảnh khác");
                        break;
                    default:
                        location.href = '<?php echo admin_url("admin.php?page=quan_ly_sach_product_manager") ?>';
                }
                $('#spinner').hide();
            },
            error: function(xhr, status, error) {
                console.log(error); // Xử lý lỗi
                $('#spinner').hide();
            }
        })
    }
</script>


</html>