<?php
global $hosting;
include_once PLUGIN_DIR . 'admin/Model/theLoaiModel.php';
include_once PLUGIN_DIR . 'admin/Model/NSXModel.php';
include_once PLUGIN_DIR . 'admin/Model/sanPhamModel.php';
$action = isset($_GET['action']) ? $_GET['action'] : '';
$maSanPham = isset($_GET['maSanPham']) ? $_GET['maSanPham'] : '';
// sản phẩm
$sanpham = new sanPhamModel($maSanPham, '', '', '', '', '', '', '', '', '', '');
$dataSanPham = $sanpham->getDatabyID();
// var_dump($dataSanPham);
// thể loại
$theLoai = new theLoaiModel($dataSanPham[0]->maTheLoai, "");
$theLoaiSanPham = $theLoai->getDatabyID();
$tenTheLoaiSanPham = $theLoaiSanPham[0]->tenTheLoai;
$maTheLoaiSanPham = $theLoaiSanPham[0]->maTheLoai;

// nhà sản xuất
$NSX = new NSXModel($dataSanPham[0]->maNSX, "");
$NSX_SanPham = $NSX->getDatabyID();
// var_dump($NSX_SanPham);
$tenNSX_SanPham = $NSX_SanPham[0]->tenNXB;
$maNSX_SanPham = $NSX_SanPham[0]->maNXB;
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
                            <h2 class="tm-block-title d-inline-block">Edit Product</h2>
                        </div>
                    </div>
                    <div class="row tm-edit-product-row">
                        <div class="col-xl-8 col-lg-6 col-md-12">
                            <form action="<?php echo PLUGIN_URL . 'admin/Controller/sanPhamController.php?action=update_product&maSanPham=' . $maSanPham  ?>" method="post" enctype="multipart/form-data" class="tm-edit-product-form">
                                <div class="form-group mb-3">
                                    <label for="name">Tên sản phẩm<sup class="sub">*</sup>
                                    </label>
                                    <input value="<?php echo $dataSanPham[0]->tenSanPham ?>" type="text" id="tenSanPham" name="tenSanPham" minlength="3" maxlength="255" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Tên tác giả<sup class="sub">*</sup>
                                    </label>
                                    <input value="<?php echo $dataSanPham[0]->tacGia ?>" type="text" name="tacGia" id="tacGia" maxlength="50" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Tên dịch giả
                                    </label>
                                    <input value="<?php echo $dataSanPham[0]->dichGia ?>" type="text" class="form-control" maxlength="50" id="dichGia" name="dichGia">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Năm sản xuất
                                    </label>
                                    <input value="<?php echo $dataSanPham[0]->namSanXuat ?>" type="number" class="form-control" name="namSX" id="namSX" min="2000" max="2099" step="1">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Giới thiệu sách</label>
                                    <textarea id="textarea_edit" rows="5" cols="5" name="gioiThieu" class="form-control" maxlength="10000" placeholder="Default textarea">
                                    <?php echo trim($dataSanPham[0]->gioiThieu) ?>
                                    </textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="category">Thể Loại <sup class="sub">*</sup></label>
                                    <input hidden type="text" id="maTheLoai_cu" value="<?php echo $dataSanPham[0]->maTheLoai ?>">
                                    <select class="custom-select tm-select-accounts" id="maTheLoai" name="maTheLoai" required>
                                        <?php
                                        $dataTheLoai = $theLoai->getAll();
                                        echo "<option>Please select...</option>";
                                        for ($i = 0; $i < count($dataTheLoai); $i++) {
                                            $maTheLoai = $dataTheLoai[$i]->maTheLoai;
                                            $tenTheLoai = $dataTheLoai[$i]->tenTheLoai;

                                            // sửa
                                            if ($maTheLoaiSanPham == $maTheLoai) {
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
                                        $dataNSX = $NSX->getAll();
                                        echo "<option>Please select...</option>";
                                        for ($i = 0; $i < count($dataNSX); $i++) {
                                            $maNSX = $dataNSX[$i]->maNXB;
                                            $tenNSX = $dataNSX[$i]->tenNXB;

                                            // sửa
                                            if ($maNSX_SanPham == $maNSX) {
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
                            <label class="text-center" for="category">Ảnh đại diện<sup class="sub">*</sup></label>
                            <div class="tm-product-img-edit mx-auto">
                                <img style="width: 200px; height: 200px;" src="<?php echo PLUGIN_URL . 'images/' .  $tenTheLoaiSanPham . '/' . $dataSanPham[0]->anhDaiDien ?>" alt="Product image" id="anh" class="img-fluid d-block mx-auto">
                            </div>
                            <div class="custom-file mt-3 mb-3 text-center">
                                <input style="visibility: hidden;" id="anhDaiDien_moi" name="anhDaiDien_moi" type="file" onclick="selectImage('anh','anhDaiDien_moi')" accept="image/jpeg, image/png, image/gif" />
                                <input style="visibility: hidden;" type="text" name="anhDaiDien_cu" id="anhDaiDien_cu" value="<?php echo $dataSanPham[0]->anhDaiDien  ?>">
                                <input type="button" class="btn btn-primary btn-block mx-auto" value="CHỌN ẢNH ĐẠI DIỆN" onclick="document.getElementById('anhDaiDien_moi').click();" />
                            </div>
                            <label class="text-center" for="category">File sách<sup class="sub">*</sup></label>
                            <div class="custom-file mt-3 mb-3 text-center">
                                <input style="visibility: hidden;" type="text" id="tenFile_cu" name="tenFile_cu" value="<?php echo $dataSanPham[0]->tenFile  ?>">
                                <input value="<?php echo $dataSanPham[0]->tenFile ?>" id="tenFile_moi" name="tenFile_moi" type="file" accept=".pdf, .epub" />
                            </div>
                        </div>
                        <div class="col-12">
                            <button onclick="submit_update_product()" type="button" class="btn btn-primary btn-block text-uppercase">Update Now</button>
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
        selector: 'textarea#textarea_edit',
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



    function submit_update_product() {
        var tenSanPham = document.getElementById('tenSanPham').value;
        var tacGia = document.getElementById('tacGia').value;
        var dichGia = document.getElementById('dichGia').value;
        var namSX = document.getElementById('namSX').value;
        var gioiThieu = tinymce.activeEditor.getContent();
        var maTheLoai_cu = document.getElementById('maTheLoai_cu').value;
        var maTheLoai = document.getElementById('maTheLoai').value;
        var maNSX = document.getElementById('maNSX').value;
        var anhDaiDien_cu = document.getElementById('anhDaiDien_cu').value;
        var anhDaiDien_moi = document.getElementById('anhDaiDien_moi').files[0];
        var tenFile_cu = document.getElementById('tenFile_cu').value;
        var tenFile_moi = document.getElementById('tenFile_moi').files[0];
        if (tenSanPham === '' || tacGia === '' || maTheLoai === '' || maNSX === '') {
            alert("Vui lòng điền đầy đủ thông tin");
            return;
        }
        if (maTheLoai != <?php echo $maTheLoaiSanPham ?>) {
            if (!anhDaiDien_moi || !tenFile_moi) {
                alert('Do bạn đã thay đổi thể loại. Vui lòng chọn lại ảnh và file sách điện tử!!');
                return;
            }

        }

        var formData = new FormData();
        formData.append('action', 'updateProduct');
        formData.append('maSanPham', <?php echo $maSanPham ?>);
        formData.append('tenSanPham', tenSanPham.trim());
        formData.append('tacGia', tacGia.trim());
        formData.append('dichGia', dichGia.trim());
        formData.append('namSX', namSX.trim());
        formData.append('gioiThieu', gioiThieu.trim());
        formData.append('maTheLoai', maTheLoai.trim());
        formData.append('maNSX', maNSX.trim());
        formData.append('anhDaiDien_cu', anhDaiDien_cu.trim());
        formData.append('anhDaiDien_moi', anhDaiDien_moi);
        formData.append('tenFile_cu', tenFile_cu.trim());
        formData.append('tenFile_moi', tenFile_moi);
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
            },
            error: function(xhr, status, error) {
                console.log(error); // Xử lý lỗi

            }
        })
    }
</script>

</html>